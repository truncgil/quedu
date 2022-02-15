<?php include("sablon.php");
include("secure.php");
if(getisset("id")) {
	oturumAc();
	oturum("sec_uni",get("id"));
	yonlendir("bolum.php");
}
if(getisset("id2")) {
	oturumAc();
	oturum("sec_uni",get("id2"));
	yonlendir("social.php?u={$_SESSION['sec_uni']}");	
}
a("Üniversiteler");
if(getisset("ara")) {
	$kr = veri("%".post("ara")."%");
	$kriter = "WHERE title LIKE $kr";
} else {
	$kriter = "";
}
$universite = ksorgu("university","$kriter ORDER BY title ASC");
?>
<form action="?ara<?php if(getisset("sec")) e("&sec") ?>" method="post">
<input type="text" name="ara" placeholder="Üniversite Ara..." id="" />
<button><i class="fa fa-search"></i></button>
</form>
<div style="text-align:center;">
<?php
while($u = kd($universite)) {
	if(getisset("sec")) {
		$link = "?id={$u['title']}";
	} else {
		$link = "?id2={$u['title']}";
	}
	e("<a href='$link' class='ui-btn ui-btn-inline uni' style='   '><img src='{$u['logo']}' class='profilepic' />{$u['title']}</a></li>");
}
?>
</div>
<?php
b();
 ?>