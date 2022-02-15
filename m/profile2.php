<?php include("sablon.php"); ?>
<?php include("secure.php"); 

if(getisset("follow")) {
	$user2 = veri(post("user"));
	$k = post("k");
	$varmi =ksorgu("friend","WHERE uid = {$user['id']} AND uid2 = $user2");
	if($varmi==0) { //eğer arkadaş bende yoksa 
		if($k==1) { //eğer takip et tıklandıysa ekle 
		dEkle("friend",array(
			"uid" => $user['id'],
			"uid2" => post("user")
		));
		$kim = user($user['id']);
		logz(	
			post("user"),
			lr("Yeni bir takipçin var!"),
			lr("{$kim['adi']} {$kim['soyadi']} artık seni takip ediyor"),
			"profile2.php?id={$user['id']}"
			);
		
		}
	} else {
		if($k==0) {  // eğer takibi bırak tıklandıysa sil
			sil("friend","uid = {$user['id']} AND uid2 = $user2");
		}
	}
	print_r($_POST);
	exit();
}
if(!getisset("id")) {
	yonlendir("profile.php");
} else {
	$id = veri(get("id"));
	$id2 = veri(get("id")."%");
	$id3 = veri(explode("_",get("id"))[0]."%");
	$id4 = veri(explode("_",get("id"))[1]);
//	e($id3);
	$user = kd(ksorgu("uyeler","WHERE id = $id OR (mail like $id2 OR (id = $id4 AND mail like $id3)) ORDER BY FIELD(id, $id) DESC"));
	$id=$user['id'];

}
if($_SESSION["uid"]==$user['id']) { //kendi profilimi kendime gösterme kendi sayfama git
	yonlendir("profile.php");
}
?>
<?php include("social.inc.php") ?>
<?php a("Profiliniz"); ?>
	<?php 
	userprofile(); ?>
	<a href="#kelime_gelistirme" data-position-to="window" data-rel="popup" data-transition="slideup" style="background: #3B97D4;" class="ui-btn"><img src="https://www.zomni.xyz/file/resolutions_06_512.png" style="    vertical-align: middle;margin:5px 10px;" width="64" alt="" />Kelime Geliştirme Oyna</a>
	<div data-role="navbar">
		<ul>
		<?php 
		oturumAc();
		$fvarmi = ksorgu("friend","WHERE uid={$_SESSION['uid']} AND uid2 = {$user['id']}");
		
		if($fvarmi==0) { ?>
			<li><a href="#" id="takip" class="ui-btn nephritis"><i class="fa fa-plus-circle middleicon"></i> <span><?php le("Takip Et") ?></span></a></li>
		<?php } else { ?>
			<li><a href="#" id="takip" class="ui-btn concrete"><i class="fa fa-minus-circle middleicon"></i> <span><?php le("Takibi Bırak") ?></span></a></li>
		<?php } ?>
			<li><a href="#oyunSec" data-rel="popup" data-transition="slideup" class="ui-btn  pumpkin"><i class="fa fa-play-circle middleicon"></i> <?php le("Oyna") ?></a></li>
			<li><a href="#ilgialanlari" data-rel="popup" data-transition="slideup"><i class="fa fa-heart middleicon"></i><?php le("İlgi Alanları") ?></a></li>
			<li><a href="#oyungecmisi" data-rel="popup" data-transition="slideup"><i class="fa fa-gamepad middleicon"></i><?php le("Oyun Geçmişi") ?></a></li>
		</ul>
	</div>
	<?php games("random"); ?>
	<?php 
		$nick = nickname($user['id']);

	dialogbox("@$nick kişisine bir şeyler yaz","@$nick "); ?>
	<div class="dialogzone">
	</div>
	<?php  usertabs2(); ?>
<?php include("inc.toggleclick.php"); ?>
<?php include("social2.inc.php") ?>

<?php b(""); ?>