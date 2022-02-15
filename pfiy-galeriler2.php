<?php include("pfi-yonetici-yetki.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php dile(7) ?></title>
<?php 
include("pfiy-he-in.php");
yukle_head('pfi-bvi-yonga.php?galeriIslem=dosyaYukle', $gk['tur'], $gk['turAciklama'])

?>

</head>

<body>
<div class="sekme">
	<ul>
    	<li><a href="#galeriler"><?php dile(7) ?></a></li>
    	<li><a href="#yeniForm"><?php dile(33)?></a></li>
    	<?php if (isset($_GET['gid'])) { ?>
		<?php 
            $galerine = kSorgu("galerikategori",
                               sprintf("WHERE id = %s",
                                       veri($_GET['gid'])
                                       )
                               );
            $gk = kd($galerine);
        ?>
        <li><a href="#galeriDetay"><?php echo $gk['isim'];  ?> <?php dile(40)?></a></li><?php } ?>
    </ul>
    <div class="icerik" id="galeriler">
<?php
$galeri = kSorgu("galerikategori");
?>
		<h2><?php dile(7) ?></h2>
        <?php if($galeri==0) { ?>
        <?php bilgi(dil(39)) ?>
        <?php } else { 
		?>
        <ul>
        <?php while ($g = kd($galeri)) { ?>
			<li id="l<?php echo $g['id']; ?>" yazi="<?php printf(dil(37),$g['isim']) ?>" url="<?php echo $via ?>galeriIslem=sil&id=<?php echo $g['id']; ?>" ajax="#l<?php echo $g['id']; ?>" duzenle="?gid=<?php echo $g['id']; ?>#galeriDetay"><?php echo resim("resimler/dock/07.png"); ?><a href="?gid=<?php echo $g['id']; ?>#galeriDetay"><?php echo $g['isim']; ?></a>
            <sil yazi="<?php printf(dil(37),$g['isim']) ?>" url="<?php echo $via ?>galeriIslem=sil&id=<?php echo $g['id']; ?>" ajax="#l<?php echo $g['id']; ?>"><?php echo resim("resimler/ikon/sil.png"); ?></sil>
			<sayi><?php echo toplam("galeriicerik",
			sprintf("gid = %s",$g['id'])); ?></sayi>
            <yayin deger="<?php echo $g['y']; ?>" id="<?php echo $g['id']?>" tur="galeri" ><?php if ($g['y']==1) { echo resim($img . "ikon/y.png"); } else { echo resim($img . "ikon/yd.png"); }?></yayin>
            </li>        
        <?php } ?>
        </ul>
        <?php } ?>
    </div>
    <div id="yeniForm">
        <form id="ekle" name="ekle" method="post" action="<?php echo $via ?>galeriIslem=ekle&y=<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data">
        <fieldset>
            <legend><?php dile(33)?></legend>
            <ul>
                <li><label><?php dile(34)?></label><input type="text" name="isim" id="isim" required /></li>
                <li><label><?php dile(35)?></label><input type="text" name="tur" id="tur" value="jpg,png,gif" required /></li>
                <li><label><?php dile(42)?></label><input type="text" name="turAciklama" id="turAciklama" value="Resim Türleri" required /></li>
         		<li class="submit"><input name="" type="submit" value="<?php dile(36)?>" /></li>
           </ul>
           </fieldset>
         </form> 
    </div>
<?php if (isset($_GET['gid'])) { ?>
    <div id="galeriDetay">
        <form id="guncelle" name="guncelle" method="post" action="<?php echo $via ?>galeriIslem=guncelle&y=<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data">
        <fieldset>
            <legend><?php echo $gk['isim']; ?> <?php dile(40)?></legend>
            <ul>
                <li><label><?php dile(34)?></label><input type="text" name="gisim" id="gisim" value="<?php echo $gk['isim']; ?>" required /></li>
                <li><label><?php dile(35)?></label><input type="text" name="gtur" id="gtur" value="<?php echo $gk['tur']; ?>" required /></li>
                <li><label><?php dile(42)?></label><input type="text" name="gturAciklama" id="gturAciklama" value="<?php echo $gk['turAciklama']; ?>" required /></li>
         		<li class="submit"><input name="" type="submit" value="<?php dile(41)?>" /></li>
           </ul>
           </fieldset>
               <input type="hidden" name="id" value="<?php echo get("gid"); ?>" />

         </form> 
            <form  method="post" id="yukle" action="pfi-bvi-yonga.php?galeriIslem=dosyaYukle">
                <div id="uploader">
                    <p>Tarayıcınızın flash yazılımını güncelleyin</p>
                </div>
				<?php input("hidden","gid",get("gid")); ?>
				<?php input("hidden","user",oturum("pFiUser")); ?>
				<?php input("hidden","uid",oturum("uid")); ?>
            </form>
			<script type="text/javascript">
            // Convert divs to queue widgets when the DOM is ready
            $(function() {
               
				$("#uploader").plupload({
                    // General settings
                    runtimes : 'silverlight,flash',
                    url : 'pfi-bvi-yonga.php?galeriIslem=dosyaYukle',
                    max_file_size : '100mb',
                    max_file_count: 100, // user can add no more then 20 files at a time
                    unique_names : true,
                    multiple_queues : true,
            
                    // Rename files by clicking on their titles
                    rename: true,
                    
                    // Sort files
                    sortable: true,
					multipart_params: { 
						'gid': $('#gid').val(),
						'uid': $('#uid').val(),
						'user': $('#user').val()
					},
                    // Specify what files to browse for
                    filters : [
                        {title : "<?php echo $gk['turAciklama']; ?>", extensions : "<?php echo $gk['tur']; ?>"}
                    ],
            
                    // Flash settings
                    flash_swf_url : '<?php echo $betik."plupload/" ?>js/plupload.flash.swf',
            
                    // Silverlight settings
                    silverlight_xap_url : '<?php echo $betik."plupload/" ?>js/plupload.silverlight.xap'
                });
            
                // Client side form validation
                $('form#yukle').submit(function(e) {
				alert("sda");
                    var uploader = $('#uploader').plupload('getUploader');
            
                    // Files in queue upload them first
                    if (uploader.files.length > 0) {
					alert(uploader.files.length)
                        // When all files are uploaded submit form
                        uploader.bind('StateChanged', function() {
                            if (uploader.files.length === (uploader.total.uploaded + uploader.total.failed)) {
                                $('form#yukle')[0].submit();
								alert("tamam");
                            }
                        });
                            
                        uploader.start();
                    } else  {
                        alert('<?php dile(44) ?>');
            
                    return false;
					}
                });
                 
            
            });
            </script>
			<div class="icerik">
			<?php 
			$icerikler = kSorgu("galeriicerik",
				sprintf("WHERE gid = %s",
					veri(get("gid"))
				)
				);
			
			?>
				<ul>
				<?php while($i = kd($icerikler)) { ?>
					<li id="i<?php echo $i['id']; ?>" yazi="<?php dile(43) ?>" url="<?php echo $via ?>galeriIslem=icerikSil&id=<?php echo $i['id']; ?>&resim=<?php echo $i['url']; ?>" ajax="#i<?php echo $i['id']; ?>"><?php if ($gk['tur']=="jpg,png,gif") { ?><?php echo resim("pfi-galeri-icerik/" . $i['url'],"200"); ?><?php } else { ?><?php echo resim($img . "dock/07.png"); ?><a href="#"><?php echo $i['url']; ?></a><?php } ?>
            <sil yazi="<?php dile(43) ?>" url="<?php echo $via ?>galeriIslem=icerikSil&id=<?php echo $i['id']; ?>&resim=<?php echo $i['url']; ?>" ajax="#i<?php echo $i['id']; ?>"><?php echo resim("resimler/ikon/sil.png"); ?></sil>
 </li>
				<?php } ?>
				</ul>
			</div>
    </div>
<?php } ?>
</div>
</body>
</html>