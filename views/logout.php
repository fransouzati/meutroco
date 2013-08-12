<?php require_once('../config.php'); //require_once("functions.php"); ?>
<?php 
//Config
include("../models/config.php");

//Log the user out
if(isUserLoggedIn()) $loggedInUser->userLogOut();
	
//Apagar cookie
setcookie('token','',time()-3600,'/');

//Retorna para site
header('Location: '.SITE_URL);
?>