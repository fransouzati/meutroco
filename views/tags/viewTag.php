<?php  
	require_once('../../functions.php'); 

	//Variáveis
	$api = new 	API;
	$myTag = $api->getTag($_GET['id']);				//Busca pela TAG
	$transactions = $api->getTransactions(100,date('2011-01-01'),date('Y-m-31'),"",$_GET['id'],'date','asc');	//Todas as transações para esta tag
	$totalTransactions = count($transactions);		//Quantidade total de transações
	$totalAmount = 0;								//Total gasto nessa tag
	$latestMonths = getLatestMonths();				//Lista dos últimos meses

	//Cria array com valores vazios
	$info = array();
	for($i = 0; $i < count($latestMonths); $i++):
		$info[$latestMonths[$i]] = 0;
	endfor;
?>

<!-- Título -->
<h2>Tag: <strong><?php echo $myTag[0]->name; ?></strong> <span class="actions"><span class="goBack"><a href="javascript:;" title="Voltar para página anterior">Voltar</a></span></span></h2>

<!-- Gráfico com últimos 12 meses de transações -->
<div class="block <?php if(count($transactions) != 0): echo "double"; endif; ?>" id="tagTransactions">
	<h3>Últimos 12 meses</h3>
	<div class="graph" id="monthBalanceGraph"></div>
</div>

<?php if(count($transactions) == 0): echo '<span class="blockDistance"></span>'; endif; ?>

<!-- Lista de transações -->
<div class="block" id="transactionsList">
	<h3>Lista de transações</h3>

	<?php /* Caso não possua nenhuma transação */ ?>
	<?php if(count($transactions) == 0): ?>
		<div class="noData">
			Você ainda não cadastrou nenhuma transação para esta tag. 
		</div>

	<?php /* Se existir transações */ ?>
	<?php else: ?>
		<table class="tableList">
			<?php 

				//Para cada transação
				$i = 0;
				foreach($transactions as $transaction): $i++;

					//Data da transação
					$thisDate = strtotime($transaction->date);

					//Verifica se o mês e ano bate com últimos meses
					foreach($latestMonths as $latestMonth):
						$m = date('m', strtotime($latestMonth));		//Mês
						$y = date('Y', strtotime($latestMonth));		//Ano

						//O mês e ano bate em algum momento?
						if(date('Y', $thisDate) == $y && date('m', $thisDate) == $m):
							$info[$latestMonth] += $transaction->amount;
							break;
						endif;
					endforeach;

					//Adiciona ao valor total
					$totalAmount += $transaction->amount;
			?>
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
				<?php if(round($totalTransactions/2) == $i): ?>
	            </table>
	            </div>
	            <span class="blockDistance"></span>
	            <div class="block">
	            <h3>&nbsp;</h3>
	            <table class="tableList">
	            <?php endif; endforeach; ?>
		</table>

	<?php endif; ?>
</div>

<!-- Total gasto nesta TAG -->
<?php if(count($transactions) != 0): ?>
<div class="footerInfo"><strong>Total:</strong> <?php echo moneyFormat($totalAmount, true); ?></div>
<?php endif; ?>


<!-- Script -->
<script>
(function($){
	/* ***** Gerar gráfico mensal ***** */

	<?php /* Caso não exista valores */ ?>
	<?php if(count($info) == 0): ?>
		$('#monthBalanceGraph').css('height','auto').html('<div class="noData">esta tag não registrou transações nos últimos meses.</div>');
	
	<?php /* Monta série para gráfico */ ?>
	<?php else: ?>

		<?php
			$graphData = '';
			$categories = '[';

			//Percorre os meses
			foreach($latestMonths as $latestMonth): 

				//Monta valor positivo ou negativo
				$math = (float)$info[$latestMonth]; 
				$math = $math * -1; 
				$math2 = $math > 0 ? $math : $math * -1;
				$graphData .= '{y: '.$math2.', color:"';
				$math > 0 ? $graphData .= "#ce6a6a" : $graphData .= "#8cce6a"; 
				$graphData.= '"},';

				//Monta categorias
				$categories .= "'".thisMonthName(date('m', strtotime($latestMonth)), true)." ".date('Y', strtotime($latestMonth))."',";

			endforeach;

			$categories .= ']';
		?>

		monthBalanceGraph = new Highcharts.Chart({
		 	chart: {
		 		renderTo: 'monthBalanceGraph', 
		 		type: 'column'
		 	},
		 	legend: {enabled: false},
			colors: ['#ce6a6a'],
			xAxis: {
				categories: <?php echo $categories; ?>
				
			},
			series: [
				{
					name: '<?php echo convertToUnicode($myTag[0]->name); ?>',
					data: [<?php echo $graphData; ?>]
				}
			]
	 });

	<?php endif; ?>
	 
})(jQuery);
</script>


