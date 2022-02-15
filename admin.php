<link rel="stylesheet" href="tema/truncgil.blok.css" />
<script type="text/javascript">
$(function(){
	function alert(title) {
		$("<div></div>").html(title).dialog({
			modal:true
			
		});
		return false;
	}
	$(".butonset").buttonset();
	$(".butonlar").sortable({
					stop : function(e,u) {
						var k="";
						$(".butonlar li").each(function(a){
							$.post("?sira",{
								"id" : $(this).data("id"),
								"index": $(this).index()
							},function(d){
								//alert(d);
							});		
						});
						
					}
				});
	$("#title").blur(function(){
		
		$.post("?slug",{
			deger : $(this).val()
		},function(d){
			
			$("#slug").val(d.trim());
		});
		
	});

	$("#slugguncelle").click(function(){
		
		$.post("?slug",{
			deger : $("#title2").val()
		},function(d){
			
			$("#slug2").val(d.trim());
		});
		
	});
	$(".autocomplete").autocomplete({
		source :"?autocomplete",
		minLength: 2
	});
	function imgerror(){
		$( "img" ).error(function() {
			$( this ).hide();
		});
	}
	$(".google").keydown(function(e){
		if(e.keyCode==13) {
			$(".googleSonuc").html('<img src="loading.gif" style="border:none;box-shadow:none;opacity:1;top:0" alt="" />');
			
			$(".googleSonuc").load("?googleSonuc="+encodeURIComponent($(this).val()));
			
			imgerror();
		}
	});
	$("#ustmenu .window").click(function(){
				var isim = $(this).text();
				var site = $(this).attr("href");
					   $.window({
						   title: isim,
						   url: site,
						   content: $("#penIcerik"),
						   showRoundCorner: true,
						   top:0,
						   width: 700,
						   height: 465
						});
				return false;
				});
	$("#ustmenu").buttonset();
	//$(".googleSonuc").sortable();
	
});
</script>
<script language="javascript" type="text/javascript" src="tema/editarea/edit_area/edit_area_full.js"></script>
<script language="javascript" type="text/javascript">
editAreaLoader.init({
	id : "code"		// textarea id
	,syntax: "php"			// syntax to be uses for highgliting
	,start_highlight: true		// to display with highlight mode on start-up
});
editAreaLoader.init({
	id : "code2"		// textarea id
	,syntax: "php"			// syntax to be uses for highgliting
	,start_highlight: true		// to display with highlight mode on start-up
});
</script>
<?php 
			if(getisset("kid")) {
				$kid = veri(get("kid"));
				$kid2 = veri(get("kid"));
				$kid = "kid=$kid";
				$kat = kd(ksorgu("content","WHERE slug=$kid2"));
				
				$title = "{$kat['title']} kategorisine yeni içerik ekle";
				$title2 = "{$kat['title']} kategorisindeki sorular";
			} else {
				$kid = "kid IS NULL";
				$title="Yeni içerik ekle";
				$title2="";
			}
			$content = ksorgu("content","WHERE $kid ORDER BY s ASC"); 
			?>
<img id="pelinom" src="logo.png" alt="" />
<div id="ustmenu">
		<a href="#" class="dugme" onclick="$('#googleAlan').slideToggle('slow')"><i class="fa fa-file-image-o"></i>Görsel Ara</a>
		<a href="betikler/elfinder2/elfinder.php" class="dugme window"><i class="fa fa-folder"></i> Erzak Deposu</a>
		<a href="pfiy-galeriler.php" class="dugme window"><i class="fa fa-picture-o"></i> Galeriler</a>
		<a href="pfiy-profil-ayar.php" class="dugme window"><i class="fa fa-cogs"></i> Site Ayarları</a>
		<a href="pfiy-profil-ayar.php" class="dugme window"><i class="fa fa-user"></i> Kişisel Bilgiler</a>
		<a href="hakems.php" class="dugme window"><i class="fa fa-graduation-cap"></i> Hakemler</a>
		<a href="pfiy-uyeler.php" class="dugme window"><i class="fa fa-user"></i> Üyeler</a>
		<a href="index" class="dugme" target="_blank"><i class="fa fa-level-up"></i> Siteye Dön</a>
		<a href="?cikis=1" teyit="Çıkmak istediğinizden emin misiniz?" class="dugme"><i class="fa fa-sign-out"></i> Güvenli Çıkış</a>
		
