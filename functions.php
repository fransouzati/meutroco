<?php 
ob_start(); session_start();

//Config
require_once('config.php');

//facebook API
//require_once('modules/facebook/facebook.php');

/* Informações básicas do site  
 ****************************************************** */
class siteInfo {
	public static function url() {
		return SITE_URL;
	}
	public static function apiUrl() {
		return API_PATH;
	}
	public static function proxyUrl() {
		return PROXY_URL;
	}
	public static function apiKey() {
		return API_KEY;
	}
}

/* Verificador de localhost  
 ****************************************************** */
function isLocalHost() {
	$islocal = false; 
	$host = $_SERVER['SERVER_ADDR'];
	if($host == "localhost"):
		$islocal = true;
	endif;
	$ip = explode(".",$host);
	if($ip[0] == "192" || $ip[0] == "172" || $ip[0] == "127" || $ip[0] == "198"):
		$islocal = true;
	endif;
	return $islocal;
}

/* Formatar valor monetário para padrão BRL
 ****************************************************** */
function moneyFormat($number, $currency = false) {
	if($currency == true)
	    return 'R$ '.number_format($number,2,',','.');
	else
		return number_format($number,2,',','.');
}

/* Formatar data para padrão BRL
 ****************************************************** */
function dateFormat($date){
	$date = new DateTime($date);
	return $date->format('d/m/Y');
}

/* Retorna o nome do mês atual 
 ****************************************************** */
function thisMonthName($m = "", $mini = false) {
	if(empty($m))
		$m = date('m');
	if(!$mini):
		switch ($m) {
			case "01":    $mes = "Janeiro";     break;
			case "02":    $mes = "Fevereiro";   break;
			case "03":    $mes = "Março";       break;
			case "04":    $mes = "Abril";       break;
			case "05":    $mes = "Maio";        break;
			case "06":    $mes = "Junho";       break;
			case "07":    $mes = "Julho";       break;
			case "08":    $mes = "Agosto";      break;
			case "09":    $mes = "Setembro";    break;
			case "10":    $mes = "Outubro";     break;
			case "11":    $mes = "Novembro";    break;
			case "12":    $mes = "Dezembro";    break; 
	 	}
	else:
		switch ($m) {
			case "01":    $mes = "Jan";    break;
			case "02":    $mes = "Fev";    break;
			case "03":    $mes = "Mar";    break;
			case "04":    $mes = "Abr";    break;
			case "05":    $mes = "Mai";    break;
			case "06":    $mes = "Jun";    break;
			case "07":    $mes = "Jul";    break;
			case "08":    $mes = "Ago";    break;
			case "09":    $mes = "Set";    break;
			case "10":    $mes = "Out";    break;
			case "11":    $mes = "Nov";    break;
			case "12":    $mes = "Dez";    break; 
	 	}
	endif;
 return $mes;
}

/* Retorna o tipo de transação (de acordo com o ID)
 ****************************************************** */
function transactionType($type){
	if($type == 1)
		return 'creditCard';
	if($type == 2)
		return 'checking';
	elseif($type == 3)
		return 'investment';
	elseif($type == 4)
		return 'cash';
	elseif($type == 5)
		return 'others';
}

function transactionTypeColor($type){
	if($type == 1)
		return '#D98B26';
	if($type == 2)
		return '#25a19d';
	elseif($type == 3)
		return '#D9539B';
	elseif($type == 4)
		return '#5362D9';
	elseif($type == 5)
		return '#666666';
	else
		return 'RED';
}

/* Retorna a URL do site atual
 ****************************************************** */
