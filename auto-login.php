<?php include("pfi-tema.php");
oturumAc();
$bilgi = array(
	"id" => get("id"),	
	"okul" => get("okul"),
	"bolum" => get("bolum"),
	"adi" => get("adi"),
	"gender" => get("gender"),
	"soyadi" => get("soyadi"),
	"seviye" => get("seviye"),
	"resim" => get("resim"),
	"sifre" => get("sifre"),
	"slug" => get("slug")
);
$md5 = md5(implode(",",$bilgi));
if($_GET['md5'] == $md5) {
	e("ok");
	$varmi = ksorgu("uyeler","where mail='{$bilgi['slug']}'");
	if($varmi==0) {
		$bilgi['mail'] = $bilgi['slug'];
		$bilgi['user'] = md5($bilgi['mail']);
	//	unset($bilgi['id']);
		$bilgi['y'] = 1;
		$id = dEkle("uyeler",$bilgi);
		oturum("uid",$id);
		setcookie("uid",$bilgi['id'],time() + (30*60*60*24));
	} else {
		$u = kd($varmi);
		e("<hr />");
		print_r($u);
		dGuncelle("uyeler",$bilgi,"id='{$u['id']}'");
		print_r($_COOKIE);
		oturum("uid",$u['id']);
		setcookie("uid",$u['id'],time() + (30*60*60*24));
		print_r($_SESSION);
	}
	yonlendir("m/profile.php");
} else {
	e("false");
}
?>