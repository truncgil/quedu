<?php include("pfi-yonetici-yetki.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
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
    	<li><a href="#icerik">Yeni Siparişler</a></li>
    	<li><a href="#yeniForm">Onaylanan Siparişler</a></li>
    </ul>
    <div class="icerik" id="icerik">
	<?php $siparis = sorgu("SELECT * FROM siparis 
	INNER JOIN uyeler ON siparis.uid = uyeler.id
	","WHERE onay<>'Onaylandı'"); 
		if($siparis!=0):
	?>				

		<table class="tablesorter" cellpadding=0 cellspacing=0>
			<thead>
			<tr>
				<th>Bayi Adı</th>
				<th>Tarih</th>
				<th>İşlem</th>
			</tr>
			</thead>
			<tbody>
			<?php while($s = kd($siparis)) : ?>
			<tr>
				<td><a href="#"><?php e($s['adi']) ?> <?php e($s['soyadi']) ?></a></td>
				<td><?php e($s['tarih']) ?></td>
				<td>
				<a href="odeme.php" class="pencere fa fa-credit-card" title="Ödeme Bilgisi"></a>
				<a href="" class="pencere fa fa-check" title="Siparişi Onayla"></a>
				<a href="" class="pencere fa fa-bars" title="Sipariş Detayı"></a>
				</td>
			</tr>
			<?php endwhile; ?>
			</tbody>
		</table>
		<?php endif; ?>
    </div>
    <div id="yeniForm">
	
    </div>
</div>
<script type="text/javascript">
<!--
//var sprytextfield1 = new Spry.Widget.ValidationTextField("alan", "custom", {useCharacterMasking:true, pattern:"00:00"});
<?php spryDesen("alan","00000");?>
</script>
</body>
</html>