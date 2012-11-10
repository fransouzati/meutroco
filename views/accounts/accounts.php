<?php
	require_once('../../functions.php'); 
	$api = new API;
	$i = 0;
    isset($_GET['m']) ? $m = $_GET['m'] : $m = date('m');
    isset($_GET['y']) ? $y = $_GET['y'] : $y = date('Y');
    isset($_GET['acc']) ? $accounts = $api->getAccounts($_GET['acc']) : $accounts = $api->getAccounts();
?>

<?php if(count($accounts) == 1): ?>
    <h2>Visualizar conta <span class="actions"><span class="goBack"><a href="javascript:;" title="Voltar para página anterior">Voltar</a></span></span></h2>
<?php else: ?>
    <h2>Ver Todas as Contas</h2>
<?php endif; ?>

<?php if(count($accounts) > 1): ?>
    <!-- Onde está meu dinheiro -->
    <div class="block" id="assetAllocation">
        <h3>Onde está meu dinheiro</h3>
        <div id="assetAllocationGraph" class="graph"><!--Gráfico--></div>
        <table class="tableList">
            <?php foreach($accounts as $acc): if($acc->balance > 0): ?>
                <tr data-id="<?php echo $acc->id ?>" data-name="<?php echo $acc->name ?>" data-role="acc">
                    <td class="name"><?php echo $acc->name ?>:</td>
                    <td class="amount <?php if($acc->balance >= 0) echo 'positive'; else echo 'negative'; ?>"><?php echo moneyFormat($acc->balance, true); ?></td>
                    <td class="actions">
                        <span class="viewSmall"><a href="#contas?acc=<?php echo $acc->id ?>" title="Ver esta conta"></a></span>
                        <span class="editSmall"><a href="#editarConta?id=<?php echo $acc->id ?>" title="Editar esta conta"></a></span>
                        <span class="removeSmall"><a href="#removerConta?id=<?php echo $acc->id ?>" title="Excluir esta conta"></a></span>
                    </td>
                </tr>
            <?php endif; endforeach; ?>
        </table>
    </div>
    
    <span class="blockDistance"></span>

    <!-- Onde mais gastei esse mês -->
    <div class="block" id="mostSpending">
        <h3>Onde mais gastei esse mês</h3>
        <div class="noData">
            Ops! Esse recurso ainda não está implementado completamente. Aguarde por novidades.
        </div>
    </div>
    <span class="clear"></span>
<?php endif; ?>

