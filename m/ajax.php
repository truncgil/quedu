<?php include("sablon.php"); 
include("secure.php");
if(getisset("log")) {
	printjson();
	$varmi = ksorgu("log","WHERE uid={$user['id']} AND okundu=0");
	$json = array();
	$b = 0;
	if($varmi!=0) {
		
		while($b = kd($varmi)) {
			$json[$b]['title'] = $b['title'];
			$json[$b]['html'] = $b['html'];
			$json[$b]['date'] = $b['tarih'];
			$json[$b]['zf'] = zf($b['tarih']);
			$b++;
		//	dGuncelle("log",array("okundu"=>"1"),"uid={$user['id']} AND id={$b['id']}");
		}
		e(json_encode($json));
	}
}
if(getisset("search")) {
	ob_end_clean();
	header('Content-Type: application/json; charset=UTF-8');
	$dizi = explode(" ",trim(get("q")));
	$kd = array();
	$kd2 = array();
	foreach($dizi as $deger) {
		$deger = trim($deger);
		$k = veri("%$deger%");
		array_push($kd," (adi LIKE $k OR soyadi LIKE $k OR mail LIKE $k OR slug LIKE $k) ");
		array_push($kd2," (title LIKE $k OR slug LIKE $k) ");
	}
	$kriter = implode(" OR ",$kd);
	$kriter2 = implode(" OR ",$kd2);
	//e($kriter);
	$konular = ksorgu("content","WHERE $kriter2 AND y=1 AND kid IS NOT NULL LIMIT 0,5");
	$kisiler = ksorgu("uyeler","WHERE $kriter LIMIT 0,5");
	$json = array();
	$k=0;
	while($a = kd($konular)) {
	//	if(toplam("soru","kat='{$a['slug']}'")>5) {
		$json[$k]['title'] = $a['title'];
		if($a['pic']!="") { 
			$json[$k]['logo'] = $a['pic'];
		} else {
			$json[$k]['logo'] = catlogo($a['kid']);
		}
		$json[$k]['url'] = "category.php?slug={$a['slug']}";
		$k++;
	//	}
	}
	while($u = kd($kisiler)) {
		$json[$k]['title'] = "{$u['adi']} {$u['soyadi']}";
		$json[$k]['pic'] = "{$u['resim']}";
		$json[$k]['url'] = "profile2.php?id={$u['id']}";
		$k++;
	}
	e(json_encode($json));
	exit();
}
if(getisset("tip")) {
	ob_end_clean();
	switch($_GET['tip']) {
		case "mesajlar" :
		//bana yazılan 
			$sorgu = ksorgu("message","where u1={$user['id']} group by u2 order by id desc");
			?>
			<?php if($sorgu!=0) { ?>
			<ul class="liste"><?php
			while($s = kd($sorgu)) {
				?><li class=" radius10 "><a class="ui-btn <?php if($s['okundu']==0) e("sunflower"); ?>" href="mesajlar.php?uid=<?php e($s['u2']); ?>">
				<?php profilepic($s['u2']); ?>
					<h3><?php e(username($s['u2'])) ?></h3>
					<p><?php e($s['html']); ?></p>
					<sayi2><?php e(toplam("message","u1={$user['id']} AND u2={$s['u2']} and okundu=0")); ?></sayi2>
					</a></li><?php
			}
			?></ul>
			<a href="mesajlar.php" class="ui-btn">Tümünü Gör</a>
			<?php } ?>
			<?php
		break;
		case "profilegame" : 
			ob_end_flush();
			whilejson(
			"SELECT id,kat,u1,date FROM play 
			WHERE u2={$user['id']} AND u2score IS NULL AND u1score IS NOT NULL ORDER BY date DESC"
			,"play");
		
		break;
		case "sayi" :
			echo totalistek($user['id']);
		break;
		case "okundu" : 
			dGuncelle("log",array("okundu"=>"1"),"uid={$user['id']}");
		break;
		case "mesaj_okundu" : 
			$id = veri(get("id"));
			dGuncelle("message",array("okundu"=>"1"),"u1={$user['id']} and id=$id");
		break;
		case "gamepad" :
		$say=0;
		$istekler = ksorgu("play","WHERE u2={$user['id']} AND u2score IS NULL AND u1score IS NOT NULL ORDER BY date DESC");
		while($i =kd($istekler)) {
			$say++;
			
			?>
			<div href="" class="ui-btn butonlist bildirim gamepad">
			<a href="" class="ui-btn ui-btn-inline yanlis" playid="<?php e($i['id']) ?>" ><i class="fa fa-times"></i> <?php le("Red") ?></a>
			<a href="play2.php?first=<?php e($i['id']) ?>" class="ui-btn ui-btn-inline dogru"><i class="fa fa-check"></i> <?php le("Kabul") ?></a>
			<img src="../file/<?php e(catlogo($i['kat'])); ?>" alt="" />
			<span><?php echo user($i['u1'],"adi"); ?> <?php echo user($i['u1'],"soyadi"); ?> <?php echo cattitle($i['kat']) ?> <?php le("alanında bir oyun talebinde bulunuyor.") ?>
			<tarih style="position:absolute;top:5px;left:5px;font-size:9px;"><?php echo zf($i['date']) ?></tarih>
			</span>
			</div>
			
		<?php } ?>
		<?php $log = ksorgu("log","WHERE uid={$user['id']} ORDER BY id DESC LIMIT 0,10 "); ?>
		<h3><i class="fa fa-globe"></i> <?php le("Son bildirimler") ?></h3>
		<?php while($l = kd($log)) {
		
			$say++;
			?>
			<div href="" class="ui-btn butonlist <?php if($l['okundu']==0) { ?>sunflower<?php } ?>">
			<a href="<?php e($l['url']) ?>" class="ui-btn ui-btn-inline <?php if($l['okundu']==0) { ?>orange<?php } else { ?>wetasphalt<?php } ?>" > <?php le("Git") ?> <i class="fa fa-reply"></i> </a>
			<span>
				<h3 class="margin0 padding0"><?php e($l['title']); ?></h3>
				<?php e($l['html']) ?>
			</span>
			<tarih style="position:absolute;bottom:5px;right:5px;font-size:9px;"><?php echo zf($l['tarih']) ?></tarih>
			</span>
			</div>
			<?php
		} ?>
		<?php if($say==0) {
			e('<div class="ui-btn sunflower">Herhangi bir istek ya da bildirim yok!</div>');
		} ?>
	<script type="text/javascript">
	$(function(){
		
	});
	</script>
			<?php
		break;
		case "users" :
			?>
<ul data-role="listview" data-filter="true" data-filter-placeholder="Ara..." data-inset="true">
<?php for($k=0;$k<=10;$k++) { ?><li><a href="profile.php?id=<?php e(rand(999,9999)) ?>"><img src="logo.png"><h2><?php e(rand(999,9999)) ?></h2></a></li><?php } ?>
</ul>	
	
			<?php
			
		break;
		case "heart" :
		$favorite = ksorgu("favorite","WHERE uid={$user['id']}");
		if($favorite!=0) {
			while($f = kd($favorite)) {
				$logo = catlogo($f['cat']);
				$title = cattitle($f['cat']);
				e("<a href='category.php?slug={$f['cat']}' class='ui-btn ui-btn-inline'><img src='../file/$logo' width='64' class='center'  />$title</a>");
			}
		} else {	
			e("<a href='category.php' class='ui-btn wisteria'><i class='fa fa-heart'></i>");
			le("Hemen Favorilerini Oluştur");
			e("</a>");
		}
			?>
	
			<?php
		break;
	}
}
?>