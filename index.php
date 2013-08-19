<?php require_once('config.php'); //require_once("functions.php"); ?>

<?php
	/*
		UserPie
		http://userpie.com
	*/
	require_once("models/config.php");
	
	//Prevent the user visiting the logged in page if he/she is already logged in
	//if(isUserLoggedIn()) { header("Location: minha-conta/"); die(); }
?>
<?php
	/* 
		Below is a very simple example of how to process a login request.
		Some simple validation (ideally more is needed).
	*/

//Forms posted
if(!empty($_POST))
{
		$errors = array();
		$username = trim($_POST["username"]);
		$password = trim($_POST["password"]);
		if(isset($_POST["remember_me"]))
			$remember_choice = trim($_POST["remember_me"]);
		else
			$remember_choice = false;
	
		//Perform some validation
		//Feel free to edit / change as required
		if($username == "")
		{
			$errors[] = lang("ACCOUNT_SPECIFY_USERNAME");
		}
		if($password == "")
		{
			$errors[] = lang("ACCOUNT_SPECIFY_PASSWORD");
		}
		
		//End data validation
		if(count($errors) == 0)
		{
			//A security note here, never tell the user which credential was incorrect
			if(!usernameExists($username))
			{
				$errors[] = lang("ACCOUNT_USER_OR_PASS_INVALID");
			}
			else
			{
				$userdetails = fetchUserDetails($username);
			
				//See if the user's account is activation
				if($userdetails["active"]==0)
				{
					$errors[] = lang("ACCOUNT_INACTIVE");
				}
				else
				{
					//Hash the password and use the salt from the database to compare the password.
					$entered_pass = generateHash($password,$userdetails["password"]);

					if($entered_pass != $userdetails["password"])
					{
						//Again, we know the password is at fault here, but lets not give away the combination incase of someone bruteforcing
						$errors[] = lang("ACCOUNT_USER_OR_PASS_INVALID");
					}
					else
					{
						//passwords match! we're good to go'
						
						//Construct a new logged in user object
						//Transfer some db data to the session object
						$loggedInUser = new loggedInUser();
						$loggedInUser->email = $userdetails["email"];
						$loggedInUser->id = $userdetails["id"];
						$loggedInUser->hash_pw = $userdetails["password"];
						$loggedInUser->display_username = $userdetails["username"];
						$loggedInUser->clean_username = $userdetails["username_clean"];
						$loggedInUser->remember_me = $remember_choice;
						$loggedInUser->api_key = $_POST['api_key'];
						$loggedInUser->login = $userdetails["email"];
						$loggedInUser->redirect = 'false';
						$loggedInUser->remember_me_sessid = generateHash(uniqid(rand(), true));
						
						//Update last sign in
						$loggedInUser->updatelast_sign_in();
		
						if($loggedInUser->remember_me == 0)
							$_SESSION["userPieUser"] = $loggedInUser;
							else if($loggedInUser->remember_me == 1) {
							$db->sql_query("INSERT INTO ".$db_table_prefix."sessions VALUES('".time()."', '".serialize($loggedInUser)."', '".$loggedInUser->remember_me_sessid."')");
							setcookie("userPieUser", $loggedInUser->remember_me_sessid, time()+parseLength($remember_me_length));
						}
						
						//Redirect to user account page
						$url = API_PATH . '/login';
						$data = $loggedInUser;

						// use key 'http' even if you send the request to https://...
						$options = array(
							'http' => array(
								'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
								'method'  => 'POST',
								'content' => http_build_query($data),
							),
						);
						$context  = stream_context_create($options);
						$result = file_get_contents($url, false, $context);

						header("Location: minha-conta/?token=".$result);
						exit(); die();
					}
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

			<?php if(isset($_GET['status']) && $_GET['status'] == "success") { ?>
			<div id="success">
				Sua conta foi criada com sucesso. Basta logar-se!
			</div>
			<?php } ?>

			<form method="post" action="<?php echo API_PATH . '/login' ?>" id="loginForm">
				<input type="hidden" id="api_key" name="api_key" value="<?php echo API_KEY ?>" />
				<input type="hidden" name="remember_me" id="remember_me" value="false">

				<p><input type="text" name="username" value="<?php if(isset($_POST["username"])) { echo $_POST["username"]; } ?>" placeholder="Nome de usuário"></p>
				<p><input type="password" name="password" value="" placeholder="Senha"></p>
				<p class="remember_me">
					<label>
						<input type="checkbox" name="remember_me" id="remember_me">
						Lembrar de mim?
					</label>
				</p>
				<p class="submit"><input type="submit" name="commit" id="newfeedform" value="Entrar"></p>
			</form>

			<div class="register">
				<a href="/novo-usuario" title="Clique para se registrar">Não possui uma conta?</a>
			</div>
		</div>

		<!-- <div class="login-help">
			<p>Esqueceu sua senha? <a href="index.html">Clique aqui</a>.</p>
		</div> -->
	</section>
</body>
</html>