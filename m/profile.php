<?php include("sablon.php"); ?>
<?php include("secure.php"); 
include("gamedelete.php");
include("social.inc.php");
$uids = array();

array_push($uids,$user['id']);
$friends= ksorgu("friend","WHERE uid = {$user['id']}");
while($f=kd($friends)) {
	array_push($uids,$f['uid2']); //takip ettiklerim
}
$uids = implode(",",$uids);
if(getisset("short")) {
	$sonyaz =  ksorgu("social","WHERE uid IN ($uids) ORDER BY id DESC LIMIT 0,3"); 
	while($s = kd($sonyaz)) {
		socialbox($s);
	}
}
if(getisset("news")) {
	dEkle("see",array(
		"tarih" => simdi(),
		"uid" => oturum("uid")
	));
}
?>
<?php a("Profiliniz"); ?>

	<?php if($user['okul']=="") { ?>
		<a href="university.php?sec" class="ui-btn orange">
		<i class="fa fa-exclamation-triangle"></i> <?php le("Eğitim bilgileriniz girilmemiş. Güncellemek için bu alana tıklayın"); ?>
		</a>
	<?php } ?>
	<div data-role="navbar">
		<ul>
			<li><a href="profile.php" <?php if(!getisset("news")) { ?>class="ui-btn-active"<?php } ?>><i class="fa fa-user"></i> <?php le("Profilim") ?></a></li>
			<li><a href="?news" <?php if(getisset("news")) { ?>class="ui-btn-active"<?php } ?>><i class="fa fa-newspaper-o"></i> <?php le("Haber Kaynağı") ?> 
			<?php $see = kd(ksorgu("see","where uid = {$user['id']} ORDER BY id DESC"))['tarih']; 
	$toplam = toplam("social","uid IN ($uids) AND uid <>{$user['id']} AND tarih>'$see'");
	?>
	<?php if($toplam!=0) { ?>
			<span style="background: #CA0B0B;
    padding: 3px 6px 3px 5px;
    border-radius: 100%;
    width: 61px;"><?php e($toplam) ?></span>
	<?php } ?>
	</a></li>
		</ul>
	</div>
	<?php if(!getisset("news")) { ?>
	<?php userprofile(); ?>
	<a href="#kelime_gelistirme" data-position-to="window" data-rel="popup" data-transition="slideup" style="background: #3B97D4;" class="ui-btn"><img src="https://www.zomni.xyz/file/resolutions_06_512.png" style="    vertical-align: middle;margin:5px 10px;" width="64" alt="" />Kelime Geliştirme Oyna</a>
	<div data-role="navbar" class="navbarmini">
		<ul>
			<li><a href="#oyunSec" data-rel="popup" data-transition="slideup"  class="ui-btn pomegranate"><i class="fa fa-play-circle middleicon"></i> <?php le("Yeni Oyun") ?></a></li>
			<?php $sonoyun = kd(ksorgu("play","WHERE u1={$user['id']} ORDER BY id DESC")); ?>
			<li><a href="category.php?rasgelesec=<?php e($sonoyun['kat']) ?>" class="ui-btn  pumpkin"><i class="fa fa-refresh middleicon"></i> <?php 
			$kattitle=cattitle($sonoyun['kat']);
			le("$kattitle Oyununu Başkasıyla Tekrarla") ?></a></li>
			<li><a href="#ilgilendikleriniz"  data-position-to="window" data-rel="popup" data-transition="slideup"><i class="fa fa-users middleicon"></i><?php le("İlgilendikleriniz") ?></a></li>
			<li><a href="#ilgilenenler"  data-position-to="window" data-rel="popup" data-transition="slideup"><i class="fa fa-users middleicon"></i><?php le("İlgilenenler") ?></a></li>
			<!--<li><a href="#trendsoylesi"  data-position-to="window" data-rel="popup" data-transition="slideup"><i class="fa fa-globe middleicon"></i><?php le("Trend Söyleşiler") ?></a></li>-->
			<li><a href="#yeniguncellenen"  data-position-to="window" data-rel="popup" data-transition="slideup"><i class="fa fa-refresh middleicon"></i><?php le("Yeni Güncellenen") ?></a></li>
			<li><a href="#trendkonular"  data-position-to="window" data-rel="popup" data-transition="slideup"><i class="fa fa-list middleicon"></i><?php le("Trend Konular") ?></a></li>
			<li><a href="#populer"  data-position-to="window" data-rel="popup" data-transition="slideup"><i class="fa fa-user middleicon"></i><?php le("Bu Hafta Popüler") ?></a></li>
			<li><a href="#encokkazanan"  data-position-to="window" data-rel="popup" data-transition="slideup"><i class="fa fa-trophy middleicon"></i><?php le("En Çok Kazananlar") ?></a></li>
			<!--<li><a href="#birseyleryaz"  data-position-to="window" data-rel="popup" data-transition="slideup"><i class="fa fa-send middleicon"></i><?php le("Bir Şeyler Yaz") ?></a></li>-->
			<li><a href="#ilgialanlari"  data-position-to="window" data-rel="popup" data-transition="slideup"><i class="fa fa-heart middleicon"></i><?php le("İlgi Alanlarınız") ?></a></li>
			<li><a href="#oyungecmisi"  data-position-to="window" data-rel="popup" data-transition="slideup"><i class="fa fa-gamepad middleicon"></i><?php le("Oyun Geçmişi") ?></a></li>
		</ul>
		
	</div>
	<?php games(); ?>
	<script type="text/javascript">
	$(function(){
		
		var update = function(){
			$.get("ajax.php?tip=profilegame",function(d){
				$(".logprofile").html("");
				$.each(d,function(a,i) {
					var pattern = '<div href="" class="ui-btn butonlist bildirim gamepad">'+
					'<a href="" class="ui-btn ui-btn-inline yanlis" playid="'+i.id+'" ><i class="fa fa-times"></i> <?php le("Red") ?></a>'+
					'<a href="play2.php?first='+i.id+'" class="ui-btn ui-btn-inline dogru"><i class="fa fa-check"></i> <?php le("Kabul") ?></a>'+
					'<img src="../file/'+i.logo+'" alt="" />'+
					'<span>'+i.u1+' '+i.kat+' <?php le("alanında bir oyun talebinde bulunuyor.") ?>'+
					'<tarih style="position:absolute;bottom:5px;right:5px;font-size:12px;"><i class="fa fa-calendar"></i> '+i.date+'</tarih>'+
					'</span>'+
					'</div>';
					$(".logprofile").append(pattern);
				});
					$(".gamepad .yanlis").click(function(){
						var id = $(this).attr("playid");
						$.post("istekler.php?red",{
							"playid" : id
						},function(d){
							
						});
						$(this).parent().fadeOut("slow");		
					});			
				});		
		}
		update()
		window.setInterval(update,5000);
		
	});
	</script>
	<div class="logprofile">
	
	</div>
	<div data-role="popup" id="ilgilendikleriniz" class="panelAlan clouds">
		<h3 ><i class="fa fa-users"></i> İlgilendikleriniz</h3>
		<?php users("select u2 AS uid, COUNT(*) as toplam from play 
		inner join uyeler on uyeler.id = play.u2
		where u1='{$user['id']}' and u2 is not null group by u2 order by toplam desc limit 0,6"); ?>
	</div>
	<div data-role="popup" id="ilgilenenler" class="panelAlan clouds">
		<h3><i class="fa fa-users"></i> İlgilenenler</h3>
		<?php users("select u1 AS uid, COUNT(*) as toplam, play.date AS tarih from play 
		inner join uyeler on uyeler.id = play.u1
		where u2='{$user['id']}' and u1 is not null group by u1 order by toplam desc limit 0,6"); ?>
	</div>
	<div  data-role="popup" id="birseyleryaz" style="min-width:400px;" class="panelAlan">
	<?php dialogbox("Hadi bir şeyler yaz"); ?>
		<div class="dialogzone short">
			<?php $sonyaz =  ksorgu("social","WHERE uid IN ($uids) ORDER BY id DESC LIMIT 0,3"); 
				while($s = kd($sonyaz)) {
					socialbox($s);
				}
			?>
		
		</div>
		<a href="?news" class="ui-btn"><i class="fa fa-bars"></i> Tümünü gör</a>
	</div>
		<?php trends(); ?>
		<?php //userdurum(); ?>
		<?php usertabs2(); ?>
	<?php } else {  ///NEWs ?>
		<?php dialogbox(); ?>
		<div class="dialogzone">
			<?php 
			
			$social = ksorgu("social","WHERE uid IN ($uids) ORDER BY id DESC"); ?>
			<?php while($s = kd($social)) { 
				socialbox($s);
			} ?>
		</div>
	<?php } // news or profile ?>
	<?php include("social2.inc.php"); ?>
<?php b(""); ?>