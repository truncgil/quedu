<?php include("sablon.php"); ?>
<?php include("secure.php"); ?>
<?php 
include("social.inc.php");
$id = veri(get("id"));
$varmi = ksorgu("social","WHERE id=$id");
if($varmi==0) yonlendir("profile.php");
a("Zomni"); ?>
<?php 

$ne = kd($varmi); 
$kim = nickname($ne['uid']);
dialogbox("@$kim kişisine bir şeyler yaz ","@$kim ");
?>
<div class="dialogzone">
<?php
socialbox($ne);
?>
</div>
<?php 
include("social2.inc.php");
b(); 

?>