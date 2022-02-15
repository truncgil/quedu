<?php 

include("sablon.php"); ?>
<?php include("secure.php"); 
if(!getesit("pass","**1498**")) yonlendir("profile.php");
?>
<?php 
set_time_limit(10000000000);
header( 'Content-Encoding: none; ' ); //Gzip oluşturuyoruz
header( 'Content-type: text/html; charset=utf-8' ); //Html karekter kodlamamızı ayarlıyoruz

a("Zomni"); ?>
<?php $sorular = ksorgu("soru","where tip='soru' order by rand() limit 0,10");
 ?>
<?php while($s=kd($sorular)) { 
$cevaps = ksorgu("soru","WHERE tip='cevap' AND ust={$s['id']} ORDER BY rand()");

?>
	<div class="soru">
	<?php $pic = $s['pic'];
	if($pic!="") { ?><img src="../r.php?w=512&p=file/<?php e($pic); ?>" class="soruResim" alt="" /><?php } ?>
	<h1><?php e($s['val']); ?></h1>
	 <div class="cevaplar">
	<?php while($c = kd($cevaps)) { 
		getcevap($c);
	 } ?>
	 </div>
	</div>
	<clear></clear>
<?php } ?>
<?php b(); ?>