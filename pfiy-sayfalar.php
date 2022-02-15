<?php include("pfi-yonetici-yetki.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php dile(2); ?></title>
<?php 
include("pfiy-he-in.php");
meditor();
?>
</head>

<body>
<div class="sekme">
	<ul>
    	<li><a href="#icerik"><?php dile(86); ?></a></li>
    	<li><a href="#yeniKategori"><?php dile(84); ?></a></li>
    	<li><a href="#menuSira">Üst Menü Sıralaması</a></li>
	<?php if (isset($_GET['kid'])) { ?>
		<?php $kategori = kSorgu("sayfakategori",sprintf("WHERE id = %s",veri(get("kid"))));
		$ka = kd($kategori);
		?>
    	<li><a href="#yeniHaber"><?php printf(dil(75),$ka['kAd']); ?></a></li>
	<?php } ?>
	<?php if (isset($_GET['hid'])) { 
	$haberne = idSorgu("sayfalar",get("hid"));
	$hn = kd($haberne);
	?>
    	<li><a href="#haberDetay"><?php printf(dil(87),$hn['baslik']); ?></a></li>
    <?php }?>
	<?php if (isset($_GET['kategoriDetay'])) { ?>
		<?php $skategori = kSorgu("sayfakategori",sprintf("WHERE id = %s",veri(get("kategoriDetay"))));
		$katAd = kd($skategori);
		?>
    	<li><a href="#kategoriDetay"><?php printf(dil(93),$katAd['kAd'],dil(86)); ?></a></li>
	<?php } ?>
    </ul>
    <div class="icerik" id="icerik">
<?php 
$haber = select("*,sayfalar.id AS hid, sayfakategori.id AS kid, sayfalar.y AS sy, sayfakategori.y AS ky","sayfalar","INNER JOIN sayfakategori ON sayfalar.kategori = sayfakategori.id",0,100);
?>

		<h2><?php dile(86); ?></h2>       
        <?php if($haber==0) { ?>
        <?php bilgi(dil(89)) ?>
        <?php } else { 
		?>
        <ul>
        <?php while ($h = kd($haber)) {
			if ($h['resim']!=""){
				$resim = $img. "/ikon/sayfa.png";
				$boyut="128";
			} else {
				$resim = $img. "/ikon/sayfa.png";
				$boyut="";
			}
				
		?>
			<li id="l<?php echo $h['hid']; ?>" yazi="<?php printf(dil(83),$h['baslik']) ?>" url="<?php echo $via ?>sayfaIslem=sil&id=<?php echo $h['hid']; ?>" ajax="#l<?php echo $h['hid']; ?>" duzenle="?hid=<?php echo $h['hid']; ?>#haberDetay"><?php echo resim($resim); ?><a href="?hid=<?php echo $h['hid']; ?>#haberDetay" title=""><?php echo $h['baslik']; ?></a>
            <sil yazi="<?php printf(dil(83),$h['baslik']) ?>" url="<?php echo $via ?>sayfaIslem=sil&id=<?php echo $h['hid']; ?>" ajax="#l<?php echo $h['hid']; ?>"><?php echo resim("resimler/ikon/sil.png"); ?></sil>
            <sayi class="beyaz"><a href="?kategoriDetay=<?php echo $h['id']?>#kategoriDetay"><?php echo $h['kAd']?></a></sayi>
            <yayin deger="<?php echo $h['sy']; ?>" id="<?php echo $h['hid']?>" tur="sayfa" ><?php if ($h['sy']==1) { echo resim($img . "ikon/y.png"); } else { echo resim($img . "ikon/yd.png"); }?></yayin>
            </li>        
        <?php } ?>
        </ul>
        <?php } ?>
    </div>
    <div id="yeniKategori">
        <form id="ekle" name="ekle" method="post" action="<?php echo $via ?>sayfaIslem=kategoriEkle&y=<?php echo $_SERVER['PHP_SELF']; ?>#yeniKategori">
        <fieldset>
            <legend><?php dile(72); ?></legend>
            <ul>
                <li><label><?php dile(73); ?></label><input autofocus type="text" size="40" name="kAd" id="kAd" required /></li>
         		<li class="submit"><input name="" type="submit" value="<?php dile(90)?>"/></li>
           </ul>
           </fieldset>
         </form> 
			<div class="icerik" id="icerik">
		<?php //sayfa kategorileri
		$kategori = kSorgu("sayfakategori");
		?>

				<h2><?php dile(84); ?></h2>       
						<?php if($kategori==0) { ?>
						<?php bilgi(dil(85)) ?>
						<?php } else { 
						?>
						<ul>
						<?php while ($hk = kd($kategori)) { ?>
							<li id="hk<?php echo $hk['id']; ?>" yazi="<?php printf(dil(82),$hk['kAd']) ?>" url="<?php echo $via ?>sayfaIslem=kategoriSil&id=<?php echo $hk['id']; ?>" ajax="#hk<?php echo $hk['id']; ?>" duzenle="?kid=<?php echo $hk['id']; ?>#yeniHaber"><?php echo resim($img. "/dock/02.png"); ?><a href="?kid=<?php echo $hk['id']; ?>#yeniHaber" class="yellow" title="<?php dile(74); ?>"><?php echo $hk['kAd']; ?></a>
                            <?php $toplam = toplam("sayfalar",sprintf("kategori = %s",$hk['id']));
							if ($toplam==0) { 
							?>
							<sil yazi="<?php printf(dil(82),$hk['kAd']) ?>" url="<?php echo $via ?>sayfaIslem=kategoriSil&id=<?php echo $hk['id']; ?>" ajax="#hk<?php echo $hk['id']; ?>"><?php echo resim("resimler/ikon/sil.png"); ?></sil>
                            <?php } ?>
							<sayi class="mavi"><?php echo $toplam ?></sayi>
                            <yayin deger="<?php echo $hk['y']; ?>" id="<?php echo $hk['id']?>" tur="sayfakategori" ><?php if ($hk['y']==1) { echo resim($img . "ikon/y.png"); } else { echo resim($img . "ikon/yd.png"); }?></yayin>
							</li>        
						<?php } ?>
						</ul>
						<?php } ?>
			</div>
    </div>
	<div id="menuSira">
		<?php $sira = kSorgu("sayfakategori","WHERE y=1 AND mg=1 ORDER BY s ASC"); ?>
		<table>
			<thead>
				<tr>
					<th>Sayfa</th>
					<th>Sıra</th>
				</tr>
			</thead>
			<tbody>
			<?php while($si = kd($sira)) { ?>
				<tr>
					<td><?php e($si['kAd']) ?></td>
					<td>
					<select class="ajaxDuzenle" tablo="sayfakategori" s_alan="id" s_kriter="<?php e($si['id']) ?>" d_alan="s">
						<?php for($ks=1;$ks<=20;$ks++) { ?>
							<option value="<?php e($ks); ?>" <?php if($ks==$si['s']) { ?>selected="selected"<?php } ?>><?php e($ks); ?></option>
						<?php } ?>
					</select>
					</td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
	</div>
	<?php if (isset($_GET['kid'])) { ?>
    <div id="yeniHaber">
     <h1><input type="text" class="ajaxDuzenle" tablo="sayfakategori" s_alan="id" d_alan="kAd" s_kriter="<?php echo $ka['id']; ?>" value="<?php echo $ka['kAd']; ?>" /></h1>
		<select class="ajaxDuzenle" tablo="sayfakategori" s_alan="id" d_alan="mg" s_kriter="<?php echo $ka['id']; ?>" >
			<option value="1" <?php if($ka['mg']==1) { ?>selected="selected"<?php } ?>>Üst Menüde Göster</option>
			<option value="" <?php if($ka['mg']=="") { ?>selected="selected"<?php } ?>>Üst Menüde Gösterme</option>
		</select>
	 <form id="hekle" name="hekle" method="post" action="<?php echo $via ?>sayfaIslem=ekle&y=<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
        <fieldset>
            <legend><?php printf(dil(75),$ka['kAd']); ?></legend>
            <ul>
                <li><label><?php dile(76); ?></label><input autofocus type="text" size="40" name="baslik" id="baslik" required /></li>
                <!--<li><label><?php dile(78); ?></label><input type="file" size="40" name="resim" id="resim" /></li>-->
                <li><label><?php dile(77); ?></label><textarea name="icerik" id="icerik" class="meditor" cols="70" rows="10"></textarea></li>
                <li><label><?php dile(92); ?></label><select name="galeri"><?php $galeri = kSorgu("galerikategori","ORDER BY isim ASC"); while ($ga = kd($galeri)) {?><option value="<?php echo $ga['id']; ?>"><?php echo $ga['isim']; ?></option><?php } ?>
                <option value="-1" selected="selected">Seçiniz</option>
                </select></li>
         		<li class="submit"><input name="" type="submit" value="<?php dile(80); ?>" /></li>
           </ul>
           </fieldset>
           <input type="hidden" name="kategori" value="<?php echo get("kid"); ?>" />
         </form> 
    </div>
	<?php } ?>
	<?php if (isset($_GET['hid'])) { ?>
    <div id="haberDetay">
        <form id="hduzenle" name="hduzenle" method="post" action="<?php echo $via ?>sayfaIslem=guncelle&y=<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
        <fieldset>
            <legend><?php printf(dil(75),$hn['baslik']); ?></legend>
            <ul>
            	    <?php echo resim($img. "sayfalar/" . $hn["resim"],"150","align=right")?>
                <li><label><?php dile(76); ?></label><input autofocus type="text" size="40" value="<?php echo $hn['baslik']; ?>" name="baslik" id="baslik" required /></li>
                <!--<li><label><?php dile(78); ?></label><input type="file" size="40"  name="resim" id="resim" /></li>-->
                <li><label><?php dile(60); ?></label><textarea name="icerik" id="icerik"  class="meditor" cols="70" rows="10"><?php echo $hn['icerik']; ?></textarea></li>
                <li><label><?php dile(73); ?></label><select name="kategori"><?php $kate = kSorgu("sayfakategori","ORDER BY kAd ASC"); while ($ka = kd($kate)) {?><option value="<?php echo $ka['id']; ?>" <?php if ($ka['id']==$hn['kategori']) {?>selected="selected"<?php }?>><?php echo $ka['kAd']; ?></option><?php } ?></select></li>
                <li><label><?php dile(92); ?></label><select name="galeri"><?php $galeri = kSorgu("galerikategori","ORDER BY isim ASC"); while ($ga = kd($galeri)) {?><option value="<?php echo $ga['id']; ?>" <?php if ($ga['id']==$hn['galeri']) {?>selected="selected"<?php }?>><?php echo $ga['isim']; ?></option><?php } ?>
                <option value="-1" <?php if ($hn['galeri']=="-1") {?>selected="selected"<?php } ?>>Seçiniz</option>
                </select></li>
         		<li class="submit"><input name="" type="submit" value="<?php dile(81); ?>" /></li>
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
$haber = select("*,sayfalar.id AS hid, sayfakategori.id AS kid, sayfalar.y AS sy, sayfakategori.y AS ky","sayfalar",
				sprintf("INNER JOIN sayfakategori ON sayfalar.kategori = sayfakategori.id WHERE sayfakategori.id = %s ",
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
				$resim = $img. 'sayfalar/' .  $h['resim'];
				$boyut="128";
			} else {
				$resim = $img. "/ikon/sayfa.png";
				$boyut="";
			}
				
		?>
			<li id="l<?php echo $h['hid']; ?>" yazi="<?php printf(dil(83),$h['baslik']) ?>" url="<?php echo $via ?>sayfaIslem=sil&id=<?php echo $h['hid']; ?>" ajax="#l<?php echo $h['hid']; ?>" duzenle="?hid=<?php echo $h['hid']; ?>#haberDetay"><?php echo resim($resim,$boyut); ?><a href="?hid=<?php echo $h['hid']; ?>#haberDetay" title=""><?php echo $h['baslik']; ?></a>
            <sil yazi="<?php printf(dil(83),$h['baslik']) ?>" url="<?php echo $via ?>sayfaIslem=sil&id=<?php echo $h['hid']; ?>" ajax="#l<?php echo $h['hid']; ?>"><?php echo resim("resimler/ikon/sil.png"); ?></sil>
            <sayi class="mavi"><?php echo $h['kAd']?></sayi>
            <yayin deger="<?php echo $h['sy']; ?>" id="<?php echo $h['hid']?>" tur="sayfakategori" ><?php if ($h['sy']==1) { echo resim($img . "ikon/y.png"); } else { echo resim($img . "ikon/yd.png"); }?></yayin>
            </li>        
        <?php } ?>
        </ul>
        <?php } ?>
    </div>
<?php }?>
</div>
<script type="text/javascript">
<!--
-->
</script>
</body>
</html>