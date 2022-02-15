<?php include("pfi-yonetici-yetki.php"); 

function geri($get){
	yonlendir("pfiy-masaustu.php?$get");
}

function googleSearch($kriter,$adim=0) {
	foreach(google($kriter,$adim) as $alan ) {
			echo "<img onerror='this.style.display = \"none\"' onload='this.style.opacity = 1; this.style.top=0' src='".$alan->url."'/>";
	}
}
function yenislug($kriter) {
	$slug = veri(slug($kriter));
	$varmi =ksorgu("content","WHERE slug=$slug");
	if($varmi==0) {
		return slug($kriter);
	} else {
		return slug($kriter.rand(0,999));
	}
}

if(getisset("soruSil")) {
	$id = veri(get("soruSil"));
	sil("soru","id=$id");
	sil("soru","ust=$id");
}
if(getisset("soruGuncelle")) {
	print_r($_POST);
	$id = veri(post("id"));
	dGuncelle("soru",array(
		"val" => post("deger")
	),"id=$id");
	exit();
}
if(getisset("cevapla")) {
	print_R($_POST);
	$soru = veri(post("soru"));
	$cevap = veri(post("cevap"));
	//önce cevaplanmýþý sil
	dGuncelle("soru",array(
		"dogru" => "0"
	),"ust=$soru");
	//þimdi cevapla
	dGuncelle("soru",array(
		"dogru" => "1"
	),"id=$cevap");
	exit();
}
if(getisset("tumunuSil")) {
	if(getisset("grup")) {
		$grup = veri(get("grup"));
		$grup = "AND grup=$grup";
	} else {
		$grup = "";
	}
	$ust = veri(get("tumunuSil"));
	sil("soru","kat=$ust $grup");
	yonlendir("?kid={$_GET['tumunuSil']}#sorular");
}
if(getisset("tekli")) {
	postyukle("pic","file/");
	$soru = dEkle("soru",array(
		"val" => post("soru"),
		"tip" => "soru",
		"kat" => get("kid"),
		"pic" => post("pic")
	));
	$k = 0;
	foreach($_POST['cevap'] AS $cevap) {
		if($k==0) {
			$dogru=1;
		} else {
			$dogru=0;
		}
		dEkle("soru",array(
			"val" => $cevap,
			"tip" => "cevap",
			"ust" => $soru,
			"dogru" =>$dogru,
			"kat" => get("kid")
		));
		$k++;
	}
	yonlendir("?kid={$_GET['kid']}#sorular");
}
if(getisset("coklu3")) { //resimli soru eklemek için
	$satir = explode("\n",post("havuz"));
	$toplam = count($satir);
	$toplamSoru = count($satir)/6;
	$grup = simdi(); // soru grubu oluþturmak için 
	if(ctype_digit(strval($toplamSoru))) {
		for($s=0;$s<$toplamSoru;$s++) {
			
			$soru = dEkle("soru",array(
				"val" => $satir[$s*6+1],	
				"tip" => "soru",
				"grup" => $grup,
				"pic" => get("kid")."/".$satir[$s*6+0],
				"kat" => get("kid")
			));
			e("soru eklendi: {$satir[$s*2]} <br />");
			dEkle("soru",array(
				"val" => $satir[$s*6+2],
				"tip" => "cevap",
				"grup" => $grup,
				"dogru" => 1,
				"ust" => $soru,
				"kat" => get("kid")
			));
			dEkle("soru",array(
				"val" => $satir[$s*6+3],
				"tip" => "cevap",
				"grup" => $grup,
				"dogru" => 0,
				"ust" => $soru,
				"kat" => get("kid")
			));
			dEkle("soru",array(
				"val" => $satir[$s*6+4],
				"tip" => "cevap",
				"grup" => $grup,
				"dogru" => 0,
				"ust" => $soru,
				"kat" => get("kid")
			));
			dEkle("soru",array(
				"val" => $satir[$s*6+5],
				"grup" => $grup,
				"tip" => "cevap",
				"dogru" => 0,
				"ust" => $soru,
				"kat" => get("kid")
			));
			e("---->cevaplar eklendi: <br />");
		}
		yonlendir("admin?kid={$_GET['kid']}#sorular");
	} else {
		$_POST['sorun'] = "Dizide sorun olduðundan bir iþlem yapýlmadý";
	}
	
	
}
if(getisset("coklu")) {
	$satir = explode("\n",post("havuz"));
	/*
	0,
	1,2,3,4,
	5,
	6,7,8,9,
	10
	*/
	$k=0;
	print_r($satir);
	$grup=simdi();
	foreach($satir AS $deger) {
		e("$k <br />");
		if($k%6==0) {
			$soru = dEkle("soru",array(
				"val" => trim($deger),
				"tip" => "soru",
				"grup" => $grup,
				"kat" => get("kid")
			));
			e("soru eklendi: $soru <br />");
			$cevapsayi=0;
		} else {
			if(trim($deger)!="") {
				if($cevapsayi==0) {
					$dogru=1;
				} else {
					$dogru=0;
				}
				e("cevap ekleniyor: $soru <br />");
				dEkle("soru",array(
					"val" => trim($deger),
					"grup" => $grup,
					"tip" => "cevap",
					"dogru" => $dogru,
					"ust" => $soru,
					"kat" => get("kid")
				));
				$cevapsayi++;
				e("cevap eklendi: $soru <br />");
			}
		}
		$k++;
	}
	yonlendir("?kid={$_GET['kid']}#sorular");
}
if(getisset("coklu2")) {
	$satir = explode("\n",post("havuz"));
	/*
	0 resim,
	1 soru,
	2,3,4,5
	6 boþ
	7 resim,
	8 soru,
	9,10,11,12
	13 boþ,
	14 soru,
	14,15,16,17
	18 resim,
	19 soru
	*/
	$k=0;
	$resim ="";
	print_r($satir);
	foreach($satir AS $deger) {
		e("$k <br />");
		if($k%6==0) {
			if($deger!="") {
				$deger = str_replace("#$!@%!#","",$deger);
				
				$resim = $deger;
			} else {			
				$resim = "";
			}
			if($satir[$k+1]!="") {
				$soru = dEkle("soru",array(
					"val" => $satir[$k+1],
					"tip" => "soru",
					"pic" => $resim,
					"kat" => get("kid")
				));
				e("soru eklendi: $soru <br />");
			}
			$cevapsayi=0;
		} else {
			if(trim($deger)!="") {
				if($cevapsayi==0) {
					$dogru=1;
				} else {
					$dogru=0;
				}
				e("cevap ekleniyor: $soru <br />");
				if($satir[$k+1]!="") {
				dEkle("soru",array(
					"val" => $satir[$k+1],
					"tip" => "cevap",
					"dogru" => $dogru,
					"ust" => $soru,
					"kat" => get("kid")
				));
				}
				$cevapsayi++;
				e("cevap eklendi: $soru <br />");
			}
		}
		$k++;
	}
	yonlendir("?kid={$_GET['kid']}#sorular");
}
if(getisset("googleSonuc")) {
	$kriter = get("googleSonuc");
	if($kriter!="") {
		googleSearch($kriter);
		googleSearch($kriter,4);
		googleSearch($kriter,8);
	}
	exit();
}
if(!oturumesit("Seviye2","Yonetici")) yonlendir("index.php");
if(getisset("sira")) {
	$id = veri(post("id"));
	e("$id :".post("index"));
	dGuncelle("content",array(
		"s" => post("index")
	),"id=$id");
	exit();
}
function tumunuSil($slug) {
	$content = contents($slug);
	if($content!=0) {
		while($c = kd($content)) {
			$varmi = ksorgu("content","WHERE pic='{$c['pic']}' AND id<>{$c['id']}"); //baþkasý bu görseli kullanýyor mu?
			if($varmi==0) {
				@unlink("file/{$c['pic']}");
			}
			sil("content","id={$c['id']}");
			tumunuSil($c['slug']);
		}
	}
}
if(getisset("cogalt")) {
	$id = veri(get("cogalt"));
	$c = kd(content(get("cogalt")));
	$c['slug'] = yenislug($c['title']);

	unset($c['id']);
	print_R($c);
	echo dEkle("content",array_filter($c));
	$icerik = contents(get("cogalt"));
	while($i = kd($icerik)) {
		unset($i['id']);
		$i['slug'] = yenislug($i['title']);
		$i['kid'] = $c['slug'];
		echo dEkle("content",array_filter($i));
	}
	yonlendir("pfiy-masaustu.php?kid=".$c['kid']);
}
if(getisset("sil")) {
	$id = veri(get("sil"));
	$kim  =kd(content_id(get("sil")));
	$varmi = ksorgu("content","WHERE pic='{$kim['pic']}' AND id<>$id"); //baþkasý bu görseli kullanýyor mu?
	if($varmi==0) {
		@unlink("file/{$kim['pic']}");
	}
	tumunuSil($kim['slug']);
	sil("content","id=$id");
	exit();
}
if(getisset("ekle")) {
	print_R($_POST);
	postyukle("pic","file/");
	posttarih("date");
	$_POST['code'] = str_replace("<!--?php","<?php",$_POST['code']);
	$_POST['code'] = str_replace("?-->","?>",$_POST['code']);
	dEkle("content",$_POST);
	if(!postesit("kid","")) {
		geri("kid={$_POST['kid']}");
	} else {
		geri();
	}
	
}
if(getisset("autocomplete")) {
	$kriter = veri("%".trim(strip_tags($_GET['term']))."%");
	$sorgu = ksorgu("galerikategori","WHERE isim LIKE $kriter");
	$k=0;
	while($s = kd($sorgu)) {
		$dizi[$k]['value']=$s['isim'];
		$dizi[$k]['id']=(int)$s['id'];
		$k++;
	}
	//print_r($dizi);
	echo json_encode($dizi);
	exit();
}
if(getisset("guncelle")) {
	postyukle("pic","file/");
	posttarih("date");
	$id = veri(get("guncelle"));
	$_POST['code'] = str_replace("<!--?php","<?php",$_POST['code']);
	$_POST['code'] = str_replace("?-->","?>",$_POST['code']);
	dGuncelle("content",$_POST,"slug=$id");
	//alt seviyedekileri de güncelle
	dGuncelle("content",array(
		"kid" => post("slug")
	),"kid=$id");
		geri("kid={$_POST['slug']}&guncelle2#yeniForm");
	
}
if(getisset("slug")) {
	$slug = veri(slug(post("deger")));
	$varmi =ksorgu("content","WHERE slug=$slug");
	if($varmi==0) {
		e(slug(post("deger")));
	} else {
		e(slug(post("deger").rand(0,999)));
	}
	exit();
}
 ?>