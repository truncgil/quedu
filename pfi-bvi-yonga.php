<?php
error_reporting(E_ALL); ini_set("display_errors", 1); 
include("pfi-bd-yonga.php");
/*
PelinomFi - Pelinom Farklı İçerik Yönetim Sistemi 

Bilumum Veritabanı İşlemleri Yongası (BVIYonga.php)
Gelen sorguyu işleyip veritabanına attıktan sonra istenilen mevkiye gönderen çekirdek yapısı
Yazan: Ümit TUNÇ
	Daha mükemmel bir Türkiye için yapabildiğimin en iyisini yapmalıyım!
	En küçük bir işim bile dünya kalitesinde olmak zorunda...
	Allah'ım yardım et!
	
Başlangıç Tarihi: 31/12/2011 Saat: 02:30
Bitiş Tarihi: 31/03/2012 Saat: 09:00

Yeniden Düzenleme 16.02.2014 Saat 14:52
*/

oturumAc();
$uyeIslem = sprintf("http://%s/pfi-bvi-yonga.php?",$adres);

//bu sayfayı kurcalayan kişinin bütün bilgilerini toplayalım
$uid = oturum("uid");
if($uid=="") {

	$uid = post("uid");

}
//echo $uid;
$user = sorgu(
			sprintf("SELECT * FROM uyeler WHERE id=%s",
					veri($uid)
					)
			);
