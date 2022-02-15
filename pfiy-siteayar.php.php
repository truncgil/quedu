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
    	<li><a href="#icerik">Taslak</a></li>
    	<li><a href="#yeniForm">Yeni Form</a></li>
    </ul>
    <div class="icerik" id="icerik">
<?php 
$etkinlik = kSorgu("etkinlikler");
?>

		<h2>Başlık</h2>
        <?php if($etkinlik==0) { ?>
        <?php bilgi("uyarı") ?>
        <?php } else { 
		?>
        <ul>
        <?php while ($e = kd($etkinlik)) { ?>
			<li id="l<?php echo $e['id']; ?>"><?php echo resim("resimler/etkinlik/" . $e['resim'],"128"); ?><a href="?gid=<?php echo $e['id']; ?>#etkinlikDetay"><?php echo $e['isim']; ?></a>
            <sil yazi="<?php printf(dil(29),$e['isim']) ?>" url="<?php echo $via ?>etkinlikIslem=sil&id=<?php echo $e['id']; ?>&img=<?php echo $e['resim']; ?>" ajax="#l<?php echo $e['id']; ?>"><?php echo resim("resimler/ikon/sil.png"); ?></sil>
            </li>        
        <?php } ?>
        </ul>
        <?php } ?>
    </div>
    <div id="yeniForm">
        <form id="ekle" name="ekle" method="post" action="<?php echo $via ?>---&y=<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data">
        <fieldset>
            <legend>Form Başlık</legend>
            <ul>
                <li><label>İsim</label><span id="alan"><input type="text" name="isim" id="isim" required /></span></li>
                <li><label>Dosya</label><input type="file" name="Dosya" id="Dosya" /></li>
                <li><label>Alan</label><textarea name="Alan" id="Alan" cols="45" rows="5"></textarea></li>
         		<li class="submit"><input name="" type="submit" value="Gönder" /></li>
           </ul>
           </fieldset>
         </form> 
    </div>
</div>
<script type="text/javascript">
<!--
//var sprytextfield1 = new Spry.Widget.ValidationTextField("alan", "custom", {useCharacterMasking:true, pattern:"00:00"});
<?php spryDesen("alan","00000");?>
</script>
</body>
</html>