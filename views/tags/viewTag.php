<?php  
	require_once('../../functions.php'); 
	$api = new API;
	$myTag = $api->getTag($_GET['id']);
	$transactions = $api->getTransactions(100,date('2011-01-01'),date('Y-m-31'),"",$_GET['id'],'date','asc');
	$totalTransactions = count($transactions);
	$info = array();
	$totalAmount = 0;
	

?>
<h2>Tag: <strong><?php echo $myTag[0]->name; ?></strong> <span class="actions"><span class="goBack"><a href="javascript:;" title="Voltar para página anterior">Voltar</a></span></span></h2>


<div class="block <?php if(count($transactions) != 0): echo "double"; endif; ?>" id="tagTransactions">
	<h3>Últimos 12 meses</h3>
	<div class="graph" id="monthBalanceGraph"></div>
</div>

<?php if(count($transactions) == 0): echo '<span class="blockDistance"></span>'; endif; ?>

<div class="block" id="transactionsList">
	<h3>Lista de transações</h3>
	<?php if(count($transactions) == 0): ?>
		<div class="noData">
			Você ainda não cadastrou nenhuma transação para esta tag. 
		</div>
	<?php else: ?>

		<table class="tableList">
			<?php 
				$i=0; 
				foreach($transactions as $transaction): $i++; 
					$thisDate = strtotime($transaction->date);
					
					//Sets
					if(!isset($firstYear))
						$firstYear = date("Y",$thisDate);
					if(!isset($firstMonth)):
						$firstMonth = date("m",$thisDate);
						
					//Year list
					for($o = 0; $o <= date('Y') - $firstYear; $o++):
						if(!isset($info[$firstYear + $o]))
							$info[$firstYear + $o] = array();
					endfor;
					
					//Month List
					$o = 0;
					foreach($info as $inf):
						$arr = array_keys($info);
						if($arr[$o] != date('Y')):
							for($u = 0; $u <= 12 - $firstMonth; $u++):
								if(!isset($info[$arr[$o]][$firstMonth + $u]))
									$info[$arr[$o]][str_pad($firstMonth + $u, 2, '0', STR_PAD_LEFT)] = array("amount" => "0.00");
							endfor;
						else:
							for($u = 0; $u < date('m'); $u++):
								if(!isset($info[$arr[$o]][$u + 1]))
									$info[$arr[$o]][str_pad($u + 1, 2, '0', STR_PAD_LEFT)] = array("amount" => "0.00");
							endfor;
						endif;
						$o++;
					endforeach;
					endif;
					
					//Verify if MONTH exists
					if(isset($info[date("Y",$thisDate)][date("m",$thisDate)]["amount"]))
						$info[date("Y",$thisDate)][date("m",$thisDate)]["amount"] += $transaction->amount;
					
					//Increment Total Amount
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

<?php if(count($transactions) != 0): ?>
<div class="footerInfo"><strong>Total:</strong> <?php echo moneyFormat($totalAmount, true); ?></div>
<?php endif; ?>


<!-- Script -->
<script>
(function($){
	/* ***** Generate Month Graph ***** */
	<?php if(count($info) == 0): ?>
		$('#monthBalanceGraph').css('height','auto').html('<div class="noData">esta tag não registrou transações nos últimos meses.</div>');
	
	<?php else: ?>

		<?php
		$graphData = '';
		foreach($info as $inf): 
			foreach($inf as $in):
				$math = (float)$in["amount"]; 
				$math = $math * -1; 

				$math2 = $math > 0 ? $math : $math * -1;

				$graphData .= '{y: '.$math2.', color:"';
				if($math > 0): $graphData .= "#ce6a6a"; else: $graphData .= "#8cce6a"; endif;
				$graphData.= '"},';
			endforeach; 
		endforeach;
		?>
		monthBalanceGraph = new Highcharts.Chart({
		 	chart: {renderTo: 'monthBalanceGraph',type: 'column'},
		 	legend: {enabled: false},
			colors: ['#ce6a6a'],
			xAxis: {
				categories: [
					<?php 
						$o = 0; $u = 0;
						foreach($info as $inf): 
							foreach($inf as $in):
								$arr = array_keys($info);
								$arr2 = array_keys($inf);
								echo "'".thisMonthName($arr2[$u], true)." ".$arr[$o]."',";
								$u++;
							endforeach;
							$o++; $u=0;
						endforeach;
					?>
				]
				
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


