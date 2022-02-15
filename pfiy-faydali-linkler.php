<?php include("pfi-yonetici-yetki.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<?php 
include("pfiy-he-in.php");
	//formee
	js($betik . "formee/js/formee.js") . _js();
	linkCss($betik . "formee/css/formee-structure.css");
	linkCss($betik . "formee/css/formee-style.css")

?>

</head>

<body>
<div class="sekme">
	<ul>
    	<li><a href="#icerik">Faydalı Linkler</a></li>
    	<?php if(isset($_GET['duzenle'])) { ?><li><a href="#duzenle">Link Düzenle</a></li><?php } ?>
    </ul>
    <div id="icerik">
    <div id="yeniForm">
        <form id="ekle" name="ekle" method="post" action="<?php echo $via ?>linkIslem=ekle&y=<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data">
        <fieldset>
            <legend>Yeni Adres Ekle</legend>
            <ul>
                <li><label>Adres Adı</label><input type="text" name="isim" id="isim" required /></li>
                <li><label>URL</label><span id="alan"><input type="text" name="url" id="url" value="http://" required /></span></li>
                <li><label>Fotoğraf</label><input type="file" name="foto" id="foto" /></li>
                <li><label>Adres Açıklaması</label><textarea name="aciklama" id="aciklama" cols="45" rows="5"></textarea></li>
         		<li class="submit"><input name="" type="submit" value="Adresi Ekle" /></li>
           </ul>
           </fieldset>
         </form> 
    </div>
<?php 
$link = kSorgu("linkler");
?>

        <?php if($link==0) { ?>
		<h2>Faydalı Adresler</h2>
        <?php bilgi("Sitede kayıtlı adres bulunamadı") ?>
        <?php } else { 
		?>
		<div class="icerik">
        <ul>
        <?php while ($e = kd($link)) { ?>
			<li id="l<?php echo $e['id']; ?>" duzenle="?duzenle=<?php e($e['id']) ?>#duzenle"><?php if($e['foto']!="") { ?><?php echo resim($img . "linkler/" . $e['foto'],"128"); } else { e(resim("resimler/dock/20.png"));  } ?><a href="<?php e($e['url']); ?>" target="_blank"><?php echo $e['isim']; ?></a>
            <sil yazi="<?php printf("%s linkini silmek istediğinizden emin misiniz?",$e['isim']) ?>" url="<?php echo $via ?>linkIslem=sil&id=<?php echo $e['id']; ?>&img=<?php echo $e['foto']; ?>" ajax="#l<?php echo $e['id']; ?>" ><?php echo resim("resimler/ikon/sil.png"); ?></sil>
            </li>        
        <?php } ?>
        </ul>

		</div>
        <?php } ?>
    </div>
	<?php if(isset($_GET['duzenle'])) { 
	$link = ksorgu("linkler",
		sprintf("WHERE id=%s",veri(get("duzenle","sayi")))
	);
	$l = kd($link);
	?>
    <div id="duzenle">
        <form id="duzenle" name="duzenle" method="post" action="<?php echo $via ?>linkIslem=duzenle&y=<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
        <fieldset>
            <legend>Faydalı Link Düzenle</legend>
            <ul>
                <li><label>Adres Adı</label><input value="<?php e($l['isim']); ?>" type="text" name="disim" id="disim" required /></li>
                <li><label>URL</label><span id="alan2"><input value="<?php e($l['url']); ?>" type="text" name="durl" id="durl" required /></span></li>
                <li><label>Fotoğraf (Değiştirmek istemiyorsanız boş bırakın)</label><input type="file" name="dfoto" id="dfoto" /></li>
                <li><label>Adres Açıklaması</label><textarea name="daciklama" id="daciklama" cols="45" rows="5"><?php e($l['aciklama']); ?></textarea></li>
         		<li class="submit"><input name="" type="submit" value="Adresi Ekle" /></li>
				<input type="hidden" name="efoto" value="<?php e($l['foto']); ?>"  />
				<input type="hidden" name="id" value="<?php e($l['id']); ?>"  />
           </ul>
           </fieldset>
         </form> 
    </div>
	<?php } ?>
</div>
<script type="text/javascript">
<!--
//var sprytextfield1 = new Spry.Widget.ValidationTextField("alan", "custom", {useCharacterMasking:true, pattern:"00:00"});
</script>
</body>
</html>