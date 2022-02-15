<?php 
require("mail/include/class.php");
function mailGonder($mail,$konu,$mesaj){
$header = "";
$footer = "";
$mail_adresiniz	= "noreply@gakk.k12.tr";
$mail_sifreniz	= "Ce6G5KHC";
$gidecek_adres	= $mail;
$domain_adresi	= "gakk.k12.tr";	//www olmadan yazınız

///////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////

$mail = new PHPMail();
//$mail->Host       = "smtp.".$domain_adresi;
//$mail->SMTPAuth   = true;
//$mail->Username   = $mail_adresiniz;
//$mail->Password   = $mail_sifreniz;
//$mail->IsSMTP();
$mail->IsHTML(true);
$mail->AddAddress($gidecek_adres);
$mail->From       = $mail_adresiniz;
$mail->FromName   = "bulbulzadeyurdu.com";
$mail->Subject    = $konu;
$mail->Body       = $header . $mesaj . $footer;
$mail->AltBody    = "";
	if(!$mail->Send()) {
		return $header . $mesaj . $footer;
	} else {
		return $header . $mesaj . $footer;
	}
}
 ?>
<?php 
function google($title,$start=0) {
	if($title!="") {
		$title = urlencode($title);
		$json = file_get_contents("http://ajax.googleapis.com/ajax/services/search/images?v=1.0&q=$title&start=$start");
		$obj = json_decode($json);
		return $obj->responseData->results;
	}
}
 ?>
<?php function layerslider($slug) {
	?>
	<?php $slider=kd(content($slug)); ?>
	<div class="ls-wp-container layerslider noback" style="<?php e($slider['style']); ?>">
	<?php $slides = contents($slug); ?>
	<?php while($s = kd($slides)) { ?>
		<div class="ls-slide" data-ls="<?php e($s['datals']) ?>">
			<?php if($s['pic']!="") { ?>
				<img src="r.php?w=1920&p=file/<?php e($s['pic']) ?>" class="ls-bg" alt="" />
			<?php } ?>
			<?php $layers = contents($s['slug']); ?>
			<?php while($l = kd($layers)) { ?>
				<div class="ls-l" style="<?php e($l['style']) ?>" alt="<?php e($l['alt']) ?>" data-ls="<?php e($l['datals']) ?>">
					<?php if($l['pic']) {
						?>
						<img src="file/<?php e($l['pic']) ?>" alt="" />
						<?php
					} ?>
					<?php e($l['html']); ?>
				</div>
			<?php } ?>
		</div>
	<?php } ?>
	<?php
	
} ?>

<?php function bg($url) {
	echo "<style type='text/css'>
	content{
		background:url($url) !important;
		background-size: cover !important;
	}
		</style>";
} ?>
<?php function galeri2($isim) {
	$isim = veri($isim);
	$galeri = kd(ksorgu("galerikategori","WHERE isim=$isim"));
	$galericerik = ksorgu("galeriicerik","WHERE gid='{$galeri['id']}' ORDER BY sira ASC");
	e("<div class=\"galeri\">");
	while($g = kd($galericerik)) {
		e("<a href='r.php?p=pfi-galeri-icerik/{$g['url']}&w=1024' data-lightbox='galeri'><img src='r.php?p=pfi-galeri-icerik/{$g['url']}&w=141&h=120' /></a>");
	}
	e("</div>");
	
} ?>
<?php function content($slug,$where="") {
	$content = ksorgu("content","WHERE y=1 AND slug='$slug' $where");
	return $content;
} ?>
<?php function content_id($id,$where="") {
	$content = ksorgu("content","WHERE y=1 AND id='$id' $where");
	return $content;
} ?>
<?php function contents($slug,$where="") {
	$content = ksorgu("content","WHERE y=1 AND kid='$slug' $where ORDER BY s ASC");
	return $content;
} ?>
<?php function anamenu($slug,$alt=false){
	global $uzanti;
	$content = contents($slug);
	if($content!=0) {
		while($c = kd($content)) {
			e("<li><a href='{$c['slug']}.$uzanti'>{$c['title']}</a>");
				if($alt==true) {
					e("<ul>").anamenu($c['slug'],true).e("</ul>");
				}
			e("</li>");
		}
	}
} ?>

