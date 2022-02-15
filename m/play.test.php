<?php include("sablon.php"); ?>
<?php include("secure.php"); ?>
<?php 
oturumAc();
if(getisset("goruldu")) {
	oturum("isGoruldu","1");
//	e("ok");
	exit();
}
if(getisset("cevapclick")) {
	if(!oturumisset("userinfo")){
		$_SESSION['userinfo'] = array();
	}
	array_push($_SESSION['userinfo'],$_POST);
	print_r($_SESSION['userinfo']);
	
	exit();
}
if(getisset("finish")) {
	ob_start();
	$score =0;
	//print_r($_SESSION['userinfo']);
	foreach($_SESSION['userinfo'] AS $deger) {
		$score += $deger['score'];
	}
	dGuncelle("play",
	array(
		"u1info" => json_encode(oturum("userinfo")),
		"u1score" => $score
		),
		"id={$_SESSION['playgame']}"
		);
	if($score==0) {
		e("Sıfır");
	} else {
		e($score);
	}
	ob_end_flush();
	
	$ne = kd(ksorgu("play","WHERE id ={$_SESSION['playgame']}"))['kat'];
	$kat = cattitle($ne);
	
	fb_bildirim(oturum("selectuser"),"{$user['adi']} {$user['soyadi']} Zomni'de $kat alanında yarışmak istiyor. Yarışmak istersen hemen tıkla!","$appurl"."play2.php?first={$_SESSION['playgame']}");
	zmail(
		oturum("selectuser"),
		"
		{$user['adi']} {$user['soyadi']} Zomni'de $kat alanında yarışmak istiyor.",
		"Sayın {$user2['adi']} {$user2['soyadi']} 
		<br />
		{$user['adi']} {$user['soyadi']} Zomni'de $kat alanında yarışmak istiyor. Yarışmak ister misin?",
		"$appurl"."play2.php?first={$_SESSION['playgame']}","Hemen Yarışmak İçin Tıkla!"
		);
	
	unset($_SESSION['playgame']);
	unset($_SESSION['userinfo']);
	oturumSil("isGoruldu");
	ob_end_flush();
	exit();
		
}
if(getisset("isTrue")) {
	$id = veri(post("cevap"));
	$dizi = array();
	$cevap=kd(ksorgu("soru","WHERE id=$id AND tip='cevap'")); //işaretlenen
	if($cevap['dogru']==0) { //işaretlenen cevap yanlışsa
		$dogrucevap = kd(ksorgu("soru","WHERE ust={$cevap['ust']} AND dogru=1"));//doğru cevap ne söyle bakalım
		$dizi[0]['dogrumu'] = false;
		$dizi[0]['dogrusu'] = $dogrucevap['val'];
		
	} else {
		$dizi[0]['dogrumu'] = true;
	}
	e(json_encode($dizi));
	exit();
}
if(getisset("first")) {
	oturumAc();
	unset($_SESSION['playgame']);
	unset($_SESSION['userinfo']);
		$sorular = ksorgu("soru","WHERE tip='soru' ORDER BY rand() LIMIT 0,7");
		$dizi = array();
		while($s=kd($sorular)) {
			array_push($dizi,$s['id']); //seçilen soruları diziye atalım
		} 
		$sorular = json_encode($dizi); //diziyi json a dönüştürelim
		//şimdi oyun meydanını yazalım bismillah
		$id = dEkle("play",array(
			"sorular" => $sorular,
			"u1" => $user['id'],
			"u2" => $user['id'], // challange a davet ettiğimiz kişi
			"kat" => "test",
			"date" => simdi() //başladığımız tarih
		));
		oturum("playgame",$id);
		yonlendir("play.php"); // oyun ekranına yönlendirelim.
	
	
}
if(!oturumisset("playgame")) {
	yonlendir("profile.php");
}
if(oturumisset("isGoruldu")) {
	oturumSil("isGoruldu");
	$id = veri(post("playid"));
	dGuncelle("play",array(
	"u1score" => "0",
	"u1info" => "Vazgeçti"
	),"id =$id AND u1 = {$user['id']}");	
	yonlendir("profile.php");
}
if(getisset("select")) {
	exit();
}
if(getisset("get")) {
	//$tek = contents
	exit();
}
 ?>