$kisi = kd($user);
$seviye = oturum("Seviye2");
if($seviye == "") {
	$seviye = $kisi['Seviye'];
}
//echo $seviye;
switch ($seviye) {
	case "Yonetici" : 
	$ks = 3;
	break;
	case "Yazar" :
	$ks = 2;
	break;
	case "Okuyucu" :
	$ks = 1;
	break;	
	default :
	$ks = 0;
	break;
}
//$ks = 3;
/*üye işlemleri
üye kaydolur
üye şifresini unutur ve şifre talebi oluşturur ve üyenin şifresi mail adresine gönderilir.
üye şifresini mail adresindeki url adresine tıklar ve değiştirme sayfasına gönderilir.
üye seviye yükseltir. (Okuyucu, Yazar ve Yönetici)
*/ 
if(getisset("cokluResim")) {
		$imza2 = kripto($imza.post("uid"));
		if(postesit("imza",$imza2)) {
			//kullanıcı bilgisini al user ve id
			$user = post("user");
			$id = post("uid");
			$dir ="file/{$_POST['kid']}/";
			if (!file_exists($dir) && !is_dir($dir)) {
				mkdir($dir);         
			} 
		}
	
}
if(getisset("ara")) {
$k = trim(get("term"));
$k = str_replace(" ", "%",$k);
$kriter = veri("%". $k . "%");
$kriter2 = veri("%". strtoupper(get("term")) . "%");
$urunler = sorgu("SELECT *,urunler.isim AS urun_isim, urunler.slug AS uslug 
FROM urunler 
WHERE  (urunler.isim LIKE $kriter 
OR urunler.isim LIKE $kriter2)
LIMIT 0,10");
$a =0;
if($urunler!=0) :
while ($k = kd($urunler)) {
	$items[$a]['value'] = htmlspecialchars_decode($k['urun_isim']); 
	$items[$a]['slug'] = $k['uslug']; 
	$items[$a]['resim'] = resim("resimler/urunler/" . $k['resim'],100,'align="left"'); 
	$items[$a]['kategori'] = kategori($k['kid']); 
	$a++;
}
else :
	$items[$a]['value'] = "Aradığınız kritere uygun ürün bulunamadı. $k sonucunu detaylı aramak için tıklayın."; 
	$items[$a]['id'] = ""; 
	$items[$a]['kriter'] = $k; 
	$items[$a]['resim'] = "<img src='resimler/dock/31.png'align='left' width='50' />";
	$items[$a]['kategori'] = ""; 
	$items[$a]['yok'] = "1"; 
	
endif;
echo json_encode($items);

}
if((isset($_GET['urunler']))) {
	switch($_GET['urunler']) :
		case "listele" :
			oturumAc();
			if(!oturumisset("kid")) {
				oturum("kid",get("kid"));
			}
			$deger = veri(get("deger"));
			$ozellik = veri(get("ozellik"));
			if(getisset("deger")) :
				if(getesit("sil","1")) :
					unset($_SESSION['kriter'][$ozellik][$deger]);
				else :			
					if(!oturumisset("kriter")) {
						$_SESSION['kriter'] =array();
						$_SESSION['kriter'][$ozellik][$deger]=1;
					} else {
						$_SESSION['kriter'][$ozellik][$deger]=1;
					}
				endif;
			endif;
			$ozellikler="";
			$degerler="";
			$sorgu="";
			$fiyat_aralik = "";
			if(oturumisset("kriter")) :
			foreach($_SESSION['kriter'] AS $ozellik => $deg) {
				foreach($deg AS $deger => $sayi) {
					$ozellik = htmlspecialchars($ozellik);
					$deger = htmlspecialchars($deger);
					$ozellikler .= "," . $ozellik;
					$degerler .= "," . $deger;
					if($sorgu=="") {
						$sorgu = "AND (urun_detay.tur = $ozellik AND urun_detay.deger = $deger) ";
					} else {
						$sorgu .= "OR (urun_detay.tur = $ozellik AND urun_detay.deger = $deger) ";
					}
					
				}
			}
			
			if(getisset("bas")) {
				$bas = get("bas");
				$son = get("son");
				if($son=="") {
					$son = veri($bas);
				} else {
					$son = veri($son);
				}
				if(oturumisset("fiyat_aralik")) {
					$fiyat_aralik = oturum("fiyat_aralik");
				}
				if($bas!="") :
					$bas = veri(get("bas"));
					$fiyat_aralik = "AND urunler.fiyat>=$bas AND urunler.fiyat<=$son";
					oturum("basFiyat",get("bas"));
					oturum("sonFiyat",get("son"));
					oturum("fiyat_aralik",$fiyat_aralik);
				endif;
			}
			//echo $fiyat_aralik;
			$sorgu = stripslashes($sorgu);
			endif;
			//echo ($sorgu);
			//echo "<clear></clear>";
			if($_GET['kid']!=$_SESSION['kid']) {
				unset($_SESSION['kriter']);
				oturumSil("kid");
				$sorgu="";
				oturumSil("basFiyat");
				oturumSil("sonFiyat");
				oturumSil("fiyat_aralik");
			}
			$kid = get("kid");
			$tkid = tkid($kid);
			$urunler = sorgu("SELECT * FROM urunler LEFT JOIN urun_detay
			ON urunler.id = urun_detay.urun_id
			WHERE kid IN ($tkid) $sorgu
			$fiyat_aralik
			GROUP BY urunler.id
			");
			if($urunler!=0) :
			while($u = kd($urunler)) :
		
				?>
				
				<a class="urun" href="urun.php?id=<?php e($u['slug']) ?>">
					<?php e(resim("resimler/urunler/" . $u['resim'],200)); ?>
					<span><?php e($u['isim']) ?></span>	
				</a>
				<?php
			endwhile;
			else :
				bilgi("Bu kategoriye ürünler çok yakında eklenecektir.");
			endif;
		break;
	endswitch;
}
if((isset($_GET['urunIslem'])) && ($ks==3)) {
	switch($_GET['urunIslem']) {
		case "kategoriEkle" :
			dEkle("urun_kategori",array(
				"isim" => post("isim"),
				"aciklama" => post("aciklama"),
				"logo" => yukle("logo","resimler/urunler/"),
				"ust" => post("ust")
			));
			yonlendir("pfiy-urunler.php?kid=" . post("ust") . "#kategoriDetay");
		//	$sonuc=1;
		break;
		case "kategoriSil" :
			sil("urun_kategori",
				sprintf("id = %s",veri(get("id")))
			);
		break;
		case "kategoriGuncelle" :
			unlink("resimler/urunler/" . post("eskiresim"));
			$resim = yukle("glogo","resimler/urunler/");
			guncelle("urun_kategori",
				sprintf("logo = %s",
					veri($resim)
				),
				sprintf("id = %s",
					veri(post("id"))
				)
			);
			$sonuc=1;
		break;
		case "urunEkle" :
			dEkle("urunler",array(
				"isim" => post("uisim"),
				"resim" => yukle("uresim","resimler/urunler/","","resim",1024),
				"aciklama" => post("uaciklama"),
				"efiyat" => post("uefiyat"),
				"fiyat" => post("ufiyat"),
				"kod" => post("ukod"),
				"kid" => post("kid")
			));
			$sonuc=1;
		break;
		case "urunSil" :
			unlink("resimler/urunler/" . get("resim"));
			sil("urunler",
				sprintf("id = %s",veri(get("id")))
			);
			$sonuc=1;
		break;
		case "detayResimSil" :
			unlink("resimler/urunler/" . get("img"));
			sil("urun_detay",
				sprintf("id = %s AND tur='galeri'",veri(get("id")))
			);
			$sonuc=1;
		break;
		case "urunGuncelle" :
		if($_FILES['uresim']['tmp_name']!="") {
			dguncelle("urunler",
				array(
				"isim" => post("uisim"),
				"resim" => yukle("uresim","resimler/urunler/","","resim",1024),
				"aciklama" => post("uaciklama"),
				"efiyat" => post("uefiyat"),
				"fiyat" => post("ufiyat"),
				"kod" => post("ukod"),
				"kid" => post("kid")
			),
				sprintf("id=%s",
					veri(post("id"))
				)
			);
		} else {
			dguncelle("urunler",
				array(
				"isim" => post("uisim"),
				"aciklama" => post("uaciklama"),
				"efiyat" => post("uefiyat"),
				"fiyat" => post("ufiyat"),
				"kod" => post("ukod"),
				"kid" => post("kid")
			),
				sprintf("id=%s",
					veri(post("id"))
				)
			);
		
		}
			$sonuc=1;
		break;
		
	
	}
}
if(isset($_GET['anketIslem'])) {
		switch($_GET['anketIslem']) {
			case "ekle" :
				if($ks>=3) {
					//soru ekle ve id sini ccevaplara ekle
					$bid = kd(sorgu("SELECT MAX(id) AS bid FROM anketler")); //son id al
					$sid = $bid['bid']; //son id
					$sid++;
						dEkle("anketler",array(
							"yazi" => post("soru"),
							"tur" => "soru",
							"id" => $sid
						));
					$cevaplar = explode("\n",post("cevaplar"));
					//print_r($cevaplar);
					foreach($cevaplar AS $deger) {
						dEkle("anketler",array(
							"yazi" => $deger,
							"tur" => "cevap",
							"aid" => $sid
						));
					}
					$sonuc=1;
			}
			break;
			case "oyla" :
			$anket = kripto(post("anket"));
			$anketkripto = post("anketkripto");
			echo $anket;
			echo $anketkripto;
			$kim = session_id();
			$oy = ksorgu("anket_yanit",sprintf("WHERE aid=%s AND uid=%s",veri(post("anket")),veri($kim)));
			if($oy==0) {
			if($anket==$anketkripto) {
					dEkle("anket_yanit",array(
						"uid" => $kim,
						"aid" => post("anket"),
						"cid" => post("cevap"),
						"tarih" => simdi()
					));
					e("tamam");
					}
			}
				$sonuc=1;
			break;
			case "sil" : 
				if($ks>=3) {
					sil("anketler",sprintf("id=%s",veri(get("id"))));
					sil("anketler",sprintf("aid=%s",veri(get("id"))));
					$sonuc=1;
				}
			break;
		}
	

}
if(isset($_GET['sozIslem'])) {
	if($ks>=2) {
		switch($_GET['sozIslem']) {
			case "ekle":
				dEkle("sozler",array(
					"soz" => "",
					"kim" => ""
				));
				$sonuc=1;
			break;
			case "sil" :
				sil("sozler",sprintf("id=%s",veri(get("id"))));
				$sonuc=1;
			break;
		}
	}
} 
if(isset($_GET['bransIslem'])){
	if($ks==3){
		switch($_GET['bransIslem']){
			case "ekle":
				dEkle("branslar",array(
					"bransAd" => post("bransAd"),
					"logo" => yukle("ikon","resimler/logo/")
				));
				$sonuc=1;
			break;
			case "guncelle":
			echo "sdfaf";
			echo $_FILES['dikon']['tmp_name'];
				if($_FILES['dikon']['tmp_name']=="") {
					$resim = post("eikon");
				} else {
					$resim = yukle("dikon","resimler/logo/");
				}
				guncelle("branslar",
				sprintf("bransAd=%s, logo=%s",
					veri(post("dbransAd")),
					veri($resim)
					),
				sprintf("id=%s",veri(post("id"),"sayi")));
				$sonuc=1;
			break;
			case "sil" : 
				sil("branslar",sprintf("id=%s",veri(get("id"),"sayi")));
				$sonuc=1;
			break;
		}
	}
}
if (isset($_GET['linkIslem'])) {
	if($ks==3) {
		switch ($_GET['linkIslem']) {
			case "ekle" : 
				dEkle("linkler",array(
				"isim" => post("isim"),
				"foto" => yukle("foto",$img . "linkler/","","resim","128"),
				"aciklama" => post("aciklama"),
				"url" => post("url")
				));
			$sonuc=1;
			break;
			case "duzenle" :
			if($_FILES['dfoto']['tmp_name']!="") {
				$resim = yukle("dfoto",$img . "linkler/","","resim","128");
			} else {
				$resim = post("efoto");
			}
				guncelle("linkler",
					sprintf("isim=%s, foto=%s, aciklama=%s, url=%s",
						veri(post("disim")),
						veri($resim),
						veri(post("daciklama")),
						veri(post("durl"))
					),
					sprintf("id=%s",
						veri(post("id"),"sayi")
					)
				);
				echo "dsfas";
				$sonuc=1;
			break;
			case "sil" :
				sil("linkler",sprintf("id=%s",get("id")));
			break;
		}
	}
}
if (isset($_GET['uyeIslem'])) {

	switch ($_GET['uyeIslem']) {
	//üye kayıt işlemleri için bir formdan bilgileri okur ve o bilgileri onaylamak için bir mail gönderir
		
		case "adresGuncelle" :
			$uid = oturum("uid");
			uye_detay_g("adres","$uid",post("id"));
			$sonuc =1;
		break;
		case "adresEkle" :
			oturumAc();
			uye_detay("adres",oturum("uid"));
			$sonuc=1;
		break;
		case "uyeKayit" :
			$mail = kSorgu("uyeler",
				sprintf("WHERE mail = %s OR mail =%s", //mail var mı yok mu küçük büyük kontrol ediliyor
					trim(veri(post("mail"))),
					trim(veri(strtolower(post("mail"))))
					
				)
			);
			oturumAc();
		if(($mail==0) && (!isset($_SESSION['kayitTamam']))) { //mail adresi yoksa kayıt yapılıyor
			$mail = trim(post("mail"));
			$uid = dEkle("uyeler",array(
			
				"user" => kripto($mail),
				"sifre" => kripto(post("sifre")),
				"mail" => $mail,
				"adi" => post("adi"),
				"soyadi" => post("soyadi")
			));
			
			mailGonder(post("mail"),$baslik,
				sprintf("<h1>%s</h1><p>Sitemize kayıt olduğunuz için teşekkür ederiz</p>",$baslik)
				
			);
			
			$sid = oturum("sepet");
			$u = kd(ksorgu("uyeler","WHERE id = '$uid'"));
				dGuncelle("sepet",array(
					"uid" => "$uid"
				),"id = '$sid'");
				oturum("kayitTamam",kripto(post("mail"))); //kayitTamam oturum değişkeni oluşturuluyor bu yüklü kaydı engellemek için 
				oturum("uid", $uid);
				oturum("pFiMail", $u['mail']);
				oturum("pFiUser", $u['user']);
				oturum("Seviye2",$u['seviye']);
				oturum("adi", $u['adi']);
				oturum("soyadi", $u['soyadi']);
				oturum("Seviye","peyamFi");
				oturumSil("kayitTamam");
			}
			$sonuc=1;
		break;
		//üyeye şifre sıfırlama maili gönderir. Tabi eğer mail varsa...
		
		case "uyeSifreMail" : 
		$varmi = sorgu(
					sprintf("SELECT * FROM uyeler WHERE mail = %s",
							veri(post("mail"))
							)
				);
			if($mail==0) {
				$sonuc="mailYok";
			
			} else {
				mailGonder(post("mail"),
					sprintf("%sislemID=%s&uid=%s&islem=uyeSifreMail",
					$uyeIslem,
					kripto("uyeSifreMail=" . post("mail")),
					post("mail")
					)
				);
			$sonuc=1;
			}
		break;
		case "Onay" :
			 $deger = post("yayin");
			 $id = post("id");
			guncelle("uyeler",
				sprintf("y=%s",veri($deger))
				,
				sprintf("id=%s",veri($id,"sayi"))
				);
			$sonuc=1;
		break;
		//şifre sıfırlama sayfasından alınan şifreyi eskisiyle değiştirir. uid Oturum nesnesini kullanır.
		case "uyeSifreYenile" :
			guncelle("uyeler",
				sprintf("sifre=%s",veri(post("sifre")))
				,
				sprintf("id=%s",veri(oturum("uid")))
				);
			$sonuc=1;
		break;
		//üyenin seviyesini değiştirir. bu işlemi sadece yöneticiler yapabilmektedir. 
		//post değeri seviye, kisi
		case "uyeSeviye" :
		if ($ks==3) {
		echo "deneme";
				$seviye = post("d_kriter");
				$kisi = post("s_kriter");
				guncelle("uyeler",
					sprintf("seviye=%s",veri($seviye)),
					sprintf("id = %s",veri($kisi,"sayi"))
				);
			}
			$sonuc=1;
		break;
		case "uyeSira" :
		if ($ks==3) {
		echo "deneme";
				$sira = post("d_kriter");
				$kisi = post("s_kriter");
				guncelle("uyeler",
					sprintf("s=%s",veri($sira)),
					sprintf("id = %s",veri($kisi,"sayi"))
				);
			}
			$sonuc=1;
		break;
		case "uyeBrans" :
		if ($ks==3) {
		echo "deneme";
				$brans = post("d_kriter");
				$kisi = post("s_kriter");
				guncelle("uyeler",
					sprintf("brans=%s",veri($brans)),
					sprintf("id = %s",veri($kisi,"sayi"))
				);
			}
			$sonuc=1;
		break;
		case "blog" :
		if ($ks>=2) {
		echo "tamam";
				$biyografi = post("biyografi");
				$kisi = oturum("uid");
				guncelle("uyeler",
					sprintf("biyografi=%s",veri($biyografi)),
					sprintf("id = %s",veri($kisi,"sayi"))
				);
			}
			e($biyografi);
			$sonuc=1;
		break;
		case "mesajDetay" :
			if($ks>=1) :
				$uid = oturum("uid");
				$id = get("id");
				$mid = kd(ksorgu("uye_mesaj","WHERE uid=$uid AND id = $id"));
				echo $mid['mesaj'];
				dGuncelle("uye_mesaj",array("okundu"=>1),"uid=$uid AND id = $id");
			endif;
		break;
		case "mesajOkundu" :
			$uid = oturum("uid");
			$id = get("id");
			if($ks>=1) :
				dGuncelle("uye_mesaj",array("okundu"=>1),"uid=$uid AND id = $id");				
			endif;
		break;
		case "mesajSil" :
			$uid = oturum("uid");
			$id = get("id");
			if($ks>=1) :
				sil("uye_mesaj","uid=$uid AND id = $id");				
			endif;
		break;
		case "oturumAc" : //kullanıcılar oturum açmak isterse
		oturumAc();
	//	if(isset($_SESSION['oturumHata']) && $_SESSION['oturumHata']>10){ //eğer oturum hatası 4 ten büyük olmadığı durumlarda
			$girisYasak = 0;
			//yonlendir("pfi-uye-formu.php?giris");
		//}
		if(!isset($girisYasak)) {
			$uye = kSorgu("uyeler",
				sprintf("WHERE user = %s AND sifre = %s", //kullanıcı adını ve şifrenin kriptolanmış şeklini kontrol et
					veri(kripto(trim(post("mail")))),
					veri(kripto(post("sifre")))
				)
			);
			$u = kd($uye);
			if (!isset($_SESSION['oturumHata'])) { //daha önce hata değişkeni oluşturulmamışsa
			oturum("oturumHata",0); //oluştur
			
			}
			if($uye!=0) { //eğer böyle bir üye varsa
				oturumAc(); //oturum değişkenlerini yaz
				oturum("uid", $u['id']);
				oturum("pFiMail", $u['mail']);
				oturum("pFiUser", $u['user']);
				oturum("Seviye2",$u['seviye']);
				oturum("adi", $u['adi']);
				oturum("soyadi", $u['soyadi']);
				oturum("Seviye","peyamFi");
				oturumSil("kayitTamam");
						
				$sonuc = 1;
			} else { //eğer böyle bir üye yoksa
				$sonuc = 0;
				$hata=oturum("oturumHata"); //son oturum hata değerini al
				$hata++; // hata değerini bir arttır
				oturum("oturumHata",$hata); //hata değerini yaz
				if (isset($_GET['y'])){
					//$url = $_GET['y'] . "&sonuc=0";
					
				} else {
					//$url = $_SERVER['REQUEST_URI'] . "&sonuc=0";
					//yonlendir("pfi-uye-formu.php?giris");
				}
				
			}
		}
		break;
		case "guncelle" : //kayıt bilgilerini güncelle şifre hariç
		if($_FILES['resim']['tmp_name']=="") {
			$resim = post("eskiResim");
		} else {
			unlink($img ."uyeler/" . post("eskiResim"));
			$resim = yukle("resim",$img ."uyeler/","","resim","500");
		}
		$mail = trim(post("mail"));
		
			dGuncelle("uyeler",array(
				"adi" => post("adi"),
				"soyadi" => post("soyadi"),
				"mail" => $mail,
				"resim" => $resim,
				"user" => kripto($mail)
			),"id = {$_SESSION['uid']}"
			);
				$sonuc = 1;
		break;
		case "bilgiGuncelle" :
		if($ks>=1) :
			$uid = oturum("uid");
			$mail = veri(post("mail"));
			$varmi = ksorgu("uyeler","WHERE mail = $mail AND id<>$uid");
			if($varmi==0) :
			dguncelle("uyeler",$_POST," id = $uid");
			$u = kd(ksorgu("uyeler","WHERE id =$uid"));
			oturum("pFiMail", $u['mail']);
			oturum("pFiUser", $u['user']);
			oturum("Seviye2",$u['seviye']);
			oturum("adi", $u['adi']);
			oturum("soyadi", $u['soyadi']);
				oturum("guncelleHata","0");
			else :
				oturum("guncelleHata","1");
			endif;
			$sonuc=1;
			break;
			
		endif;
		break;
		case "sifreGuncelle" :
			$uid= oturum("uid");
			$sifre = veri(kripto(post("eskisifre")));
			$dogrumu=ksorgu("uyeler","WHERE id = $uid AND sifre = $sifre");
			if($dogrumu!=0):
			if($_POST['sifre']==$_POST['sifre2'] && $_POST['sifre']!="") {
				dGuncelle("uyeler",array(
					"sifre" => kripto(trim(post("sifre")))
				),
					"id=$uid"
				);
				oturum("sifreGuncelle","1");
			} else {
				oturum("sifreGuncelle","0");
			}
			else : 
				oturum("sifreGuncelle","-1");
			endif;
			$sonuc = 1;
		break;
	}
}
/*
	haber işlemleri
	bütün haber işlemlerinin yapılmasını sağlar sadece Yonetici ve Yazar kullanıcıları 
	bu işlemleri yapabilme yetkisine sahiptir.
	//////////////
		bir haber eklenir. Her haberin bir kategorisi olduğu unutulmamalıdır
		yanlış yazılır değiştirilir
		işe yaramaz silinir.
		haber kategorisi değiştirilebilir.
		
		kategori eklenir
		kategori silinir
		kategori güncellenir
		
	
*/
if(getisset("sepetIslem")) {
	switch($_GET['sepetIslem']) {
		case "soruSor" :
			$uid = oturum("uid");
			dEkle("uye_soru",array(
				"soru" => post("soru"),
				"sz" => simdi(),
				"uid" => oturum("uid")
			));
			$sonuc=1;
		break;
		case "siparisIptal" :
			oturumAc();
			$uid = oturum("uid");
			$id = veri(get("id"));
			$odemevar = ksorgu("sepet","WHERE durum='Hazırlanıyor' AND uid='$uid' AND id=$id");
			if($odemevar==0) :
				dGuncelle("sepet",array(
					"durum"=>"İptal Edildi"
				),"uid='$uid' AND id =$id");
			else :
				dGuncelle("sepet",array(
					"iptal"=>"1"
				),"uid='$uid' AND id =$id");
			endif;
			$sonuc=1;
		break;
		case "adresSec" :
		oturumAc();
			$sepet_id = oturum("sepet");
			$uid = oturum("uid");
			dGuncelle("sepet",array(
				"adres_id" => post("adres")
			),"id = $sepet_id AND uid = $uid");
			echo $sepet_id;
			oturum("seciliAdres",post("adres"));
			$sonuc=1;
		break;
		case "havaleOdeme" : 
			oturum("havaleBanka",post("banka"));
			oturum("odemeTuru","Havale/EFT");
			$sonuc=1;
		break;
		case "kkOdeme" :
			oturum("kkno",post("kn1").post("kn2").post("kn3").post("kn4"));
			oturum("ay",post("ay"));
			oturum("yil",post("yil"));
			oturum("ccv",post("ccv"));
			oturum("unvan",post("unvan"));
			oturum("odemeTuru","Banka Kredi Kartı (3D Secure)");
			$sonuc=1;
		break;
		case "onay" :
			$sid = oturum("sepet");
			$takip = $sid . "-" . substr(session_id(),5,10);
			if(oturumesit("odemeTuru","Havale/EFT")) :
				//havale ödemesi yapılacaklar
				// sipariş onayı ödeme bekliyor			
				dGuncelle("sepet",array(
					"durum" => "Ödeme Bekliyor",
					"takip" => "$takip",
					"odeme_tur" => oturum("odemeTuru"),
					"banka_id" => oturum("havaleBanka")
				),"id=$sid");
				oturum("takipNo",$takip);
				mesaj("$takip Nolu siparişiniz ödeme bekliyor","Siparişiniz elimize ulaştı ödeme yaptığınız anda işleme alınacaktır.",oturum("uid"));
			
				//iz bırakma
				oturumSil("odemeTuru");
				oturumSil("havaleBanka");
				oturumSil("kkno");
				oturumSil("yil");
				oturumSil("ccv");
				oturumSil("unvan");
				oturumSil("sepet");
				$sonuc = 1;
			else :
				//banka ile ilgili 
				//bankaya verileri transfer et
				//netice olumluysa
				
				dGuncelle("sepet",array(
					"durum" => "Hazırlanıyor",
					"takip" => "$takip",
					"odeme_tur" => oturum("odemeTuru")
				),"id=$sid");
				mesaj("$takip nolu siparişiniz hazırlanıyor","$takip nolu siparişinizin ödeme onayı alında en kısa zamanda adresinize gönderilecektir. Sabırla beklediğiniz için teşekkürler",oturum("uid"));
				oturum("takipNo",$takip);
				//iz bırakma
				oturumSil("odemeTuru");
				oturumSil("havaleBanka");
				oturumSil("kkno");
				oturumSil("yil");
				oturumSil("ccv");
				oturumSil("unvan");
				oturumSil("sepet");
				$sonuc=1;
			endif;
		break;
		case "sepetEkle" : 
			oturumAc();
			$sepet_id = oturum("sepet");
			$urun_id = veri(post("urun_id"));
			$urun = kd(ksorgu("urunler","WHERE id = $urun_id"));
			$varmi = ksorgu("sepet_detay","WHERE urun_id=$urun_id");
			if($varmi==0) :
			dEkle("sepet_detay",array(
				"sepet_id" => $sepet_id,
				"urun_id" => $urun['id'],
				"fiyat" => $urun['ilkfiyat'],
				"iskonto" => $urun['iskonto'],
				"kdv" => $urun['kdv']
			));
			else :
			$v = kd($varmi);
			$adet = $v['adet'] + 1;
			dGuncelle("sepet_detay",array(
				"adet" => "$adet"
			),"sepet_id = $sepet_id AND urun_id = $urun_id");
			endif;
		break;
		case "adetGuncelle" :
			$sid = oturum("sepet");
			$sdid = veri(post("sdid"));		
			dGuncelle("sepet_detay",array(
				"adet" => post("adet")
			),"sepet_id = $sid AND id = $sdid");
		break;
		case "sil" :
			$sid = oturum("sepet");
			$id = veri(get("id"));		
			sil("sepet_detay","sepet_id=$sid AND id =$id");
			yonlendir("sepet.php");
		break;
		case "sepetiBosalt" :
			$sid = oturum("sepet");
			sil("sepet_detay","sepet_id=$sid");
			yonlendir("sepet.php");
		break;
	}
}
if (isset($_GET['haberIslem'])) {	
	if($ks>=1) {
		switch ($_GET['haberIslem']){
			case "haberEkle" :
					dEkle("haberler",array(
					
						"baslik" => post("baslik"),
						"icerik" => post("icerik"),
						"tarih" => simdi(),
						"resim" => yukle("resim", $img. "haberler/","resim","640"),
						"kategori" => post("kategori"),
						"uid" => oturum("uid")
						
					));
			$sonuc=1;
			break;
			case "haberGuncelle" :
					if ($_FILES['resim']['tmp_name']!=""){
						$resim = yukle("resim", $img. "haberler/","resim","640");				
					} else {
						$resim = post("eskiresim");
					}
					guncelle("haberler",
						sprintf("baslik=%s, icerik=%s, tarih=%s, resim=%s, kategori=%s, uid=%s",
							veri(post("baslik")),
							veri(post("icerik")),
							veri(simdi()),
							veri($resim),
							veri(post("kategori")),
							veri(oturum("uid"))
						),
						sprintf("id = %s",
							veri(post("id"),"sayi")
						)
					);
			$sonuc=1;
				
			break;
			case "sil" : 
			if($ks>=3) {
					sil("haberler",
							sprintf("id=%s",
								veri(get("id"),"sayi"),
								veri(oturum("uid"))
							)
						);
			$sonuc=1;
			}
			break;
			case "kategoriDegistir" : 
			if($ks>=3) {
					guncelle("haberler",
						sprintf("kategori=%s",
							veri(post("kategori"))
						),
						sprintf("id=%s",
							veri(post("id"),"sayi")
						)
					);
			$sonuc=1;
			}
			break;
			case "kategoriEkle" : 
			if($ks>=3) {
				dEkle("haberkategori",array(
					"kAd" => post("kAd"),
					"uid" => oturum("uid")
					)
				);
			$sonuc=1;
			}
			break;
			case "kategoriSil" :
			if($ks>=3) {
				sil("haberkategori",
					sprintf("id = %s",
						veri(get("id"),"sayi")
					)
				);
			$sonuc=1;
			}
			break;
			case "kategoriGuncelle" :
			if($ks>=3) {
				guncelle("haberkategori",
					sprintf("kAd = %s",
						veri(post("kAd"))
						),
					sprintf("id = %s",
						veri(post("id"),"sayi")
					)
				
				);
				}
			break;
				
			

		}
	} else {
			$sonuc=0;
	}
}

/*
Etkinlik işlemleri
bu işlemi sadece yöneticiler yapabilmektedir. 
etkinlik eklenir
güncellenir
ve silinir
 */
if (isset($_GET['etkinlikIslem'])){
	if ($ks>=1) {
		switch ($_GET['etkinlikIslem']) {
		//etkinlik oluştur
			case "ekle":
				dEkle("etkinlikler",array(
					"isim" => post("isim"),
					"tarih" => post("tarih") . " " . post("saat"),
					"btarih" => post("btarih") . " " . post("bsaat"), 
					"icerik" => post("icerik"),
					"resim" => yukle("resim", $img . "etkinlik/","","resim",500),
					"uid" => oturum("uid")
				));
				$sonuc = 1;
			break;
			//var olan bir etkinliği günceller
			case "guncelle": 
			if ($_FILES['gresim']['tmp_name']=="") { //eğer resim seçilmemişse
				$resim = post("eskiResim"); //eski resmi al
			} else {
				unlink($img . "etkinlik/" . post("eskiResim")); //eski resmi sil
				$resim = yukle("gresim", $img . "etkinlik/","","resim",500); //yeni resmi yükle
			}
			$id = veri(post("id"));
				dGuncelle("etkinlikler",array(
					"isim" => post("gisim"),
					"tarih" => post("gtarih") . " " . post("gsaat"),
					"btarih" => post("gbtarih") . " " . post("gbsaat"), 
					"icerik" => post("gicerik"),
					"resim" => $resim,
					"uid" => oturum("uid")
				),
				
					"id=$id"
				);
				$sonuc = 1;
			break;
			//etkinliği veritabanından siler
			case "sil":
			if($ks>=3) {
				sil("etkinlikler",
					sprintf("id=%s",
						veri(get("id"))
						)
					);
				unlink($img . "etkinlik/" . get("img"));
				$sonuc = 1;
				}
			break;
		
		}
	} else {
			$sonuc=0;
	}
} 

/*
Sayfa işlemleri
bir sayfa kategorisi oluşturur. 
kategori içerisine sayfa ekleme
bu işlemleri sadece yöneticiler yapabilir
*/
if (isset($_GET['sayfaIslem'])){
	if ($ks>=3) {
		switch ($_GET['sayfaIslem']){
			case "ekle" :
			if ($_FILES['resim']['tmp_name']==""){
				$resim="";
			} else {
				$resim = ""; //yukle("resim",$img . "sayfalar/");
			}
				dEkle("sayfalar",array(
					"baslik" => post("baslik"),
					"icerik" => post("icerik"),
					"resim" => $resim,
					"galeri" => post("galeri"),
					"kategori" => post("kategori"),
					"uid" => oturum("uid")
					)
				);
				$sonuc=1;
			break;
			case "guncelle":
				$baslik = post("baslik");
				$id =  post("id");
				$icerik = post("icerik");
				$galeri = post("galeri");
				$kategori  = post("kategori");
				dGuncelle("sayfalar",array(
					"baslik" => "$baslik",
					"icerik" => "$icerik",
					"galeri" => "$galeri",
					"kategori" => "$kategori"
				),
				"id = '$id'"
				);

				$sonuc=1;
			break;
			case "sil":

				sil("sayfalar",
					sprintf("id=%s AND uid = %s",
						veri(get("id")),
						veri(oturum("uid"))
						)
				);
				$sonuc=1;
			break;
			case "kategoriDegistir" : 
					guncelle("sayfalar",
						sprintf("kategori=%s",
							veri(post("kategori"))
						),
						sprintf("id=%s",
							veri(post("id"),"sayi")
						)
					);
			$sonuc=1;
			break;
			case "kategoriEkle" : 
				dEkle("sayfakategori",array(
					"kAd" => post("kAd"),
					"uid" => oturum("uid")
					)
				);
			$sonuc=1;
			break;
			case "kategoriSil" :
				sil("sayfakategori",
					sprintf("id=%s AND uid = %s",
						veri(get("id")),
						veri(oturum("uid"))
						)
				);
			$sonuc=1;
			break;
			case "kategoriGuncelle" :
				guncelle("sayfakategori",
					sprintf("kAd = %s",
						veri(post("kAd"))
						),
					sprintf("id = %s",
						veri(post("id"),"sayi")
					)
				
				);
			break;
		}
	}

}
/*
Yazı işlemleri
bir üyenin yazı işlemleri
bütün üyeler yazı yazabilir!
*/
if(isset($_GET['yaziIslem'])){
	switch($_GET['yaziIslem']){
		case "ekle":
			dEkle("uyeyazilar",array(
				"baslik" => post("baslik"),
				"icerik" => post("icerik"),
				"onemli" => post("onemli"),
				"tarih" => simdi(),
				"uid" => oturum("uid")
			));
			$sonuc=1;
		break;
		case "guncelle":
			dGuncelle("uyeyazilar",array(
				"baslik" => post("baslik"),
				"icerik" => post("icerik"),
				"tarih" => simdi(),
				"onemli" => post("onemli"),
				"uid" => oturum("uid")
			),
			array(
				"id" => post("id")
			));
			$sonuc=1;
		break;
		case "sil":
				sil("uyeyazilar",
					sprintf("id=%s AND uid = %s",
						veri(get("id")),
						veri(oturum("uid"))
						)
					);
			$sonuc=1;
		break;
	}
}
if (isset($_GET['galeriIslem'])){
	if ($ks>=1) {
	switch ($_GET['galeriIslem']) {
		case "ekle" :
			dEkle("galerikategori",
				array(
					"isim" => post("isim"),
					"tur" => post("tur"),
					"turAciklama" => post("turAciklama"),
					"uid" => oturum("uid") 
				)
			);
			$sonuc=1;
		break;
		case "sil":
		if($ks>=3) {
		//önce galeriyi silelim
				sil("galerikategori",
					sprintf("id=%s",
						veri(get("id"))
						)
					);
		//sonra galerinin içerisinde bulunan icerikleri dizinden silelim
		$resim = kSorgu("galeriicerik",
							sprintf("WHERE gid = %s",
							veri(get("id"))
							)
							);
				if ($resim !=0) {
					while($r = kd($resim)) {
						unlink("pfi-galeri-icerik/" . $r['url']);
					}
					//icerikleri veritabanından kaldıralım
					sil("galeriicerik",
						sprintf("gid=%s",
							veri(get("id"))
							)
					);
				}
			$sonuc=1;
			}
		break;
		case "guncelle" :
		$id = veri(post("id"));
			dGuncelle("galerikategori",
				array(
					"isim" => post("gisim"),
					"tur" => post("gtur"),
					"turAciklama" => post("gturAciklama")
				),
				"id = $id"
				
			);
			$sonuc=1;
		break;
		case "icerikSil":
				unlink("pfi-galeri-icerik/" . get("resim"));
				sil("galeriicerik",
					sprintf("id=%s",
						veri(get("id"))
						)
					);
			$sonuc=1;
		break;
		
	}
	} //if
	switch($_GET['galeriIslem']){
		case "cokluResim" :
			$imza2 = kripto($imza.post("uid"));
			if(postesit("imza",$imza2)) {
				$user = post("user");
				$id = post("uid");

				$dir ="file/{$_POST['kid']}/";
				if (!file_exists($dir) && !is_dir($dir)) {
					mkdir($dir);         
				} 
				
					$yukle = yukle("file",$dir);
				
			}
		break;
		case "dosyaYukle" : //ajax metodu ile dosya yüklemede oturum değişkenleri nedense çalışmıyor bu yüzdene farklı bir şifreleme sistemi geliştireceğiz
		$imza2 = kripto($imza.post("uid"));
		if(postesit("imza",$imza2)) :
		//kullanıcı bilgisini al user ve id
		$user = post("user");
		$id = post("uid");
		$kullanici = kSorgu("uyeler",sprintf("WHERE user = %s AND id = %s",
			veri($user),
			veri($id)
		));
		$galeri = kd(ksorgu("galerikategori",sprintf("WHERE id=%s",veri(post("gid")))));
		$tur = $galeri['tur'];
		if($tur=="jpg,png,gif") {
			if($_FILES["file"]["size"]>930) {
				$yukle = yukle("file","pfi-galeri-icerik/","","resim",930);
			} else {
				$yukle = yukle("file","pfi-galeri-icerik/");
			}
		} else {
			$yukle = yukle("file","pfi-galeri-icerik/");
		}
		$k = kd($kullanici);
		if($kullanici !=0) { //kullanıcı varsa
			//herhangi bir galeri içerisine resim yükleyelim
			dEkle("galeriicerik", 
				array(
					"gid" => post("gid"),
					"url" => $yukle,
					"uid" => post("uid")
				));
			//$sonuc=1;
		}
		endif;
		break;
		case "urunEkle" : 
		//kullanıcı bilgisini al user ve id
		$imza2 = kripto($imza.post("uid"));
		if(postesit("imza",$imza2)) :
		$user = post("user");
		$id = post("uid");
		$kullanici = kSorgu("uyeler",sprintf("WHERE user = %s AND id = %s",
			veri($user),
			veri($id)
		));
		if($tur=="jpg,png,gif") {
			if($_FILES["file"]["size"]>=1024 ) {
				$yukle = yukle("file","resimler/urunler/","","resim",1024);
			} else {
				$yukle = yukle("file","resimler/urunler/");
			}
		} else {
			$yukle = yukle("file","resimler/urunler/");
		}
		$k = kd($kullanici);
		if($kullanici !=0) { //kullanıcı varsa
			//herhangi bir galeri içerisine resim yükleyelim
			$isim = explode(".",$_FILES["file"]["name"]);
			
			dEkle("urunler", 
				array(
					"kid" => post("kid"),
					"resim" => $yukle,
					"isim" => $isim[0],
					"slug" => slug($isim[0])
				));
			//$sonuc=1;
		}
		endif;
		break;
		case "urunResimEkle" :
			$imza2 = kripto($imza.post("uid"));
			if(postesit("imza",$imza2)) :
			dEkle("urun_detay",
				array(
					"urun_id" => post("urun_id"),
					"tur" => "galeri",
					"deger" => yukle("file","resimler/urunler/")
				)
			);
			endif;
		break;
	}
	
}
/*
bir içeriği yayınlamak ve yayından kaldırmak için
yalnızca kullanıcıların kendi içerikleri yayından kaldırabilir veya yayına sokabilir.
*/
if (isset($_GET['yayin'])){
//evet mi hayır mı?
//peki kime işlem yapılacak?
	switch($_GET['tur']){
		case "haber":
			$tablo = "haberler";
			$yuid=2;
		break;
		case "haberkategori":
			$tablo = "haberkategori";
			$yuid=3;
		break;
		case "sayfa":
			$tablo = "sayfalar";
			$yuid=3;
		break;
		case "sayfakategori":
			$tablo = "sayfakategori";
			$yuid=3;
		break;
		case "yazi":
			$tablo = "uyeyazilar";
			$yuid=1;
		break;
		case "etkinlik": 
			$tablo = "etkinlikler";
			$yuid=2;
		break;
		case "galeri":
			$tablo = "galerikategori";
			$yuid=3;
		break;
		case "content" :
			$tablo = "content";
			$yuid=3;
		break;
	}
// o zaman işlemlere başla
	if($yuid<=$ks) { //kullanıcı seviyesinin istenilen seviyeden büyük olması durumunda
	dGuncelle($tablo,array(
		"y" => veri(get("yayin"),"sayi")
	),
		array(
			"id" => veri(get("yid"),"sayi")
		)
	);
	if ($_GET['yayin']=="1") {
		echo resim($img . "ikon/y.png");
	} else {
		echo resim($img . "ikon/yd.png");
	}
	}
	//$sonuc=1;
}
/*
üye yorumları ekleme bölümü
her üye yorum ekleyebilir.
*/
if (isset($_GET['yorumIslem'])) {
//yorumu neye ekleyeceksin
/*	switch($_GET['tur']) {
		case "haber":
			$tablo="haberyorum";
			$alan ="haberId";			
		break;
		case "sayfa":
			$tablo="sayfayorum";
			$alan ="sayfaId"; 
		break;
		case "etkinlik":
			$tablo="etkinlikyorum";
			$alan ="etkinlikId"; 
		break;
		case "uyeYazi":
			$tablo="uyeyaziyorum";
			$alan ="yaziId"; 
		break;
	}*/ 
// o halde ekle!
switch($_GET['yorumIslem']) {
	case "ekle" :
		dEkle("yorumlar",array(
				"sayfa" => post("sayfa"),
				"tur" => post("sayfan"),
				"icerik" => post("mesaj"),
				"baslik" => post("baslik"),
				"yazan" => post("isim"),
				"y" => 0,
				"tarih" => simdi(),
				"uid" => post("uid")
			)
		);
		$sonuc=1;
	break;

}

}
	if($ks>=2) {
if(isset($_GET['yorumAdmin'])) {
		switch($_GET['yorumAdmin'])	{
			case "onayla" :
				guncelle("yorumlar","y=1",sprintf("id=%s",veri(get("id"))));
				$sonuc=1;
			break;
			case "sil" :
				sil("yorumlar",sprintf("id=%s",veri(get("id"))));
				$sonuc=1;
			break;
		}
	}
	}

if (($ks>=2) && isset($_GET['ajax'])) { //sadece yöneticiler ve öğretmenler bu ajax işlemini yapabilir 
	switch ($_GET['ajax']) {
		case "input" :
			$s_alan = post("s_alan");
			$s_kriter = post("s_kriter");
			$d_kriter = post("d_kriter");
			switch($_POST['tablo']) {
				case "urun_detay" :
					$tur = post("d_alan");
					$urun_id = post("s_kriter");
					$deger = post("d_kriter");
					$varmi = ksorgu("urun_detay","WHERE tur = '$tur' AND urun_id = '$urun_id'");
					if($varmi!=0) :
						$v = kd($varmi);
						$id = $v['id'];
						dGuncelle("urun_detay",array(
							"deger" => "$deger"
						),"id = $id");
					else : 
						dEkle("urun_detay",array(
							"tur" => "$tur",
							"urun_id" => "$urun_id",
							"deger" => "$deger"
						));
					endif;
				break;
				case "urunler" :
				if(postesit("d_alan","isim")) :
					dGuncelle(post("tablo"),array(
						post("d_alan") => "$d_kriter",
						"slug" => slug($d_kriter)
					),"$s_alan = $s_kriter");
				else :
					dGuncelle(post("tablo"),array(
						post("d_alan") => "$d_kriter"
					),"$s_alan = $s_kriter");
				endif;
				break;
				default:
					dGuncelle(post("tablo"),array(
						post("d_alan") => "$d_kriter"
					),"$s_alan = $s_kriter");
				break;
			
			}
			
			
			$sonuc="guncelleme tamam";
		break;
	}
		
	
}
if (($ks>=1) && isset($_GET['ajax'])) { //bütün üyeler bu ajax işlemini yapabilir 
	switch ($_GET['ajax']) {
		case "parola" :
			$parola = kSorgu("uyeler", //üyeye ait olan parolayı doğrula 
						sprintf("WHERE id = %s AND sifre = %s AND mail = %s",
							veri(oturum("uid"),"sayi"),
							veri(kripto(post("sifre"))),
							veri(oturum("pFiMail"))
						)
					);
			if($parola==0) {
				$sonuc=0;
			} else {
				$sonuc=1;
			}
		break;
	}
		
}
if (isset($_GET['y']) && (isset($sonuc)) && ($sonuc == 1)) {
	//yonlendir($_SERVER['REQUEST_URI'])
	if (!isset($url)) {
	yonlendir(get("y"));
	} else {
	yonlendir($url);
	}
}
if(isset($sonuc)){
echo $sonuc;
}
?>