<?php 
$hiyerarsi="";
function hiyerarsi($id) {
global $hiyerarsi;
	$kat = kd(ksorgu("content","WHERE slug='$id'"));
	$isim = $kat['title'];
	$a = $kat['slug'];
		$hiyerarsi =  "<a class='dugme' href='?kid=$a'>$isim</a> " . $hiyerarsi;
	if($kat['kid']!="") {
		hiyerarsi($kat['kid']);
	}
	return "<div class='butonset'><a href='pfiy-masaustu.php' class='dugme'><i style='  font-size: 17px;
  height: 19px;' class='fa fa-home'></i></a>$hiyerarsi</div>";
}
 ?>
<?php 
$hiyerarsi2="";
function hiyerarsi_web($id) {
global $hiyerarsi;
global $uzanti;
	$kat = kd(ksorgu("content","WHERE slug='$id'"));
	$isim = $kat['title'];
	$a = $kat['slug'];
	if($kat['kid']!="") {
		$hiyerarsi =  "<a class='dugme' href='$a.$uzanti'>$isim</a> " . $hiyerarsi;
	}
	if($kat['kid']!="") {
		hiyerarsi_web($kat['kid']);
	}
	return "<div class='butonset'>$hiyerarsi</div>";
}
 ?>
<?php 
function postyukle($post,$dizin) {
	if($_FILES[$post]['name']!="") {
		$_POST[$post] = yukle($post,$dizin);
	}
}
function posttarih($post) {
	$_POST[$post] = simdi();
}
function zftr($d2){
 $d1 = date('Y-m-d H:i:s');
 
    if(!is_int($d1)) $d1=strtotime($d1);
    if(!is_int($d2)) $d2=strtotime($d2);
    $d=abs($d1-$d2);
if ($d1-$d2<0) {
$ifade = "sonra";
} else {
$ifade = "önce";
 }
$once = " "; 
    if($d>=(60*60*24*365))    $sonuc  = $once . floor($d/(60*60*24*365)) . " yıl $ifade";
    else if($d>=(60*60*24*30))     $sonuc = $once . floor($d/(60*60*24*30)) . " ay $ifade";
    else if($d>=(60*60*24*7))  $sonuc  = $once . floor($d/(60*60*24*7)) . " hafta $ifade";
    else if($d>=(60*60*24))    $sonuc  = $once . floor($d/(60*60*24)) . " gün $ifade";
    else if($d>=(60*60))   $sonuc = $once . floor($d/(60*60)) . " saat $ifade";
    else if($d>=60) $sonuc  = $once . floor($d/60)  . " dakika $ifade";
	else $sonuc = "Az $ifade";
 
    return $sonuc;
}
function zfen($d2){
 $d1 = date('Y-m-d H:i:s');
 
    if(!is_int($d1)) $d1=strtotime($d1);
    if(!is_int($d2)) $d2=strtotime($d2);
    $d=abs($d1-$d2);
if ($d1-$d2<0) {
$ifade = "left";
} else {
$ifade = "ago";
 }
$once = " "; 
    if($d>=(60*60*24*365))    $sonuc  = $once . floor($d/(60*60*24*365)) . " year $ifade";
    else if($d>=(60*60*24*30))     $sonuc = $once . floor($d/(60*60*24*30)) . " month $ifade";
    else if($d>=(60*60*24*7))  $sonuc  = $once . floor($d/(60*60*24*7)) . " week $ifade";
    else if($d>=(60*60*24))    $sonuc  = $once . floor($d/(60*60*24)) . " day $ifade";
    else if($d>=(60*60))   $sonuc = $once . floor($d/(60*60)) . " hour $ifade";
    else if($d>=60) $sonuc  = $once . floor($d/60)  . " minute $ifade";
	else $sonuc = "Few $ifade";
 
    return $sonuc;
}
function zfar($d2){
 $d1 = date('Y-m-d H:i:s');
 
    if(!is_int($d1)) $d1=strtotime($d1);
    if(!is_int($d2)) $d2=strtotime($d2);
    $d=abs($d1-$d2);
if ($d1-$d2<0) {
$ifade = "فيما بعد";
} else {
$ifade = "قبل";
 }
$once = " "; 
    if($d>=(60*60*24*365))    $sonuc  = $once . floor($d/(60*60*24*365)) . " عام $ifade";
    else if($d>=(60*60*24*30))     $sonuc = $once . floor($d/(60*60*24*30)) . " شهر $ifade";
    else if($d>=(60*60*24*7))  $sonuc  = $once . floor($d/(60*60*24*7)) . " أسبوع $ifade";
    else if($d>=(60*60*24))    $sonuc  = $once . floor($d/(60*60*24)) . " يوم $ifade";
    else if($d>=(60*60))   $sonuc = $once . floor($d/(60*60)) . " ساعة $ifade";
    else if($d>=60) $sonuc  = $once . floor($d/60)  . " دقيقة $ifade";
	else $sonuc = "القليل $ifade";
 
    return $sonuc;
}

