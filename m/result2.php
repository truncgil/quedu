<?php include("sablon.php"); ?>
<?php //include("secure.php"); 
$id = veri(get("id"));
$play = ksorgu("play","WHERE id=$id AND u1info IS NOT NULL AND u2info IS NOT NULL");
if($play==0) {yonlendir("profile.php"); }

$p = kd($play);
if($p['u1']==$user['id']) { 
	$user1 = user($p['u1']);
	$user1 = "{$user1['adi']} {$user1['soyadi']}";
	$user2 = user($p['u2']);
	$user2 = "{$user2['adi']} {$user2['soyadi']}";
} else {
	$user1 = user($p['u1']);
	$user1 = "{$user1['adi']} {$user1['soyadi']}";
	$user2 = user($p['u2']);
	$user2 = "{$user2['adi']} {$user2['soyadi']}";
}
if($p['u1score']==$p['u2score']) {
	$durum = "Berabere";
	$renk = "sunflower";
} elseif($p['u1score']>$p['u2score']) {
		$durum = "$user1 Kazandı!";
		$renk = "nephritis";
} elseif($p['u1score']<$p['u2score']) {
		$durum = "$user2 Kazandı!";
		$renk = "nephritis";
} 
?>
<?php include("social.inc.php"); ?>

<?php a("Zomni"); ?>
<?php echo hiyerarsi($p['kat']) ?>

 <fieldset class="ui-grid-b profiles"><a href="profile2.php?id=<?php e($p['u1']) ?>" class="ui-block-a textcenter">
	<?php profilepic($p['u1']) ?>
<?php e($user1) ?>
<score id="u1score"><?php e($p['u1score']) ?></score>
</a><a href="category.php?slug=<?php e($p['kat']); ?>" class="ui-block-b textcenter">
<img style="width:64px" src="../file/<?php e(catlogo($p['kat'])); ?>" alt="" />
<h3 style="margin:0px;"><?php e(cattitle($p['kat'])); ?></h3>
	</a><a href="profile2.php?id=<?php e($p['u2']) ?>" class="ui-block-c textcenter">
	<?php profilepic($p['u2']) ?>
<?php e($user2) ?>
<score id="u2score"><?php e($p['u2score']) ?></score>

</a>
</fieldset>
<score class="<?php e($renk) ?>" style="  text-align:center;  font-size: 42px;    width: 100%;" id="sonscore"><?php e($durum) ?></score>
<div class="ui-btn">Oyun Geçmişi</div>
<div id="canvas-holder">
	<canvas id="chart-area" style="display:block;margin:0 auto;width:85%;    background-color: white;
    padding: 10px;
    border-radius: 10px;" />
	
</div>
<div data-role="navbar">
<ul>
	<li><a href="#" style="background:rgba(41, 128, 185,1.0)"><?php e($user1) ?></a></li>
	<li><a href="#" style="background:rgba(192, 57, 43,1.0)"><?php e($user2) ?></a></li>
</ul>
</div>
<div class="panelAlan">
<div class="owl-carousel owl-theme" >
<?php 
$sorular = json_decode($p['sorular']);
$u1info = json_decode($p['u1info']);
$u2info = json_decode($p['u2info']);
$k = 0;
foreach($sorular AS $soru) {  
$cevaps = ksorgu("soru","WHERE tip='cevap' AND ust=$soru ORDER BY rand()"); ?>
<div class="soru">
<?php 
$pic = soru($soru,"pic");
if($pic!="") { ?><img src="../r.php?w=512&p=file/<?php e($pic); ?>" class="soruResim" alt="" /><?php } ?>
<h1 style="color:white"><?php e(soru($soru,"val")); ?></h1>
	 <div class="cevaplar">
		<?php while($c = kd($cevaps)) { 
			$style="";
			$isaret1="";
			$isaret2="";
			if($c['dogru']=="1") {
				$style="nephritis";
			}
			if($u2info[$k]->cevap==$c['id']) {
				$isaret1="<i class='fa fa-hand-o-left' style='    position: absolute;
    right: 0px;background:rgba(192, 57, 43,1.0);padding:5px;border-radius:100%;color:white'></i>";
			}
			if($u1info[$k]->cevap==$c['id']) {
				$isaret2="<i class='fa fa-hand-o-right' style='position: absolute;
    left: 0px;background:rgba(41, 128, 185,1.0);padding:5px;border-radius:100%;color:white'></i>";
			}
			if(strlen($c['val'])>25) {
				$class="cevap cevap2";
			}else {
				$class="cevap";
			}
			//e($c['id'] ." ".$u2info[$k]->cevap );
			e("<a href='#' class='ui-btn $class $style2 $style '>$isaret2 {$c['val']} $isaret1</a>");
		 } ?>
	</div>
</div>
<?php $k++; } ?>
</div>
</div>
<?php 
$durum2 ="Bu oyun hakkında bir şeyler yaz";
resultsocial(); ?>		
<?php 
$u1info = json_decode($p['u1info']);
$u2info = json_decode($p['u2info']);
$puan = array();
$sira = 1;
$u2scores = array();
$u1scores = array();
$simdi=0;
foreach($u1info AS $alan) {
	$simdi +=$alan->score;
	array_push($u1scores,$simdi);
}
$simdi=0;
foreach($u2info AS $alan) {
	$simdi +=$alan->score;
	array_push($u2scores,$simdi);
}
?>
<script>


			$(function(){
				Chart.defaults.global.responsive = false;
				Chart.defaults.global.responsive = false;
				Chart.defaults.global.scaleShowGridLines = true;
				Chart.defaults.global.scaleShowVerticalLines = true;
				
				var data = {
					labels: ["R1","R2","R3","R4","R5","R6","R7"],
					datasets: [
						{
							label: "<?php e($user1) ?>",
							fillColor: "rgba(41, 128, 185,0.4)",
							strokeColor: "rgba(41, 128, 185,1.0)",
							pointColor: "rgba(41, 128, 185,1.0)",
							pointStrokeColor: "rgba(41, 128, 185,1.0)",
							pointHighlightFill: "#333",
							pointHighlightStroke: "#333",
							data: [<?php e(implode(",",$u1scores)); ?>]
						},
						{
							label: "<?php e($user2) ?>",
							fillColor: "rgba(192, 57, 43,0.4)",
							strokeColor: "rgba(192, 57, 43,1.0)",
							pointColor: "rgba(192, 57, 43,1)",
							pointStrokeColor: "rgba(192, 57, 43,1.0)",
							pointHighlightFill: "#333",
							pointHighlightStroke: "#333",
							data: [<?php e(implode(",",$u2scores)); ?>]
						}
					]
				};
				var ctx = document.getElementById("chart-area").getContext("2d");
				window.myPie = new Chart(ctx).Line(data,{
					bezierCurve : true
					
				});
			});
				
			



	</script>

<?php include("social2.inc.php"); ?>

<?php b(); ?>