</div>
<div id="googleAlan" <?php gizle(); ?>>
			<input type="search" placeholder="Arayacağınız görselin kelimelerini buraya giriniz" name="" class="google" />
			<div class="googleSonuc"></div>
</div>
<div id="admin">
	<div class="sekme">
		<ul>
			<li><a href="#icerik"><i class="fa fa-list-alt"></i>İçerikler</a></li>
			<li><a href="#yeniForm"><i class="fa fa-plus-square"></i><?php e($title) ?></a></li>
			<?php if(getisset("kid")) { ?><li><a href="#sorular"><i class="fa fa-question-circle"></i><?php e($title2) ?></a></li><?php } ?>
		</ul>
		<div class="icerik" id="icerik">
		
	<?php if(getisset("kid")) echo hiyerarsi(get("kid")) ; ?>
	
	<?php if(getisset("kid")) { ?>
		<h1 style="margin-top:10px"><?php e($kat['title']) ?> İçerikleri</h1>
	<?php } else { ?>
		<h1 style="margin-top:10px">Ana İçerikler</h1>
	<?php } ?>
	
			<ul class="butonlar">
			
			
			<?php while($c = kd($content)) { ?>
				<li id="c<?php e($c['id']) ?>" slug="<?php e($c['slug']) ?>" duzenle="?kid=<?php e($c['slug']) ?>" data-id="<?php e($c['id']) ?>" isim="Title" site="?kid=<?php e($c['slug']) ?>">
				<?php if($c['pic']!="") { ?><img src="r.php?p=file/<?php echo $c['pic'] ?>&w=128" alt="" /><?php } else { ?> <img src="tema/img/zomni128.jpg" alt="" /><?php } ?>
				<a href="?kid=<?php e($c['slug']) ?>"><?php e($c['title']); ?></a>
				<sayi>
				<?php 
				$total_soru = toplam("soru","tip='soru' AND kat='{$c['slug']}'"); 
				$total_kat = toplam("content","kid='{$c['slug']}'"); 
				$geneltoplam=$total_kat + $total_soru;
				e("$geneltoplam");
				?>
				</sayi>
				<?php if($geneltoplam==0) { ?><sil yazi="<?php e($c['title']); ?> silmek istediğinizden emin misiniz?" url="?sil=<?php e($c['id']) ?>" ajax="#c<?php e($c['id']) ?>"><?php echo resim("resimler/ikon/sil.png"); ?></sil><?php } ?>
				<yayin deger="<?php echo $c['y']; ?>" id="<?php echo $c['id']?>" tur="content" ><?php if ($c['y']==1) { echo resim($img . "ikon/y.png"); } else { echo resim($img . "ikon/yd.png"); }?></yayin>
				</li>        
			<?php } ?>
			</ul>
		</div>
		<div id="yeniForm">
		
		<?php if(getisset("kid")) { ?>
			<a href="#" onclick="$('#bilgiler').slideToggle('slow');$('#yeniekle').slideToggle('slow')"  class="dugme"><i class="fa fa-refresh"></i> <?php e($kat['title']) ?> bilgilerini düzenle</a>
				Diğerleri: 
				<?php $diger = contents($kat['kid'],"AND id<>{$kat['id']}"); ?>
				<?php while($d = kd($diger)) { ?>
					<a href="?kid=<?php e($d['slug']) ?>&guncelle2#yeniForm" class="dugme"><?php e($d['title']) ?></a>
				<?php } ?>
			<div id="bilgiler" <?php if(!getisset("guncelle2")) { gizle(); } ?>>
				<form id="guncelle"  name="guncelle" method="post" action="?guncelle=<?php e(get("kid")) ?>" enctype="multipart/form-data">
			<fieldset style="  float: left;
  width: 70%;">
				<legend>Bilgileri Güncelle</legend>
				<div style="float: right;">
				
				<?php if($kat['pic']!="") {
					?>
					<a href="#" onclick="$('#pic').slideToggle();" class="dugme"><i class="fa fa-image"></i> Eklenen Resmi Göster</a>
					<clear></clear>
					<img id="pic" style=" max-width: 300px;display:none;" src="file/<?php e($kat['pic']) ?>" alt="" />
				</div>	
					<?php
				} ?>
				<clear></clear>
				<ul>
				
					<li><label>Başlık</label><span id="alan"><input type="text" id="title2" value="<?php e(strip_tags($kat['title'])) ?>" name="title"  required /></span></li>
					<li><label>Takma Ad: <a href="#" id="slugguncelle" class="dugme"><i class="fa fa-refresh"></i></a></label><span id="alan"><input type="text" value="<?php e($kat['slug']) ?>" name="slug" id="slug2"  required /></span></li>
					<li><label>Görsel</label><input type="file" name="pic" /></li>
					<li><label>Galeri Adı:</label><span id="alan"><input class="autocomplete" type="text"  value="<?php e($kat['galeri']) ?>" name="galeri" /></span></li>
					<li><label>Üst Kategori</label><span id="alan"><input type="text" name="kid"  value="<?php e($kat['kid']) ?>" /></span></li>
					<!--<li style="width:97%;"><label>Kod (PHP)</label><textarea name="code" id="code" style=" width: 100%;
  height: 300px;
  clear: both;
  font-family: monospace;
  font-size: 17px;
  color: rgb(218, 21, 21);"><?php e($kat['code']) ?></textarea></li>-->
					<li><label>İçerik</label><textarea name="html" class="meditor" cols="45" rows="5"><?php e($kat['html']) ?></textarea></li>
					
					<li class="submit"><input name="" type="submit" value="Güncelle" /></li>
			   </ul>
			   </fieldset>
			    <fieldset style="float:right;width:25%">
			   	<legend>LayerSlider</legend>
					<ul>
						<li><label for="">Style</label>
						<textarea name="style" style="  font-family: monospace;  font-size: 18px;" id="" cols="30" rows="10"><?php e($kat['style']) ?></textarea>
						</li>
						<li><label for="">Data-LS</label>
						<textarea name="datals" style="  font-family: monospace;  font-size: 18px;" id="" cols="30" rows="10"><?php e($kat['datals']) ?></textarea>
						</li>
						<li><label for="">Alt</label><input type="text" value="<?php e($kat['alt']) ?>" name="alt" id="" /></li>
					</ul>
				
			   </fieldset>
			    <clear></clear>
			 </form> 
			</div>
		<?php } ?>
		<div id="yeniekle" <?php if(getisset("guncelle2")) { gizle(); } ?>>
			<form id="ekle" name="ekle" method="post" action="?ekle" enctype="multipart/form-data">
			<fieldset style="  float: left;
  width: 70%;">
				<legend><?php e($title) ?></legend>
				<ul>
					<li><label>Başlık</label><span id="alan"><input type="text" id="title" name="title"  required /></span></li>
					<li><label>Takma Ad:</label><span id="alan"><input type="text" name="slug" id="slug"  required /></span></li>
					<li><label>Görsel</label><input type="file" name="pic" /></li>
					<li><label>Galeri Adı:</label><span id="alan"><input tablo="galerikategori" class="autocomplete" type="text" name="galeri" /></span></li>
					<li><label>Üst Kategori</label><span id="alan"><input type="text" name="kid" value="<?php e(get("kid")) ?>" /></span></li>
					<!--<li style="width:97%;"><label>Kod (PHP)</label><textarea name="code" id="code2" style=" width: 100%;
  height: 300px;
  clear: both;
  font-family: monospace;
  font-size: 17px;
  color: rgb(218, 21, 21);"></textarea></li>-->
					<li><label>İçerik</label><textarea name="html" class="meditor" cols="45" rows="5"></textarea></li>
					<li class="submit"><input name="" type="submit" value="Gönder" /></li>
			   </ul>
			 
			   </fieldset>
			    <fieldset style="float:right;width:25%">
			   	<legend>LayerSlider</legend>
					<ul>
						<li><label for="">Style</label>
						<textarea name="style" style="  font-family: monospace;  font-size: 18px;" id="" cols="30" rows="10"></textarea>
						</li>
						<li><label for="">Data-LS</label>
						<textarea name="datals" id="" style="  font-family: monospace;  font-size: 18px;"  cols="30" rows="10"></textarea>
						</li>
						<li><label for="">Alt</label><input type="text" name="alt" id="" /></li>
					</ul>
				
			   </fieldset>
			   <clear></clear>
			 </form> 
			 </div>
			 
		</div>
		<?php if(getisset("kid")) { ?>
		<div id="sorular">
		
				<blok2>
				<margin10>
				<div class="sekme">
				 <ul>
				 	<li><a href="#tekli"><i class="fa fa-question-circle"></i> Tekli Soru Formu</a></li>
				 	<li><a href="#coklu"><i class="fa fa-question-circle"></i> Çoklu Soru Formu</a></li>
				 	<li><a href="#coklu2"><i class="fa fa-question-circle"></i> Çoklu Soru Formu (Resimli)</a></li>
				 </ul>
					<div id="tekli">
						<h2 class="dugme" style="display:block"><i class="fa fa-plus"></i> Tekli Soru Formu</h2>
						<form action="?kid=<?php e(get("kid")); ?>&tekli#sorular" method="post" enctype="multipart/form-data" >
						<ul>
							<li><label for="">Resim: </label><input type="file" name="pic" id="" /></li>
							<li style="  width: 98%;"><label for="">Soru:</label> 
							
							<textarea required style="   width: 100%;"  name="soru" id="" cols="30" rows="10"></textarea></li>
							<clear></clear>
							<?php 
							
							for($s=0;$s<$cevapSayi;$s++) { ?>
							<li><label for="">Öncül <?php e($s+1) ?> :</label><input required type="text" name="cevap[]" id="" /></li>
							<?php } ?>
							<clear></clear>
							<li><input type="submit" value="Ekle" /></li>
						</ul>
						</form>	
							<clear></clear>
					</div>
					<div id="coklu">
						<h2 class="dugme" style="display:block"><i class="fa fa-plus"></i> Çoklu Soru Formu</h2>
						<form action="?kid=<?php e(get("kid")) ?>&coklu#sorular" method="post" >
						<?php bilgi("1 soru $cevapSayi cevap şeklinde giriniz. Her birini tek bir satıra giriniz. 
						Alt satıra geçmek için ENTER <i class=\"fa fa-keyboard-o\"></i> tuşuna basınız
						"); ?>
						<?php uyari("Soru arasında bir adet boşluk bırakınız") ?>
						<textarea required style="   width: 100%;font-size:20px;height:300px" name="havuz" id="" cols="30" rows="10"></textarea>
						<input type="submit" value="Gönder" />
						</form>
							<clear></clear>
					</div>
					<div id="coklu2">
					<?php linkCss($betik."plupload/js/jquery.ui.plupload/css/jquery.ui.plupload.css"); ?>
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
					$("#uploader").plupload({
                    // General settings
                    runtimes : 'flash',
                    url : 'pfi-bvi-yonga.php?galeriIslem=cokluResim',
                    max_file_size : '100mb',
                    max_file_count: 100, // user can add no more then 20 files at a time
                    unique_names : true,
                    multiple_queues : true,
            
                    rename: true,
                    
                    sortable: true,
					multipart_params: { 
						'uid': $('#uid').val(),
						'user': $('#user').val(),
						'kid': $('#kid').val(),
						'imza' : '<?php e(kripto($imza.oturum("uid"))); ?>'
						
					},
                    filters : [
                        {title : "Resim Dosyaları", extensions : "png,jpg,gif,jpeg"}
                    ],
            
                    flash_swf_url : '<?php echo $betik."plupload/" ?>js/plupload.flash.swf',
            
                    silverlight_xap_url : '<?php echo $betik."plupload/" ?>js/plupload.silverlight.xap'
					});							
					});
					</script>
					<?php if(postisset("sorun")) uyari(post("sorun")); ?>
						<h2 class="dugme" style="display:block"><i class="fa fa-plus"></i> Çoklu Soru Formu (Resimli)</h2>
						<form  method="post" id="yukle" action="pfi-bvi-yonga.php?galeriIslem=cokluResim">
							<div id="uploader">
								<p>Tarayıcınızın flash yazılımını güncelleyin</p>
							</div>
							<?php input("hidden","user",oturum("pFiUser")); ?>
							<?php input("hidden","uid",oturum("uid")); ?>
							<?php input("hidden","kid",get("kid")); ?>
						</form>
						
						<form action="?kid=<?php e(get("kid")) ?>&coklu3#sorular" method="post" >
						<?php bilgi("Öncelikle resimleri yukarıdaki bölüm ile atınız ve 1 resim 1 soru $cevapSayi cevap şeklinde giriniz. Her birini tek bir satıra giriniz. 
						Alt satıra geçmek için ENTER <i class=\"fa fa-keyboard-o\"></i> tuşuna basınız. Sorular arası boşluk bırakmayınız!
						"); ?>
						<?php uyari("Soru arasında bir adet boşluk bırakınız") ?>
						<textarea required style="   width: 100%;font-size:20px;height:300px" name="havuz" id="" cols="30" rows="10"></textarea>
						<input type="submit" value="Gönder" />
						</form>
							<clear></clear>
						
					</div>
				
				</div>
			
				</margin10>
				</blok2>
				<blok2>
				<margin10 class="tumsorular">
				<?php 
				$kid = veri(get("kid"));
				if(getisset("grup")) {
					$grup = veri(get("grup"));
					$grup ="AND grup=$grup";
					$sil_link = "?tumunuSil={$_GET['kid']}&grup={$_GET['grup']}";
				} else {
					$grup ="";
					$sil_link = "?tumunuSil={$_GET['kid']}";
				}
				$toplam = toplam("soru","kat=$kid AND tip='soru' $grup"); 
				$sayi = 20;
				?>
				<h2 class="dugme" style="display:block"><i class="fa fa-list"></i> Mevcut Sorular</h2>
				<fieldset style="margin:5px 0">
					<legend>Soru Grupları</legend>
				<a href="?kid=<?php e(get("kid")); ?>#sorular" class="dugme">Tümü</a>
				<?php $grup = sorgu("select * from soru where kat=$kid group by grup"); ?>
				<?php while($g = kd($grup)) { 
					if($g['grup']=="") {
						$t = "Eskiler";
					} else {
						$t = $g['grup'];
					}
				?>
				<a href="?kid=<?php e(get("kid")); ?><?php if($g['grup']!="") { ?>&grup=<?php e($g['grup']); ?><?php } ?>#sorular" class="dugme"><?php e($t) ?></a>
				<?php } ?>
				</fieldset>
				<blok2>
					<a href="<?php e($sil_link) ?>" style="background:red" teyit="Bu konudaki <?php e($toplam) ?> adet sorular silinecek. Gerçekten bu işlemi yapmak istediğinizden emin misiniz?" class="dugme"><i class="fa fa-times"></i> Bu konudaki <?php e($toplam) ?> adet soruları sil</a>
				
				</blok2>
				<blok2>
					<?php 
					
					if($toplam>$sayi) {
						 ?>
						 <?php for($k=1;$k<=round($toplam/$sayi);$k++) { ?>
						 <a href="?kid=<?php e(get("kid")) ?>&sayfa=<?php e($k) ?><?php if(getisset("grup")) e("&grup={$_GET['grup']}"); ?>#sorular"
						<?php if(getesit("sayfa",$k)) { ?>style="background:red;"<?php } ?>
						 class="dugme"><?php e($k) ?></a>
						 <?php } ?>
						 <?php
						
						?>
						
						<?php
					}
					?>
				</blok2>
				
				<clear></clear>
				
				<?php 
				if(getisset("sayfa")) {
					$bas = $sayi*(get("sayfa")-1);
				} else {
					$bas = 0;
				}
				if(getisset("grup")) {
					$grup = veri(get("grup"));
					$grup ="AND grup=$grup";
				} else {
					$grup ="";
				}
				$kid = veri(get("kid"));
				$soru = ksorgu("soru","WHERE kat=$kid AND tip='soru' $grup ORDER BY id DESC LIMIT $bas,$sayi"); ?>
				<?php 
				$k=0;
				while($s = kd($soru)) { 
				$k++;
				?>
				<blok1  style="width:250px" id="s<?php e($s['id']) ?>">
					<margin10 style="  background-color: rgba(255, 255, 255, 1);
  padding: 5px 9px;
  border-radius: 10px;
  box-shadow: 0px 3px 3px rgba(0, 0, 0, 0.2);
  position:relative;
  <?php if(toplam("soru","ust={$s['id']} AND dogru=1")==0) { ?>background:rgba(255, 255, 0, 0.35); <?php } ?>
  "
  
  >
  <a href="?kid=<?php e(get("kid")) ?>&soruSil=<?php e($s['id']) ?>#sorular" ajax="#s<?php e($s['id']) ?>" class="dugme" teyit="Silmek istediğinizden emin misiniz?" style="  position: absolute;
  right: 0px;
  top: 0px;"><i style="  font-weight: normal;
  -webkit-text-stroke: 0px;" class="fa fa-trash"></i></a>
						<?php if($s['pic']!="") { ?><img style="    max-height: 138px;
    max-width: 100%;
    display: block;
    margin: 5px auto;" src="r.php?w=200&p=file/<?php e($s['pic']) ?>" alt="" /><?php } ?>
						<h3><textarea class="sorutext" name="" id="<?php e($s['id']) ?>" style="    margin: 0px;
    width: 216px;
    height: 62px;"><?php echo $s['val'] ?></textarea></h3>
	
						<?php $cevap = ksorgu("soru","WHERE ust = {$s['id']} ORDER BY id ASC LIMIT 0,4"); ?>
						<?php while($c = kd($cevap)) {
							?>
							<label><input class="cevap" type="radio" name="<?php e($s['id']) ?>" value="<?php e($c['id']); ?>" id="" <?php if($c['dogru']==1) e("checked"); ?> /> <input type="text" class="cevaptext" name="" id="<?php e($c['id']) ?>" value="<?php e($c['val']); ?>" /></label>
							<?php
						} ?>
					</margin10>
				</blok1>
				<?php
				//if($k%3==0) {e("<clear></clear>");}
				
				} ?>
				<clear></clear>
				</margin10>
				</blok2>
			 <clear></clear>
			 <style type="text/css">
			 .tumsorular margin10 {
				 transition: all 1s;
				 max-height:200px;
				 min-height:200px;
				 overflow:hidden;
				 padding:10px;
			 }
			 .sorutext {
				   border: none !important;
				  background: none !important;
				  width: 100%;
				  padding: 0px;
				  font-size: 14px  !important;
				  height: 33px;
			 }
			 .tumsorular margin10:hover {
				 max-height:500px;
				 
			 }
			 .cevaptext {
				    border: none;
					background: transparent;

				 
			 }
			 </style>
			 <script type="text/javascript">
			 $(function(){
				$(".cevap").click(function(){
					var soru = $(this).attr("name");
					var cevap = $(this).attr("value");
					//falanca sorunun cevabı falanca
					$.post("?cevapla",{
						soru : soru,
						cevap : cevap
					},function(d){
					//	alert(d);
					})
				});
				$(".sorutext,.cevaptext").blur(function(){
					var deger = $(this).val();
					var id = $(this).attr("id");
					$.post("?soruGuncelle",{
						deger : deger,
						id : id
					},function(d){
						//alert(d);
					});
				});
			 });
			 </script>
			 </div>
		<?php } ?>
	</div>
</div>