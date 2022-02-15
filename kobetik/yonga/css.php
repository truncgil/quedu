<?php
$tr = array("/sol/","/sağ/","/üst/","/alt/","/orta/","/yasla/","/temiz/");
$en = array("left", "right","top","bottom","center","justify","clear");
?>
<?php function webSite($en="1024",$boy="") { ?>
<style type="text/css"><?php echo $kodlar ?></style>
<?php } ?>
<?php function stil($kodlar) {?>
<style type="text/css"><?php echo $kodlar ?></style>
<?php }?>
<?php function sblok($isim, $icerik) {
return $isim . "{" . $icerik . "}";
}?>
<?php function co($ozellik, $deger) {
return $ozellik . ":" . $deger . ";";
}?>
<?php function keyu($deger) { // kenar yuvarla
return "-moz-border-radius:" . $deger . ";" . "border-radius:" . $deger . ";" ."-webkit-border-radius:" . $deger . ";" ;
}?>
<?php function kenar($kalinlik,$tur="solid",$renk="#000",$mevki=NULL) {
global $tr;
global $en;
if ($mevki!=NULL) {
$mevki = "-" . preg_replace($tr,$en,$mevki);
}
return "border" . $mevki . ": " . $tur . " " . $kalinlik . " " . $renk . ";";
}?>
<?php function disuz($deger,$mevki=NULL) {
global $tr;
global $en;
if ($mevki!=NULL) {
$mevki = "-" . preg_replace($tr,$en,$mevki);
}
return "margin" . $mevki . ": " . $deger . ";";
}?>
<?php function icuz($deger,$mevki=NULL) {
global $tr;
global $en;
if ($mevki!=NULL) {
$mevki = "-" . preg_replace($tr,$en,$mevki);
}
return "padding" . $mevki . ": " . $deger . ";";
}?>
<?php function artalan($deger) {
return "background-color: " . $deger . ";";
}?>
<?php function artresim($deger) {
return "background-image:url(" . veri($deger) . ");";
}?>
<?php function arttekrar($deger=NULL) {
if ($deger=="yok") {
$deger = "no-repeat";
} else
if ($deger!=NULL) {
$deger = "repeat-" . $deger;
}
return "background-repeat: " . $deger . ";";
}?>
<?php function artalaka($deger) {
return "background-attachment:" . $deger . ";";
}?>
<?php function artmevki($deger) {
global $tr;
global $en;
$deger = preg_replace($tr,$en,$deger);
return "background-position:" . $deger . ";";
}?>
<?php function font($deger) {
return "font-family:" . $deger . ";";
}?>
<?php function hizala($deger) {
global $tr;
global $en;
$deger = preg_replace($tr,$en,$deger);
return "text-align:" . $deger . ";";
}?>
<?php function bol($deger) {
global $tr;
global $en;
$deger = preg_replace($tr,$en,$deger);
return "float:" . $deger . ";";
}?>
<?php function ekran($deger="none") {
global $tr;
global $en;
$deger = preg_replace($tr,$en,$deger);
return "display:" . $deger . ";";
}?>
<?php function fontboyut($deger) {
return "font-size:" . $deger . ";";
}?>
<?php function renk($deger) {
return "color:" . $deger . ";";
}?>
<?php function imlec($deger) {
return "cursor:" . $deger . ";";
}?>
<?php function en($deger) {
return "width:" . $deger . ";";
}?>
<?php function boy($deger) {
return "height:" . $deger . ";";
}?>
<?php function kutu($kenar="#000",$arka="#E2E2E2",$yazi="#000") {
return kenar("1px","solid",$kenar)
. disuz("5px")
. icuz("5px")
. artalan($arka)
. "color:" . $yazi . ";";
}?>
<?php function mevki($deger,$ust="10px",$sol="10px") {
return "position:" . $deger . ";top:" . $ust . ";left:" . $sol . ";";
}?>
<?php function kgolge($x="0px", $y="0px", $yayma="5px", $renk="#000") {
return "box-shadow:". $x . " " . $y . " " . $yayma . " " . $renk . ";";
}?>
<?php function ygolge($x="0px", $y="0px", $yayma="5px", $renk="#000") {
return "text-shadow:". $x . " " . $y . " " . $yayma . " " . $renk . ";";
}?>
<?php function tasma($deger) {
return "overflow:" . $deger . ";";
}?>
<?php function gizle() { ?>
style="display:none;"
<?php } ?>