<?php
/*
 * CONFIGURAÇÕES DO SERVIDOR
 * ATENÇÃO: Cuidado ao alterar este arquivo. Todo o funcionamento do sistema está baseado nestas configurações.
 * @autor: Rafael Heringer Carvalho
 * @url: www.meutroco.com.br
 */

//Produção ou testes
define('TEST_SERVER',true);

//Diretório da API
TEST_SERVER ? define('API_PATH', 'http://127.0.0.1/api.meutroco.com.br') : define('API_PATH', 'http://www.api.meutroco.com.br');

//Arquivo principal da API
define('API_URL',API_PATH.'/api.php');

//Chave da API
TEST_SERVER ? define('API_KEY','d8988842-43d5-42b3-9049-af4bbc69') : define('API_KEY','d675432123-43d5-42b3-9049-af4bbc68');

//Diretório do site
TEST_SERVER ? define('SITE_URL','http://127.0.0.1/meutroco.com.br') : define('SITE_URL','http://www.meutroco.com.br');

//Proxy URL
define('PROXY_URL',SITE_URL.'/proxy.php');

//Título padrão para o "minha-conta"
define('DEFAULT_TITLE',':: Meu Troco');

//Locale
setlocale(LC_MONETARY, 'pt_BR');
date_default_timezone_set('America/Sao_Paulo');

//Facebook
define('FACEBOOK_APIKEY','225468620827830');
define('FACEBOOK_SECRET','52b7db183efd056cc7ed1c37325341d1');
?>