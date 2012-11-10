<?php  
	require_once('../../functions.php'); 
	$api = new API;
	$accounts = $api->getAccounts();
	$total = count($accounts);
?>
<h2>Editar Conta</h2>
<form>
	<fieldset>
		<label for="accountName">Nome:</label>
		<input id="accountName" name="accountName" type="text" title="Insira aqui o nome da conta" value="<?php echo $_GET['name']; ?>" />
	</fieldset>
	<fieldset>
		<label for="accountType">Tipo:</label>
		<select id="accountType" name="accountType" title="Escolha o tipo de conta">
			<?php foreach($api->getAccountTypes() as $type){ ?> 
				<option value="<?php echo $type->id ?>" <?php if($type->id == $_GET['accountType']) echo "selected='selected'"; ?>><?php echo $type->name ?></option>
			<?php } ?>
		</select>
	</fieldset>
	<fieldset>
		<label for="initialBalance">Saldo inicial:</label>
		<input class="maskDecimal" id="initialBalance" name="initialBalance" type="text" value="<?php echo moneyFormat($_GET['initialBalance']) ?>" /> <span class="valid">R$</span>
	</fieldset>
    <input type="hidden" id="accountId" name="accountId" value="<?php echo $_GET['id']; ?>" />
</form>