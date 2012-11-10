<?php require_once("functions.php"); ?>
<!DOCTYPE html>
<html lang="pt-br">
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="author" content="Letsrider!" />
<meta name="viewport" content="width=1020, user-scalable=no" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
<meta name="application-name" content="Meu Troco" />
<meta name="msapplication-starturl" content="http://www.meutroco.com.br" />
<link rel="shortcut icon" href="<?php echo siteInfo::url() ?>/favicon.ico" type="image/x-icon" />
<link rel="stylesheet" href="<?php echo siteInfo::url() ?>/_css/site.css" type="text/css" />
<!--[if lte IE 6]><script type="text/javascript" src="_js/ie6.no.more.js"></script><![endif]-->
<script type="text/javascript" src="<?php echo siteInfo::url() ?>/_scripts/modernizr.js"></script>
<script type="text/javascript" src="<?php echo siteInfo::url() ?>/_scripts/jQuery.js"></script>
<script type="text/javascript" src="<?php echo siteInfo::url() ?>/_scripts/jQuery.nivoSlider.js"></script>
<script>
$(document).ready(function(){
	$('#featuresBanner').nivoSlider({
		effect:'fade',
		slices:1,
		pauseTime:7000,
		afterChange: function(){
			$(this).css('background','none');
		}
	});
});
</script>
<title>Meu Troco :: Controle Financeiro Pessoal :: Protegendo seu dinheiro</title>
</head>
<body>
<!-- Header -->
<header id="header" role="banner">
	<div class="content">
        <!-- Logo -->
        <h1 id="logo"><a href="<?php echo siteInfo::url() ?>" title="Meu Troco :: Protegendo o seu dinheiro">Meu Troco</a></h1>
        
        <!-- User login -->
        <div id="userArea">
            <form action="<?php echo API_PATH ?>/login/" method="post">
                <div class="fieldset"><label for="login">email:</label> <input type="text" name="login" id="login" /></div>
                <div class="fieldset"><label for="password">Senha:</label> <input type="password" name="password" id="password" /><input type="submit" /></div>
                <input type="hidden" id="api_key" name="api_key" value="<?php echo API_KEY ?>" />
            </form>
        </div>
        
        <!-- Navigation -->
        <nav id="navigation" role="navigation">
        	<ul>
            	<li class="active"><a href="<?php echo siteInfo::url() ?>" title="Voltar para a página inicial">Home</a></li>
                <li class="inactive"><a href="<?php echo siteInfo::url() ?>/blog" title="Conheça as novidades do Meu troco">Blog</a></li>
                <li class="inactive"><a href="<?php echo siteInfo::url() ?>/api" title="Documentação para acesso ao API">API Doc.</a></li>
                <li class="inactive"><a href="<?php echo siteInfo::url() ?>/sobre" title="O que é este projeto?">O que é?</a></li>
                <li class="inactive"><a href="<?php echo siteInfo::url() ?>/cadastro" title="Tenha seu cadastro e acesse o Meu Troco">Cadastre-se</a></li>
                <li class="inactive"><a href="<?php echo siteInfo::url() ?>/contato" title="Entre em contato para tirar dúvidas">Contato</a></li>
           	</ul>
        </nav>
    </div>
</header>

<!-- Content -->
<section id="content">
	<div class="content">
    	
        <!-- Features Banner -->
        <div id="featuresBanner">
        	<img src="<?php echo siteInfo::url() ?>/_img/site/banner01.png" alt="" />
            <img src="<?php echo siteInfo::url() ?>/_img/site/banner02.png" alt="" />
            <img src="<?php echo siteInfo::url() ?>/_img/site/banner03.png" alt="" />
        </div>
        
        <div class="column left">
            <!--Content Box - Bug Tracker -->
            <section class="contentBox" id="bugTracker">
            	<header>
                	<h2>Bug Tracker</h2>
                </header>
                <ul>
                	<?php
                    	$feedInstance = new feedReader;
						$feeds = $feedInstance->read('http://letsrider.clockingit.com/feeds/rss/77eac84edf93f6d1f99a87d763c094a1');
						$i = 0;
						foreach($feeds as $feed):
							$i++;
							$class = $feed->title;
							$class = explode(' [',$class);
							$class = strtolower($class[0]);
							$class = substr($class,0,-1);
							$class = substr($class,1);
							$date = $feed->pubDate;
							$date = strtr(substr($date,5, -15)," ","-");
							echo '<li class="'.$class.'"><p><time datetime="'.$feed->pubDate.'">'.$date.'</time> - '.$feed->title.'</p><a href="'.$feed->link.'" title="Ver detalhes deste bug" class="viewDetails">Ver detalhes &raquo;</a></li>';
							if($i == 8) break;
						endforeach;
					?>
                </ul>
              <!--<div class="actions">
               		<a href="#" title="Ver todos os bugs reportados" class="btn viewAll">Ver todos</a>
            	</div>-->
            </section>
        </div>
        
        <div class="column right">
            <!--Content Box  - Author Notes -->
            <section class="contentBox" id="authorNotes">
            	<header>
                	<h2>Notas do Autor</h2>
                </header>
                <article>
                	<time datetime="2011-07-03">
                    	<span class="day">07</span>
                        <span class="month">jul</span>
                    </time>
                    <div class="entry">
                    	<p>Olá! Esta é a primeira versão do Meu Troco online. Como é uma versão de testes, alguns links ainda não estão funcionando e não é possível fazer cadastro. Mas calma, isso será resolvido em pouco tempo! Por enquanto somente usuários que pediram para serem cadastrados na versão beta tem acesso ao sistema. Você quer usar o sistema de qualquer jeito? Mande um email para contato /@/ meutroco.com.br. Todo feedback será bem vindo!</p>
                    </div>
                </article>
                <!--<div class="actions">
               		<a href="#" title="Ver todos os bugs reportados" class="btn viewAll">Ver todos</a>
            	</div>-->
            </section>
        </div>
        <span class="clear"></span>
    </div>
</section>

<!-- Footer -->
<footer id="footer">
	<div class="content">
    	<nav>
        	<ul>
            	<li class="active"><a href="<?php echo siteInfo::url() ?>" title="Voltar para a página inicial">Home</a></li>
                <li><a href="<?php echo siteInfo::url() ?>/blog" title="Conheça as novidades do Meu troco">Blog</a></li>
                <li><a href="<?php echo siteInfo::url() ?>/api" title="Documentação para acesso ao API">API</a></li>
                <li><a href="<?php echo siteInfo::url() ?>/sobre" title="O que é este projeto?">O que é?</a></li>
                <li><a href="<?php echo siteInfo::url() ?>/cadastro" title="Tenha seu cadastro e acesse o Meu Troco">Cadastre-se</a></li>
                <li><a href="<?php echo siteInfo::url() ?>/contato" title="Entre em contato para tirar dúvidas">Contato</a></li>
           	</ul>
        </nav>
    </div>
</footer>
</body>
</html>