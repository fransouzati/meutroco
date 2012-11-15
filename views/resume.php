<?php  
	require_once('../functions.php'); 
	$api = new API; 																	//API
	$accounts = $api->getAccounts(); 													//Contas

	/* Verifica se existem contas para o usuário */
	if(count($accounts) == 0): 
		include('firstTime.php'); 														//Inclui página de conta
		exit();
	endif;

	$transactions = $api->getTransactions(20); 											//Últimas 20 transações
	$tags = $api->getTags(10,'','most_expensive','asc',date('Y-m-01'),date('Y-m-31')); 	//As 10 tags mais caras
	$balances = $api->getAccountBalance(); 												//Balanço por conta

	/* Monta QUERY para execução de gráfico */
	$seriesGraph = '[';
		$i=0; foreach($accounts as $acc): $i++;
			$seriesGraph .= '{';
				$seriesGraph .= 'name: "' . convertToUnicode($acc->name) . '",';
				$seriesGraph .= 'data: [';

				$monthsLeft = 12 - date('m');						//Meses que faltam para o fim do ano
				$invertedCount = 0;									//Contador invertido para meses dos anos passados
				$year = date('Y');
				$monthCount = date('m');

				for($o = 0; $o <= 12; $o++):
					$year = date( "Y", strtotime( '-' . (12 - $o) . ' months', strtotime( date('Y') . '-' . date('m') . '-01' ) ) );
					$toMonth = date( "m", strtotime( '-' . (12 - $o) . ' months', strtotime( date('Y') . '-' . date('m') . '-01' ) ) );
					$generatedDate = 1000 * strtotime($year .'-' . $toMonth . '-01');
				
					$seriesGraph .= '[';
					$seriesGraph .= 'Date.UTC(' . $year .',' . ($toMonth - 1) . ',1),'; //Base zero para javascript (0 - 11)

					$TodayDiff = $monthsLeft + $o;
					foreach($balances as $accountId => $years): 					//Conta
						//$accountId = Id da conta
						if($accountId == $acc->id):
							foreach ($years as $yearId => $monthsList): 			//Ano
								//$yearId = Ano
								if($yearId == $year):
									foreach ($monthsList as $monthId => $months):	//Mês
										//$monthId->total = Total do Ano
										foreach ($months as $month => $finalMonth):
											//$month = Mês
											//$finalMonth = valor desse mês
											if($toMonth == $month):
												$seriesGraph .= $finalMonth;
												break;
											endif;
										endforeach;
									endforeach;
									break;
								endif;
							endforeach;
							break;
						endif;
					endforeach;

					$seriesGraph .= '],';
				endfor;
				$seriesGraph = rtrim($seriesGraph, ',');
				$seriesGraph .= ']';
			$seriesGraph .= '},';
		endforeach;
		$seriesGraph = rtrim($seriesGraph, ',');
	$seriesGraph .= ']';
?>

<h2>Resumo</h2>
<div class="block double" id="monthBalance">
	<h3>Últimos 12 meses</h3>
	<div id="monthBalanceGraph" class="graph"><!-- Gráfico --></div>
</div>

<span class="clear"></span>

<div class="block" id="lastTransactions">
	<h3>Ultimas transações<span class="actions"><span class="viewAll"><a href="#contas" title="Ver todas as transações">Ver todas</a></span></span></h3>
	<?php if(count($transactions) == 0): ?>
		<div class="noData">
			Você ainda não cadastrou uma transação. <a href="#adicionarTransacao" title="Cadastrar primeira transação">Clique aqui</a> para começar!
		</div>
	<?php else: ?>
	<table class="tableList">
	<?php foreach($transactions as $transaction): ?>
		<tr 
			class="<?php echo transactionType($transaction->account_type); if($transaction->date > date('Y-m-d')) echo " toDo"; ?>" 
			data-description="<?php echo $transaction->description ?>" 
			data-id="<?php echo $transaction->id ?>" 
			data-type="<?php echo $transaction->type ?>" 
			data-date="<?php echo $transaction->date ?>" 
			data-acc="<?php echo $transaction->account_from ?>"
			data-accTo="<?php echo $transaction->account_to ?>" 
			data-tags="<?php $html=""; foreach($transaction->tags as $tag):$html .= $tag->name.', '; endforeach; echo substr($html,0,-2); ?>" 
			data-role="transaction"
			data-amount="<?php echo $transaction->amount; ?>"
		>
			<td class="name" data-tip="<?php echo $transaction->description ?>"><span><?php echo $transaction->description ?></span></td>
			<td class="date"><?php echo dateFormat($transaction->date); ?></td>
			<td class="amount"><?php echo moneyFormat($transaction->amount, true) ?></td>
			<td class="actions">
				<span class="editSmall"><a href="#editarTransacao?id=<?php echo $transaction->id ?>" title="Editar esta transação"></a></span>
				<span class="removeSmall"><a href="#removerTransacao?id=<?php echo $transaction->id ?>" title="Excluir esta transação"></a></span>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
	<?php endif; ?>
