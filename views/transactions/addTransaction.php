<?php  
	require_once('../../functions.php'); 
	$api = new API;
?>
<h2>Adicionar Transação</h2>
<form method="get" action="#">
	<fieldset>
		<label for="transDescription">Descrição:</label>
		<input type="text" name="description" id="transDescription" />
	</fieldset>
	<fieldset>
		<label for="transAmount">Valor:</label>
		 <input type="text" id="transAmount" name="amount" value="0,00" />
	</fieldset>
	<fieldset>
		<label for="transType">Tipo:</label>
		<select id="transType" name="transType">
			<?php foreach($api->getTransactionTypes() as $type): ?> 
				<option value="<?php echo $type->id ?>"><?php echo $type->name ?></option>
			<?php endforeach; ?>
		</select>
		<label for="dateSelect">Data:</label>
		<input type="text" id="dateSelect" name="date" class="fullCalendar" value="<?php echo date('d').'/'.date('m').'/'.date('Y') ?>" />
		<span class="calendarIco"></span>
	</fieldset>
	<fieldset>
		<label for="accountFrom">Conta:</label>
		<select id="accountFrom" name="accountFrom">
			<?php foreach($api->getAccounts() as $acc): ?> 
				<option value="<?php echo $acc->id ?>" <?php if(isset($_GET['acc'])) if($_GET['acc'] == $acc->id) echo 'selected="selected"'; ?>><?php echo $acc->name ?></option>
			<?php endforeach; ?>
		</select>
		<span class="transferTo transfer"></span>
		<select id="accountTo" class="transfer" name="accountTo">
			<?php foreach($api->getAccounts() as $acc): ?> 
				<option value="<?php echo $acc->id ?>"><?php echo $acc->name ?></option>
			<?php endforeach; ?>
		</select>
	</fieldset>
	<fieldset>
		<label for="selectTags">Marcadores:</label>
		<input type="text" id="selectTags" name="tags" class="suggest tagSuggest" />
	</fieldset>
</form>