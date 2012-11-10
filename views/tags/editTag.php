<h2>Editar Marcador</h2>
<form>
	<fieldset>
		<label for="tagName">Nome:</label>
		<input type="text" id="tagName" name="tagName" title="Altere o nome deste marcador." value="<?php echo $_GET['name']; ?>" />
        <input type="hidden" name="id" id="id" value="<?php echo $_GET['id']; ?>" />
	</fieldset>
</form>
