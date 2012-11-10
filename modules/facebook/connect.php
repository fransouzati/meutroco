<?php
# Config
//require_once('../../functions.php');

# Facebook API
require_once('facebook.php');

# Creating the facebook object
$facebook = new Facebook(array(  
    'appId'  => FACEBOOK_APIKEY,  
    'secret' => FACEBOOK_SECRET,  
    'cookie' => true
));

# Let's see if we have an active session 
$session = $facebook->getUser(); 

if(!empty($session)):
	# Active session, let's try getting the user id (getUser()) and user info (api->('/me'))  
    try{  
        $uid = $facebook->getUser();  
        $user = $facebook->api('/me');  
    } catch (Exception $e){} 
	
	if(!empty($user)){  
        # User info ok? Let's print it (Here we will be adding the login and registering routines) 
        print_r($user); 
    } else { 
        # For testing purposes, if there was an error, let's kill the script  
        die("There was an error.");  
    } 
else:  
    # There's no active session, let's generate one  
    $login_url = $facebook->getLoginUrl();  
    header("Location: ".$login_url);  
endif;


?>