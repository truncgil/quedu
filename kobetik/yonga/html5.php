<?php
/*
Kobetik Ýþaretleme Dili (KID)
Kobetik Markup Language (KML)
HTML 5 Özellikleri
Yazan (Author): Ümit TUNÇ
2011 - Aralýk 
*/
function kobetik() { ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php } ?>
<?php function _k() { ?></html><?php } ?>
<?php function head($baslik="Yeni Sayfa - KobetiK",$karset="utf-8") {
?><head><meta http-equiv="Content-Type" content="text/html;" charset=<?php echo $karset ?> /><title><?php echo $baslik ?></title><?php } ?>
<?php function _h() { ?></head><?php } ?>
<?php function body($parametre="") { ?><body<?php if($parametre!="") { echo " " . parametre(); } ?>><?php } ?>
<?php function _b() { ?></body><?php } ?>
<?php function br() {
	echo "<br />";
} ?>
<?php function linkCss($href) {
	printf("<link href='%s' rel='stylesheet' type='text/css' />",$href);
} ?>
<?php
/*
Form bileþenleri
*/
function form($yol,$metod,$dp="") {
	echo sprintf("<form action='%s' method='%s' %s>",$yol,$metod,$dp);
}
function _f() {
	echo "</form>";
}
function submit($value,$name="", $dp="") {
	printf("<input type='submit' value='%s' name='%s' %s />",$value, $name, $dp);
}
function input($tip="text",$isim="k",$deger="", $dp="") {
	echo '<input type="' . $tip . '" name="' . $isim . '" id="' . $isim . '" value="' . $deger . '"' . $dp . ' />'  ;
}
function inputGerekli($tip="text",$isim="k",$deger="", $placeholder="", $dp="") {
	echo '<input type="' . $tip . '" name="' . $isim . '" placeholder="' . $placeholder . '"' . '" value="' . $deger . '"' . $dp . ' required />'  ;
}
?>
<?php function video($url, $en=320, $boy=240) {
	printf("<video src=%s height=%s width=%s controls preload=false></video>",
		veri($url,"sayi"),
		veri($boy),
		veri($en)
		);
} ?>
<?php
function secim($isim="Kobetik-form-eleman",$tercihler="<option value='1'>Kobetik Örnek Seçim Deðeri</option>", $dp="") {
	return '<select name="' . $isim . '" '. $dp .'>' . $tercihler  . '</select>'  ;
}?>
<?php
function tercih($isim="Kobetik Örnek Seçim Deðeri", $deger="-1", $dp="") {
	 '<option value="' . $deger . '" ' . $dp .'>' . $isim . '</option>'  ;
}?>
<?php function js($url="") {?><script<?php if ($url!="") { ?> src="<?php echo $url ?>" type="text/javascript"<?php } ?>><?php if ($url!="") { ?></script><?php } ?><?php } ?>
<?php function _js() {?></script><?php } ?> 
<?php function a($url="#", $hedef="", $dp="") {?>
<a href="<?php echo $url ?>" <?php if ($hedef!="") { ?>target="<?php echo $hedef ?>"<?php } ?> <?php echo $dp ?>>
<?php } ?>
<?php function _a() {?></a><?php } ?>
<?php 
/*
Jquery fonksiyonlarý
*/ ?>
<?php function jQ() {?>
$(document).ready(function(){
<?php } ?>
<?php
function o($secici,$olay="click") {?>
$("<?php echo $secici ?>").<?php echo $olay ?>(function(){
<?php } ?>
<?php function _jx() {?>
});
<?php } ?>
  