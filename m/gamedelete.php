<?php

if(isset($_SESSION['playgame'])) { //eğer mevcutta bir oyun varsa
	$sorgu =ksorgu("play","WHERE id = '{$_SESSION['playgame']}' AND (u1info is not null)");//u1 boş değilse bu işlemi oyunu ilk kişiye uygulamaması için yapıyoruz
	if($sorgu!=0) {
	$kim = kd($sorgu); 
	//bilgilerin değişkeni ilk oyuncu zaten oyunu bitirdi ben ikinci oyuncuyum ben vazgeçtim
		$score = "u2score"; 
		$info= "u2info";
		$winscore=$kim['u1score'];
		$ben = $kim['u2'];
		$o = $kim['u1'];

	$sorular = json_decode($kim['sorular']);
	$k = 0;
	$userinfo = array();
	foreach($sorular AS $soru) { // her bir soruyu alalım ve infoya boş atayalım
		$userinfo[$k]['soru'] = $soru;
		$userinfo[$k]['cevap'] = 0;
		$userinfo[$k]['dogru'] = 0;
		$userinfo[$k]['sure'] = 0;
		$userinfo[$k]['score'] = 0;
		$k++;
	}
	$jsoninfo = json_encode($userinfo); 
	dGuncelle("play",array(
		$score => 0,
		$info => "$jsoninfo"
	),"id={$_SESSION['playgame']}");
	$varmi = ksorgu("results","WHERE pid = {$_SESSION['playgame']}");
	if($varmi==0) {
		dEkle("results",array(
			"sonuc" => "Win",
			"kat" => $kim['kat'],
			"pid" => $_SESSION['playgame'],
			"tarih" => simdi(),
			"uid" => $o,
			"uid2" => $ben
		));
		dEkle("results",array(
			"kat" => $kim['kat'],
			"sonuc" => "Lost",
			"pid" => $_SESSION['playgame'],
			"tarih" => simdi(),
			"uid" => $ben,
			"uid2" => $o
		));
		dEkle("scores",array(
			"score" => $winscore,
			"tarih" => simdi(),
			"pid" => $_SESSION['playgame'],
			"uid" => $o,
			"kat" => $kim['kat']
		));
		dEkle("scores",array(
			"score" => 0,
			"pid" => $_SESSION['playgame'],
			"tarih" => simdi(),
			"kat" => $kim['kat'],
			"uid" => $ben
		));
		//ona bir bildirimde bulunalım
		logz($o,"{$user['adi']} {$user['soyadi']} sana hükmen mağlup!","{$user['adi']} {$user['soyadi']} oyundan erken çıktı ve sana hükmen mağlup oldu!","result2.php?id={$_SESSION['playgame']}");
		yonlendir("profile.php");
	}
	} else { //ben kendim girdim kendim vazgeçtim
		sil("play","id = '{$_SESSION['playgame']}'");
	}
	unset($_SESSION['playgame']);
	unset($_SESSION['userinfo']);
	oturumSil("isGoruldu");
}

 ?>