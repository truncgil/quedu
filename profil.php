<?php include("pfi-tema.php");
if(!getisset("s")) {
	yonlendir("profil.php?s=1");
}
oturumAc();

if(!oturumisset("uid")) {
	yonlendir("index.php");
}
oturumSil("takipNo");

$uid = oturum("uid");
pBas("Profilim"); // HTML Head başı
spryTextJS();
spryTeyitJS(); 

_pBas(); //head sonu
	pUst(); //banner ve navigasyonlar
	
	pOrta(); //içerik işlemleri başı
	?>
	<script type="text/javascript">
		$(function(){
			var s = <?php e(get("s")) ?>-1;
			$(".sol-menu li:eq("+s+") a").addClass("secili");
		});
	</script>
	<blok4>
	<h1>Profilim</h1>
	<blok1>
	<ul class="sol-menu">
		<li><a href="?s=1">Hesabım</a></li>
		<li><a href="?s=2">Radyum'a Bağlan</a></li>
		<li><a href="?s=3">Adreslerim</a></li>
		<li><a href="?s=4">Müşteri Hizmetleri</a></li>
		<li><a href="?cikis=1">Güvenli Çıkış</a></li>
	</ul>
	</blok1>
	<blok3>
		<?php if(getesit("s","1")) : ?>
		
		<?php endif; ?>
		<?php if(getesit("s","1")) : ?>
		
		<?php endif; ?>
	</blok3>
	</blok4>
	<?php
	//pAna(); Anasayfa içerikleri
	 _pOrta(); //içerik işlemleri sonu
	
pAlt(); //body html sonu

?>