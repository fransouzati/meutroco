<?php 
//Config
require_once('../functions.php');

//Apagar cookie
setcookie('token','',time()-3600,'/');

//Retorna para site
header('Location: '.siteInfo::Url());
?>