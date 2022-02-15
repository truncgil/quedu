<?php include("sablon.php"); ?>
<?php include("secure.php"); ?>
<?php include("social.inc.php"); ?>
<?php $hash = veri("%".get("tag")."%"); 
$oyun = intclear(get("tag"));
if(is_numeric($oyun)) yonlendir("result2.php?id=$oyun");
$tags = ksorgu("social","WHERE hash LIKE $hash ORDER BY id DESC");
?>
<?php a("Zomni"); 

dialogbox("#{$_GET['tag']} hakkında bir şeyler yaz","#{$_GET['tag']} ");
e('<div class="dialogzone">');
while($t = kd($tags)) {
	socialbox($t);
}
e("</div>");
?>
<?php include("social2.inc.php"); ?>
<?php b(); ?>