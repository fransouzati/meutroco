<?php require_once('config.php'); ?>

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

			<div id="errors" style="display: none;"></div>     

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
				<!-- <p class="remember_me">
					<label>
						<input type="checkbox" name="remember_me" id="remember_me">
						Lembrar de mim?
					</label>
				</p> -->
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

	<!-- Scripts -->
	<script language="javascript">
	/* Global Site Info */
	siteInfo = {
		url: "<?php echo SITE_URL ?>",
		apiUrl: "<?php echo API_PATH ?>"
	};
	</script>
	<script type="text/javascript" src="_scripts/jQuery.js"></script>
	<script type="text/javascript" src="_scripts/control/home.js"></script>
</body>
</html>