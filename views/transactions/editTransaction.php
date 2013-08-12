<?php  
	require_once('../../functions.php'); 
	$api = new API;
?>
<h2>Editar Transação</h2>
<form>
	<fieldset>
		<label for="transDescription">Descrição:</label>
		<input type="text" name="description" id="transDescription" value="<?php echo $_GET['description']; ?>" />
	</fieldset>
	<fieldset>
		<label for="transAmount">Valor:</label>
		<input type="text" id="transAmount" name="amount" value="<?php $a =$_GET['amount']; if($a < 0) $a=$a*-1; echo moneyFormat($a); ?>" /> R$
	</fieldset>
	<fieldset>
		<label for="transType">Tipo:</label>
		<select id="transType" name="transType">
			<?php foreach($api->getTransactionTypes() as $type){ ?> 
				<option value="<?php echo $type->id ?>" <?php if(isset($_GET['type'])) if($_GET['type'] == $type->id) echo 'selected="selected"'; ?>><?php echo $type->name ?></option>
			<?php } ?>
		</select>
		<label for="dateSelect">Data:</label>
		<input type="text" id="dateSelect" name="date" class="fullCalendar" value="<?php echo dateFormat($_GET['date']); ?>" />
		<span class="calendarIco"></span>
	</fieldset>
	<fieldset>
		<label for="accountFrom">Conta:</label>
		<select id="accountFrom" name="accountFrom">
			<?php foreach($api->getAccounts() as $acc): ?>
				<?php if(isset($_GET['acc']) && $_GET['acc'] == $acc->id): ?> 
					<option value="<?php echo $acc->id ?>" selected <?php if($acc->status != 1) echo "disabled" ?>><?php echo $acc->name ?></option>
				<?php elseif($acc->status == 1): ?>
					<option value="<?php echo $acc->id ?>"><?php echo $acc->name ?></option>
				<?php endif; ?>
			<?php endforeach; ?>
		</select>
		<span class="transferTo transfer"></span>
		<select id="accountTo" class="transfer" name="accountTo">
			<?php foreach($api->getAccounts() as $acc): ?> 
				<?php if(isset($_GET['accto']) && $_GET['accto'] == $acc->id): ?> 
					<option value="<?php echo $acc->id ?>" selected <?php if($acc->status != 1) echo "disabled" ?>><?php echo $acc->name ?></option>
				<?php elseif($acc->status == 1): ?>
					<option value="<?php echo $acc->id ?>"><?php echo $acc->name ?></option>
				<?php endif; ?>
			<?php endforeach; ?>
		</select>
	</fieldset>
	<fieldset>
		<label for="selectTags">Tags:</label>
		<input type="text" id="selectTags" name="tags" class="suggest tagSuggest" value="<?php echo $_GET['tags']; ?>" />
	</fieldset>
	<input type="hidden" name="transactionId" value="<?php echo $_GET['id'] ?>" />
</form>