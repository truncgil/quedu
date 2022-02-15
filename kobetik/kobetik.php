<?php ob_start(); ?>
<?php 
/*
Trunçgil Teknoloji 2012
Kobetik v2
Yazan (Author) : Ümit TUNÇ
*/
?>
<?php 
function isMobile2() {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}
if(!isset($_SESSION['redirectIptal'])) {
if(isMobile2()){
    header("Location: m/");
}
}

require("ayarlar.php"); ?>
<?php require("yonga/yonga.php"); 
mysql_query("SET NAMES utf8");
?>