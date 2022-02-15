<?php include("pfi-yonetici-yetki.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ürünler ve Kategorileri</title>
<?php 
include("pfiy-he-in.php");
	//formee
	js($betik . "formee/js/formee.js") . _js();
	linkCss($betik . "formee/css/formee-structure.css");
	linkCss($betik . "formee/css/formee-style.css");
linkCss($betik."plupload/js/jquery.ui.plupload/css/jquery.ui.plupload.css");
?>
<script type="text/javascript" src="<?php echo $betik."plupload/" ?>js/plupload.js"></script>
<script type="text/javascript" src="<?php echo $betik."plupload/" ?>js/plupload.html4.js"></script>
<script type="text/javascript" src="<?php echo $betik."plupload/" ?>js/plupload.flash.js"></script>
<script type="text/javascript" src="<?php echo $betik."plupload/" ?>js/plupload.browserplus.js"></script>
<script type="text/javascript" src="<?php echo $betik."plupload/" ?>js/plupload.html5.js"></script>
<script type="text/javascript" src="<?php echo $betik."plupload/" ?>js/plupload.browserplus.js"></script>
<script type="text/javascript" src="<?php echo $betik."plupload/" ?>js/plupload.silverlight.js"></script>
<script type="text/javascript" src="<?php echo $betik."plupload/" ?>js/jquery.ui.plupload/jquery.ui.plupload.js"></script>
<script type="text/javascript">
$(function(){
	$(".icerik li img").error(function(){
		$(this).attr("src","resimler/dock/31.png");
	});
});
</script>
</head>

<body>
		
<div class="sekme">
	<ul>
    	<li><a href="#kategoriler">Ürün Kategorileri</a></li>
    	<li><a href="#kategoriEkle">Kategori Ekle</a></li>
		<?php if(isset($_GET['kid'])) { 
		$kategori = kd(ksorgu("urun_kategori",sprintf("WHERE id = %s",veri(get("kid")))));
		?>
		<li><a href="#kategoriDetay"><?php e($kategori['isim']) ?> Kategorisi Ürünleri</a></li>
		<?php } ?>
    </ul>
    <div class="icerik" id="kategoriler">
<?php 
$kategoriler = kSorgu("urun_kategori","WHERE ust IS NULL");
?>

		<h2>Ana Ürün Kategorileri</h2>
        <?php if($kategoriler==0) { 
				bilgi("Henüz ekli bir kategori bulunmadı");
			} else { ?>
        <ul>
        <?php while ($e = kd($kategoriler)) { ?>
			<li id="l<?php echo $e['id']; ?>"><?php echo resim_png("resimler/urunler/" . $e['logo'],"128"); ?><a href="?kid=<?php echo $e['id']; ?>#kategoriDetay"><?php echo $e['isim']; ?></a>
            <?php $urunsayi = toplam("urunler",sprintf("kid IN (%s)",veri(tkid($e['id'],1))));
			if($urunsayi==0) {
			?>
			<sil yazi="<?php printf("%s kategorisini silmek istediğinizden emin misiniz?",$e['isim']) ?>" url="<?php echo $via ?>urunIslem=kategoriSil&id=<?php echo $e['id']; ?>&img=<?php echo $e['logo']; ?>" ajax="#l<?php echo $e['id']; ?>"><?php echo resim("resimler/ikon/sil.png"); ?></sil>
            <?php } ?>
			<sayi><?php e($urunsayi) ?></sayi>
			</li>        
        <?php } ?>
        </ul>
        <?php } ?>
    </div>
    <div id="kategoriEkle">
        <form id="ekle" name="ekle" method="post" action="<?php echo $via ?>urunIslem=kategoriEkle" enctype="multipart/form-data">
        <fieldset>
            <legend>Kategori Formu</legend>
            <ul>
                <li><label>İsim</label><span id="isim"><input type="text" name="isim" id="isim" required /></span></li>
                <li><label>Logo</label><input type="file" name="logo" id="logo" /></li>
				<li><label for="ust">Üst Kategori</label>
				<?php $kategoriler = ksorgu("urun_kategori"); ?>
					<select name="ust" id="">
						<option value="" selected>Kategori Yok</option>
					<?php while($k = kd($kategoriler)) : ?>
						<option value="<?php e($k['id']) ?>"><?php e($k['isim']) ?></option>
					<?php endwhile; ?>
					</select></li>
                <li><label>Açıklama</label><textarea name="aciklama" id="aciklama" cols="45" rows="5"></textarea></li>
         		<li class="submit"><input name="" type="submit" value="Gönder" /></li>
           </ul>
           </fieldset>
         </form> 
    </div>
		<?php if(isset($_GET['kid'])) {  ?>
	<div id="kategoriDetay">
		<div class="sekme">
			<ul>
			<?php if(isset($_GET['uid'])) { 
			$urun = kd(ksorgu("urunler",sprintf("WHERE id = %s",veri(get("uid")))));
			?>
				<li><a href="#urunDetay"><?php echo kelime($urun['isim'],3) ?></a></li>
			<?php } ?>
				<li><a href="#urunler"><?php e($kategori['isim']) ?> Ürünleri</a></li>
				<li><a href="#urun">Yeni Ürün Ekle</a></li>
				<li><a href="#ukategori"><?php e($kategori['isim']) ?> Kategorisinin Bilgilerini Değiştir</a></li>
			</ul>
			<?php  if(isset($_GET['uid'])) {  ?>
			<div id="urunDetay">
				<form method="post" action="<?php echo $via ?>urunIslem=urunGuncelle&y=pfiy-urunler.php?kid=<?php e(get("kid")); ?>#kategoriDetay" enctype="multipart/form-data">
				<fieldset>
					<legend><?php echo $urun['isim'] ?> Ürününü Düzenle</legend>
					<ul>
						<li><?php e(resim("resimler/urunler/" . $urun['resim'],"128")); ?></li>
						<li><label>Ürün Kodu</label><input class="ajaxDuzenle" tablo="urunler" d_alan="kod" s_alan="id" s_kriter="<?php e($urun['id']) ?>" value="<?php e($urun['kod']) ?>" type="text" name="ukod" id="ukod" /></li>
						<li><label>Ürün Adı</label><input class="ajaxDuzenle" tablo="urunler" d_alan="isim" s_alan="id" s_kriter="<?php e($urun['id']) ?>" value="<?php e($urun['isim']) ?>" type="text" name="uisim" id="uisim" /></li>
						<li><label>Ürün Resmi</label><input type="file" name="uresim" id="uresim" /></li>
						<li><label>Açıklama</label><textarea placeholder="Satır satır yazın" class="ajaxDuzenle meditor" tablo="urunler" d_alan="aciklama" s_alan="id" s_kriter="<?php e($urun['id']) ?>" value="<?php e($urun['aciklama']) ?>" name="uaciklama" id="uaciklama" cols="45" rows="5"><?php e($urun['aciklama']) ?></textarea></li>
						<li><label>Video</label><textarea placeholder="iframe kodunu kopyalayın" class="ajaxDuzenle" tablo="urunler" d_alan="video" s_alan="id" s_kriter="<?php e($urun['id']) ?>" value="<?php e($urun['video']) ?>" name="uvideo" id="uvideo" cols="45" rows="5"><?php e($urun['aciklama']) ?></textarea></li>
						<li><label>Eski Fiyat</label><input class="ajaxDuzenle" tablo="urunler" d_alan="efiyat" s_alan="id" s_kriter="<?php e($urun['id']) ?>" value="<?php e($urun['efiyat']) ?>" type="text" name="uefiyat" id="uefiyat" /></li>
						<li><label>Bayi Fiyatı</label><input class="ajaxDuzenle" tablo="urunler" d_alan="bfiyat" s_alan="id" s_kriter="<?php e($urun['id']) ?>" value="<?php e($urun['bfiyat']) ?>" type="text" name="uefiyat" id="uefiyat" /></li>
						<li><label>Fiyatı</label><input class="ajaxDuzenle" tablo="urunler" d_alan="fiyat" s_alan="id" s_kriter="<?php e($urun['id']) ?>" value="<?php e($urun['fiyat']) ?>" type="text" name="uefiyat" id="uefiyat" /></li>
						<li><input class="ajaxDuzenle" tablo="urunler" d_alan="fiyat" s_alan="id" s_kriter="<?php e($urun['id']) ?>" value="<?php e($urun['fiyat']) ?>" type="hidden" name="ufiyat" id="ufiyat" /></li>
						<li class="submit"><input name="" type="submit" value="Ürün Bilgilerini Güncelle" /></li>
						<input type="hidden" name="kid" value="<?php e($kategori['id']) ?>" />
						<input type="hidden" name="id" value="<?php e($urun['id']) ?>" />
				   </ul>
				   </fieldset>
				   <fieldset>
				   	<legend>Ürün Özellikleri</legend>
					<?php
					$kid = $urun['kid'];
					$ozellik = kd(ksorgu("urun_kategori","WHERE id = $kid")); 
						if($ozellik['ozellik']!="") :
						$oz = explode(",",$ozellik['ozellik']);
						?>
						<table class="tablesorter" cellpadding=0 cellspacing=0>

							<tbody>
							<?php foreach($oz AS $deger) : ?>
								<tr>
									<td width="50%" style="text-align:right;"><?php e($deger) ?>:</td>
									<td><input
									class="ajaxDuzenle" 
									tablo="urun_detay" 
									d_alan="<?php e($deger) ?>" 
									s_alan="" 
									s_kriter="<?php e($urun['id']) ?>"
									value="<?php e(urun_ozellik($deger,$urun['id'])); ?>" 
									type="text" name="" id="" /></td>
								</tr>
							<?php endforeach; ?>
							</tbody>
						</table>
						<?php
						endif;
					?>
				   </fieldset>
					<fieldset>
						<legend>Ürün Detay Resimleri</legend>
						<a class="dugme" onclick="$('#uploader2').toggle();"><div class="fa fa-plus"></div> Bu ürüne yeni resim ekle</a>
						<div id="uploader2" <?php gizle() ?>></div>
						<div class="icerik">
<?php 
$urun_id = veri(get("uid"));
$dresim = kSorgu("urun_detay","WHERE urun_id=$urun_id");
?>

        <?php if($dresim==0) { 
				bilgi("Henüz ekli bir detay resmi bulunmadı");
			} else { ?>
		<h2>Mevcut Resimler</h2>
        <ul>
        <?php while ($e = kd($dresim)) { ?>
			<li id="l<?php echo $e['id']; ?>"><?php echo resim_png("resimler/urunler/" . $e['deger'],"128"); ?>
			<sil yazi="<?php e("resmi silmek istediğinizden emin misiniz?"); ?>" url="<?php echo $via ?>urunIslem=detayResimSil&id=<?php echo $e['id']; ?>&img=<?php echo $e['deger']; ?>" ajax="#l<?php echo $e['id']; ?>"><?php echo resim("resimler/ikon/sil.png"); ?></sil>
			</li>        
        <?php } ?>
        </ul>
        <?php } ?>							
						</div>
					</fieldset>
				  
				 </form> 
			
			</div>
			<?php } ?>
			<div id="urunler">
						

			<script type="text/javascript">
            // Convert divs to queue widgets when the DOM is ready
            $(function() {
               
				$("#uploader").plupload({
                    // General settings
                    runtimes : 'silverlight,flash',
                    url : 'pfi-bvi-yonga.php?galeriIslem=urunEkle',
                    max_file_size : '100mb',
                    max_file_count: 500, // user can add no more then 20 files at a time
                    unique_names : true,
                    multiple_queues : true,
            
                    // Rename files by clicking on their titles
                    rename: true,
                    
                    // Sort files
                    sortable: true,
					multipart_params: { 
						'kid': '<?php e(get("kid")); ?>',
						'uid': '<?php e(oturum("uid")) ?>',
						'user': '<?php e(oturum("pFiUser")) ?>',
						'imza' : '<?php e(kripto($imza.oturum("uid"))); ?>'
					},
                    // Specify what files to browse for
                    filters : [
                        {title : "Resim Türleri", extensions : "jpg,png,gif"}
                    ],
            
                    // Flash settings
                    flash_swf_url : '<?php echo $betik."plupload/" ?>js/plupload.flash.swf',
            
                    // Silverlight settings
                    silverlight_xap_url : '<?php echo $betik."plupload/" ?>js/plupload.silverlight.xap'
                });
				$("#uploader2").plupload({
                    // General settings
                    runtimes : 'silverlight,flash',
                    url : 'pfi-bvi-yonga.php?galeriIslem=urunResimEkle',
                    max_file_size : '100mb',
                    max_file_count: 500, // user can add no more then 20 files at a time
                    unique_names : true,
                    multiple_queues : true,
            
                    // Rename files by clicking on their titles
                    rename: true,
                    
                    // Sort files
                    sortable: true,
					multipart_params: { 
						'kid': '<?php e(get("kid")); ?>',
						'uid': '<?php e(oturum("uid")) ?>',
						'user': '<?php e(oturum("pFiUser")) ?>',
						'urun_id': '<?php e(get("uid")) ?>',
						'imza' : '<?php e(kripto($imza.oturum("uid"))); ?>'
						
					},
                    // Specify what files to browse for
                    filters : [
                        {title : "Resim Türleri", extensions : "jpg,png,gif"}
                    ],
            
                    // Flash settings
                    flash_swf_url : '<?php echo $betik."plupload/" ?>js/plupload.flash.swf',
            
                    // Silverlight settings
                    silverlight_xap_url : '<?php echo $betik."plupload/" ?>js/plupload.silverlight.xap'
                });
            
               
            
            });
            </script>
<?php 
$kid = veri(get("kid"));
$kategoriler = kSorgu("urun_kategori","WHERE ust = $kid");
$tkid = tkid($kid);
?>
<div class="icerik">
	
	<?php echo hiyerarsi($kid); ?>
	<?php if($kategori['ust']!="") : ?>
		<a href="pfiy-urunler.php?kid=<?php e($kategori['ust']) ?>#kategoriDetay" class="dugme"><i class="fa fa-arrow-circle-up"></i> Üst Kategori</a>
	<?php endif; ?>
   			 <hr />
     <?php if($kategoriler!=0) { 
			 ?>		
			 <h2>Alt Ürün Kategorileri</h2>

        <ul>
        <?php while ($e = kd($kategoriler)) {

		?>
		
			<li id="l<?php echo $e['id']; ?>"><?php echo resim_png("resimler/urunler/" . $e['logo'],"128"); ?><a href="?kid=<?php echo $e['id']; ?>#kategoriDetay"><?php echo $e['isim']; ?></a>
            <?php 
			$bkid = tkid(veri($e['id']));
			$us = toplam("urunler","kid IN ($bkid)");
			if($us==0) {
			?>
			<sil yazi="<?php printf("%s kategorisini silmek istediğinizden emin misiniz?",$e['isim']) ?>" url="<?php echo $via ?>urunIslem=kategoriSil&id=<?php echo $e['id']; ?>&img=<?php echo $e['logo']; ?>" ajax="#l<?php echo $e['id']; ?>"><?php echo resim("resimler/ikon/sil.png"); ?></sil>
            <?php } ?>
			<sayi><?php e($us) ?></sayi>
			</li>        
        <?php } ?>
        </ul>
        <?php } ?>
</div>
			<h1 class="dugme" onclick="$('#uploader').toggle();"><i class="fa fa-plus"></i> Yeni Ürün(ler) Ekle</h1>
			<div id="uploader" style="display:none;"></div>
			<?php 
			$urunler = ksorgu("urunler","WHERE kid IN ($tkid) ORDER BY id DESC LIMIT 0,100"); 
			if($urunler!=0) {
				bilgi("Bu kategoride (alt kategorilerdeki dahil) " . toplam("urunler","kid IN ($tkid)") . " adet ürün mevcut");
			?>
			<h1>Son eklenen ürünler</h1>
				<table class="tablesorter" cellpadding="0" cellspacing="0">
					<thead>
						<tr>
							<th width="10">Sıra</th>
							<th width="20">Resim</th>
							<th width=200>İsim (veya Kod)</th>
							<th width="32">İşlem</th>
						</tr>
					</thead>
					<script type="text/javascript">
					$(function(){
						$("tr input").blur(function(){
							var p = $(this).parent().parent().children("td");
							var kdv = eval(p.children(".kdv").val());
							var iskonto = eval(p.children(".iskonto").val());
							var ilkfiyat = eval(p.children(".ilkfiyat").val());
							p.children(".fiyat").val(Math.round(ilkfiyat + ilkfiyat*kdv/100 - ilkfiyat*iskonto/100));
							p.children(".efiyat").val(Math.round(ilkfiyat + ilkfiyat*kdv/100));
						});
					});
					</script>
					<tbody>
					<?php 
					while($u = kd($urunler)) {
					?>
						<tr id="a<?php echo $u['id'] ?>">
							<td><input type="number" id="gbaslik" class="ajaxDuzenle" tablo="urunler" debug="" s_alan="id" d_alan="kod" s_kriter="<?php e($u['id']) ?>" value="<?php e($u['kod']) ?>" /></td>
							<td><?php e(resim('resimler/urunler/' . $u["resim"],64)) ?></td>
							<td><input type="text" id="gbaslik" class="ajaxDuzenle" tablo="urunler" s_alan="id" d_alan="isim" s_kriter="<?php e($u['id']) ?>" value="<?php e($u['isim']) ?>" /></td>
							<td>
							<a title="Ürünün bilgilerini detaylı güncelleyin" href="?uid=<?php e($u['id']) ?>&kid=<?php e($u['kid']) ?>#kategoriDetay"><i class="fa fa-refresh"></i></a>
							<a title="Ürünü kalıcı olarak silin" href="<?php echo $via ?>urunIslem=urunSil&id=<?php e($u['id']) ?>&resim=<?php e($u['resim']) ?>" ajax="#a<?php e($u['id']) ?>" teyit="<?php e($u['isim']) ?> isimli ürünü sistemden kaldırmak istediğinizden emin misiniz?"><i class="fa fa-times-circle"></i></a></td>
						</tr>
					<?php } ?>
					</tbody>
				</table>
			<?php } else {
				bilgi("Bu kategoriye hiç ürün eklenmemiş");
			} ?>
			</div>
			<div id="urun">
				<form method="post" action="<?php echo $via ?>urunIslem=urunEkle&y=<?php echo $_SERVER['REQUEST_URI']; ?>#kategoriDetay" enctype="multipart/form-data">
				<fieldset>
					<legend><?php e($kategori['isim']) ?> Kategorisine Yeni Ürün Ekle</legend>
					<ul>
						<li><label>Ürün Kodu</label><input type="text" name="ukod" id="ukod" required /></li>
						<li><label>Ürün Adı</label><input type="text" name="uisim" id="uisim" required /></li>
						<li><label>Ürün Resmi</label><input type="file" name="uresim" id="uresim" /></li>
						<li><label>Miktar Türleri</label><textarea placeholder="Satır satır yazın" name="uaciklama" id="uaciklama" cols="45" rows="5"><?php e($kategori['aciklama']) ?></textarea></li>
						<li><label>Kısa Açıklama</label><input type="text" value="" name="uefiyat" id="uefiyat" /></li>
						<li><input type="hidden" value=""  name="ufiyat" id="ufiyat"  /></li>
						<li class="submit"><input name="" type="submit" value="Ürün Ekle" /></li>
						<input type="hidden" name="kid" value="<?php e($kategori['id']) ?>" />
				   </ul>
				   </fieldset>
				 </form> 
			</div>
			<div id="ukategori">
				<form method="post" action="<?php echo $via ?>urunIslem=kategoriGuncelle&y=<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data">
				<fieldset>
					<legend><?php e($kategori['isim']) ?> Kategorisinin Bilgilerini Değiştir</legend>
					<ul>
						<li><label>İsim</label><span id="isim"><input class="ajaxDuzenle" tablo="urun_kategori" d_alan="isim" s_alan="id" s_kriter="<?php e($kategori['id']); ?>" value="<?php e($kategori['isim']) ?>" type="text" name="isim" id="isim" required /></span></li>
						<li><label>Logo (Değiştirmek istemiyorsanız boş bırakın)</label><input type="file" name="glogo" id="glogo" /></li>
						<li><label>Açıklama</label><textarea class="ajaxDuzenle" tablo="urun_kategori" d_alan="aciklama" s_alan="id" s_kriter="<?php e($kategori['id']); ?>" name="aciklama" id="aciklama" cols="45" rows="5" required><?php e($kategori['aciklama']) ?></textarea></li>
						<li><label>Görünürlük</label>
							<select name="" class="ajaxDuzenle" tablo="urun_kategori" d_alan="ozellik" s_alan="id" s_kriter="<?php e($kategori['id']); ?>" id="">
								<option value="" selected>Gizli</option>
								<option value="herkes" <?php if($kategori['ozellik']=="herkes") e("selected"); ?>>Herkese Görünsün</option>
							</select>
						</li>
						<li class="submit"><input name="" type="submit" value="Yalnızca Logoyu Güncelle" /></li>
						<li><?php e(resim("resimler/urunler/" . $kategori['logo'])); ?></li>
						<input type="hidden" name="eskiresim" value="<?php e($kategori['logo']) ?>" />
						<input type="hidden" name="id" value="<?php e($kategori['id']) ?>" />
				   </ul>
				</fieldset>
				</form> 
			</div>
		</div>
		 
	</div>
	<?php } ?>
</div>
<script type="text/javascript">
<!--
//var sprytextfield1 = new Spry.Widget.ValidationTextField("alan", "custom", {useCharacterMasking:true, pattern:"00:00"});
<?php //spryDesen("alan","00000"); ?>
</script>
</body>
</html>