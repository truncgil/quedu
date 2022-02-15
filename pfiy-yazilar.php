<?php include("pfi-yonetici-yetki.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php dile(5) ?></title>
<?php 
include("pfiy-he-in.php");
?>
</head>

<body>
<div class="sekme">
	<ul>
	<?php if (!isset($_GET['gid'])) { ?>
    	<li><a href="#yeniForm"><?php dile(46) ?></a></li>
		<?php } ?>
    	<li><a href="#yicerik"><?php dile(45) ?></a></li>
    	<?php if (isset($_GET['gid'])) { 
			$yazi = kSorgu("uyeyazilar",
				   sprintf("WHERE uid = %s AND id = %s",
						   veri(oturum("uid")),
						   veri(get("gid"))
						   )
				   );
	$ya = kd($yazi);
		?><li><a href="#yaziDetay"><?php printf(dil(50),$ya['baslik']); ?></a></li><?php  } ?>
    </ul>
 	<?php if (!isset($_GET['gid'])) { ?>
   <div id="yeniForm">
        <form id="ekle" name="ekle" method="post" action="<?php echo $via ?>yaziIslem=ekle&y=<?php echo $_SERVER['REQUEST_URI']; ?>#yicerik">
        <fieldset>
            <legend><?php dile(46); ?></legend>
            <ul>
                <li><label><?php dile(47); ?></label><input type="text" name="baslik" id="baslik" size="100" required /></li>
                <li><label><?php dile(48); ?></label><textarea name="icerik" class="meditor" id="icerik" cols="70" rows="20"></textarea></li>
         		<li class="submit"><input name="" type="submit" value="<?php dile(53); ?>" /></li>
           </ul>
           </fieldset>
         </form> 
    </div>
	<?php }  ?>
    <div class="icerik" id="yicerik">
<?php 
//sadece ye kendi yazlarn grebilmeli
$yazilar = kSorgu("uyeyazilar",
				   sprintf("WHERE uid = %s",veri(oturum("uid")))
				   );
?>

		<h2><?php dile(45) ?></h2>
        <?php if($yazilar==0) { ?>
        <?php bilgi(dil(52)) ?>
        <?php } else { 
		?>
        <ul>
        <?php while ($y = kd($yazilar)) { ?>
			<li id="l<?php echo $y['id']; ?>" yazi="<?php printf(dil(51),$y['baslik']) ?>" url="<?php echo $via ?>yaziIslem=sil&id=<?php echo $y['id']; ?>" ajax="#l<?php echo $y['id']; ?>" duzenle="?gid=<?php echo $y['id']; ?>#yaziDetay"><?php echo resim($img . "dock/05.png"); ?><a href="?gid=<?php echo $y['id']; ?>#yaziDetay"><?php echo $y['baslik']; ?></a>
            <sil yazi="<?php printf(dil(51),$y['baslik']) ?>" url="<?php echo $via ?>yaziIslem=sil&id=<?php echo $y['id']; ?>" ajax="#l<?php echo $y['id']; ?>"><?php echo resim("resimler/ikon/sil.png"); ?></sil>
			<sayi class="mavi"><?php echo zf($y['tarih']) ?></sayi>
            <yayin deger="<?php echo $y['y']; ?>" id="<?php echo $y['id']?>" tur="yazi" ><?php if ($y['y']==1) { echo resim($img . "ikon/y.png"); } else { echo resim($img . "ikon/yd.png"); }?></yayin>
            </li>        
        <?php } ?>
        </ul>
        <?php } ?>
    </div>
	<?php if (isset($_GET['gid'])) { 
	?>
    <div id="yaziDetay">
        <form id="guncelle" name="guncelle" method="post" action="<?php echo $via ?>yaziIslem=guncelle&y=<?php echo $_SERVER['PHP_SELF']; ?>">
        <fieldset>
            <legend><?php printf(dil(50),$ya['baslik']); ?></legend>
            <ul>
                <li><label><?php dile(47); ?></label><input type="text" name="baslik" id="baslik" size="100" value="<?php echo $ya['baslik']?>" required /></li>
                <li><label><?php dile(48); ?></label><textarea name="icerik" class="meditor" id="icerik" cols="70" rows="20"><?php echo $ya['icerik'];?></textarea></li>
         		<li class="submit"><input name="" type="submit" value="<?php dile(54); ?>" /></li>
           </ul>
           </fieldset>
               <input type="hidden" name="id" value="<?php echo get("gid"); ?>" />

         </form> 
    </div>
    <?php } ?>
</div>
</body>
</html>