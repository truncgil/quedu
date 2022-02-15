<?php 
/*Pelinom Facebook Login v1.0*/

require 'fb2.3/src/facebook.php';
if(getisset("facebookLogin")) {
	print_r(post("array"));
	$profile = post("array");
//	$array = json_decode(post("array"));
//	print_r($array);
	$fb = veri("%".$profile['id']."%"); // daha önce mail izni verip tekrar izni kaldıranlar olabilir
		$varmi = ksorgu("uyeler","WHERE facebook LIKE $fb"); //fb id ile bir bak bakalım
		if($varmi==0) {
			$max = kd(sorgu("SELECT MAX(id) AS son FROM uyeler"));
			$son = $max['son']+1;
			dEkle("uyeler",array(
				"id" => $son,
				"y" => 1,
				"user" => kripto(ed($profile['email'],$profile['id'])),
				"adi" => $profile['first_name'],
				"soyadi" => $profile['last_name'],
				"mail" => ed($profile['email'],$profile['id']),
				"gender" => $profile['gender'],
				"facebook" => $profile['link'],
				"locale" => $profile['locale'],
				"birthday" => date_format(date_create($profile['birthday']),"Y-m-d"),
				
				"location" => ed($profile['location']['name'],""),
				"cover" => ed($profile['cover']['source'],""),
				"hometown" => ed($profile['hometown']['name'],""),
				"education" => ed(json_encode($profile['education']),""),
				"work" => ed(json_encode($profile['work']),""),
				"resim" => $profile['picture']['data']['url'],
				"sifre" => kripto("zomni".$profile['id']),
				"fbid" => $profile['id'],
				"seviye" => "Okuyucu"
			));
			
			$bilgi = kd(ksorgu("uyeler","WHERE mail='{$profile['email']}'"));
			oturumAc();
			oturum("uid", $bilgi['id']);
			setcookie("uid",$u['id'],time() + (30*60*60*24));
			e("Yeni eklendi");
		} else {
				$u = kd($varmi);
				dguncelle("uyeler",array(
				"adi" => $profile['first_name'],
				"soyadi" => $profile['last_name'],
				"mail" => ed($profile['email'],$profile['id']),
				"gender" => $profile['gender'],
				"facebook" => $profile['link'],
				"locale" => $profile['locale'],
				"birthday" => date_format(date_create($profile['birthday']),"Y-m-d"),
				"fbid" => $profile['id'],
				"slug" => slug("{$profile['first_name']} {$profile['last_name']} {$u['id']}"),
				"location" => ed($profile['location']['name'],""),
				"cover" => ed($profile['cover']['source'],""),
				"hometown" => ed($profile['hometown']['name'],""),
				"education" => ed(json_encode($profile['education']),""),
				"work" => ed(json_encode($profile['work']),""),
				"resim" => $profile['picture']['data']['url'],
				"sifre" => kripto("zomni".$profile['id']),
				"seviye" => "Okuyucu"
			),"id='{$u['id']}'");
				oturumAc();
				oturum("uid", $u['id']);
				setcookie("uid",$u['id'],time() + (30*60*60*24));
				e("Güncellendi");
		}
	exit();
}
$facebook = new Facebook(array(
    'appId' => '1459822474326327',
    'secret' => '3c847153f31693d14f5e87f42d75b528',
	'cookie' => true
	));
	$userid = $facebook->getUser();
	if(getisset("fb_source")) {
		if($userid==0) {
			$login = $facebook->getLoginUrl(array(
			'canvas'    => 1,
			'fbconnect' => 1,
			'redirect_uri' => 'https://apps.facebook.com/zomniapp',
			'scope' => 'email,publish_stream,offline_access'
			));
			e("<script>top.location.href='$login';</script>'");
		}
	}
	if ( $userid ){
		try {
		   $profile = $facebook->api('/me?fields=cover,locale,link,hometown,first_name,last_name,id,birthday,name,picture.type(large),email,gender,location,work,education');
			//$profile = $facebook->api('/me');
			print_r($profile);
		} catch ( FacebookApiException $e ){
		   print $e->getMessage();
			$userid = null;
		}
	//	e("test");
	print_r($profile);
		//eğer yoksa ekle
		$fb = veri("%".$profile['id']."%"); // daha önce mail izni verip tekrar izni kaldıranlar olabilir
		$varmi = ksorgu("uyeler","WHERE facebook LIKE $fb"); //fb id ile bir bak bakalım
		if($varmi==0) {
			$max = kd(sorgu("SELECT MAX(id) AS son FROM uyeler"));
			$son = $max['son']+1;
			dEkle("uyeler",array(
				"id" => $son,
				"y" => 1,
				"user" => kripto(ed($profile['email'],$profile['id'])),
				"adi" => $profile['first_name'],
				"soyadi" => $profile['last_name'],
				"mail" => ed($profile['email'],$profile['id']),
				"gender" => $profile['gender'],
				"facebook" => $profile['link'],
				"locale" => $profile['locale'],
				"birthday" => date_format(date_create($profile['birthday']),"Y-m-d"),
				
				"location" => ed($profile['location']['name'],""),
				"cover" => ed($profile['cover']['source'],""),
				"hometown" => ed($profile['hometown']['name'],""),
				"education" => ed(json_encode($profile['education']),""),
				"work" => ed(json_encode($profile['work']),""),
				"resim" => $profile['picture']['data']['url'],
				"sifre" => kripto("zomni".$profile['id']),
				"fbid" => $profile['id'],
				"seviye" => "Okuyucu"
			));
			
			$bilgi = kd(ksorgu("uyeler","WHERE mail='{$profile['email']}'"));
			oturumAc();
			oturum("uid", $bilgi['id']);
			setcookie("uid",$u['id'],time() + (30*60*60*24));
			yonlendir("profile.php");

		} else {
				$u = kd($varmi);
				dguncelle("uyeler",array(
				"adi" => $profile['first_name'],
				"soyadi" => $profile['last_name'],
				"mail" => ed($profile['email'],$profile['id']),
				"gender" => $profile['gender'],
				"facebook" => $profile['link'],
				"locale" => $profile['locale'],
				"birthday" => date_format(date_create($profile['birthday']),"Y-m-d"),
				"fbid" => $profile['id'],
				"slug" => slug("{$profile['first_name']} {$profile['last_name']} {$u['id']}"),
				"location" => ed($profile['location']['name'],""),
				"cover" => ed($profile['cover']['source'],""),
				"hometown" => ed($profile['hometown']['name'],""),
				"education" => ed(json_encode($profile['education']),""),
				"work" => ed(json_encode($profile['work']),""),
				"resim" => $profile['picture']['data']['url'],
				"sifre" => kripto("zomni".$profile['id']),
				"seviye" => "Okuyucu"
			),"id='{$u['id']}'");
				oturumAc();
				oturum("uid", $u['id']);
				setcookie("uid",$u['id'],time() + (30*60*60*24));
				yonlendir("profile.php");
		}
		
	}



	if ( $userid ){
		$logout = $facebook->getLogoutUrl(array(
			'next' => '?cikis=1'
		));
		//print_r($profile);
		//echo "bağlantı kuruldu";
	} else {
		$login = $facebook->getLoginUrl(array(
			'scope' => 'email',
			'next' => 'profile.php'
		));
		yonlendir($login);
		
	}
	



 ?>