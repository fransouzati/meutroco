<?php require_once("functions.php"); ?>
<!DOCTYPE HTML>
<html lang="pt-BR">
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="application-name" content="Meu Troco" />
<meta name="msapplication-starturl" content="http://www.meutroco.com.br" />
<link rel="shortcut icon" href="http://www.meutroco.com.br/favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="fav.png" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Meu Troco - Protegendo seu Dinheiro</title>
<style>
	html {background:url(_img/closedbeta/bg2.jpg) repeat #d6d6d6; margin:0; padding:0;}
	body {background:url(_img/closedbeta/bg1.jpg) no-repeat center center #d6d6d6; width:990px; height:610px; position:absolute; top:50%; left:50%; margin:-305px 0 0 -495px; text-align:center; padding:0; font-family:Arial, Helvetica, sans-serif; }
	div#header {margin:25px 0 0 0;}
	p {color:#6f6f6f; font-size:15px; font-weight:bold; margin:40px 0 20px 0;}
	fieldset {margin:0 auto 50px auto; padding:0; border:none; width:290px;}
	input[type="text"],
	input[type="password"] {border:1px solid #999; background:white; border-radius:12px; margin:0 0 0 10px; font-weight:bold; font-size:19px; color:#999; padding:9px 10px 10px 10px; width:260px; display:block; margin:0 0 10px 0;}
	input[type="submit"] {width:60px; height:42px; background:url(_img/closedbeta/btn-ok.png) no-repeat right top; border:none; z-index:-999%; line-height:0; font-size:0; cursor:pointer; float:right; margin-top:-53px; margin-right:9px;}
	input[type="text"]:focus,
	input[type="password"]:focus,
	input[type="submit"]:focus {outline:none;}
	.message {position:absolute; width:100%; text-align:center; top:398px;}
	.message span {font-weight:bold; font-size:12px; padding:3px 10px; border-radius:5px; -webkit-border-radius:5px; -moz-border-radius:5px;}
	.error span {background:#FCC; background:rgba(255, 183, 183, .5); color:#710000;}
	.success span {background:#D9FFD9; color:#060; border:1px solid #A4FFA4;}
	.loading {background:url(_img/closedbeta/loading.gif) no-repeat left top; width:14px; height:14px; display:block; position:absolute; left:323px; top:328px;}
</style>
<script type="text/javascript" src="<?php echo siteInfo::url() ?>/_scripts/jQuery.js"></script>
<script>
$(document).ready(function(){
		$('input[type="text"], input[type="password"]')
			.addClass('off')
			.bind('focusin', function(){
				$(this).removeClass('off').attr('value','');
			})
			.bind('focusout', function(){
				if($(this).attr('value') == $(this).attr('placeholder') || $(this).attr('value') == '')
					if($(this).is('[type="text"]'))
					$(this).addClass('off').attr('value',$(this).attr('placeholder'));
			});
		
		$('form').bind('submit', function(event){
			$('form').prepend('<span class="loading"></span>');
			$('.message').hide();
			$.ajax({
				url: $('form').attr('action'),
				type:'POST',
				data: {login: $('form input[name="login"]').val(), password: $('form input[name="password"]').val(), api_key:$('form input[name="api_key"]').val(), redirect: 'false' },
				success: function(data){
					window.location = "minha-conta/?token=" + data
				},
				error: function(data){
					$('<div class="message error" style="display:none"><span>Ops! Confira o seu email e senha...</span></div>').prependTo($('form')).fadeIn();
					$('.loading').fadeOut(function(){$(this).remove();});
				}
			});
			
			event.preventDefault();
			return false;
		});
	});
</script>
</head>
<body>
<div id="header"> 
	<h1><img src="_img/closedbeta/meu-troco-logo.png" alt="Meu Troco - Protegendo seu dinheiro" /></h1>
</div>
<div id="section">
	<p>O projeto "MEU TROCO" está quase pronto...</p>
    <form action="<?php echo API_PATH ?>/login/" method="post" onsubmit="javascript:void(0)">
    	<fieldset>
        	<input type="text" placeholder="Email:" value="Email:" name="login" id="login" />
			<input type="password" placeholder="Senha:" name="password" id="password" />
			<input type="hidden" id="api_key" name="api_key" value="<?php echo API_KEY ?>" />
            <input type="submit" value="OK" />
        </fieldset>
    </form>
	<img src="_img/closedbeta/print.png" alt="">
	<img src="_img/closedbeta/loading.gif" style="position:absolute; left:-99999999px; top: -99999999999px; opacity: 0.01;">
</div>
</body>
</html>
