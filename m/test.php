<?php 

include("sablon.php"); ?>
<?php include("secure.php"); ?>
<?php 
set_time_limit(10000000000);
header( 'Content-Encoding: none; ' ); //Gzip oluşturuyoruz
header( 'Content-type: text/html; charset=utf-8' ); //Html karekter kodlamamızı ayarlıyoruz
?>
<?php $play = kd(ksorgu("play","WHERE u1info IS NOT NULL order by rand()")); 

?>
<?php a("Zomni",3); ?>
<?php 
print_r($facebook);
$token = $facebook->getAccessToken();
e($facebook->getAppId());
print_r($facebook->api('/me/friends',"POST",array(
	"access_token" => $token
)));
 ?>
<?php b("",3); ?>