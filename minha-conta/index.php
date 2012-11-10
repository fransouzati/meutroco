<?php
//Configurações da administração
require_once("../functions.php");

//Cria API
$api = new API;

//Caso o usuário não esteja logado
//if(!$im_usuario->logado):

//Caso o usuário esteja logado e validado
//else:
		//require_once("views/institucional/index.html");
 
		//Adiciona topo do site
		require_once("../views/header.php");
		
		//Adiciona conteúdo do site
		require_once("../views/content.php");
		
		//Adiciona rodapé do site
		require_once("../views/footer.php");

//endif;
?>