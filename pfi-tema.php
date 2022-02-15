<?php 
include("tema/tema.php");
include("pfi-bd-yonga.php"); 
if(isset($_GET['cikis'])) { //cikis isimli bir get değişkenin değeri 1 olması durumunda bütün oturum değişkenleri silinir. Bir ayak izi dahi bırakmaz 
				oturumSil("uid");
				oturumSil("pFiMail");
				oturumSil("pFiUser");
				oturumSil("pFi");
				oturumSil("Seviye");
				oturumSil("adi");
				oturumSil("soyadi");
				/*
				$sid = oturum("sepet");
				sil("sepet","WHERE id = $sid");
				sil("sepet_detay","WHERE sepet_id = $sid");
				*/
				yonlendir("index.php");

}

function pBas($bas=""){

global $betik;
global $baslik;
global $adres;
global $mail;
global $dil;
global $stil;
global $img; 
global $via;
global $favicon;
global $ayar;
	bas($baslik . " > " . $bas);
	include("pfi-he-in.php"); // pelinom fi header include
	include("pfi-giris-js.php"); 
	//e($ayar['head']); 
}
function _pBas() { 
	_bas();
 } 
function pUst($sayfa="normal") { 
global $betik;
global $baslik;
global $adres;
global $mail;
global $dil;
global $stil;
global $img; 
global $via;
global $ayar;
    govde($sayfa);
} //pUst 
function pManset() {
}
function pOrta($sayfa="",$top="") { 
	ana($sayfa,$top);
} //pOrta 
function pAna(){ //anasayfada yer alacak içeriklerin yer aldığı fonksiyon 
	indeks();
} //pAna  
function _pOrta(){ 
	_ana();
} 
function pAlt() { 
	alt();
} 
?>
