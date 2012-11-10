<h2>Meu Perfíl</h2>
<form>
	<fieldset>
		<label for="profileName">Nome Completo:</label>
		<input type="text" name="name" id="profileName" />
	</fieldset>
	<fieldset>
		<label for="profileGender">Sexo:</label>
		<select id="profileGender" name="gender">
			<option>Masculino</option>
			<option>Feminino</option>
		</select>
		<label for="profileBirthday">Data de nascimento:</label>
		<input type="text" id="profileBirthday" name="birthday" class="fullCalendar" />
	</fieldset>
	<fieldset>
		<label for="profilePassword">Senha:</label>
		<input type="password" name="password" id="profilePassword" />
		<label for="checkProfilePassword">Confirme a senha:</label>
		<input type="password" name="password" id="checkProfilePassword" />
	</fieldset>
	<fieldset>
		<label for="profileEmail">Email:</label>
		<input type="text" name="email" id="profileEmail" />
	</fieldset>
</form>