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
	//print_r($_SESSION['userinfo']);
	
	exit();
}
if(getisset("finish")) {
	$score =0;
	foreach($_SESSION['userinfo'] AS $deger) {
		$score += $deger['score'];
	}
	e($score);
	//score güncelleniyor...
	dGuncelle("play",
	array(
		"u1info" => json_encode(oturum("userinfo")),
		"u1score" => $score
		),
		"id={$_SESSION['playgame']}"
		);
		
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
	$kim = content(veri(get("first"),"tirnaksiz")); //kategorinin ne olduğunu alalım
	if($kim!=0) {
		$ne = kd($kim);
		$k=1;
		//kategoriye ait soruları bulalım ve ondan 7 seçim yapalım.
		$sorular = ksorgu("soru","WHERE kat='{$ne['slug']}' AND tip='soru' ORDER BY rand() LIMIT 0,7");
		$dizi = array();
		while($s=kd($sorular)) {
			array_push($dizi,$s['id']); //seçilen soruları diziye atalım
		} 
		$sorular = json_encode($dizi); //diziyi json a dönüştürelim
		//şimdi oyun meydanını yazalım bismillah
		$id = dEkle("play",array(
			"sorular" => $sorular,
			"u1" => $user['id'],
			"kat" => oturum("selectcat"),
			"date" => simdi() //başladığımız tarih
		));
		oturum("playgame",$id);
		yonlendir("singleplay.php"); // oyun ekranına yönlendirelim.
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
<?php a("Oyna",3); ?>
<?php 
oturumAc();
//print_r($_SESSION);
$game = oturum("playgame");
$sorular = kd(ksorgu("play","WHERE id=$game"));
$sorular2 = json_decode($sorular['sorular']);
 ?>
 <div class="start">
	<h1>Hazırsan Başlıyoruz!</h1>
	<div class="user1">
	<h1><i class="fa fa-user bigicon"></i>
<?php echo $user['adi'] ?> <?php echo $user['soyadi'] ?></h1>
	</div>

 </div>
 <fieldset class="ui-grid-a profiles"><div class="ui-block-a textcenter">
	<i class="fa fa-user bigicon"></i>
<?php echo $user['adi'] ?> <?php echo $user['soyadi'] ?>
<score id="u1score">0</score>
</div><div class="ui-block-b textcenter">
	
	<div class="counter">
		<saniye></saniye>
		<durum></durum>
	</div>
	<round></round>
	</div>
</fieldset>
 <div class="sorular" style="    max-width: 700px;
    margin: 0 auto;">
 <?php foreach($sorular2 AS $soru) {  
 $cevaps = ksorgu("soru","WHERE tip='cevap' AND ust=$soru ORDER BY rand()");
 ?>
 <div class="soru"> 
<h1><?php e(soru($soru,"val")); ?></h1>
<?php while($c = kd($cevaps)) { 
	e("<a href='#' cevap='{$c['id']}' d='{$c['dogru']}'  id='c1' class='ui-btn cevap'>{$c['val']}</a>");
 } ?>
</div>
 <?php } ?>
 </div>
 <div class="finish"  style="max-width: 700px;
    margin: 0 auto;display:none">

	<i class="fa fa-user bigicon"></i>
<?php echo $user['adi'] ?> <?php echo $user['soyadi'] ?>
<score id="u1score2"></score>

<a href="" class="ui-btn ui-btn-inline yesil" style="background-color: #FF6800;"><i class="fa fa-repeat"></i> <?php le("Tekrar Oyna") ?></a>
<a href="profile.php" class="ui-btn ui-btn-inline" style="background-color: #37BC9B;"><i class="fa fa-user"></i> <?php le("Profiline Git") ?></a>
<a href="" class="ui-btn ui-btn-inline" style="background-color: #053763;"><i class="fa fa-facebook-square"></i> <?php le("Paylaş") ?></a>
</div>
 <script type="text/javascript">
 $(function(){
	
	 $.post("?goruldu",{
		 "isGoruldu" : "1" 
		 
	 },function(d){
		//alert(d);
	 });
	
	
	
	 
	var speed = "fast";
	var eksilt =0;
	var sure=10;
	var u1score = $("#u1score");
	var saniye = $(".counter saniye");
	var interval=false;
	 /* Start */
	 //diğer oyuncunun bilgisini alalım 
	$(".profiles").hide();
	$(".sorular").hide();
	$(".start").slideDown("slow");
	window.setTimeout(function(){
		$(".start").fadeOut();

		
		$(".profiles").fadeIn();
		$(".sorular").fadeIn();
		window.setTimeout(function(){
		interval=true;
		},1000);
	},2000);
	
	/*Finish*/
	
	
	 $("durum").html(sure);		
	
	 window.setInterval(function(){
		 if(interval) {
			sureStart();	
		 }
	 },1000);
	 var round = 1;
	 
	 var totalround = $(".soru").length;
	 $("round").html(round + "/"+ totalround);
	 function finish() {
		$(".profiles").hide();
		$(".sorular").hide();
		$(".start").hide();
		$(".finish").fadeIn("slow");
		//son olarak skoru al
		$.post("?finish",function(d){
			$("#u1score2").html(d.trim());
			
		});
	 }
	 function sureStart() {
		var saniye = $(".counter saniye");
		var mevcut = saniye.width();
		if(sure==7) {
			saniye.css("background","#E08712");
		}
		if(sure==4) {
			saniye.css("background","red");
		}
		
		

		if(sure==0) { // sonraki rounda geç
			if(round<totalround) {
				interval=false;
				sonrakiSoru(round-1);
				round++;
				$("round").html(round + "/"+ totalround);
			} else {
				interval=false;
				finish();
			}
			//sonrakisoru
		} else {
			if(eksilt==0) {
				eksilt  = mevcut/sure +5;
			}
			//alert(eval(mevcut-eksilt));
			saniye.css("width",eval((sure-1)*10) + "%");
			sure--;
			$("durum").html(sure);			
		}
	 }
	 $(".soru").hide();
	 $(".soru:eq(0)").show();
	var tikla=true;
	
	//ilk başlangıç
	
	
	//şıkka tıklandığında
	$(".cevap").click(function(){
		
		var bu = $(this);
		var cevap = $(this).attr("cevap");
		var soruno = $(this).parent().index();
		

		if(tikla) {
			var isDogru = bu.attr("d");
		
			var score = 0;
			if(isDogru==1) { //puanı ver
				u1score.html(eval(u1score.html())+(sure+1)*2);
				
				score = (sure+1)*2;
				bu.addClass("dogru");
				tikla=false;
				
				
				window.setTimeout(function(){
					if(round<totalround) {
						interval=false;
						sonrakiSoru(round-1);
						round++;
						$("round").html(round + "/"+ totalround);
					} else {
						interval=false;
						finish();
					}
				},1000);
				
			} else {
		
				score=0;
				bu.addClass("yanlis");
				$(".soru:eq("+soruno+") [d=1]").addClass("dogru");
				tikla=false;
				window.setTimeout(function(){
					if(round<totalround) {
						interval=false;
						sonrakiSoru(round-1);
						round++;
						$("round").html(round + "/"+ totalround);
					} else {
						interval=false;
						finish();
					}
				},1000);
			
			}
			$.post("?cevapclick",{
					"soru" : soruno,
					"cevap" : cevap,
					"dogru" : isDogru,
					"sure" : sure+1,
					"score" : score
				},function(d){
					//alert(d);
				});
			/*
			//doğru mu yanlış mı
			$.ajax({
				type:"POST",
				dataType:"json",
				url:"?isTrue",
				data:"cevap="+cevap,
				success : function(d) {
					var isDogru=d[0].dogrumu;
					//alert(isDogru);
					
					if(isDogru) {
						bu.addClass("dogru");
						tikla=false;
						
						sonrakiSoru(soruno);
					} else {
						bu.addClass("yanlis");
						$(".cevap:contains('"+d[0].dogrusu+"')").addClass("dogru");
						tikla=false;
						sonrakiSoru(soruno);
					
					}
					
					
				}
 			}); */
			
		}
		return false;
	});
	function sonrakiSoru(soruno){
		//alert(soruno);
			window.setTimeout(function(){
				sure=10;
				saniye.css("width","100%");
				saniye.css("background","#0E9603");
				$("durum").html(sure);	
			},500);
		window.setTimeout(function(){
			var sonraki = soruno+1;
			$(".soru:eq("+soruno+") h1").fadeOut(speed,function(){
				$(".soru:eq("+soruno+") .cevap:eq(0)").fadeOut(speed,function(){
					$(".soru:eq("+soruno+") .cevap:eq(1)").fadeOut(speed,function(){
						$(".soru:eq("+soruno+") .cevap:eq(2)").fadeOut(speed,function(){
							$(".soru:eq("+soruno+") .cevap:eq(3)").fadeOut(speed,function(){
								$(".soru:eq("+sonraki+")").fadeIn("slow");
								tikla=true;
								interval=true;
							});
						});
					});
				});
			});	
		},1000);
		
		
	}
 });
 </script>
 <style type="text/css">
.ui-content {
    position: absolute !important;
    width: 99% !important;
    margin: 0 auto;
    height: 100% !important;
    max-width: 100% !important;
}
* {
	overflow-y:hidden;
	overflow-x:inherit;
	
}
 </style>
<?php b(""); ?>