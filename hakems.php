<?php include("pfi-yonetici-yetki.php"); 
if(getisset("ata")) {
	dEkle("hakems",$_POST);
	yonlendir("hakems.php");
}
if(getisset("sil")) {
	$id = veri(get("sil"));
	sil("hakems","id=$id");
}
if(getisset("search")) {
	$kriter = veri("%".trim(strip_tags($_GET['term']))."%");
	$sorgu = ksorgu("uyeler","WHERE adi LIKE $kriter OR soyadi LIKE $kriter OR slug LIKE $kriter OR mail LIKE $kriter");
	$k=0;
	while($s = kd($sorgu)) {
		$dizi[$k]['value']="{$s['adi']} {$s['soyadi']} - {$s['slug']}";
		$dizi[$k]['id']=(int)$s['id'];
		$k++;
	}
	//print_r($dizi);
	echo json_encode($dizi);
	exit();
}
if(getisset("search2")) {
	$kriter = veri("%".trim(strip_tags($_GET['term']))."%");
	$sorgu = ksorgu("content","WHERE slug LIKE $kriter OR title LIKE $kriter");
	$k=0;
	while($s = kd($sorgu)) {
		$dizi[$k]['value']=$s['title'];
		$dizi[$k]['id']=$s['slug'];
		$k++;
	}
	//print_r($dizi);
	echo json_encode($dizi);
	exit();
}
?>
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
	linkCss($betik . "formee/css/formee-style.css");
	linkCss("tema/truncgil.blok.css");

?>

</head>

<body>
<div class="sekme">
	<ul>
    	<li><a href="#icerik">Yetkili Kişiler</a></li>
    </ul>
    <div class="icerik" id="icerik">
	<form action="?ata" method="post">
		<fieldset>
			<legend>Yetkili Kişi Ata</legend>
			<blok1>
				<label for="uid">Üye Adı</label>
				<input type="text" class="search" required id="" />
				<input type="hidden" name="uid" id="uid" required />
			</blok1>
			<blok1>
				<label for="kat">Kategori</label>
				<input type="text" class="search2" required id="" />
				<input type="hidden" name="kat" id="kat" required />
			</blok1>
			<blok1>
				<input type="submit" value="Yetkili Olarak Ata" />
			</blok1>
		</fieldset>
	</form>
	<?php $hakems = ksorgu("hakems","ORDER BY id DESC"); ?>
	<?php if($hakems!=0) { ?>
	<table class="tablesorter" cellpadding=0 cellspacing=0>
		<thead>
			<th>Yetkili Kişi</th>
			<th>Kategori</th>
			<th>İşlem</th>
		</thead>
		<tbody>
		<?php while($k = kd($hakems)) { ?>
			<td><?php e(username($k['uid'])); ?></td>
			<td><?php e(cattitle($k['kat'])); ?></td>
			<td><a href="?sil=<?php e($k['id']); ?>" teyit="Silmek istediğinizden emin misiniz?"><i class="fa fa-times"></i></a></td>
		<?php } ?>
		</tbody>
	</table>
	<?php } ?>
    </div>
    
</div>
<script type="text/javascript">
$(function(){
	$(".search").autocomplete({
		source :"?search",
		minLength: 2,
		select: function (a, b) {
			console.log(b.item.id);
			$("#uid").val(b.item.id);
		}
	});
	$(".search2").autocomplete({
		source :"?search2",
		minLength: 2,
		select: function (a, b) {
			console.log(b.item.id);
			$("#kat").val(b.item.id);
		}
	});
});
</script>
<script type="text/javascript">

<!--
//var sprytextfield1 = new Spry.Widget.ValidationTextField("alan", "custom", {useCharacterMasking:true, pattern:"00:00"});
<?php spryDesen("alan","00000");?>
</script>
</body>
</html>