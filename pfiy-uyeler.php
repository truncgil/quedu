<?php include("pfi-yonetici-yetki.php");
if(getisset("ekle")) {
	$_POST['y']="1";
	$_POST['seviye']="Yazar";
	$_POST['user']=kripto($_POST['mail']);
	$_POST['sifre']=kripto($_POST['sifre']);
	dEkle("uyeler",$_POST);
	yonlendir("pfiy-uyeler.php");
}
if(getisset("sil")) {
	$id = veri(get("id"),"sayi");
	sil("uyeler","id=$id");
	yonlendir("pfiy-uyeler.php");
}
if(getisset("yetkiver")) {
	$fid = veri(post("fid"));
	$katlar ="";
	if(postisset("kat")) :
	foreach($_POST['kat'] AS $deger) {
		$katlar .= "$deger,"; 
	}
	$katlar = substr($katlar,0,strlen($katlar)-1);
	else:
	$katlar="";
	endif;
	$varmi = ksorgu("yetkiler","WHERE fid=$fid");
		if($varmi==0) {
			dEkle("yetkiler",array(
				"fid" => post("fid"),
				"uid" => $katlar
			));
		} else {
			dGuncelle("yetkiler",array(
				"uid" => $katlar
			),"fid=$fid");
		}
}
  ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<?php 
setlocale(LC_ALL,'TURKISH');
include("pfiy-he-in.php");
	//formee
	js($betik . "formee/js/formee.js") . _js();
	linkCss($betik . "formee/css/formee-structure.css");
	linkCss($betik . "formee/css/formee-style.css");
	tablesorter();
	input_ajax("pfi-bvi-yonga.php?uyeIslem=uyeSeviye",".uyeseviye");
	input_ajax("pfi-bvi-yonga.php?uyeIslem=uyeSira",".uyesira");
	input_ajax("pfi-bvi-yonga.php?uyeIslem=uyeBrans",".uyebrans");
//input_ajax("pfi-bvi-yonga.php?uyeIslem=Onay",".uyeOnay","1");
?>
<script type="text/javascript">
$(function(){
	$(".uyeOnay").click(function(){
			var o = $(this).attr("checked");
			var id = $(this).attr("id");
			var yayin;
		if (o=="checked") {
			yayin = 1;
		} else {
			yayin = 0;
		}
		$.post("pfi-bvi-yonga.php?uyeIslem=Onay",{
			"yayin" : yayin,
			"id" : id
		
		},function (d){
		//alert(d);
		});
	});
});
</script>
</head>

