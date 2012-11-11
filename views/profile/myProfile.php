<?php  
	require_once('../../functions.php'); 
	$api = new API;
	$user = $api->getProfileInfo();
	$user = $user[0];
?>
<h2>Editar meu perfil</h2>
<form>
	<fieldset>
		<label for="profileName">Nome:</label>
		<input type="text" name="name" id="profileName" value="<?php echo $user->name;?>" />
	</fieldset>
	<fieldset>
		<label for="profileBirthday">Nascimento:</label>
		<input type="text" id="profileBirthday" name="birthday" class="fullCalendar" value="<?php echo dateFormat($user->birthday);?>" />
		<label for="profileGender">Sexo:</label>
		<select id="profileGender" name="gender">
			<option value="male" <?php if($user->gender == "male") echo "selected"; ?>>Masculino</option>
			<option value="female" <?php if($user->gender == "female") echo "selected"; ?>>Feminino</option>
		</select>
	</fieldset>
	<fieldset>
		<label for="profileEmail">Email:</label>
		<input type="text" name="email" id="profileEmail" value="<?php echo $user->email;?>" />
	</fieldset>
	<fieldset>
		<p>Deseja alterar sua senha? Basta preencher os campos:</p>
	</fieldset>
	<fieldset>
		<label for="profilePassword">Senha atual:</label>
		<input type="password" name="password" id="profilePassword" />
		<label for="checkProfilePassword">Nova senha:</label>
		<input type="password" name="newPassword" id="newProfilePassword" />
	</fieldset>
</form>

<div class="changePhoto">
	<?php if($user->photoUrl != ""): ?>
		<img src="<?php echo $user->photoUrl; ?>" alt="" width="100" />
	<?php elseif($user->gender == "male"): ?>
		<img src="<?php echo siteInfo::url(); ?>/_img/blankAvatar.jpg" alt="" width="100" />
	<?php else: ?>
		<img src="<?php echo siteInfo::url(); ?>/_img/blankAvatarFemale.jpg" alt="" width="100" />
	<?php endif; ?>
	<?php /*<a href="javascript:;" id="changeProfilePhoto">Alterar foto</a>*/ ?>
</div>

<span class="clear"></span>