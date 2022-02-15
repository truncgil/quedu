<?php include("sablon.php"); ?>
<?php include("secure.php"); 
include("gamedelete.php");
?>
<?php a("Kategoriler"); ?>
<?php
if(getisset("follow")) {
	$k = post("k");
	$cat = veri(post("cat"));
	if($k==0) {
		sil("favorite","cat=$cat AND uid={$user['id']}");
	} else {
		dEkle("favorite",array(
			"cat" => post("cat"),
			"uid" => $user['id']
		));
	}
}
if(getisset("rasgelesec")) {
	oturum("selectcat",get("rasgelesec"));
	oturum("selectuser",rasgele_user(get("rasgelesec")));
	$kategori = veri(get("rasgelesec"));
	$kim = kd(ksorgu("content","where slug=$kategori limit 1"));
	if($kim['kid']=="kelime-gelistirme") {
		yonlendir("play_soz.php?first={$_SESSION['selectcat']}");
	} else {
		yonlendir("play.php?first={$_SESSION['selectcat']}");
	}

	
}
if(getisset("sec")) {
	oturum("selectcat",get("sec"));
	yonlendir("selectuser.php");
	
}
if(getisset("slug")) {
	$kid = get("slug");
	$kid2 = veri(get("slug"));
} else {
	$kid = "sorular";
	$kid2 = "'sorular'";
}
$fvarmi=ksorgu("favorite","WHERE uid={$user['id']} AND cat='$kid'");
$bu = kd(ksorgu("content","WHERE slug=$kid2 AND y=1"));
$kategori = ksorgu("content","WHERE kid=$kid2 AND y=1 ORDER BY title ASC");
if($bu['alt']!="") {
	$hemen_oyna_link = "play_soz.php?first={$bu['slug']}";
} else {
	$hemen_oyna_link = "category.php?rasgelesec={$_GET['slug']}";
}
?>
<?php echo hiyerarsi($kid) ?>
<?php if($kategori!=0) {
	
	
 ?>
<ul data-role="listview" class="yatay" data-filter="true" data-filter-placeholder="<?php le("Ara...") ?>" data-inset="true">
<?php
while($u = kd($kategori)) {
	if($u['pic']=="") {
		$ust = kd(content($u['kid']));
		if($ust['pic']!="") {
			$icon = "../file/{$ust['pic']}";
		} else {
			$icon="onlylogo.png";
		}
	} else {
		$icon = "../file/{$u['pic']}";
	}
	$varmi = contents($u['slug']);
	if($varmi==0) {
		if(toplam("soru","kat='{$u['slug']}'")>=0) {
			e("<li><a href='?slug={$u['slug']}'><img src='$icon'  />{$u['title']}</a>
			</li>");
		}
	} else {
		e("<li><a href='?slug={$u['slug']}'><img src='$icon'  />{$u['title']}</a>
		</li>");
	}
}
?>
</ul>

<?php
} else {
	$slug = veri(get("slug"));
	$toplam = toplam("soru","kat=$slug");
	if($toplam<0) {
		ob_start();
		yonlendir("index.php");
	}
/*	e("<a style='    width: 200px;
    padding: 43px 10px 83px 10px;
    border-radius: 100%;
    margin: 0 auto;' href='game.php?slug={$bu['slug']}' class='ui-btn'><i class='fa fa-gamepad bigicon'></i> {$bu['title']} Oyna!</a>");*/
	?>
	<div id="profil">
		<?php if($bu['pic']!="") { ?>
		<img src="../file/<?php e($bu['pic']) ?>" alt="" />
		<?php } else { 
			$ust = kd(content($bu['kid']));
		?>
		<?php if($ust['pic']!="") { ?>
			<img src="../file/<?php e($ust['pic']) ?>" alt="" />
		<?php } else { ?>
		<i class="fa fa-gamepad"></i>
		<?php } ?>
		<?php } ?>
		<div id="isim"><?php e($bu['title']) ?> </div>
	</div>
	<div data-role="navbar" id="navi2">
		<ul>
			<li><a href="?sec=<?php e($bu['slug']); ?>" style="    background-color: #E5097F;" ><i class="fa fa-play"></i>
				<span><?php le("Oyna") ?></span>
			</a></li>
			<?php if($fvarmi==0) { ?>
			<li><a href="#" id="favori" class="nephritis" data-ajax="false"><i class="fa fa-heart"></i>
			
			<span><?php le("Favorilerime Ekle") ?></span>
			</a>
			</li>
			<?php } else { ?>
			<li><a href="#" id="favori" class="concrete" data-ajax="false"><i class="fa fa-heart-o"></i>
			
			<span><?php le("Favorilerimden Kaldır") ?></span>
			</a>
			</li>
			<?php } ?>
			<li><a href="#" class="wisteria" data-ajax="false"><i class="fa fa-users"></i>
			
			<span><?php e(toplam("favorite","cat='{$bu['slug']}'")) ?> takipçi</span>
			</a></li>	
			
			<li ><a href="rating2.php?id=<?php e($bu['slug']) ?>" class="pumpkin"><i class="fa fa-trophy"></i>
				<span><?php le("Sıralama") ?></span>
			</a></li>
		</ul>
	</div><!-- /navbar -->
	<a href="<?php e($hemen_oyna_link) ?>" class="ui-btn colored"><i style="display: block;
    font-size: 37px;" class="fa fa-random"></i> Hemen Oyna</a>
		<?php 
		sonuclar("SELECT * FROM results WHERE kat=$kid2 GROUP BY pid ORDER BY id DESC LIMIT 0,200"); ?>
	</div><!-- /tabs -->
	
	<?php
}
?>

	<?php include("inc.toggleclick.php"); ?>

<?php b(); ?>