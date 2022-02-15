<?php include("sablon.php"); ?>
<?php include("secure.php"); 
dEkle("error",array(
	"e" => get("e"),
	"tarih" => simdi(),
	"ip" => $_SERVER['REMOTE_ADDR']
));
?>
<?php a("Sorun Var!"); ?>
<div class="panelAlan clouds" style="text-align:center;">
<img src="onlylogo.png" width="300" alt="" />
<h1><?php 
$adi = username($user['id']);
le("Sayın $adi, henüz sebebini bilmediğimiz bir nedenden dolayı hata oluştu. 
Hata mesajı sistem yöneticisine iletildi. Bu sorunu en kısa sürede çözeceğiz. 
Sizi üzmek istemezdik, özür diliyoruz.
"); ?></h1>
</div>
<?php b(); ?>