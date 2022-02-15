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
    	<li><a href="#yeniForm">Bilgileriniz</a></li>
    </ul>
    <div  id="yeniForm">
	<form action="<?php echo $via ?>uyeIslem=blog&y=<?php echo $_SERVER['REQUEST_URI']; ?>" method="POST">
<?php 
$uye = kd(kSorgu("uyeler",sprintf("WHERE id=%s",veri(oturum("uid"),"sayi"))));
?>
		<h2>Tanıtım Sayfanız</h2>
		<div style="float:left"><a href="pfi-yazar-detay.php?id=<?php e(oturum("uid")) ?>" target="_blank"><?php e(resim("resimler/dock/18.png")) ?><br>Önizleme</a></div>
		<?php bilgi("Kendinizi tanıtan bir şeyler yazın") ?>
	<textarea name="biyografi" class="meditor" id="biyografi" cols="30" rows="10"><?php e($uye['biyografi']) ?></textarea>
	<input type="submit" value="Bilgileri Güncelle" />
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