<?php  
	require_once('../../functions.php'); 
	$api = new API;
?>
<h2>Adicionar Uma Conta</h2>
<form>
	<fieldset>
		<label for="accountName">Nome:</label>
		<input id="accountName" name="accountName" type="text" title="Insira aqui o nome da conta" />
	</fieldset>
	<fieldset>
		<label for="accountType">Tipo: </label>
		<select id="accountType" name="accountType" title="Escolha o tipo de conta">
			<?php foreach($api->getAccountTypes() as $type){ ?> 
				<option value="<?php echo $type->id ?>"><?php echo $type->name ?></option>
			<?php } ?>
		</select>
	</fieldset>
	<fieldset>
		<label for="initialBalance">Saldo inicial:</label>
		<input class="maskDecimal" id="initialBalance" name="initialBalance" type="text" value="0,00" title="Quanto já existe nesta conta?" /> <span class="valid">R$</span>
	</fieldset>
</form>