?>

<?php 
oturumAc();
if(!oturumisset("dil")) {
	oturum("dil","tr");
}
if(getisset("dil")) {
	oturum("dil",get("dil"));
}
function lang($tr,$en,$ar="جميع الحقوق محفوظة") {
	oturumAc();
	if(oturumesit("dil","tr")) {
		e($tr);
	} elseif(oturumesit("dil","en")) {
		e($en);
	} elseif(oturumesit("dil","ar")) {
		e($ar);
	} else {
		e($tr);
	}
}
 ?>
<?php function jd($d){
return json_decode($d['deger'],true);
} ?>
<?php function sayfaicerik($id) {
	$s = kd(ksorgu("sayfalar","WHERE id = $id"));
	return $s['icerik'];
} ?>
<?php function urun_ozellik($deger,$id) {
	$ozellik = kd(ksorgu("urun_detay","WHERE tur = '$deger' AND urun_id = '$id'"));
	return $ozellik['deger'];
} ?>
<?php function kategori($id) {
	$kat = kd(ksorgu("urun_kategori","WHERE id=$id"));
	return $kat['isim'];
} ?>
<?php function uye_detay($anahtar,$uid) {
global $_POST;
	$id =dEkle("uye_detay",array(
	"anahtar" => "$anahtar",
	"uid" => "$uid",
	"deger" => json_encode($_POST)
	));
return $id;
} ?>
<?php function mesaj($konu,$icerik,$uid) {
	dEkle("uye_mesaj",array(
		"tarih" => simdi(),
		"konu" => "$konu",
		"mesaj" => "$icerik",
		"uid" => "$uid"
	));
} ?>
<?php function uye_detay_g($anahtar,$uid,$id) {
global $_POST;
	$json = veri(json_encode($_POST));
	sorgu("UPDATE uye_detay SET deger = $json 
	WHERE anahtar = '$anahtar' AND uid = '$uid' AND id= '$id'");
return $id;
} ?>
<?php function via($islem,$url="") { 
	global $via; 
	if($url==""){
		$adres =""; 
	}else {
		$adres = "&y=$url";
	} 
	echo $via.$islem.$adres; 
} ?>
<?php function sayfakategori($altmenu="") {
	$sayfakategori = ksorgu("sayfakategori","WHERE mg=1 AND y=1 ORDER BY s ASC");
	while($s = kd($sayfakategori)) :
		$id = son_sayfa_id($s['id']);
		$title = $s['kAd'];
		if($id!="") {
			$url="pfi-sayfalar.php?id=$id"; 
		} else {
			$url = "#";
		}
		 
		if($altmenu=="") :
			echo "<li><a href='$url'>$title</a></li>";
		else :
		$alt_menu = ksorgu("sayfalar","WHERE kategori = {$s['id']} AND y=1");
		if(sToplam($alt_menu)>1) :
			echo "<li><a href='#'>$title</a><ul>";
			
			while($a = kd($alt_menu)):
				echo "<li><a href='pfi-sayfalar.php?id={$a['id']}'>{$a['baslik']}</a></li>";
			endwhile;
			echo "</ul></li>";
		else :
			echo "<li><a href='$url'>$title</a></li>";
		endif;
		endif;
	endwhile;
 } ?>

<?php function yorum($yaz="Yorum Ekle",$yorum="Yorumlar"){ 
global $via;
?>
<style type="text/css">
.yorumAlan {
	margin:20px;
}
</style>
<div class="yorumAlan">
<?php bilgi("Değerli ziyaretçimiz yapmış olduğunuz yorumlar onaylandıktan sonra sitemize eklenmektedir") ?>
<div class="sekme">

	<ul>
		<li><a href="#yorumekle"><?php e($yaz) ?></a></li>
		<li><a href="pfi-ajax.php?islem=yorumlar&sayfa=<?php e(kripto($_SERVER['REQUEST_URI'])); ?>"><?php e($yorum) ?>(<?php echo toplam("yorumlar", sprintf("y=1 AND sayfa=%s",veri(kripto($_SERVER['REQUEST_URI'])))); ?>)</a></li>
	</ul>
		<div id="yorumekle" style="overflow:auto">
			<form action="<?php e($via) ?>yorumIslem=ekle&y=<?php e($_SERVER['REQUEST_URI']) ?>" method="POST" class="formee">
			<?php oturumAc();
				if(isset($_SESSION['pFiUser'])) {
				echo sprintf("<h2>Sayın %s %s aşağıdaki formu doldurarak mesajınızı yazabilirsiniz</h2>",oturum("adi"),oturum("soyadi"));
				?>
				<input type="hidden" name="isim" value="<?php e(oturum("adi") . " " . oturum("soyadi")) ?>" />
				<input type="hidden" name="uid" value="<?php e(oturum("pFiUser")) ?>" />
				<?php
				} else {
			?>
				<div class="grid-12-12">
					<label for="isim">Adınız ve Soyadınız</label>
					<input type="text" name="isim" id="isim" />
				</div>
				<input type="hidden" name="uid" value="<?php e(kripto("Misafir")) ?>" />
				<?php } ?>
				<input type="hidden" name="sayfa" value="<?php e(kripto($_SERVER['REQUEST_URI'])) ?>" />
				<input type="hidden" name="sayfan" value="<?php e($_SERVER['REQUEST_URI']) ?>" />
				<div class="grid-12-12">
					<label for="baslik">Konu</label>
					<input type="text" name="baslik" id="baslik" />
				</div>
				<div class="grid-12-12">
					<label for="baslik">Mesaj</label>
					<textarea name="mesaj" id="" cols="30" rows="10"></textarea>
				</div>
				<div class="grid-12-12">
					<input type="submit" value="Yorum Ekle" />
				</div>
			
			</form>
		</div>
</div>

<?php } ?>
<?php function tarihBolum($tarih) { 
global $aylar;
global $gunler;
?>
<div class="tarihBolum"><div id="yazi"><?php echo buyukTarih($tarih,$gunler,$aylar,"hepsi",""); ?></div></div>
<?php } ?>
<?php function tarihDizi($tarih,$tur) { 
global $aylar;
global $gunler;
$t = buyukTarih($tarih,$gunler,$aylar,"dizi",$tur);
echo $t;
?>
<div class="tarihBolum"><div id="yazi"><?php echo buyukTarih($tarih,$gunler,$aylar,$tur); ?></div></div>
<?php } ?>
<?php 
//peyamFi Bileşenler Yongası
function yazarlar($detay=""){  // köşe yazarları bloğu
global $img;
?>
    <div id="altIcerik">
   	  <div id="sol" <?php echo $detay ?>>
        <div id="yazarlar" >
		<div id="baslik"></div>
		<?php 
		//yazarı al sonra onun son yayındaki yazısını al 
		$yazarlar = kSorgu("uyeler",sprintf("WHERE (seviye='Yazar' OR seviye='Yonetici') AND y=1 ORDER BY s ASC"));
		if($yazarlar!=0){
		while($y = kd($yazarlar)) {
		?>
 					<?php 
					$sonYazi = kSorgu("uyeyazilar",sprintf("WHERE uid = %s AND y = 1 ORDER BY id DESC",$y['id']));
					$sY = kd($sonYazi);
					
						
					
					?>
          		<div class="yazar">
           		  <div class="isim"><a href="pfi-yazar-detay.php?id=<?php echo $y['id'] ?>" ><?php echo $y['adi'] ?> <?php echo $y['soyadi'] ?></a></div>
                    <div class="resim"><?php if($y['resim']!="") { echo resim($img . "uyeler/" . $y['resim'],"92"); } else { echo resim($img . "dock/12.png"); } ?></div>
                    <div class="yazi"><?php if($sonYazi!=0) { ?><a href="pfi-yazi-detay.php?id=<?php echo $sY['id'] ?>" ><?php echo kelime($sY['baslik'],20); ?></a><?php }else {  dile(178); }?></div>

				</div>
		<?php } 
		} else {
			bilgi(dil(165));
		}?>
          </div> 
      </div>
<?php } ?>
<?php 
//mini galeri popeye
function galeri($resimDizi=array(0 => array("yazi","resimler/dock/01.png","url")),$tur="Resim",$gen="500",$yuk="300") { ?>
<div class="ppy" id="ppy1" style="width:<?php echo $gen ?>px">
            <ul class="ppy-imglist" style="width:<?php echo $gen ?>px">
			<?php foreach($resimDizi as $yazi => $resim) { ?>
                <li>
                    <a href="<?php echo $resim[1] ?>">
                        <?php echo resim($resim[1],$gen); ?>
                    </a>
					<?php if (count($resim)==3) { ?>
                    <span class="ppy-extcaption">
                        <?php echo $resim[0] ?>
                        <a href="<?php echo $resim[2] ?>">Devamı için tıklayın</a>
                    </span>
					<?php } ?>
                </li>
			<?php } ?>
            </ul>
            <div class="ppy-outer" >
                <div class="ppy-stage" style="width:<?php echo $gen ?>px;height:<?php echo $yuk ?>px">
                    <div class="ppy-nav">
                        <a class="ppy-prev" >Previous image</a>
                        <a class="ppy-switch-enlarge" >Enlarge</a>
                        <a class="ppy-switch-compact" >Close</a>
                        <a class="ppy-next" >Next image</a>
                    </div>
                </div>
            </div>
            <div class="ppy-caption">
                <div class="ppy-counter">
                    <?php echo $tur ?> <strong class="ppy-current"></strong> - <strong class="ppy-total"></strong> 
                </div>
                <span class="ppy-text"></span>
            </div>
        </div><?php } ?>
<?php function ayrintiBolum($ayrintiDizi = array(0 => array("isim","foto","link"))) { ?>
<!--
<div class="ayrintiBolum">
	<ul>
	<?php foreach($ayrintiDizi as $a => $deger) { ?>
		<li><a href="<?php echo $deger[2] ?>" title="<?php echo $deger[0] ?>"><?php echo resim($deger[1]); ?></a></li>
	<?php } ?>
	</ul>
</div>
-->
<?php } ?>
<?php function pFiListe($listeDizi = array(0 => array("isim","link")),$id="liste",$class="liste") { ?>
<ul>
<?php foreach($listeDizi as $l => $deger) { ?>
	<li id="<?php echo $id ?>" class="<?php echo $class ?>"><a href="<?php echo $deger[1] ?>"><?php echo $deger[0] ?></a></li>
<?php } ?>
</ul>
<?php } ?>
<?php function galeriBuyuk($gD=array(array("başlık","url","içerik")),$tur="resim") { 
global $betik;
global $img;
	//Linking Sliders Galeri
	js($betik . "Linking/js/slides.min.jquery.js") . _js();
	linkCss($betik . "Linking/css/global.css");

?>
<div id="example">
			<div id="slides">
				<div class="slides_container">
				<?php if($tur="resim") { 
				foreach($gD as $g => $deger) {
					echo resim($deger[0],"580");
				}
				?>
				<?php } else { 
				foreach($gD as $g => $deger) {
				?>
					<div class="slide">
						<h1><?php echo $deger[1]; ?></h1>
						<?php echo $deger[2]; ?>
						<p><a href="<?php echo $deger[0]; ?>" class="link"><?php dile(128); ?></a></p>
					</div>
				<?php 
				}
				} ?>
				</div>
				<a href="#" class="prev"><img src="<?php echo $betik . "Linking/" ?>img/arrow-prev.png" width="24" height="43" alt="Arrow Prev"></a>
				<a href="#" class="next"><img src="<?php echo $betik . "Linking/" ?>img/arrow-next.png" width="24" height="43" alt="Arrow Next"></a>
			</div>
			<img src="<?php echo $betik . "Linking/" ?>img/example-frame.png" width="739" height="341" alt="Example Frame" id="frame">
		</div><?php } ?>
<?php function lightboxJS(){ 
global $betik;
global $img;

?>
<link rel="stylesheet" href="<?php echo $betik . "lightbox/css/lightbox.css" ?>" type="text/css" media="screen" />
<?php 
	//linkCss($betik . "lightbox/css/lightbox.css");
	js($betik . "lightbox/js/prototype.js") . _js(); 
	js($betik . "lightbox/js/scriptaculous.js?load=effects,builder") . _js(); 
	js($betik . "lightbox/js/lightbox.js") . _js(); 
} ?>
<?php function lightbox($gD=array(array("başlık","url","içerik")),$tur="resim"){ 
global $betik;
global $img;
?>
<?php
?>
<?php foreach($gD as $g => $deger) { ?>
<a href="<?php echo $deger[0] ?>" rel="lightbox[roadtrip]">
<img src="r.php?w=160&h=120&p=<?php e($deger[0]) ?>" alt="" />
</a>
<?php } ?>
<?php } ?>
<?php function galeriPro($gD=array(array("başlık","url","içerik")),$tur="resim") { 
global $betik;
global $img;
	//Product Sliders Galeri
	js($betik . "Product/js/slides.min.jquery.js") . _js();
	linkCss($betik . "Product/css/global.css");

?>
<?php js(); ?>
$(function(){
			// Set starting slide to 1
			var startSlide = 1;
			// Get slide number if it exists
			if (window.location.hash) {
				startSlide = window.location.hash.replace('#','');
			}
			// Initialize Slides
			$('#products').slides({
				preload: true,
				preloadImage: '<?php echo $betik . "Product/" ?>img/loading.gif',
				effect: 'slide, fade',
				crossfade: true,
				slideSpeed: 350,
				fadeSpeed: 500,
				generateNextPrev: true,
				generatePagination: false
			});
			});
<?php _js(); ?>
<div id="container">
		<div id="products_example">
			<div id="products">
				<div class="slides_container">
				<?php foreach($gD as $g => $deger) { ?>
					<a href="<?php echo $deger[0] ?>" target="_blank"><?php echo resim($deger[0],"660") ?></a>
				<?php } ?>
				</div>
				<ul class="pagination">
				<?php foreach($gD as $g => $deger) { ?>
					<li><a href="#"><?php echo resim($deger[0],"55") ?></a></li>
				<?php } ?>
				</ul>
			</div>
		</div>
<?php } ?>
<?php function ilgiliGaleri($gid) { ?>
	<?php 
	$galeri = pFS("galerikategori",$gid);
	$gK = kd($galeri);
	$gD = array(); //galeri dizimiz 
	$resimler = pFAS2("galeriicerik","gid",$gid); //galeriye ait olan içerikleri alalım
	?>
	<h2><?php echo $gK['isim'] ?></h2>
	<?php
	if ($gK['tur']=="jpg,png,gif"){ //eğer galerimiz resim türlerini barındırıyorsa
		$k = 0;
		while($r = kd($resimler)){
			$gD[$k]=array("pfi-galeri-icerik/".$r['url']);
			$k++;
		}
		galeriPro($gD,$gK['isim']); //ölçülerle galerimizi oluşturalım.
	} else {
		while($r = kd($resimler)){
			$gD[$k]=array(resim($img . "dock/07.png"),$r['url']);
			$k++;
		}
		pFiListe($gD,"galeri","galeri");
	}
	
	?>

<?php } ?>
<?php function yazarUst($resim,$isim,$id="") { 
global $img;
?>
		<div id="yazarUst">
			<div id="resim"><?php if($resim!="") { echo resim($img . "uyeler/" . $resim,"128"); } else { echo resim($img . "dock/12.png"); } ?></div>
			<div id="isim"><?php echo $isim ?></div>
			<?php if($id!="") { ?>
			<div id="detay">
				<ul>
				<li><a href="#yazilar" title="<?php dile(135) ?>" ><?php echo resim($img . "ikon/kitap.png") ?></a></li>
				<li><a href="pfi-yazar-detay.php?id=<?php echo $id; ?>" title="<?php dile(129) ?>" ><?php echo resim($img . "ikon/biyografi.png") ?></a></li>
				<li><a href="#iletisim" title="<?php dile(130) ?>" ><?php echo resim($img . "ikon/mail.png") ?></a></li>
				</ul>
			</div>
			<?php } ?>
		</div>

<?php } ?>
<?php function pFiBlok($baslik,$ikon,$dizi=array(0 => array("başlık","url")),$stil="sol") { 
if ($stil="sol"){
	$style = ' style="float:left"';
} elseif($stil="sag") {
	$style = ' style="float:right"';
} else {
	$style= "";
}

?>
	<div class="blok"<?php echo $style ?>>
		<div class="baslik">
			<div class="sol"></div>
			<div class="orta">
				<div class="ikon"><?php echo resim($ikon); ?></div>
				<div class="yazi"><?php echo kelime($baslik,10) ?></div>
			</div>
			<div class="sag"></div>
		</div>
			<div class="icerik">
				<ul>
				<?php foreach($dizi as $d => $deger) { ?>
					<li><a href="<?php echo $deger[1] ?>"><?php echo kelime($deger[0],10) ?></a></li>
				<?php } ?>
				</ul>
			</div>
		</div>
<?php } ?>
<?php function pFiAmblem() { 
global $amblem;
?>
<style>
#amblem {
	background-image: url(<?php e($amblem); ?>);
	height: 142px;
	width: 177px;
	margin-top: 0px;
	margin-right: auto;
	margin-bottom: 0px;
	margin-left: auto;
}

</style>
<div id="amblem"></div>
<?php } ?>
