<?php
	require_once('../functions.php'); 
	$api = new API; 
	$totalGastos = 0.00;
	$totalGanhos = 0.00;
	$totalSaldo = 0.00;
	$creditos = 0.00;
	$accounts = $api->getAccounts();
	$transactions = $api->getTransactions('all',date('Y-m-01'),date('Y-m-d'));
?>

<?php if(count($accounts) != 0): ?>
	<h2>Minhas Contas</h2>
	<div class="myAccountsList">
		<?php $i=0; foreach($accounts as $acc): $i++; ?>	
				<div id="sidebarAcc<?php echo $i ?>" class="account <?php echo transactionType($acc->account_type_id) ?>">
                    <h3 
						data-id="<?php echo $acc->id ?>"
						data-name="<?php echo $acc->name ?>"
						data-accountType="<?php echo $acc->account_type_id ?>"
						data-initialBalance="<?php echo $acc->initial_balance ?>"
						data-role="account"
					>
						<a href="#contas?acc=<?php echo $acc->id ?>" title="Visualizar histórico desta conta"><?php echo $acc->name ?></a>
						<span class="actions">
							<span class="editSmall"><a href="#editarConta?id=<?php echo $acc->id ?>" title="Editar esta conta"></a></span>
							<span class="removeSmall"><a href="#removerConta?id=<?php echo $acc->id ?>" title="Excluir esta conta"></a></span>
						</span>
					</h3>
                    <ul class="tableList">
                        <li>Saldo: <span class="amount <?php if($acc->balance >= 0) echo 'positive'; else echo 'negative'; ?>"><?php echo moneyFormat($acc->balance, true) ?></span></li>
                        <li class="subtitle"><?php echo thisMonthName() ?></li>
                        <?php 
                            $gastos = $ganhos = $balanco = $creditos = 0;
                            foreach($transactions as $transaction):
                                if($transaction->account_from === $acc->id):
									$transaction->amount < 0 ? $gastos += $transaction->amount : $ganhos += $transaction->amount;
									if($transaction->type == "3"):
										$gastos -= $transaction->amount;
										$ganhos -= $transaction->amount;
										$creditos += $transaction->amount;
									endif;
								elseif($transaction->account_to === $acc->id):
									$ganhos += $transaction->amount;
								endif;
                            endforeach;
							$balanco = $ganhos + $gastos;
                        ?>
                        <li><?php if($acc->account_type_id == "1") echo "Utilizei:"; else echo "Despesas:"; ?> <span class="amount <?php if($gastos >= 0) echo 'positive'; else echo 'negative'; ?>"><?php echo moneyFormat($gastos, true) ?></span></li>
                        <li><?php if($acc->account_type_id == "1") echo "Paguei:"; else echo "Receitas:"; ?> <span class="amount <?php if($ganhos >= 0) echo 'positive'; else echo 'negative'; ?>"><?php echo moneyFormat($ganhos, true) ?></span></li>
                        <?php if($acc->account_type_id != "1"): ?> <li>Balanço do mês: <span class="amount <?php if($balanco >= 0) echo 'positive'; else echo 'negative'; ?>"><?php echo moneyFormat($balanco, true) ?></span></li><?php endif; ?>
                    </ul>
                    <ul class="actions">
                    <li class="addTrans"><a href="#adicionarTransacao?acc=<?php echo $acc->id ?>" title="Adicionar Transação">Adicionar transação</a></li>
                </ul>
			</div>
		<?php
			$totalGastos += $gastos + $creditos;
			$totalGanhos += $ganhos - $creditos;
			$totalSaldo += $acc->balance;
		?>
		<?php endforeach; ?>
		<div class="account balance">
			<ul class="tableList">
				<li class="subtitle">Em <?php echo thisMonthName() ?>...</li>
				<li>ganhei: <span class="amount positive"><?php echo moneyFormat($totalGanhos, true) ?></span></li>
				<li>gastei: <span class="amount negative"><?php echo moneyFormat($totalGastos, true) ?></span></li>
				<li class="total">EU TENHO: <span class="amount  <?php if($totalSaldo >= 0) echo 'positive'; else echo 'negative'; ?>"><?php echo moneyFormat($totalSaldo, true) ?></span></li>
			</ul>
		</div>
	</div>
<?php endif; ?>

