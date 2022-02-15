<?php 
/*
peyamFi 
yönetici bölümü içerikleri yetki dosyası. Bu her yönetici sayfasında olmak zorundadır.
*/
include("pfi-bd-yonga.php");
//diğer izin bilgilerini eklemeyi unutma!!!
oturumAc();
//peyamFi Güvenlik Görevlisi her kaydolan bütün paneli görebilir 
//ama bütün işlemler nihayetinde pfi-bvi-yonga.php de yapıldığı için 
//seviye orada geçerlidir
//izin olmadığı durumunda ana sayfaya yönlendirir.
//27.01.2012 Cuma 14:53 
izin("pFiUser","peyamFi","index.php"); 

if(isset($_GET['cikis']) && ($_GET['cikis']==1)) { //cikis isimli bir get değişkenin değeri 1 olması durumunda bütün oturum değişkenleri silinir. Bir ayak izi dahi bırakmaz 
				oturumSil("uid");
				oturumSil("pFiMail");
				oturumSil("pFiUser");
				oturumSil("pFi");
				oturumSil("Seviye");
				oturumSil("adi");
				oturumSil("soyadi");
				yonlendir("index.php");

}

/*
//her kullanıcının kendine ait bir dizini olmalı
$root = substr(kripto(oturum("uid") . "peyamFi"),0,15) . "/";
if (!file_exists("pfi-depo/" . $root)) {
mkdir("pfi-depo/" . $root);
}
//echo $root;
$dizin =  $_SERVER['SERVER_NAME'];
$site = $_SERVER['HTTP_HOST'];
//echo "http://" . $dizin . "/WEB/2012/GYSD/gysd/gysd/"  . $root;
*/
//kullanıcı değişkenleri
$kullanici = oturum("adi") . " " . oturum("soyadi");
$uid = oturum("uid");
$mail = oturum("pFiMail");
$seviye = oturum("Seviye2");

if($seviye=="Okuyucu") {
	yonlendir("index.php");
}
if($seviye=="Yazar") {
	yonlendir("urunler.php");
}

?>
<?php function cattitle($slug){
	$cat = kd(content($slug));
	return $cat['title'];
	
} ?>
<?php function catlogo($slug){
	$cat = kd(content($slug));
	if($cat['pic']!="") {
	return $cat['pic'];
	} else {
		$cat = kd(content($cat['kid']));
		return $cat['pic'];
	}
} ?>
<?php function username($uid) {
	$user = user($uid);
	return "{$user['adi']} {$user['soyadi']}";
} ?>
<?php function user($id,$alan="") {
	$ne = kd(ksorgu("uyeler","WHERE id = $id"));
	if($alan!="") {
		return $ne[$alan];
	} else {
		return $ne;
	}
} ?>

