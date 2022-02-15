<?php include("pfi-tema.php");
$sorgu = content(get("id"));
if($sorgu==0) yonlendir("index");
$c =kd($sorgu);
pBas($c['title']); // HTML Head başı
_pBas(); //head sonu
	pUst(); //banner ve navigasyonlar
	
	pOrta(); //içerik işlemleri başı
	?>
	
	<?php switch(get("id")) {
		case "iletisim" :
		?>
	<script src="http://maps.googleapis.com/maps/api/js?sensor=false" type="text/javascript"></script>
	<script type="text/javascript" src="tema/js/gmap3.min.js"></script>

		<script type="text/javascript">
		$(function(){
			$("#harita").gmap3({
				
				map : {
					address : "Gaziantep, Turkey" ,
					options : {
						zoom : 12,
						center : [36.993176, 37.364701]
					}
				}
			});
				<?php $pinler = contents(get("id")); ?>
				<?php while($p =kd($pinler)) { ?>
					$("#harita").gmap3({
						marker : {
							latLng : [<?php e($p['style']) ?>],
							options : {
								icon : "file/<?php e($p['pic']) ?>"
								
							},
							events:{
								click: function(){
									<?php if($p['alt']!="") { ?>window.open('<?php e($p['alt']) ?>','_blank');<?php } ?>
								}
							}
						}
					});
				<?php } ?>
		});
		</script>
		<div id="harita" style="position:absolute;top:0px;left:0px;width:100%;height:100%;"></div>
		<orta style="	  ">
			<div class="beyazAlan" style="<?php e($c['style']); ?>">
				<h1><?php e($c['title']) ?></h1>
				<?php e($c['code']) ?>
				<?php e($c['html']) ?>
			</div>
		</orta>
		<?php
		break;
		case "hizmetlerimiz" :
			layerslider("hizmetlerimiz");
		break;
		case "foto-galeri" : 
			bg("file/{$c['pic']}");
		 ?>
		
			<orta class="baslik"><h1 ><?php e($c['title']) ?></h1></orta>
			<orta class="beyazAlan" style="  text-align: center;" >
				<?php e($c['code']) ?>
				<?php e($c['html']) ?>
				<?php $icerik = contents($c['slug']); ?>
				<?php while($i = kd($icerik)) { ?>
					<a href="<?php e($i['slug']) ?>.<?php e($uzanti) ?>" class="dugme buyuk">
					<?php if($i['pic']!="") { ?>
						<img src="r.php?p=file/<?php e($i['pic']) ?>&w=128" alt="" />
					<?php } else {  ?>
						<img src="resimler/dock/07.png" alt="" />
					<?php } ?>
					<?php e($i['title']) ?></a>
				<?php } ?>
			</orta>	
		 <?php
		break;
		case "hakkimizda" :
		?>
			<?php bg("file/{$c['pic']}") ?>
			<orta class="baslik"><h1 ><?php e($c['title']) ?></h1></orta>
			<orta class="beyazAlan" style="  text-align: center;" >
				<?php e($c['code']) ?>
				<?php e($c['html']) ?>
				<?php $icerik = contents($c['slug']); ?>
				<?php while($i = kd($icerik)) { ?>
					<a href="<?php e($i['slug']) ?>.<?php e($uzanti) ?>" class="dugme buyuk"><i class="fa <?php e($i['style']) ?>"></i><?php e($i['title']) ?></a>
				<?php } ?>
			</orta>	
		<?php
		break;
		case "aday-ogrenci" :
		?>
			<?php bg("file/{$c['pic']}") ?>
			<orta class="baslik"><h1 ><?php e($c['title']) ?></h1></orta>
			<orta class="beyazAlan" style="  text-align: center;" >
				<?php 
				$c['code'] = str_replace("<!--?php","<?php",$c['code']);
				$c['code'] = str_replace("?-->","?>",$c['code']);
				e($c['code']); ?>
				
				<?php e($c['html']) ?>
				<?php $icerik = contents($c['slug']); ?>
				<?php while($i = kd($icerik)) { ?>
					<a href="<?php e($i['slug']) ?>.<?php e($uzanti) ?>" class="dugme buyuk"><i class="fa <?php e($i['style']) ?>"></i><?php e($i['title']) ?></a>
				<?php } ?>
			</orta>	
		<?php
		break;
		default : 
		?>
	<?php bg("file/{$c['pic']}") ?>
	<orta class="baslik"><h1><?php e($c['title']) ?><?php echo hiyerarsi_web($c['kid']); ?></h1>
	</orta>
	<orta class="beyazAlan">	
		
		<?php 
				eval($c['code']); ?>
		<?php e($c['html']) ?>
		<?php if($c['galeri']!="") {
				$galeri = galeri2($c['galeri']);
				
			
		} ?>
	</orta>	
		<?php
		break;
	} ?>
	

	<?php
	//pAna(); Anasayfa içerikleri
	 _pOrta(); //içerik işlemleri sonu
	
pAlt(); //body html sonu

?>