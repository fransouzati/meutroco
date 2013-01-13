<?php  
	require_once('../../functions.php'); 
	$y = (isset($_GET['y'])) ? $_GET['y'] : date('Y');
	$api = new API;
	$tags = $api->getTags(1000, "", "name", "ASC");
	$totalTags = count($tags);
	$mostSpendTags = $api->getTags(10,'','most_expensive','asc',date($y.'-01-01'),date('Y-12-31'));
	$cheaperTags = $api->getTags(10,'','most_valuable','desc',date($y.'-01-01'),date('Y-12-31'));
?>
<h2>Ver Todos os tags</h2>

<?php if(count($tags) == 0): ?>
	<div class="block double noData">
		Você ainda não cadastrou uma tag. <a href="#adicionarTag" title="Cadastrar primeiro tag">Clique aqui</a> para começar!
	</div>
<?php else: ?>

<div class="block" id="mostSpending">
	<h3>O que mais gastei em <?php echo $y; ?></h3>
	<div id="mostSpendingGraph" class="graph"></div>
	<table class="tableList">
		<?php foreach($mostSpendTags as $tag): if($tag->total_spend < 0): ?>
			<tr data-id="<?php echo $tag->id ?>" data-name="<?php echo $tag->name ?>" data-role="tag">
				<td class="name"><?php echo $tag->name ?>:</td>
				<td class="amount <?php if($tag->total_spend >= 0) echo 'positive'; else echo 'negative'; ?>"><?php echo moneyFormat($tag->total_spend, true); ?></td>
				<td class="actions">
					<span class="viewSmall"><a href="#verTag?id=<?php echo $tag->id ?>" title="Ver transações para esta tag"></a></span>
					<span class="editSmall"><a href="#editarTag?id=<?php echo $tag->id ?>" title="Editar esta tag"></a></span>
					<span class="removeSmall"><a href="#removerTag?id=<?php echo $tag->id ?>" title="Excluir esta tag"></a></span>
				</td>
			</tr>
		<?php endif; endforeach; ?>
	</table>
</div>

<span class="blockDistance"></span>

<div class="block" id="cheaper">
	<h3>Onde mais ganhei em <?php echo $y; ?></h3>
	<div id="cheaperGraph" class="graph"></div>
	<table class="tableList">
		<?php foreach($cheaperTags as $tag): if($tag->total_spend > 0):  ?>
			<tr data-id="<?php echo $tag->id ?>" data-name="<?php echo $tag->name ?>" data-role="tag">
				<td class="name"><?php echo $tag->name ?>:</td>
				<td class="amount <?php if($tag->total_spend >= 0) echo 'positive'; else echo 'negative'; ?>"><?php echo moneyFormat($tag->total_spend, true); ?></td>
				<td class="actions">
					<span class="viewSmall"><a href="#verTag?id=<?php echo $tag->id ?>" title="Ver transações para esta tag"></a></span>
					<span class="editSmall"><a href="#editarTag?id=<?php echo $tag->id ?>" title="Editar esta tag"></a></span>
					<span class="removeSmall"><a href="#removerTag?id=<?php echo $tag->id ?>" title="Excluir esta tag"></a></span>
				</td>
			</tr>
		<?php endif; endforeach; ?>
	</table>
</div>

<span class="clear"></span>

<div class="block" id="allTags">
	<h3>Todos os tags</h3>
	<table class="tableList">
    		<?php $i=0; foreach($tags as $tag): $i++; ?>
            <tr data-id="<?php echo $tag->id ?>" data-name="<?php echo $tag->name ?>" data-role="tag">
                <td class="name"><?php echo $tag->name ?>:</td>
                <td class="amount <?php if($tag->total_spend >= 0) echo 'positive'; else echo 'negative'; ?>"><?php echo moneyFormat($tag->total_spend, true); ?></td>
                <td class="actions">
					<span class="viewSmall"><a href="#verTag?id=<?php echo $tag->id ?>" title="Ver transações para esta tag"></a></span>
					<span class="editSmall"><a href="#editarTag?id=<?php echo $tag->id ?>" title="Editar esta tag"></a></span>
					<span class="removeSmall"><a href="#removerTag?id=<?php echo $tag->id ?>" title="Excluir esta tag"></a></span>
                </td>
            </tr>
            <?php if(round($totalTags/2) == $i): ?>
            </table>
            </div>
            <span class="blockDistance"></span>
            <div class="block">
            <h3>&nbsp;</h3>
            <table class="tableList">
            <?php endif; endforeach; ?>
		</table>
</div>

<!-- Script -->
<script>
$(document).ready(function(){
	/* ***** Generate Spending Graph ***** */
	spendingGraph = new Highcharts.Chart({
		chart: {
        	renderTo: 'mostSpendingGraph'
		},
		colors: [
			'#ce6a6a',
			'#d37979',
			'#d88888',
			'#dd9696',
			'#e2a6a6',
			'#e6b4b4',
			'#ebc3c3',
			'#f0d2d2',
			'#f5e1e1',
			'#faf0f0'
		],
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
		 plotOptions: {
			 pie: {
				allowPointSelect: true,
				cursor: 'pointer',
				dataLabels: {
				   enabled: false
				},
				showInLegend: false
			 }
		 },
		 series: [{
		 	type: 'pie',
			data: [
		 	<?php $i=0; foreach($mostSpendTags as $tag): if($tag->total_spend < 0): $i++; ?>
				{name:'<?php echo $tag->name ?>', y:<?php echo $tag->total_spend; ?>},
			<?php endif; endforeach; ?>
			]
		 }]
	});
	
	/* ***** Generate Cheaper Graph ***** */
	spendingGraph = new Highcharts.Chart({
		chart: {
        	renderTo: 'cheaperGraph'
		},
		colors: [
			'#8cce6a',
			'#97d379',
			'#b1dc98',
			'#bae0a4',
			'#c4e5b2',
			'#cee9be',
			'#d8edcb',
			'#e1f2d8',
			'#ebf6e5',
			'#f5fbf2'
		],
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
		 plotOptions: {
			 pie: {
				allowPointSelect: true,
				cursor: 'pointer',
				dataLabels: {
				   enabled: false
				},
				showInLegend: false
			 }
		 },
		 series: [{
		 	type: 'pie',
			data: [
		 	<?php $i=0; foreach($cheaperTags as $tag): if($tag->total_spend > 0): $i++; ?>
				{name:'<?php echo $tag->name ?>', y:<?php echo $tag->total_spend; ?>},
			<?php endif; endforeach; ?>
			]
		 }]
	});
});
</script>
<?php endif; ?>