function curPageURL() {
 $pageURL = 'http';
 //if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}

/* Retorna a lista dos últimos x meses
 ****************************************************** */
function getLatestMonths($latest = 13) {
	$arr = array();

	for($i = 0; $i < $latest; $i++):
		array_push($arr, date("Y-m-1", strtotime("- " . $i . " month")));
	endfor;

	return array_reverse($arr);
}

/* Funções básicas de usuário
 ****************************************************** */
class User {
	
	/* ***** Informações em array ***** */
	public static function userInfo($t) {
		$json = json_decode(file_get_contents(siteInfo::apiUrl().'/user/token='.User::token()));
		 foreach($json as $j):
		 	return $j->$t;
		 endforeach;
	}
	
	/* ***** Retorna e grava Token ***** */
	public static function token() {
		if(isset($_GET['token'])) {
			$_SESSION['token'] = $_GET['token'];
			$loc = curPageUrl();
			$loc = explode('?',$loc);
			$loc = $loc[0];
			header('Location: '.$loc);
		}
		elseif(isset($_SESSION['token'])) {
			return $_SESSION['token'];
		} else {
			header('Location: '.SITE_URL);
		}
	}
}

/* Converte caracteres UNICODE para acento
 ****************************************************** */
function convertToUnicode($t){	
	$array = array(
		"&aacute;" => "á",
		"&agrave;" => "à",
		"&acirc;" => "â",
		"&atilde;" => "ã",
		"&auml;" => "ä",
		"&eacute;" => "é",
		"&egrave;" => "è",
		"&ecirc;" => "ê",
		"&euml;" => "ë",
		"&iacute;" => "í",
		"&igrave;" => "ì",
		"&icirc;" => "î",
		"&iuml;" => "ï",
		"&oacute;" => "ó",
		"&ograve;" => "ò",
		"&ocirc;" => "ô",
		"&otilde;" => "õ",
		"&ouml;" => "ö",
		"&uacute;" => "ú",
		"&ugrave;" => "ù",
		"&ucirc;" => "û",
		"&uuml;" => "ü",
		"&ccedil;" => "ç",
		"&Aacute;" => "Á",
		"&Agrave;" => "À",
		"&Acirc;" => "Â",
		"&Atilde;" => "Ã",
		"&Auml;" => "Ä",
		"&Eacute;" => "É",
		"&Egrave;" => "È",
		"&Ecirc;" => "Ê",
		"&Euml;" => "Ë",
		"&Iacute;" => "Í",
		"&Igrave;" => "Î",
		"&Icirc;" => "Î",
		"&Iuml;" => "Ï",
		"&Oacute;" => "Ó",
		"&Ograve;" => "Ò",
		"&Ocirc;" => "Ô",
		"&Otilde;" => "Õ",
		"&Ouml;" => "Ö",
		"&Uacute;" => "Ú",
		"&Ugrave;" => "Ù",
		"&Ucirc;" => "Û",
		"&Uuml;" => "Ü",
		"&Ccedil;" => "Ç"
	);
	
	return strtr($t,$array);
}

/* Classe API
 ****************************************************** */
class API extends User {
	/* ***** Transações ***** */
	//Retorna transações
	public function getTransactions($count = 10, $from = "", $to = "", $account = "", $tag = "", $orderby = "", $order = ""){
		return json_decode(file_get_contents(API_PATH.'/'.User::userInfo('id').'/transactions/token='.$this->token().'&count='.$count.'&from='.$from.'&to='.$to.'&account='.$account.'&tag='.$tag.'&orderby='.$orderby.'&order='.$order));
	}
	
	//Retorna tipos de transações
	public function getTransactionTypes(){
		return json_decode(file_get_contents(API_PATH.'/'.User::userInfo('id').'/transactions/types/token='.$this->token()));
	}
	
	/* ***** Tags ***** */
	//Retorna tags
	 public function getTags($count = 10, $account = "", $orderby = "name", $order = "asc", $from = "", $to = "") {
		 return json_decode(file_get_contents(API_PATH.'/'.User::userInfo('id').'/tags/token='.$this->token().'&count='.$count.'&account='.$account.'&orderby='.$orderby.'&order='.$order.'&from='.$from.'&to='.$to));
	 }
	 
	 //Retorna tag única
	 public function getTag($id) {
		 return json_decode(file_get_contents(API_PATH.'/'.User::userInfo('id').'/tags/token='.$this->token().'&id='.$id));
	 }
	
	/* ***** Contas ***** */
	//Retorna contas
	public function getAccounts($account = ""){
		return json_decode(file_get_contents(API_PATH.'/'.User::userInfo('id').'/accounts/token='.$this->token().'&id='.$account));
	}
	
	//Retorna tipo de contas
	public function getAccountTypes(){
		return json_decode(file_get_contents(API_PATH.'/'.User::userInfo('id').'/accounts/types/token='.$this->token()));
	}
	
	//Retorna balanço
	public function getAccountBalance($account = "", $month = "", $year = "", $orderby = "account", $order = ""){
		return json_decode(file_get_contents(API_PATH.'/'.User::userInfo('id').'/accounts/balance/token='.$this->token().'&account='.$account.'&month='.$month.'&year='.$year.'&orderBy='.$orderby.'&order='.$order));
	}

	//Retorna as informações do usuário
	public function getProfileInfo(){
		return json_decode(file_get_contents(API_PATH.'/user/token='.$this->token()));
	}
}

?>