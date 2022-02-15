<?php include("sablon.php"); ?>
<?php include("secure.php"); 
include("social.inc.php");
$okul = veri(get("u"));
?>
<?php a("Zomni"); ?>
<h1><?php e(get("u")) ?> Sosyal Ağı</h1>
<?php dialogbox($ph="#{$_GET['u']} hakkında bir şeyler yaz",str_replace(" ","","#{$_GET['u']} "). " "); ?>
<div class="dialogzone">
<?php $hash = veri("%".str_replace(" ","","{$_GET['u']} ")."%"); 
$tags = ksorgu("social","WHERE hash LIKE $hash ORDER BY id DESC");
?>
<?php while($s = kd($tags)) { 
	socialbox($s);
} ?>
</div>
<?php sonuclar("SELECT * FROM results 
	inner join uyeler on results.uid = uyeler.id
	where uyeler.okul=$okul
	order by results.id desc
"); ?>

<?php 
include("social2.inc.php");
b(); ?>