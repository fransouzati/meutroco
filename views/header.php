<!DOCTYPE html>
<html lang="pt-br" class="no-js">
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="author" content="Letsrider!" />
<meta name="viewport" content="width=1020, user-scalable=no" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
<meta name="application-name" content="Meu Troco" />
<meta name="msapplication-starturl" content="http://www.meutroco.com.br" />
<title><?php echo DEFAULT_TITLE ?></title>
<link rel="shortcut icon" href="<?php echo siteInfo::url() ?>/favicon.ico" type="image/x-icon" />
<link rel="stylesheet" href="<?php echo siteInfo::url() ?>/_css/style.css" media="all" type="text/css" />
<link rel="stylesheet" href="<?php echo siteInfo::url() ?>/_css/print.css" media="print" type="text/css" />
<!--[if lte IE 6]><script type="text/javascript" src="_js/ie6.no.more.js"></script><![endif]-->
<script language="javascript">
	/* Global Site Info */
	siteInfo = {
		url: "<?php echo siteInfo::url() ?>",
		apiUrl: "<?php echo siteInfo::apiUrl() ?>",
		userId: "<?php echo User::userInfo('id') ?>",
		newUser: "<?php echo User::userInfo('newUser'); ?>",
		lastLogin: "<?php echo User::userInfo('lastLogin'); ?>",
		thisSession: "<?php echo User::userInfo('thisSession'); ?>",
		token: "<?php echo User::token() ?>", //TODO: Apagar essa linha
		apiKey: "<?php echo siteInfo::apiKey() ?>" //TODO: Apagar essa linha
	};
	
	/* Uservoice Script **/
	var uvOptions = {};
	(function() {
		var uv = document.createElement('script'); uv.type = 'text/javascript'; uv.async = true;
		uv.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'widget.uservoice.com/eZeZg2zelZ2EutcvBvlG5w.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(uv, s);
	})();
	
	/* Analytics Script */
	//////////////////////
</script>
<script type="text/javascript" src="<?php echo siteInfo::url() ?>/_scripts/jQuery.js"></script>
<script type="text/javascript" src="<?php echo siteInfo::url() ?>/_scripts/jQuery.plugins.js"></script>
<script type="text/javascript" src="<?php echo siteInfo::url() ?>/_scripts/jQuery.fx.js"></script>
<script type="text/javascript" src="<?php echo siteInfo::url() ?>/_scripts/ajax.requests.js"></script>
<script type="text/javascript" src="<?php echo siteInfo::url() ?>/_scripts/jQuery.defaults.js"></script>
</head>
<body>
<!-- Loading requests -->
<div id="loadingRequest">Aguarde...</div>

<!-- header -->
<header id="header" role="banner">
	<h1 id="logo"><a href="<?php echo siteInfo::url() ?>" title="Meu Troco :: Protegendo o seu dinheiro"><img src="../_img/logo.png" alt="Meu Troco" /></a></h1>
	<div id="userArea">
		<div class="avatar">
			<?php if(User::userInfo('photoUrl') != ""): ?>
				<img src="<?php echo User::userInfo('photoUrl'); ?>" alt="" width="55" />
			<?php elseif(User::userInfo('gender') == "male"): ?>
				<img src="<?php echo siteInfo::url(); ?>/_img/blankAvatar.jpg" alt="" width="55" />
			<?php else: ?>
				<img src="<?php echo siteInfo::url(); ?>/_img/blankAvatarFemale.jpg" alt="" width="55" />
			<?php endif; ?>
		</div>
		<p class="welcome">Bem vindo, <?php echo User::userInfo('firstName') ?>!</p>
		<p class="logInfo">Entrou a <span id="loggedTime">00 min</span></p>
		<a href="#meuPerfil" class="myProfileLink">Meu perfil</a>
		<a href="<?php echo siteInfo::apiUrl() ?>/<?php echo User::userInfo('id') ?>/logout/token=<?php echo User::token() ?>&api_key=<?php echo siteInfo::apiKey() ?>" class="btnExit" title="Sair do Meu Troco">Logout</a>
	</div>
</header>

<!-- FeedBack -->
<!-- <a id="giveFeedback" href="#feedback" title="Ideias? Sugestões? Problemas? Mande para agente">Feedback</a> -->

<!-- navigation -->
<nav id="navigation" role="navigation">
	<ul>
		<li class="nav-resume active"><a href="#resumo" title="Visualizar resumo do mês">Resumo</a></li>
		<li class="nav-account">
			<a href="#contas" title="">Contas</a>
			<ul>
				<span class="balloonArrow"></span>
				<li class="nav-account-add"><a href="#adicionarConta" title="Adicionar uma nova conta">Criar nova conta</a></li>
				<li class="nav-account-view"><a href="#contas" title="Visualizar todas as minhas contas">Ver todas</a></li>
			</ul>
		</li>
		<li class="nav-tags">
			<a href="#tags" title="">Tags</a>
			<ul>
				<span class="balloonArrow"></span>
				<!--<li class="nav-tag-edit"><a href="#editarTags" title="Escolher e editar um tag">Editar tags</a></li>-->
				<li class="nav-tag-add"><a href="#adicionarTag" title="Adicionar uma tag">Criar nova tag</a></li>
				<li class="nav-tag-view"><a href="#tags" title="Visualizar todas as tags">Ver todas</a></li>
			</ul>
		</li>
		<!--<li class="nav-profile"><a href="#meuPerfil" title="Visualizar e editar meu perfil">Meu perfil</a></li>-->
	</ul>
</nav>

<div id="contentWrap">