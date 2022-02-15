<?php 

if(isset($_COOKIE['uid'])) { 
	$varmi = ksorgu("uyeler","WHERE id='{$_COOKIE['uid']}'");
	if($varmi!=0) {
	oturumAc();
	oturum("uid",$_COOKIE['uid']);
	yonlendir("profile.php");
	} else {
		oturumAc();
		unset($_COOKIE['uid']);
		unset($_SESSION['uid']);
	}
	
}
 ?>