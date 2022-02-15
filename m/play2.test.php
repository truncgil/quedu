
<?php include("sablon.php"); ?>
<?php include("secure.php"); ?>
<?php 
oturumAc();
if(getisset("goruldu")) {
//	oturum("isGoruldu","1");
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
	$score =0;
	foreach($_SESSION['userinfo'] AS $deger) {
		$score += $deger['score'];
	}
	e($score);
//son skorları oku ve yeni tabloya yaz
		$skor = kd(ksorgu("play","WHERE id={$_SESSION['playgame']}"));
		dEkle("scores",array(
			"score" => $skor['u1score'],
			"tarih" => simdi(),
		    "pid" => $_SESSION['playgame'],
			"uid" => $skor['u1'],
			"kat" => $skor['kat']
		));
		dEkle("scores",array(
			"score" => $skor['u2score'],
			"pid" => $_SESSION['playgame'],
			"tarih" => simdi(),
			"kat" => $skor['kat'],
			"uid" => $skor['u2']
		));
		$user2 = user($skor['u2']);
		$user1 = user($skor['u1']);
		$kat = cattitle($skor['kat']);
		if($skor['u1score']==$skor['u2score']) { // berabere
			dEkle("results",array(
				"sonuc" => "Quits",
				"tarih" => simdi(),
				"kat" => $skor['kat'],
				"pid" => $_SESSION['playgame'],
				"uid" => $skor['u1'],
				"uid2" => $skor['u2']
			));
			dEkle("results",array(
				"sonuc" => "Quits",
				"kat" => $skor['kat'],
				"pid" => $_SESSION['playgame'],
			    "tarih" => simdi(),
				"uid" => $skor['u2'],
				"uid2" => $skor['u1']
			));
			
			$durum ="{$user2['adi']} {$user2['soyadi']} senin {$skor['u1score']} aldığın $kat oyununda {$skor['u2score']} puanını alarak seninle berabere kaldı";
		} elseif($skor['u1score']>$skor['u2score']) { //1. kullanıcı yendi
			dEkle("results",array(
				"sonuc" => "Win",
				"kat" => $skor['kat'],
				"pid" => $_SESSION['playgame'],
				"tarih" => simdi(),
				"uid" => $skor['u1'],
				"uid2" => $skor['u2']
			));
			dEkle("results",array(
				"kat" => $skor['kat'],
				"sonuc" => "Lost",
				"pid" => $_SESSION['playgame'],
				"tarih" => simdi(),
				"uid" => $skor['u2'],
				"uid2" => $skor['u1']
			));
			$durum ="{$user2['adi']} {$user2['soyadi']} senin {$skor['u1score']} aldığın $kat oyununda {$skor['u2score']} puanını alarak sana yenildi.  Tebrikler!";
			
		} elseif($skor['u1score']<$skor['u2score']) { //2. kullanıcı yendi
			dEkle("results",array(
				"kat" => $skor['kat'],
				"sonuc" => "Win",
				"pid" => $_SESSION['playgame'],
				"tarih" => simdi(),
				"uid" => $skor['u2'],
				"uid2" => $skor['u1']
			));
			dEkle("results",array(
				"kat" => $skor['kat'],
				"sonuc" => "Lost",
				"tarih" => simdi(),
			    "pid" => $_SESSION['playgame'],
			    "uid" => $skor['u1'],
				"uid2" => $skor['u2']
			));
			$durum ="{$user2['adi']} {$user2['soyadi']} senin {$skor['u1score']} aldığın $kat oyununda {$skor['u2score']} puanını alarak seni yendi. Arkadaşını tebrik etmek için tıkla!";
			
		} 
		logz($skor['u1'],"Oyun Sonuçlandı!",$durum,"result.php?id={$_SESSION['playgame']}");
	//	fb_bildirim($skor['u1'],$durum,"$appurl");
	
		unset($_SESSION['playgame']);
		unset($_SESSION['userinfo']);
		oturumSil("isGoruldu");
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
	$id = veri(get("first"));
	//bana ait olan bir oyun mu değil mi?
	$kim = ksorgu("play","WHERE kat='test' ORDER BY id DESC");
	
	if($kim!=0) {
		
		$play = kd($kim);
		//peki bu oyun daha önceden oynanmışmı? 
		if($play['u2score']!="") {
			yonlendir("profile.php");
		} else {
			//dizide 7 eleman var mı (tamamı çözülmüş mü)
			$u1info = json_decode($play['u1info']);
			if(count($u1info)<7) {
				sil("play","id={$play['id']} AND u2={$_SESSION['uid']}");
				yonlendir("profile.php");
			} else {
				oturum("playgame",$play['id']);
				yonlendir("play2.test.php"); // oyun ekranına yönlendirelim.	
			}
		}
	} else {
		yonlendir("profile.php");
	}
	
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
$vs = user($sorular['u1']);
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
<score id="u2score">0</score>

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
<?php while($c = kd($cevaps)) { 
	$dogru = $c['id']*3 +$c['dogru']; //soruların cevaplarını gizlemek için matematiksel algoritma
	e("<a href='#' cevap='{$c['id']}' d='$dogru'  id='c1' class='ui-btn cevap'>{$c['val']}</a>");
 } ?>
</div>
 <?php } ?>
 </div>
 <div class="finish"  style="max-width: 700px;
    margin: 0 auto;display:none">
 <fieldset class="ui-grid-a" ><div class="ui-block-a textcenter">
	<?php echo profilepic($user['id']) ?>
<?php echo $user['adi'] ?> <?php echo $user['soyadi'] ?>
<score id="u1score2"></score>
</div><div class="ui-block-b textcenter">
	<?php profilepic($vs['id']) ?>
<?php e($vs['adi']) ?> <?php e($vs['soyadi']) ?>
<score id="u2score2"></score>
</div>
</fieldset>	
<score style="    font-size: 42px;    width: 100%;" id="sonscore">0</score>
<a href="result.php?id=<?php e(oturum("playgame")); ?>" class="ui-btn wisteria"><i class="fa fa-area-chart"></i> Oyun Detayları</a>
<a href="selectuser.php?rasgele" class="ui-btn ui-btn-inline yesil" style="background-color: #FF6800;"><i class="fa fa-repeat"></i> <?php le("Başkasıyla Tekrar Oyna") ?></a>
<a href="profile.php" class="ui-btn ui-btn-inline" style="background-color: #37BC9B;"><i class="fa fa-user"></i> <?php le("Profiline Git") ?></a>
<a href="" class="ui-btn ui-btn-inline" style="background-color: #053763;"><i class="fa fa-facebook-square"></i> <?php le("Paylaş") ?></a>
</div>
<?php include("play2.core.php"); ?>
<?php b(""); ?>