</div>
<span class="blockDistance"></span>
<div class="block" id="mostSpending">
	
	<? /* Título */  ?>
	<h3>O que mais gastei no mês<span class="actions"><span class="viewAll"><a href="#marcadores" title="Ver todas os marcadores">Ver marcadores</a></span></span></h3>
	
	<?php 
	/* Verifica se existem marcadores */
	if(count($tags) == 0): 
	?>
		<div class="noData">
			Os seus gastos são registrados em marcadores. <a href="#adicionarMarcador" title="Cadastrar primeiro marcador">Clique aqui</a> para cadastrar seu primeiro marcador!
		</div>
	<?php else: ?>

		<?php 
		/* Loop de marcadores */ 
		$i = 0; 
		foreach($tags as $tag):
			if($tag->total_spend < 0): $i++;  	//Verifica se é negatico
		?>
				<?php if($i == 1): ?>
				<div id="mostSpendingGraph" class="graph"><!-- Gráfico --></div>

				<? /* Lista de marcadores */ ?>
				<table class="tableList">
				<?php endif; ?>
						<tr data-id="<?php echo $tag->id ?>" data-name="<?php echo $tag->name ?>" data-role="tag">
							<td class="name"><?php echo $tag->name ?>:</td>
							<td class="amount <?php if($tag->total_spend >= 0) echo 'positive'; else echo 'negative'; ?>"><?php echo moneyFormat($tag->total_spend, true); ?></td>
							<td class="actions">
									<span class="viewSmall"><a href="#verMarcador?id=<?php echo $tag->id ?>" title="Ver transações para este marcador"></a></span>
									<span class="editSmall"><a href="#editarMarcador?id=<?php echo $tag->id ?>" title="Editar este marcador"></a></span>
									<span class="removeSmall"><a href="#removerMarcador?id=<?php echo $tag->id ?>" title="Excluir este marcador"></a></span>
							</td>
						</tr>
				<?php if($i == count($tags)): ?>
				</table>
				<?php endif; ?>
		<?php
			endif; 
		endforeach; 

		/* Verifica se existiu algum marcador */
		if($i == 0): ?>
			<div class="noData">
				Os seus marcadores ainda não registraram gastos para este mês. Parabéns!
			</div>
		<?php endif;
	endif; 
	?>
</div>
<script>
(function($){
	<?php if(count($tags) != 0 && $i != 0): ?>
	/* ***** Gerar gráfico de gastos ***** */
	spendingGraph = new Highcharts.Chart({
		chart: {
        	renderTo: 'mostSpendingGraph'
		},
		tooltip: {
			enabled: true,
			 formatter: function() {
				 var amount = this.percentage.toString();
				 amount = amount.split('.',2);
				 var amount2 = amount[1];
				 amount2 = amount2.split('',2);
				 amount2 = amount2[0]+amount2[1];
				return '<b>'+ convertToUnicode(this.point.name) +'</b>: '+ amount[0]+'.'+amount2 +'%';
			 }
		 },
		 series: [{
		 	type: 'pie',
			data: [
		 	<?php $i=0; foreach($tags as $tag): if($tag->total_spend <= 0): $i++; ?>
				{name:'<?php echo $tag->name ?>', y:<?php echo $tag->total_spend; ?>},
			<?php endif; endforeach; ?>
			]
		 }]
	});
	<?php endif; ?>
	
	/* ***** Gerar gráfico mensal ***** */
	monthBalanceGraph = new Highcharts.Chart({
		tooltip: {
			shared:true,
			formatter: function(){
				var html = '';
				var year = <?php echo date('Y'); ?>;
				var month = <?php echo date('m'); ?>;
				var d = new Date(this.x);
				d.setDate(32); // Hack?
				html += '<div style="font-weight:bold; color:#999;">' + convertToUnicode(interface.i18n.date.monthNames[d.getMonth()]) + ' de ' + d.getFullYear() + '</div>';
				html += '<br/><span style="color:#CCC;">-------</span><br/>';
				for(i=0; i < this.points.length; i++) {
					html += '<span style="color:'+this.points[i].series.color+'">'+convertToUnicode(this.points[i].point.series.name)+': '+interface.i18n.money.currencySymbol+' '+this.points[i].y.toFixed(2)+'</span>';
					if(i != this.points.length-1)
						html += '<br/><span style="color:transparent; font-size:4px;">-------</span><br/>';
				}
				return html;
			}
		},
	 	chart: {renderTo: 'monthBalanceGraph',type: 'spline', zoomType: 'x'},
		colors: [
			<?php $i=0; foreach($accounts as $acc): $i++; ?>
				<?php echo "'".transactionTypeColor($acc->account_type_id)."',"; ?>
			<?php endforeach; ?>
		],
		xAxis: {
			type: 'datetime',
			dateTimeLabelFormats: {
				month: '%b <br /> %Y'
			},
			maxZoom: 31 * 24 * 3600000,
			tickInterval: 86400000 * 31
		},
		series: <?php echo $seriesGraph; ?>
	 });
})(jQuery);
</script>