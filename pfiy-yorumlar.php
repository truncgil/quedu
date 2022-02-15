<?php include("pfi-yonetici-yetki.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Yorumlar</title>
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
    	<li><a href="#icerik">Henüz Onaylanmamış Yorumlar</a></li>
    	<li><a href="#ara">Yorum Ara</a></li>
    </ul>
    <div class="icerik" id="icerik">
<?php 
$yorumlar = kSorgu("yorumlar","WHERE y=0");
?>

        <?php if($yorumlar==0) { ?>
        <?php bilgi("Henüz onaylanmamış yorum bulunamadı") ?>
        <?php } else { 
		?>
		<table class="tablesorter" cellpadding="0" cellspacing="0">
			<thead>
				<tr>
					<th>Başlık</th>
					<th>Yazan</th>
					<th>Tarih</th>
					<th>İşlem</th>
				</tr>
			</thead>
			<tbody>
        <?php while ($e = kd($yorumlar)) { ?>
				<tr>
					<td><?php e($e['baslik']) ?></td>
					<td><?php e($e['yazan']) ?></td>
					<td><?php e(zf($e['tarih'])) ?></td>
					<td>
						<a href="<?php e($via) ?>yorumAdmin=onayla&id=<?php e($e['id']) ?>&y=<?php e($_SERVER['REQUEST_URI']) ?>" teyit="<?php e($e['icerik']) ?> <br> yorumunu onaylamak ister misiniz?">Gözat</a> 
						| 
						<a href="<?php e($via) ?>yorumAdmin=sil&id=<?php e($e['id']) ?>&y=<?php e($_SERVER['REQUEST_URI']) ?>" teyit="<?php e($e['icerik']) ?> <br> yorumunu silmek istediğinizden emin misiniz?">Sil</a>
						|
						<a href="<?php e($e['tur']) ?>" target="_blank"> Yazıldığı Yere Git</a>
					</td>
				</tr>
        <?php } ?>
			</tbody>
		</table>

        <?php } ?>
    </div>
	<div id="ara">
		<form action="?ara#ara" method="POST">
			<fieldset>
			<legend>Yorumlarda Ara</legend>
			<?php bilgi("Yorumu yazan kişinin isminin bir kısmını yazınız."); ?>
				<div class="grid-12-12">
					<label for="kriter">Kim Yazdı? </label>
					<input type="text" name="kriter" />
				</div>
				<div class="grid-12-12">
					<input type="submit" value="Ara" />
				</div>
			</fieldset>
		</form>
		<?php 
		if(isset($_GET['ara']) && isset($_POST['kriter'])) {
			$ara = kSorgu("yorumlar",sprintf("WHERE yazan LIKE %s ORDER BY id DESC",veri("%" . post("kriter") . "%"))); 
			if($ara!=0) {
			?>
			
				<table class="tablesorter" cellpadding="0" cellspacing="0">
					<thead>
						<tr>
							<th>Başlık</th>
							<th>Yazan</th>
							<th>Tarih</th>
							<th>İşlem</th>
						</tr>
					</thead>
					<tbody>
					<?php while($a = kd($ara)) { ?>
						<tr>
							<td><?php e($a['baslik']); ?></td>
							<td><?php e($a['yazan']); ?></td>
							<td><?php e(zf($a['tarih'])); ?></td>
							<td>
							<?php if($a['y']==0) { ?>
								<a href="<?php e($via) ?>yorumAdmin=onayla&id=<?php e($a['id']) ?>&y=<?php e($_SERVER['REQUEST_URI']) ?>#ara" teyit="<?php e($a['icerik']) ?> <br> yorumunu onaylamak ister misiniz?">Gözat</a> 
								| 
							<?php } else {
							?>  
								<a href="#" onclick="alert('<?php e($a['icerik']) ?>')">Gözat</a>
								| 
							<?php
							} ?>
								<a href="<?php e($via) ?>yorumAdmin=sil&id=<?php e($a['id']) ?>&y=<?php e($_SERVER['REQUEST_URI']) ?>#ara" teyit="<?php e($a['icerik']) ?> <br> yorumunu silmek istediğinizden emin misiniz?">Sil</a>
								|
								<a href="<?php e($a['tur']) ?>" target="_blank"> Yazıldığı Yere Git</a>
							</td>
						</tr>
					<?php } ?>
					</tbody>
				</table>
			<?php
			} else {
				bilgi("Aranan kişiye uygun bir kriter bulunamadı.");
			
			}
		}
		?>
	</div>
</div>
<script type="text/javascript">
<!--
//var sprytextfield1 = new Spry.Widget.ValidationTextField("alan", "custom", {useCharacterMasking:true, pattern:"00:00"});
<?php spryDesen("alan","00000");?>
</script>
</body>
</html>