<div class="double block" id="accountList">
    <h3>Todas as contas</h3>
    <?php 
        foreach($accounts as $acc): 
            $i++; 
            $transactions = $api->getTransactions('all',date($y.'-'.$m.'-01'),date($y.'-'.$m.'-d'), $acc->id); 
            $balance = 0; 
            $positiveTransactions = ""; 
            $negativeTransactions = ""; 
            $oldBalance = 0;
            foreach($transactions as $transaction): 
                $balance += $transaction->amount;
                $html = '';
                $tagList = '';
                $amountClass = '';
                if($transaction->amount > 0) $amountClass = "positive"; else $amountClass = "negative";
                foreach($transaction->tags as $tag): $html .= $tag->name.', '; $tagList .= '<span class="tagged">'.$tag->name.'<span></span></span>';  endforeach;
                
                if($transaction->amount >= 0):
                    $positiveTransactions .= '
                    <tr 
                        class="'.transactionType($transaction->account_from).'" 
                        data-description="'.$transaction->description.'" 
                        data-id="'.$transaction->id.'" 
                        data-type="'.$transaction->type.'" 
                        data-date="'.$transaction->date.'" 
                        data-acc="'.$transaction->account_from.'" 
                        data-accTo="'.$transaction->account_to.'" 
                        data-tags="'.substr($html,0,-2).'
                        data-role="transaction"
                        data-amount="'.$transaction->amount.'"
                    >
                        <td class="name">'.$transaction->description.'</td>
                        <td class="date">'.dateFormat($transaction->date).'</td>
                        <td class="tags">'.$tagList.'</td>
                        <td class="amount '.$amountClass.'">'.moneyFormat($transaction->amount, true).'</td>
                        <td class="actions">
                            <span class="editSmall"><a href="#editarTransacao?id='.$transaction->id.'" title="Editar esta transação"></a></span>
                            <span class="removeSmall"><a href="#removerTransacao?id='.$transaction->id.'" title="Excluir esta transação"></a></span>
                        </td>
                    </tr>
                    ';
                else:
                    $negativeTransactions .= '
                    <tr 
                        class="'.transactionType($transaction->account_from).'" 
                        data-description="'.$transaction->description.'" 
                        data-id="'.$transaction->id.'" 
                        data-type="'.$transaction->type.'" 
                        data-date="'.$transaction->date.'" 
                        data-acc="'.$transaction->account_from.'" 
                        data-accTo="'.$transaction->account_to.'" 
                        data-tags="'.substr($html,0,-2).'
                        data-role="transaction"
                        data-amount="'.$transaction->amount.'"
                    >
                        <td class="name">'.$transaction->description.'</td>
                        <td class="date">'.dateFormat($transaction->date).'</td>
                        <td class="tags">'.$tagList.'</td>
                        <td class="amount '.$amountClass.'">'.moneyFormat($transaction->amount, true).'</td>
                        <td class="actions">
                            <span class="editSmall"><a href="#editarTransacao?id='.$transaction->id.'" title="Editar esta transação"></a></span>
                            <span class="removeSmall"><a href="#removerTransacao?id='.$transaction->id.'" title="Excluir esta transação"></a></span>
                        </td>
                    </tr>
                    ';
                endif; 
            endforeach; 

            $oldBalance = $acc->balance - $balance;
    ?>
	
        
    <div id="acc<?php echo $i ?>" class="block double">
            <div class="<?php echo transactionType($acc->account_type_id) ?>">
                <h3><?php echo $acc->name ?></h3>
            </div>
    
            <!-- <div class="monthSelectInTitle">
                <input type="text" class="calendar monthCalendar" value="<?php echo thisMonthName($m)." ".$y ?>" />
            </div> -->
    
            <div class="content">
                <div class="block double">
                    <table id="accountResume" class="cashFlow">
                        <tbody>
                            <tr class="total">
                                <td>Saldo anterior:</td>
                                <td colspan="3" class="amount <?php if($oldBalance >= 0) echo 'positive'; else echo 'negative'; ?>"><?php echo moneyFormat($oldBalance, true) ?></td>
                            </tr>
                             <tr>
                                <th scope="rowgroup" colspan="4">Receitas</th>
                            </tr>
    
                            <?php echo $positiveTransactions; ?>
    
                            <tr>
                                <th scope="rowgroup" colspan="4">Despesas</th>
                            </tr>
    
                             <?php echo $negativeTransactions; ?>                        
    
                            <tr class="partialTotalAmount">
                                <th scope="row" colspan="3">Balanço do mês:</th>
                                <td class="amount <?php if($balance >= 0) echo "positive"; else echo "negative"; ?>"><?php echo moneyFormat($balance, true); ?></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th scope="row" colspan="3">Saldo:</th>
                                <td class="amount <?php if($acc->balance >= 0) echo 'positive'; else echo 'negative'; ?>"><?php echo moneyFormat($acc->balance, true) ?></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
    </div>
</div>
    
    <!-- Script -->
	<script>
	jQuery(document).ready(function(){
		<?php if(count($accounts) > 1): ?>
            /* ***** Generate Asset Allocation Graph ***** */
        	assetAllocation = new Highcharts.Chart({
                chart: {
                    renderTo: 'assetAllocationGraph',
                    type: 'pie'
                },
                colors: [
                    <?php $i=0; foreach($accounts as $acc): if($acc->balance > 0): $i++; ?>
                        <?php echo "'".transactionTypeColor($acc->account_type_id)."',"; ?>
                    <?php endif; endforeach; ?>
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
                 series: [
                 {
                    data: [
                    <?php $i=0; foreach($accounts as $acc): if($acc->balance > 0): $i++; ?>
                        {name:'<?php echo $acc->name ?>', y:<?php echo $acc->balance; ?>},
                    <?php endif; endforeach; ?>
                    ]
                 }]
            });
        <?php endif; ?>
    });
   
    </script>
<?php endforeach; ?>



