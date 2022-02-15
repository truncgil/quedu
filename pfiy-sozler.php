<?php include("pfi-yonetici-yetki.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Veciz Bir Söz</title>
<?php 
include("pfiy-he-in.php");
	//formee
	js($betik . "formee/js/formee.js") . _js();
	linkCss($betik . "formee/css/formee-structure.css");
	linkCss($betik . "formee/css/formee-style.css");
	tablesorter();

?>

</head>

<body>
<div class="sekme">
	<ul>
    	<li><a href="#icerik">Veciz Sözler</a></li>
    </ul>
    <div class="icerik" id="icerik">
<?php 
$sozler = kSorgu("sozler");
?>

		<h2>Sitede bulunan sözler</h2>
		<a href="<?php e($via); ?>sozIslem=ekle&y=<?php e($_SERVER['REQUEST_URI']) ?>">Yeni bir söz ekle</a>
        <?php if($sozler==0) { ?>
        <?php bilgi("Siteye eklenmiş bir söz bulunamadı.") ?>
        <?php } else { 
		?>
        <table class="tablesorter" cellpadding="0" cellspacing="0">
        	<thead>
        		<tr>
        			<th>Söz</th>
        			<th>Söyleyen</th>
        			<th>İşlem</th>
        		</tr>
        	</thead>
			<tbody>
        <?php while ($e = kd($sozler)) { ?>
				<tr id="l<?php echo $e['id']; ?>">
					<td><input type="text" class="ajaxDuzenle" tablo="sozler" d_alan="soz" s_alan="id" s_kriter="<?php e($e['id']) ?>" value="<?php echo $e['soz']; ?>" /></td>
					<td><input type="text" class="ajaxDuzenle" tablo="sozler" d_alan="kim" s_alan="id" s_kriter="<?php e($e['id']) ?>" value="<?php echo $e['kim']; ?>" /></td>
					<td><a href="<?php e($via); ?>sozIslem=sil&id=<?php e($e['id']) ?>&y=<?php e($_SERVER['REQUEST_URI']) ?>"  teyit="<?php echo $e['soz']; ?> sözünü sistemden kaldırmak istediğinizden emin misiniz?"><?php e(resim("resimler/ikon/sil.png")) ?></a></td>
				</tr>
            </li>        
        <?php } ?>
			</tbody>
        </table>
        <?php } ?>
    </div>
</div>
<script type="text/javascript">
<!--
//var sprytextfield1 = new Spry.Widget.ValidationTextField("alan", "custom", {useCharacterMasking:true, pattern:"00:00"});
<?php spryDesen("alan","00000");?>
</script>
</body>
</html>