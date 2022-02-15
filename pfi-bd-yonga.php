<?php 
/*
PeyamFi - Peyam Farklı İçerik Yönetim Sistemi 
Bilumum Değişkenler Yongası (pFiBDYonga.php)

Yazan: Ümit TUNÇ
Başlangıç Tarihi: 01/01/2012 07:44
Bitiş Tarihi: 30/03/2012 19:30
*/
include("kobetik/kobetik.php"); 
oturumAc();
//SanalPOS ile ilgili işlemler
$banka = "garanti";
$isyeri_no = "1231312";
$kull_adi = "umit";
$sifre = "1234";
//////////
$gunDizi = array("","Pazartesi","Salı","Çarşamba","Perşembe","Cuma","Cumartesi","Pazar");
$ayDizi = array("","Ocak","Şubat","Mart","Nisan","Mayıs","Haziran","Temmuz","Ağustos","Eylül","Ekim","Kasım","Aralık");
$adres = "127.0.0.1";
$mail = "";
$dil = "tr";
$betik = "betikler/";
$stil = "stiller/";
$img = "resimler/"; 
$urunlink = "$img/urunler/";
$via = "pfi-bvi-yonga.php?";
$favicon = $img . "ikon/favicon.ico";
$amblem = "resimler/tema/amblem.png";
include("pfi-lisan/pfi-".$dil.".php"); //dil dosyamızı alalım
$ayar = kd(kSorgu("siteayarlar","WHERE id = 1"));
$imza = kripto('gjwebqTruncgil+PelinomGRQQa');
function haberler($kategori="",$bas=0,$miktar=10){
	if($kategori!="") :
		$kategori = veri($kategori);
		$kat = "AND kategori = $kategori";
	else :
		$kat="";
	endif;
	return ksorgu("haberler","WHERE y=1 $kat ORDER BY id DESC LIMIT $bas,$miktar");
}
function son_sayfa_id($kid) {
	$s = kd(ksorgu("sayfalar","WHERE kategori = $kid"));
	return $s['id'];
}

//dil dosyasını daha hızlı çağırma fonksiyonu
function dil($sayi) {
global $lisan;
		return @$lisan[$sayi];
}
function dile($sayi) {
global $lisan;
		echo $lisan[$sayi];
}
function pfS($tablo,$id) { //herhangi bir tabloda herhangi bir id numarasına ait yayınlanmış içeriği döndürür
	return kSorgu($tablo,sprintf("WHERE id = %s AND y = 1",veri($id,"sayi")));

}
function pfBS($tablo,$diger = "ORDER BY id ASC") { //herhangi bir tabloda herhangi bir id numarasına ait yayınlanmış içeriği döndürür
	return kSorgu($tablo,sprintf("WHERE y = 1 %s",$diger));

}
function pfAS($tablo,$alan,$deger,$bas=0,$son=20) { //herhangi bir tabloda herhangi bir id numarasına ait yayınlanmış içeriği döndürür
	return kSorgu($tablo,sprintf("WHERE %s = %s AND y = 1",$alan,veri($deger,"sayi")),$bas,$son);

}
function pfAS2($tablo,$alan,$deger,$bas=0,$son=20) { //herhangi bir tabloda herhangi bir id numarasına ait içeriği döndürür
	return kSorgu($tablo,sprintf("WHERE %s = %s",$alan,veri($deger,"sayi")),$bas,$son);

}
function pfYS($tablo,$bas=0,$son=20) { //yayınlanan bütün içeriği id sıralamasına göre döndürür
	return kSorgu($tablo,"WHERE y = 1 ORDER BY id DESC",$bas,$son);

}
function pfOS($tablo,$alan="id",$sirala="DESC",$bas=0,$son=20) { //yayınlanan bütün içeriği alanın belirlenen sıralama ölçütüne göre  döndürür
	return kSorgu($tablo,sprintf("WHERE y = 1 ORDER BY %s %s",$alan,$sirala),$bas,$son);

}

//bir içeriğe giriş yapıldığında onun kaydını tutar
function kayit($tur,$id){
/*öncelikle bir kişi ancak bir defa bir ip üzerinden artış sağlayabilir. 
Her defa aynı işlemin yapılmaması için bir çerez atayalım. Daha sonra o çerezin
olup olmadığına bir bakalım. Sanki oy veren bir vatandaşın parmağına mürekkep damlatmak
gibi bir şey...
*/
	if (!isset($_COOKIE[$tur.$id])) {
		$varmi = sorgu(
			sprintf("SELECT * FROM hit WHERE tid = %s AND tur = %s",
				veri($id,"sayi"),
				veri($tur)
			)
		);
		if ($varmi!=0) { //yapılmamış ise ekle
			hit("hit","sayi",sprintf("tid = %s AND tur = %s",
					veri($id,"sayi"),
					veri($tur)
				)
			);
		} else {
			dEkle("hit",array(
					"tid" => $id,
					"tur" => $tur,
					"sayi" => "1"
				)
			);
		}
		return 1;
		$cerez = $tur . $id; //aynı ip ye sahip bir kullanıcı aynı türün aynı id li içeriğine işlem yapmışsa
		$deger = ip();
		setcookie($cerez,$deger);
	}
}


?>
<?php include("pfi-bilesenler.php"); ?>