<body>
<div class="sekme">
	<ul>
    	<li><a href="#Öğretmen">Son 100 Öğretmen</a></li>
    	<li><a href="#icerik">Onaylanmamış Öğretmenler</a></li>
    	<!--<li><a href="#yazarlar"><?php dile(185) ?></a></li>-->
		<?php if(getisset("yetkilendir")) : 
		$id = veri(get("yetkilendir"));
		$kisi = kd(ksorgu("uyeler","WHERE id = $id"))
		?>
		<li><a href="#yetkilendir"><?php e($kisi['adi']) ?> <?php e($kisi['soyadi']) ?> Kişisini Yetkilendir</a></li>
		<?php endif; ?>
		<li><a href="#ara">Öğretmen Ara</a></li>
		<li><a href="#yeni">Yeni Öğretmen Kaydı</a></li>
    </ul>
	<div id="Öğretmen">
	<?php $Öğretmenler = ksorgu("uyeler","WHERE y=1 ORDER BY id DESC LIMIT 0,100"); 
	if($Öğretmenler!=0) :
	?>
	<table class="tablesorter" cellspacing="0" cellpadding="0">
			<thead>
				<tr>
					<th>Adı</th>
					<th>Soyadı</th>
					<th>Seviye</th>
					<th>Onay</th>
					<th>Sil</th>
				</tr>
			</thead>
			<tbody>
			<?php 
			bilgi(sprintf("Toplam %s Öğretmen bulundu.",sToplam($Öğretmenler)));
			while($u = kd($Öğretmenler)) { ?>
				<tr>
					<td><?php e($u['adi']) ?></td>
					<td><?php e($u['soyadi']) ?></td>
					<td>
					<select name="" class="uyeseviye" tablo="deger" s_alan="deger" s_kriter="<?php e($u['id']) ?>">
						<option value="Yonetici"<?php if($u['seviye']=="Yonetici") { ?> selected="selected"<?php } ?>>Yönetici</option>
						<option value="Yazar"<?php if($u['seviye']=="Yazar") { ?> selected="selected"<?php } ?>>Öğretmen</option>
						<option value="Okuyucu"<?php if($u['seviye']=="Okuyucu") { ?> selected="selected"<?php } ?>>Öğrenci</option>
					</select>
					</td>
					
					<td><input type="checkbox" class="uyeOnay" id="<?php e($u['id']) ?>" value="1" <?php if($u['y']=="1") { ?> checked<?php } ?> /></td>
					<td>
					<a href="?yetkilendir=<?php e($u['id']) ?>#yetkilendir" class="dugme">Kategori Yetkilendir</a>
					<a  class="dugme" href="?sil&id=<?php e($u['id']); ?>" onclick="return confirm('Silinmesini gerçekten istiyor musunuz?');">Sil</a></td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
		<?php endif; ?>
	</div>
    <div class="icerik" id="icerik">
<?php 
$uyeler = kSorgu("uyeler","WHERE y=0");

if($uyeler!=0) {
?>
<table class="tablesorter" cellspacing="0" cellpadding="0">
	<thead>
		<tr>
			<th>Adı</th>
			<th>Soyadı</th>
			<th>Mail</th>
			<th>Seviye</th>
			<th>Onay</th>
			<th>İşlem</th>
		</tr>
	</thead>
	<tbody>
	<?php 
	bilgi(sprintf("Sitede onaylanmamış toplam %s kişi bulunmaktadır.",sToplam($uyeler)));
	while($u = kd($uyeler)) { ?>
		<tr>
			<td><?php e($u['adi']) ?></td>
			<td><?php e($u['soyadi']) ?></td>
			<td><?php e($u['mail']) ?></td>
			<td>
			<select name="" class="uyeseviye" tablo="deger" s_alan="deger" s_kriter="<?php e($u['id']) ?>">
				<option value="Yonetici"<?php if($u['seviye']=="Yonetici") { ?> selected="selected"<?php } ?>>Yönetici</option>
				<option value="Yazar"<?php if($u['seviye']=="Yazar") { ?> selected="selected"<?php } ?>>Öğretmen</option>
				<option value="Okuyucu"<?php if($u['seviye']=="Okuyucu") { ?> selected="selected"<?php } ?>>Öğrenci</option>
			</select>
			</td>
			
			<td><input type="checkbox" class="uyeOnay" id="<?php e($u['id']) ?>" value="1" <?php if($u['y']=="1") { ?> checked<?php } ?> /></td>
			<td>
			<a href="?yetkilendir=<?php e($u['id']) ?>#yetkilendir" class="dugme">Kategori Yetkilendir</a>
			<a href="?sil&id=<?php e($u['id']); ?>#icerik" onclick="return confirm('Silinmesini gerçekten istiyor musunuz?');"><i class="fa fa-times"></i></a></td>
		</tr>
	<?php } ?>
	</tbody>
</table>
<?php } else {
	bilgi("Şimdilik onaylanmamış Öğretmen yok");

} ?>
    </div>
	<?php if(getisset("yetkilendir")) : ?>
	<div id="yetkilendir">
	<?php $kategoriler = ksorgu("urun_kategori","WHERE ust IS NULL");
	$yetkiler = kd(ksorgu("yetkiler","WHERE fid={$kisi['id']}"));
	$katlar = explode(",",$yetkiler['uid']);
//	print_r($katlar);
	?>
	<h2><?php e($kisi['adi']) ?> <?php e($kisi['soyadi']) ?> Kişisinin Yetkilendirildiği Kategoriler</h2>
	<form action="?yetkiver" method="post">
		<ul>
		<?php while($k = kd($kategoriler)): ?>
			<li style="float:none"><label><input type="checkbox" name="kat[]" <?php if(in_array($k['id'],$katlar)) : ?>checked<?php endif; ?> value="<?php e($k['id']) ?>" id="" /><?php e($k['isim']) ?></label></li>
		<?php endwhile; ?>
		</ul>
	<div style="clear:both"></div>
		<input type="hidden" name="fid" value="<?php e($kisi['id']); ?>" />
		<input type="submit" value="Yetkilendir" />
	</form>
	<div style="clear:both"></div>
	</div>
	<?php endif; ?>
	<div id="ara">
		<form action="?ara#ara" method="POST">
			<fieldset>
				<legend>Öğretmen Ara</legend>
				<ul>
					<li><input type="text" name="kriter" required /></li>
					<li><input type="submit" value="Ara" /></li>
				</ul>
				
			</fieldset>
		</form>
<?php 
if (isset($_GET['ara'])) {
$kriter = post("kriter");
switch ($kriter) {
	case "Öğretmen" : 
		$kriter = "Yazar";
	break;
	case "okuyucu" :
		$kriter = "Okuyucu";
	break;
	case "admin":
		$kriter  ="Yonetici";
	break;
}
$kriter = veri("%" . $kriter . "%");
$ara = kSorgu("uyeler",sprintf("WHERE adi LIKE %s OR soyadi LIKE %s OR seviye LIKE %s OR mail LIKE %s",
	$kriter,
	$kriter,
	$kriter,
	$kriter
));

if($ara!=0) {
?>		<table class="tablesorter" cellspacing="0" cellpadding="0">
			<thead>
				<tr>
					<th>Adı</th>
					<th>Soyadı</th>
					<th>Mail Adresi</th>
					<th>Seviye</th>
					<th>Onay</th>
				</tr>
			</thead>
			<tbody>
			<?php 
			bilgi(sprintf("Toplam %s kişi bulundu.",sToplam($ara)));
			while($u = kd($ara)) { ?>
				<tr>
					<td><?php e($u['adi']) ?></td>
					<td><?php e($u['soyadi']) ?></td>
					<td><?php e($u['mail']) ?></td>
					<td>
					<select name="" class="uyeseviye" tablo="deger" s_alan="deger" s_kriter="<?php e($u['id']) ?>">
						<option value="Yonetici"<?php if($u['seviye']=="Yonetici") { ?> selected="selected"<?php } ?>>Yönetici</option>
						<option value="Yazar"<?php if($u['seviye']=="Yazar") { ?> selected="selected"<?php } ?>>Öğretmen</option>
						<option value="Okuyucu"<?php if($u['seviye']=="Okuyucu") { ?> selected="selected"<?php } ?>>Öğrenci</option>
					</select>
					</td>
					
					<td><input type="checkbox" class="uyeOnay" id="<?php e($u['id']) ?>" value="1" <?php if($u['y']=="1") { ?> checked<?php } ?> /></td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
		<?php } ?>
		<?php } ?>
	</div>
	<div id="yeni">
	<form action="?ekle" method="post">
		<fieldset>
				<legend>Yeni Üye Kaydı</legend>
				<ul>
					<li><input type="text" name="adi" placeholder="Adı" required /></li>
					<li><input type="text" name="soyadi" placeholder="Soyadı" required /></li>
					<li><input type="text" class="mail" name="mail" placeholder="Mail Adresi" required /></li>
					<li><input type="text" name="sifre" placeholder="Şifre" required /></li>
					<li><input type="submit" value="Ekle" /></li>
				</ul>
				
			</fieldset>
	</form>
	</div>
	<!--
	<div id="yazarlar">
	<?php 
	$yazarlar = kSorgu("uyeler","WHERE seviye='Yazar' OR seviye='Yonetici' ORDER BY s ASC");
	?>
	<?php bilgi(dil(186)) ?>
<table class="tablesorter" cellspacing="0" cellpadding="0">
	<thead>
		<tr>
			<th>Adı</th>
			<th>Soyadı</th>
			<th>Onay</th>
			<th>Sıra</th>
		</tr>
	</thead>
	<tbody>
		<?php while($ya = kd($yazarlar)){ ?>
			<tr>
				<td><?php e($ya['adi']) ?></td>
				<td><?php e($ya['soyadi']) ?></td>
				<td><input type="checkbox" class="uyeOnay" id="<?php e($ya['id']) ?>" value="1" <?php if($ya['y']=="1") { ?> checked<?php } ?> /></td>
				<td>
				<select name="" class="uyesira" tablo="deger" s_alan="deger" s_kriter="<?php e($ya['id']) ?>">
					<?php for($k=1;$k<30;$k++) { ?>
						<option value="<?php e($k) ?>"<?php if($ya['s']==$k) { ?> selected="selected"<?php } ?>><?php e($k) ?></option>
					<?php } ?>
				</select>
				</td>
			</tr>
		<?php } ?>
		</tbody>
		</table>
	</div>
	-->
</div>
<script type="text/javascript">
<!--
//var sprytextfield1 = new Spry.Widget.ValidationTextField("alan", "custom", {useCharacterMasking:true, pattern:"00:00"});
<?php spryDesen("alan","00000");?>
</script>
</body>
</html>