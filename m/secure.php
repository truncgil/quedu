<?php 
//print_R($_COOKIE);
oturumAc();
/*
require 'fb2.3/src/facebook.php';
$facebook = new Facebook(array(
    'appId' => '1459822474326327',
    'secret' => '3c847153f31693d14f5e87f42d75b528',
	'cookie' => true
));
*/
if(!isset($_COOKIE['uid'])) { 
	if(!oturumisset("uid")) {
		yonlendir("login.php");
	} 
} else { 
	oturumAc(); 
	$_SESSION['uid'] = $_COOKIE['uid'];
	$uid = $_SESSION['uid'];
	$q = "WHERE id = $uid";
	$kim = ksorgu("uyeler","$q");
	$user = kd($kim);
	$education = json_decode($user['education']);	
}
if(getisset("cikis")) {	
	oturumSil("uid");
	unset($_COOKIE['uid']);
	setcookie("uid",null,-1,"/");
	foreach ($_COOKIE as $key => $value) {
    unset($value);
    setcookie($key, '', time() - 360000);
	}
	yonlendir("login.php?cikildi");
}




	


?>