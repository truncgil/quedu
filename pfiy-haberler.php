<?php include("pfi-yonetici-yetki.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php dile(3); ?></title>
<?php 
include("pfiy-he-in.php");
meditor();
?>
</head>

<body>
<div class="sekme">
	<ul>
    	<li><a href="#icerik"><?php dile(69); ?></a></li>
    	<li><a href="#yeniKategori"><?php dile(67); ?></a></li>
	<?php if (isset($_GET['kid'])) { ?>
		<?php $kategori = kSorgu("haberkategori",sprintf("WHERE id = %s",veri(get("kid"))));
		$ka = kd($kategori);
		?>
    	<li><a href="#yeniHaber"><?php printf(dil(58),$ka['kAd']); ?></a></li>
	<?php } ?>
	<?php if (isset($_GET['hid'])) { 
	$haberne = idSorgu("haberler",get("hid"));
	$hn = kd($haberne);
	?>
    	<li><a href="#haberDetay"><?php printf(dil(70),$hn['baslik']); ?></a></li>
    <?php }?>
	<?php if (isset($_GET['kategoriDetay'])) { ?>
		<?php $skategori = kSorgu("haberkategori",sprintf("WHERE id = %s",veri(get("kategoriDetay"))));
		$katAd = kd($skategori);
		?>
    	<li><a href="#kategoriDetay"><?php printf(dil(93),$katAd['kAd'],dil(78)); ?></a></li>
	<?php } ?>
    </ul>
    <div class="icerik" id="icerik">
<?php 
$seviye = oturum("Seviye2");
if($seviye!="Yonetici") {
	$sorgu = sprintf("INNER JOIN haberkategori ON haberler.kategori = haberkategori.id WHERE haberler.uid=%s",veri(oturum("uid")));
} else {
	$sorgu = "INNER JOIN haberkategori ON haberler.kategori = haberkategori.id";
}
$haber = select("*,haberler.id AS hid, haberkategori.id AS kid, haberler.y AS hy","haberler",$sorgu,0,20);
?>

		<h2><?php dile(69); ?></h2>       
        <?php if($haber==0) { ?>
        <?php bilgi(dil(68)) ?>
        <?php } else { 
		?>
        <ul>
        <?php while ($h = kd($haber)) {
			if ($h['resim']!=""){
				$resim = $img. 'haberler/' .  $h['resim'];
				$boyut="128";
			} else {
				$resim = $img. "/ikon/haber.png";
				$boyut="";
			}
				
		?>
			<li id="l<?php echo $h['hid']; ?>" yazi="<?php printf(dil(66),$h['baslik']) ?>" url="<?php echo $via ?>haberIslem=sil&id=<?php echo $h['hid']; ?>" ajax="#l<?php echo $h['hid']; ?>" duzenle="?hid=<?php echo $h['hid']; ?>#haberDetay"><?php echo resim($resim,$boyut); ?><a href="?hid=<?php echo $h['hid']; ?>#haberDetay" title="<?php echo zf($h['tarih'])?>"><?php echo $h['baslik']; ?></a>
            <sil yazi="<?php printf(dil(66),$h['baslik']) ?>" url="<?php echo $via ?>haberIslem=sil&id=<?php echo $h['hid']; ?>" ajax="#l<?php echo $h['hid']; ?>"><?php echo resim("resimler/ikon/sil.png"); ?></sil>
            <sayi class="beyaz"><a href="?kategoriDetay=<?php echo $h['id']?>#kategoriDetay"><?php echo $h['kAd']?></a></sayi>
            <yayin deger="<?php echo $h['hy']; ?>" id="<?php echo $h['hid']?>" tur="haber" ><?php if ($h['hy']==1) { echo resim($img . "ikon/y.png"); } else { echo resim($img . "ikon/yd.png"); }?></yayin>
            </li>        
        <?php } ?>
        </ul>
        <?php } ?>
    </div>
    <div id="yeniKategori">
        <form id="ekle" name="ekle" method="post" action="<?php echo $via ?>haberIslem=kategoriEkle&y=<?php echo $_SERVER['REQUEST_URI']; ?>#yeniKategori">
        <fieldset>
            <legend><?php dile(55); ?></legend>
            <ul>
                <li><label><?php dile(56); ?></label><input autofocus type="text" size="40" name="kAd" id="kAd" required /></li>
         		<li class="submit"><input name="" type="submit" value="Gönder"/></li>
           </ul>
           </fieldset>
         </form> 
			<div class="icerik" id="icerik">
		<?php 
		$kategori = kSorgu("haberkategori");
		?>

				<h2><?php dile(67); ?></h2>       
						<?php if($kategori==0) { ?>
						<?php bilgi(dil(68)) ?>
						<?php } else { 
						?>
						<ul>
						<?php while ($hk = kd($kategori)) { ?>
							<li id="hk<?php echo $hk['id']; ?>" yazi="<?php printf(dil(29),$hk['kAd']) ?>" url="<?php echo $via ?>haberIslem=kategoriSil&id=<?php echo $hk['id']; ?>" ajax="#hk<?php echo $hk['id']; ?>" duzenle="?kid=<?php echo $hk['id']; ?>#yeniHaber"><?php echo resim($img. "/dock/06.png"); ?><a href="?kid=<?php echo $hk['id']; ?>#yeniHaber" class="blue" title="<?php dile(57); ?>"><?php echo $hk['kAd']; ?></a>
                            <?php $toplam = toplam("haberler",sprintf("kategori = %s",$hk['id']));
							if ($toplam==0) { 
							?>
							<sil yazi="<?php printf(dil(29),$hk['kAd']) ?>" url="<?php echo $via ?>haberIslem=kategoriSil&id=<?php echo $hk['id']; ?>" ajax="#hk<?php echo $hk['id']; ?>"><?php echo resim("resimler/ikon/sil.png"); ?></sil>
                            <?php } ?>
							<sayi class="mavi"><?php echo $toplam ?></sayi>
							<yayin deger="<?php echo $hk['y']; ?>" id="<?php echo $hk['id']?>" tur="haberkategori" ><?php if ($hk['y']==1) { echo resim($img . "ikon/y.png"); } else { echo resim($img . "ikon/yd.png"); }?></yayin>
							</li>        
						<?php } ?>
						</ul>
						<?php } ?>
			</div>
    </div>
	<?php if (isset($_GET['kid'])) { ?>
    <div id="yeniHaber">
     <h1><input type="text" class="ajaxDuzenle" tablo="haberkategori" s_alan="id" d_alan="kAd" s_kriter="<?php echo $ka['id']; ?>" value="<?php echo $ka['kAd']; ?>" /></h1>
       <form id="hekle" name="hekle" method="post" action="<?php echo $via ?>haberIslem=haberEkle&y=<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
        <fieldset>
            <legend><?php printf(dil(58),$ka['kAd']); ?></legend>
            <ul>
                <li><label><?php dile(59); ?></label><input autofocus type="text" size="40" name="baslik" id="baslik" required /></li>
                <li><label><?php dile(61); ?></label><input autofocus type="file" size="40" name="resim" id="resim" required /></li>
                <li><label><?php dile(60); ?></label><textarea name="icerik" id="icerik" class="meditor" cols="70" rows="10"></textarea></li>
         		<li class="submit"><input name="" type="submit" value="<?php dile(63); ?>" /></li>
           </ul>
           </fieldset>
           <input type="hidden" name="kategori" value="<?php echo get("kid"); ?>" />
         </form> 
    </div>
	<?php } ?>
	<?php if (isset($_GET['hid'])) { ?>
    <div id="haberDetay">
        <form id="hduzenle" name="hduzenle" method="post" action="<?php echo $via ?>haberIslem=haberGuncelle&y=<?php echo $_SERVER['REQUEST_URI']; ?>#haberDetay" enctype="multipart/form-data">
        <fieldset>
            <legend><?php printf(dil(70),$hn['baslik']); ?></legend>
            <ul>
            	    <?php echo resim($img. "haberler/" . $hn["resim"],"150","align=right")?>
                <li><label><?php dile(59); ?></label><input autofocus type="text" size="40" value="<?php echo $hn['baslik']; ?>" name="baslik" id="baslik" required /></li>
                <li><label><?php dile(71); ?></label><input type="file" size="40"  name="resim" id="resim" /></li>
                <li><label><?php dile(60); ?></label><textarea name="icerik" id="icerik"  class="meditor" cols="70" rows="10"><?php echo $hn['icerik']; ?></textarea></li>
                <li><label><?php dile(56); ?></label><select name="kategori"><?php $kate = kSorgu("haberkategori","ORDER BY kAd ASC"); while ($ka = kd($kate)) {?><option value="<?php echo $ka['id']; ?>" <?php if ($ka['id']==$hn['kategori']) {?>selected="selected"<?php }?>><?php echo $ka['kAd']; ?></option><?php } ?></select></li>
         		<li class="submit"><input name="" type="submit" value="<?php dile(64); ?>" /></li>
           </ul>
           </fieldset>
           <input type="hidden" name="id" value="<?php echo $hn['id']; ?>" />
           <input type="hidden" name="eskiresim" value="<?php echo $hn["resim"]; ?>" />
         </form> 
    </div>
	<?php } ?>
    <?php if (isset($_GET['kategoriDetay'])) { ?>
    <div class="icerik" id="kategoriDetay">
<?php 
$haber = select("*,haberler.id AS hid, haberkategori.id AS kid","haberler",
				sprintf("INNER JOIN haberkategori ON haberler.kategori = haberkategori.id WHERE haberkategori.id = %s ",
						veri(get("kategoriDetay"))
						)
						,0,20);
?>

		<h2><?php printf(dil(93),$katAd['kAd'],dil(86)); ?></h2>       
        <?php if($haber==0) { ?>
        <?php bilgi(dil(89)) ?>
        <?php } else { 
		?>
        <ul>
        <?php while ($h = kd($haber)) {
			if ($h['resim']!=""){
				$resim = $img. 'haberler/' .  $h['resim'];
				$boyut="128";
			} else {
				$resim = $img. "/ikon/sayfa.png";
				$boyut="";
			}
				
		?>
			<li id="l<?php echo $h['hid']; ?>" yazi="<?php printf(dil(83),$h['baslik']) ?>" url="<?php echo $via ?>haberIslem=sil&id=<?php echo $h['hid']; ?>" ajax="#l<?php echo $h['hid']; ?>" duzenle="?hid=<?php echo $h['hid']; ?>#haberDetay" ><?php echo resim($resim,$boyut); ?><a href="?hid=<?php echo $h['hid']; ?>#haberDetay" title=""><?php echo $h['baslik']; ?></a>
            <sil yazi="<?php printf(dil(83),$h['baslik']) ?>" url="<?php echo $via ?>haberIslem=sil&id=<?php echo $h['hid']; ?>" ajax="#l<?php echo $h['hid']; ?>"><?php echo resim("resimler/ikon/sil.png"); ?></sil>
            <sayi class="mavi"><?php echo $h['kAd']?></sayi>
            </li>        
        <?php } ?>
        </ul>
        <?php } ?>
    </div>
<?php }?>
</div>
    
    
</div>
<script type="text/javascript">
<!--
-->
</script>
</body>
</html>