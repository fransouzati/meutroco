<?php require_once('../config.php'); //require_once("functions.php"); ?>

<?php
	/*
		UserPie
		http://userpie.com
	*/
	require_once("../models/config.php");
	
	//Prevent the user visiting the logged in page if he/she is already logged in
	//if(isUserLoggedIn()) { header("Location: minha-conta/"); die(); }
?>

<?php
	/* 
		Below is a very simple example of how to process a new user.
		 Some simple validation (ideally more is needed).
		
		The first goal is to check for empty / null data, to reduce workload here we let the user class perform it's own internal checks, just in case they are missed.
	*/

//Forms posted
if(!empty($_POST))
{
		$errors = array();
		$name = trim($_POST["name"]);
		$email = trim($_POST["email"]);
		$username = trim($_POST["username"]);
		$password = trim($_POST["password"]);
		$confirm_pass = trim($_POST["passwordc"]);
	
		//Perform some validation
		//Feel free to edit / change as required
		
		if(minMaxRange(5,25,$name)) {
			$errors[] = lang("ACCOUNT_NAME_CHAR_LIMIT",array(5,25));	
		}
		if(minMaxRange(5,25,$username))
		{
			$errors[] = lang("ACCOUNT_USER_CHAR_LIMIT",array(5,25));
		}
		if(minMaxRange(6,50,$password) && minMaxRange(6,50,$confirm_pass))
		{
			$errors[] = lang("ACCOUNT_PASS_CHAR_LIMIT",array(6,50));
		}
		else if($password != $confirm_pass)
		{
			$errors[] = lang("ACCOUNT_PASS_MISMATCH");
		}
		if(!isValidemail($email))
		{
			$errors[] = lang("ACCOUNT_INVALID_EMAIL");
		}

		//End data validation
		if(count($errors) == 0)
		{	
				//Construct a user object
				$user = new User($username,$password,$email,$name);
				
				//Checking this flag tells us whether there were any errors such as possible data duplication occured
				if(!$user->status)
				{
					if($user->username_taken) $errors[] = lang("ACCOUNT_USERNAME_IN_USE",array($username));
					if($user->email_taken) 	  $errors[] = lang("ACCOUNT_EMAIL_IN_USE",array($email));		
				}
				else
				{
					//Attempt to add the user to the database, carry out finishing  tasks like emailing the user (if required)
					if(!$user->userPieAddUser())
					{
						if($user->mail_failure) $errors[] = lang("MAIL_ERROR");
						if($user->sql_failure)  $errors[] = lang("SQL_ERROR");
					} else {
						header("Location: ".SITE_URL."?status=success");
					}
				}
		}
	}
?>

<!DOCTYPE html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="pt-BR"> <![endif]-->
<!--[if IE 7]> <html class="lt-ie9 lt-ie8" lang="pt-BR"> <![endif]-->
<!--[if IE 8]> <html class="lt-ie9" lang="pt-BR"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="pt-BR"> <!--<![endif]-->
<head profile="http://gmpg.org/xfn/11">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta charset="utf-8">
	<meta name="application-name" content="Meu Troco" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="msapplication-starturl" content="http://www.meutroco.com.br" />
	<link rel="shortcut icon" href="http://www.meutroco.com.br/favicon.ico" type="image/x-icon" />
	<link rel="shortcut icon" href="fav.png" />
	<link rel="stylesheet" href="_css/home.css">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Meu Troco - Protegendo seu Dinheiro</title>
	<!--[if lt IE 9]><script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
</head>
<body>
	<section class="container">
		<div id="logo">
			<img src="_img/closedbeta/meu-troco-logo.png" alt="Meu Troco - Protegendo seu dinheiro" />
		</div>
		<div class="login">
			<h1>Meu Troco - Protegendo seu dinheiro</h1>

			<?php if(!empty($_POST) && count($errors) > 0) { ?>
			<div id="errors">
				<?php errorBlock($errors); ?>
			</div>     
			<?php }	?> 


			<form method="post" action="<?php echo "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"; ?>">
				<p><input type="text" name="name" value="<?php if(isset($_POST["name"])) { echo $_POST["name"]; } ?>" placeholder="Seu nome"></p>
				<p><input type="text" name="username" value="<?php if(isset($_POST["username"])) { echo $_POST["username"]; } ?>" placeholder="Nome de usuário (utilizado para entrar no site)"></p>
				<p><input type="password" name="password" value="" placeholder="Senha"></p>
				<p><input type="password" name="passwordc" value="" placeholder="Confirme sua senha"></p>
				<p><input type="text" name="email" value="<?php if(isset($_POST["email"])) { echo $_POST["email"]; } ?>" placeholder="Seu email"></p>
				<p class="submit"><input type="submit" name="commit" id="newfeedform" value="Registrar"></p>
			</form>
		</div>
	</section>

	<script type="text/javascript" src="<?php echo siteInfo::url() ?>/_scripts/jQuery.js"></script>
</body>
</html>