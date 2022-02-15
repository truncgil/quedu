<?php include("pfi-yonetici-yetki.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php dile(4);?></title>
<?php 
include("pfiy-he-in.php");
?>
</head>

<body>
<div class="sekme">
<ul>
	<li><a href="#etkinlikler"><?php dile(23) ?></a></li>
	<li><a href="#yeniEtkinlik"><?php dile(22) ?></a></li>
	<?php if (isset($_GET['gid'])) { ?>
		<?php 
            $etkinlik = kSorgu("etkinlikler",
                               sprintf("WHERE id = %s",
                                       veri($_GET['gid'])
                                       )
                               );
            $et = kd($etkinlik);
        ?>

    <li><a href="#etkinlikDetay"><?php echo $et['isim']; ?> <?php dile(31) ?></a></li><?php } ?>
</ul>
<div class="icerik" id="etkinlikler">
<?php 
$etkinlik = kSorgu("etkinlikler");
?>
		<h2><?php dile(28) ?></h2>
        <?php if($etkinlik==0) { ?>
        <?php bilgi(dil(27)) ?>
        <?php } else { 
		?>
        <ul>
        <?php while ($e = kd($etkinlik)) { ?>
			<li id="l<?php echo $e['id']; ?>" yazi="<?php printf(dil(29),$e['isim']) ?>" url="<?php echo $via ?>etkinlikIslem=sil&id=<?php echo $e['id']; ?>&img=<?php echo $e['resim']; ?>" ajax="#l<?php echo $e['id']; ?>" duzenle="?gid=<?php echo $e['id']; ?>#etkinlikDetay"><?php echo resim("resimler/etkinlik/" . $e['resim'],"128"); ?><a href="?gid=<?php echo $e['id']; ?>#etkinlikDetay" title="<?php echo zf($e['tarih'] ); ?>"><?php echo $e['isim']; ?></a>
            <sil yazi="<?php printf(dil(29),$e['isim']) ?>" url="<?php echo $via ?>etkinlikIslem=sil&id=<?php echo $e['id']; ?>&img=<?php echo $e['resim']; ?>" ajax="#l<?php echo $e['id']; ?>"><?php echo resim("resimler/ikon/sil.png"); ?></sil>
            <yayin deger="<?php echo $e['y']; ?>" id="<?php echo $e['id']?>" tur="etkinlik" ><?php if ($e['y']==1) { echo resim($img . "ikon/y.png"); } else { echo resim($img . "ikon/yd.png"); }?></yayin>
            </li>        
        <?php } ?>
        </ul>
        <?php } ?>
</div>

<div id="yeniEtkinlik">

<form id="ekle" name="ekle" method="post" action="<?php echo $via ?>etkinlikIslem=ekle&y=<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data">
<fieldset>
	<legend><?php dile(22); ?></legend>
	<ul>
  		<li><label><?php dile(20); ?></label><input type="text" name="isim" id="isim" required /></li>
  		<li><label><?php dile(24); ?></label><input type="text" name="tarih" class="tarih" required />
  		  <span id="dsaat">
          <input size="4" name="saat" id="saat" value="12:00" required />
        </span></li>
   		<li><label><?php dile(30); ?></label><input type="text" name="btarih" class="tarih" required />
        <span id="dsaat2">
        <input type="text" size="4" name="bsaat" id="bsaat" value="12:00" required />
        </span>
        </li>
 		<li><label><?php dile(25); ?></label><input type="file" name="resim" id="resim" required /></li>
  		<li><label><?php dile(21); ?></label><textarea name="icerik" id="icerik" cols="45" rows="5"></textarea></li>
        <li class="submit"><input name="" type="submit" value="<?php dile(26) ?>" /></li>
    </ul>
    </fieldset>
</form>
</div>
<?php if (isset($_GET['gid'])) { ?>
<div id="etkinlikDetay">

<form id="guncelle" name="guncelle" method="post" action="<?php echo $via ?>etkinlikIslem=guncelle&y=<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data">
<fieldset>
	<legend><?php echo $et['isim'] . " " . dil(31); ?></legend>
	<ul>
    	<li>    <?php echo resim($img . "etkinlik/" . $et['resim'],"200"); ?></li>
  		<li><label><?php dile(20); ?></label><input type="text" name="gisim" id="gisim" value="<?php echo $et['isim']; ?>" required /></li>
  		<li><label><?php dile(24); ?></label><input type="text" name="gtarih" value="<?php echo tarihf($et['tarih'],"Y-m-d"); ?>" class="tarih" required />
  		  <span id="gdsaat">
          <input size="4" name="gsaat" id="gsaat" value="<?php echo tarihf($et['tarih'],"H:i"); ?>" required />
        </span></li>
   		<li><label><?php dile(30); ?></label><input type="text" name="gbtarih" value="<?php echo tarihf($et['btarih'],"Y-m-d"); ?>" class="tarih" required />
        <span id="gdsaat2">
        <input type="text" size="4" name="gbsaat" id="gbsaat" value="12:00" value="<?php echo tarihf($et['bsaat'],"H:i"); ?>"  required />
        </span>
        </li>
 		<li><label><?php dile(25); ?></label><input type="file" name="gresim" id="gresim" /></li>
  		<li><label><?php dile(21); ?></label><textarea name="gicerik" id="gicerik" cols="45" rows="5"><?php echo $et['icerik']; ?></textarea></li>
        <li class="submit"><input name="" type="submit" value="<?php dile(32) ?>" /></li>
    </ul>
    </fieldset>
    <input type="hidden" name="eskiResim" value="<?php echo $et['resim']; ?>" />
    <input type="hidden" name="id" value="<?php echo get("gid"); ?>" />
</form>
</div>
<?php } ?>
</div>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("dsaat", "custom", {useCharacterMasking:true, pattern:"00:00"});
var sprytextfield1 = new Spry.Widget.ValidationTextField("dsaat2", "custom", {useCharacterMasking:true, pattern:"00:00"});
<?php if (isset($_GET['gid'])) { ?>
var sprytextfield1 = new Spry.Widget.ValidationTextField("gdsaat", "custom", {useCharacterMasking:true, pattern:"00:00"});
var sprytextfield1 = new Spry.Widget.ValidationTextField("gdsaat2", "custom", {useCharacterMasking:true, pattern:"00:00"});
<?php } ?>
//-->
</script>
</body>
</html>