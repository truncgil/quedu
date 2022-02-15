 <?php if(totalgame2($user['id'])!=0) { ?>

<?php
if($_SESSION['uid']==$user['id']) {
		$win = "yendin";
		$quits2 = "kaldın";
		$lost = "yenildin";
		$url="result2.php";
		$title = "Oyun Geçmişiniz";
	} else {
		$win = "yendi";
		$quits2 = "kaldı";
		$lost = "yenildi";
		$url="result2.php";
		$title = "Oyun Geçmişi";
	}
 $sonuclar = sorgu("SELECT * FROM results WHERE uid='{$user['id']}' ORDER BY id DESC LIMIT 0,10"); ?>
<div style="text-align:center;">
<div id="canvas-holder">
	<canvas id="chart-area" style="display:block;margin:0 auto;width:85%;    background-color: white;
    padding: 10px;
    border-radius: 10px;" />
</div>
<script>

		
<?php 
$veri = sorgu("select kat,sonuc from results where uid={$user['id']} ORDER BY id DESC");  //kullanıcıya ait veriler
$puan = array();
$puan2 = array();
$kat = array();
while($v = kd($veri)) {
	if(!isset($kat[$v['kat']]['Win'])) {
		$kat[$v['kat']]['Win']=0;
	}
	if(!isset($kat[$v['kat']]['Quits'])) {
		$kat[$v['kat']]['Quits']=0;
	}
	if(!isset($kat[$v['kat']]['Lost'])) {
		$kat[$v['kat']]['Lost']=0;
	}
	if($v['sonuc']=="Win") {	
		$kat[$v['kat']]['Win']++;
	} elseif($v['sonuc']=="Quits") { 
		$kat[$v['kat']]['Quits']++;
	} else {
		$kat[$v['kat']]['Lost']++;
	}
}
$labels = array();
$wins = array();
$losts = array();
$quits = array();
foreach($kat AS $label => $deger) {
	array_push($labels,veri(cattitle($label)));
	foreach($labels AS $l) {
		if($l===NULL) {
			unset($l);
		}
	}
	foreach($deger AS $sonuc => $deger) {
		if($sonuc=="Win") {
			array_push($wins,$deger);
		} elseif($sonuc=="Quits") {
			array_push($quits,$deger);
		} else {
			array_push($losts,$deger);
		}
	}
}
?>
			$(function(){
				Chart.defaults.global.responsive = false;
				Chart.defaults.global.responsive = false;
				Chart.defaults.global.scaleShowGridLines = true;
				Chart.defaults.global.scaleShowVerticalLines = true;		
				Chart.defaults.global.multiTooltipTemplate= "<%=datasetLabel%>:<%= value %>";		
				var data = {
					labels: [<?php e(implode(",",$labels)); ?>],
					datasets: [
						{
							label: "Kazanılan",
							fillColor: "green",
							strokeColor: "green",
							pointColor: "rgba(220,220,220,1)",
							pointStrokeColor: "#000",
							pointHighlightFill: "#333",
							pointHighlightStroke: "#fff",
							data: [<?php e(implode(",",$wins)); ?>]
						} ,
						{
							label: "Kaybedilen",
							fillColor: "red",
							strokeColor: "red",
							pointColor: "rgba(220,220,220,1)",
							pointStrokeColor: "#000",
							pointHighlightFill: "#333",
							pointHighlightStroke: "#fff",
							data: [<?php e(implode(",",$losts)); ?>]
						} ,
						{
							label: "Berabere",
							fillColor: "orange",
							strokeColor: "orange",
							pointColor: "rgba(220,220,220,1)",
							pointStrokeColor: "#000",
							pointHighlightFill: "#333",
							pointHighlightStroke: "#fff",
							data: [<?php e(implode(",",$quits)); ?>]
						}
					]
				};
				var ctx = document.getElementById("chart-area").getContext("2d");
				
				window.myPie = new Chart(ctx).Bar(data);
			});
	</script>
<div data-role="popup" id="oyungecmisi" class="clouds" style="max-width:700px">
<h2><i class="fa fa-gamepad"></i> Oyun Geçmişi</h2>
<?php while($s = kd($sonuclar)) {
	$user2 = user($s['uid2']);
	$u1score = kd(ksorgu("scores","WHERE uid={$s['uid']} AND tarih='{$s['tarih']}'"))['score'];
	$u2score = kd(ksorgu("scores","WHERE uid={$s['uid2']} AND tarih='{$s['tarih']}'"))['score'];
	
	if($s['sonuc']=="Win") {
		$ifade = "{$user2['adi']} {$user2['soyadi']} kişisini $win";
		$color="nephritis";
		$color2="emerland";
	} elseif($s['sonuc']=="Lost") {
		$ifade = "{$user2['adi']} {$user2['soyadi']} kişisine $lost";
		$color="pomegranate";
		$color2="carrot";
	} else {
		$ifade = "{$user2['adi']} {$user2['soyadi']} kişisiyle berabere $quits2";
		$color="carrot";
		$color2="sunflower";
	}
	?>
	<a href="<?php e($url) ?>?id=<?php e($s['pid']) ?>" class="ui-btn ui-btn-inline <?php e($color) ?>">
	<?php if($user2['resim']!="") { ?><img src="<?php e($user2['resim']) ?>" alt="" class="profilepic" /><?php } else {?><img src="user.png" alt="" class="profilepic" /><?php }?>
	<img src="../file/<?php e(catlogo($s['kat'])) ?>" alt="" style="position: absolute;
    top: 0px;
    left: 6px;
    width: 50px;
    height: 50px;" class="profilepic" />
	<?php le($ifade) ?>
	<span class="ui-btn sunflower" style="    font-size: 18px !important;padding:5px;"><?php e($u1score) ?> / <?php e($u2score); ?></span>
	<span class="ui-btn <?php echo $color2 ?>" style="font-size:12px;position:absolute;top:0px;right:0px;padding: 2px 6px;"><?php e(zf($s['tarih'])); ?></span>
	</a>
	<?php
	
} ?>
</div>
</div>
 <?php } ?>
