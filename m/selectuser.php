<?php include("sablon.php");  ?>
<?php include("secure.php"); 
include("gamedelete.php"); 
$kat = kd(content($_SESSION['selectcat']));
if($kat['alt']!="") {
	$hemen_link = "play_soz.php?first={$_SESSION['selectcat']}";
	$user_link  ="play_soz.php?first={$_SESSION['selectcat']}";
} else {
	$hemen_link = "play.php?first={$_SESSION['selectcat']}";
	$user_link  ="selectuser.php?sec={$f['uid2']}";
}
if(getisset("hemenoyna")) {
	$varmi = content(get("hemenoyna"));
	if($varmi==0) { 
		yonlendir("profile.php"); 
	} else {
		oturum("selectcat",get("hemenoyna"));
		oturum("selectuser",get("user"));
		yonlendir($hemen_link);
	}
	
}
if(getisset("rasgele")) {
	//eski teknik favorilere sahip olandan seçiyordu
	/*
	$ilk = ksorgu("favorite","WHERE cat ='{$_SESSION['selectcat']}' AND uid <> {$user['id']} ORDER BY rand()");
	if($ilk!=0) {
		$uye = kd($ilk);
		$uye['id'] = $uye['uid'];
	} else {
		$uye = kd(ksorgu("uyeler","WHERE facebook IS NOT NULL AND id <> {$user['id']} ORDER BY rand() "));
	}
	*/
	yonlendir($hemen_link);
} 
if(getisset("sec")) {
	/*
	Şimdi bir engelleme yapalım. 
	örneğin bir oyuncu sürekli bir başka oyuncuyu seçip fake olarak 
	puanını artırmak isteyebilir 
	ve sıralamada yerini yükseltmek isteyebilir. 
	Bunun için bir kişi ile ard arda yarışmasına engel olunması lazım. 
	#Zomni sürekli bir kişi ile yarışmak isteyenleri engelleyip özellikle 
	kendi seviyesinden bir kişinin tavsiye ederek yarıştırması gereklidir. 
	Evet bu güzel oldu 
	*/
	//eğer seçilen kişi ile yarışıldıysa
	$id = veri(get("sec"));
	$son = kd(ksorgu("play","where u1={$user['id']} ORDER BY id DESC LIMIT 0,1")); //son seçtiğime bak
	if($son['u2']!=$_GET['sec']) { //son oynadığım kişi seçtiğim kişi değilse seç
		oturum("selectuser",get("sec"));
	} else { // seçtiğim kişi ise havuzdan rasgele bir kişi seç
		oturum("selectuser",rasgele_user(oturum("selectcat")));
	}
	yonlendir("play.php?first={$_SESSION['selectcat']}");
}
a("Arkadaşlarınız",2);

?>
<a href="" class="ui-btn"><img width="128" src="../file/<?php e(catlogo(oturum("selectcat"))) ?>" alt="" />
<h2><?php echo cattitle(oturum("selectcat")); ?></h2>
</a>
<div data-role="navbar">
	<ul>
		<li><a href="selectuser.php?rasgele" class="ui-btn emerland"><i class="fa fa-random middleicon"></i> <?php le("Rasgele Biriyle Oyna") ?></a></li>
	</ul>
</div>
	
<h2><?php le("ya da şunlardan biri ile oyna") ?></h2>
<div class="textcenter">
		<?php 
		$k=1;
		$friends = ksorgu("friend","WHERE uid = '{$user['id']}' ORDER BY id DESC"); ?>
		<?php if($friends!=0) { ?>
<?php while($f = kd($friends)) { 

?>
			<a href="<?php e($user_link) ?>&uid=<?php e($f['uid2']) ?>" class="ui-btn ui-btn-inline <?php echo user($f['uid2'],"color") ?>">
				<?php profilepic($f['uid2']); ?>
				<?php echo user($f['uid2'],"adi") ?> <?php echo user($f['uid2'],"soyadi") ?>
			</a>
			
			<?php $k++; } ?>
		<?php } else { ?>
		<?php } ?>
		</div>
<?php b(); ?>