<div class="progress p1"></div>
<div class="progress p2"></div>

 <?php a("Oyna",3); ?>
<?php 
oturumAc();
//print_r($_SESSION);
$game = oturum("playgame");
$sorular = kd(ksorgu("play","WHERE id=$game"));
$sorular2 = json_decode($sorular['sorular']);
$vs = user(oturum("selectuser"));
 ?>
 <div class="loading">Yükleniyor...</div>
 <div class="start">
	<h1 class="imready">Hazırsan Başlıyoruz!</h1>
	<div class="user1">
	<h1><?php profilepic($user['id']) ?>
<?php echo $user['adi'] ?> <?php echo $user['soyadi'] ?></h1>
	</div>
	<div class="kategori" style="background:url(../file/<?php e(catlogo($sorular['kat'])); ?>) no-repeat center;
	position:absolute;
	width:100%;
	height:100%;
	opacity:0.6;
	top:0px;
	left:0px;
	"></div>
	<div class="user2">
		<h1><?php profilepic($vs['id']) ?>
<?php e($vs['adi']) ?> <?php e($vs['soyadi']) ?></h1>

	</div>
 </div>
 <fieldset class="ui-grid-b profiles"><div class="ui-block-a textcenter">
	<?php profilepic($user['id']) ?>
<?php echo $user['adi'] ?> <?php echo $user['soyadi'] ?>
<score id="u1score">0</score>
</div><div class="ui-block-b textcenter">
	
	<div class="counter">
		<saniye></saniye>
		<durum></durum>
	</div>
	<round></round>
	</div><div class="ui-block-c textcenter">
	<?php profilepic($vs['id']) ?>
<?php e($vs['adi']) ?> <?php e($vs['soyadi']) ?>
<score id="u2score"><i class="fa fa-clock-o"></i></score>

</div>
</fieldset>
 <div class="sorular" style="    max-width: 700px;
    margin: 0 auto;">
 <?php foreach($sorular2 AS $soru) {  
 $cevaps = ksorgu("soru","WHERE tip='cevap' AND ust=$soru ORDER BY rand()");
	
 ?>
 
 <div class="soru">
<?php 
$pic = soru($soru,"pic");
if($pic!="") { ?><img src="../r.php?w=512&p=file/<?php e($pic); ?>" class="soruResim" alt="" /><?php } ?>
<h1><?php e(soru($soru,"val")); ?></h1>
 <div class="cevaplar">
<?php while($c = kd($cevaps)) { 
	getcevap($c);
 } ?>
 </div>
</div>
 <?php } ?>
 </div>
 <div class="finish"  style="max-width: 700px;
    margin: 0 auto;display:none">
 <fieldset class="ui-grid-a" ><div class="ui-block-a textcenter">
	<?php echo profilepic($user['id']) ?>
<?php echo $user['adi'] ?> <?php echo $user['soyadi'] ?>
</div><div class="ui-block-b textcenter">
	<?php profilepic($vs['id']) ?>
<?php e($vs['adi']) ?> <?php e($vs['soyadi']) ?>

</div>
</fieldset>	
<h1><?php le("Son Durum Şöyle") ?></h1>
<score style="    font-size: 42px;" id="sonscore"></score>
<a class="ui-btn sonmesaj"><?php le("Bakalım {$vs['adi']} {$vs['soyadi']} seni geçecek mi? <br /> Kararı ondan sonra vereceğiz"); ?></a>
<a href="selectuser.php?rasgele" class="ui-btn ui-btn-inline yesil" style="background-color: #FF6800;"><i class="fa fa-repeat"></i> <?php le("Başkasıyla Tekrar Oyna") ?></a>
<a href="profile.php" class="ui-btn ui-btn-inline" style="background-color: #37BC9B;"><i class="fa fa-user"></i> <?php le("Profiline Git") ?></a>
<a href="" class="ui-btn ui-btn-inline" style="background-color: #053763;"><i class="fa fa-facebook-square"></i> <?php le("Paylaş") ?></a>
</div>
<?php include("play.core.php"); ?>
<?php b("",3); ?>