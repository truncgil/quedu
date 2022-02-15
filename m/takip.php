<?php include("sablon.php"); ?>
<?php include("secure.php"); ?>
<?php
$uid = veri(get("id"));
$user = user(get("id"));
 ?>
<?php a("Zomni"); ?>
<?php userprofile(); ?>
<?php 
if(!getisset("ci")) {
$takip = ksorgu("friend","WHERE uid =$uid ORDER BY id DESC");

?>
<h1 class="panelAlan clouds"><?php le("Takip Ettikleri") ?></h1>
<?php
while($t = kd($takip)) {
	?>
	<a class="ui-btn ui-btn-inline user" href="profile2.php?id=<?php e($t['uid2']) ?>"><?php profilepic($t['uid2']) ?>
	<?php echo username($t['uid2']); ?>
	</a>
	<?php
}
 ?>
<?php } else { 
$takip = ksorgu("friend","WHERE uid2 =$uid ORDER BY id DESC"); ?>
<h1 class="panelAlan clouds"><?php le("Takipçileri") ?></h1>
<?php
while($t = kd($takip)) {
	?>
	<a class="ui-btn ui-btn-inline user" href="profile2.php?id=<?php e($t['uid']) ?>"><?php profilepic($t['uid']) ?>
	<?php echo username($t['uid']); ?>
	</a>
	<?php
}
 ?>
<?php } ?>
<?php b(); ?>