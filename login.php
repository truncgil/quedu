<?php include("pfi-tema.php");
oturumAc();
if(oturumisset("uid")) oturumSil("uid");
pBas("Login"); // HTML Head başı
?>
<?php spryTextJS(); ?>
<?php spryTeyitJS(); ?>
<?php
_pBas(); //head sonu
oturumAc();
	?>
<style type="text/css">body {  background: url(arka.jpg);
  background-size: cover;}</style>
<orta>
<div class="grid-12-12">
			<div id="oturumTamam" <?php gizle(); ?>><?php bilgi(dil(160)); ?></div>
			<div id="oturumHata" <?php gizle(); ?>><?php uyari(dil(161)); ?></div>
		</div>
</orta>
<orta style="
  background: rgba(255, 255, 255, 0.85);
  padding: 11px;
  border-radius: 33px;
  box-shadow: 0px 1px 6px rgba(0, 0, 0, 0.63);
  width: 500px;
  margin-top: 15%;
">
<margin></margin>
	
<blok4 style="width: 90%;
margin: 0 auto;
display: block;
float: none;">
		

	<img style="    width: 200px;
    text-align: center;
    margin: 0 auto;
    display: block;" src="logo.png" alt="" />
	
	<div class="wrap">
	<div class="col_1_of_3 span_1_of_3 second">
		
	</div>
	<div class="col_2_of_3 span_2_of_3 second">
	<?php if(!isset($_SESSION['kayitTamam']) AND (isset($_GET['kayit']))) { ?>
	<form action="<?php e($via); ?>uyeIslem=uyeKayit&y=profil.php" method="POST" id="yeniForm" class="formee">
	


	<div class="formee-msg-info " id="tamam" style="display:none"><h3><?php dile(146) ?></h3></div>
		<div class="grid-12-12">
		<div id="eMailHata" style='display:none'><?php echo uyari(dil(157)) ?></div>
		<label  for="eMail">E-Mail</label>
		<span id="mailAlan"><input type="text" id="eMail" name="mail"  />
		<?php spryMesaj(fmHata(dil(154),"left")); ?>
		<?php spryFormat(fmHata(dil(153),"left")) ?>
		</span>
		</div>
		<div class="grid-12-12">
		<label for="adiAlan">Adı:</label>
		<span id="adiAlan"><input type="text" id="adi" name="adi"  />
		<?php spryMesaj(fmHata(dil(154),"left")); ?>
		</span>
		
		</div>
		<div class="grid-12-12">
			<label for="soyadiAlan">Soyadı:</label>
			<span id="soyadiAlan"><input type="text" id="soyadi" name="soyadi"  />
			<?php spryMesaj(fmHata(dil(154),"left")); ?>
			</span>
		</div>
		<div class="grid-12-12">
			<label for="sifre"><?php dile(150) ?></label>
			<span id="sifreAlan"><input type="password" id="fsifre" name="sifre"  />
			<?php spryMesaj(fmHata(dil(154),"left")); ?>
			</span>
		</div>
		<div class="grid-12-12">
			<label for="sifre2"><?php dile(150) ?></label>
			<span id="sifre2Alan"><input type="password" id="sifre2"  />
			<?php spryTeyitMesaj(fmHata(dil(155),"left")); ?>
			<?php spryTeyitYok(fmHata(dil(156),"left")); ?>
			</span>
		</div>
		<div class="grid-12-12">
			<input type="checkbox" name="" id="" /> <a href="#" id="sozlesme">Üyelik Sözleşmesini</a> Okudum
		</div>
		<div class="grid-12-12">
		<input class="formee-button" type="submit" value="<?php dile(145) ?>" />
		</div>

		
	</form>
	<div id="sozlesmeIcerik" style="display:none;">
		<?php $sozlesme = kd(ksorgu("sayfalar","WHERE id = 88"));
		echo $sozlesme['icerik'];
		?>
		<a class="dugme" onclick="$('#sozlesmeIcerik').dialog('close');">Kapat</a>
	</div>
	<script type="text/javascript">
		$(function(){
			$("#sozlesme").click(function(){
				$("#sozlesmeIcerik").dialog({
					width: 800,
					height:400,
					modal:true
				});
				return false;
			});
		});
	<?php spryEmail("mailAlan"); ?>
	<?php spryGerekli("adiAlan"); ?>
	<?php spryGerekli("soyadiAlan"); ?>
	<?php spryGerekli("sifreAlan"); ?>
	<?php spryTeyit("sifre2Alan","fsifre"); ?>
	</script>
	<?php } else { ?>
	<?php //echo fmBilgi(sprintf(dil(152))); ?>
	<form action="#" method="POST" class="formee">
		<div id="oturumBekle" <?php gizle(); ?>><?php e(resim($img."ikon/bekle.gif")); ?></div>
			<div class="grid-12-12">
				
					<label for="mail" >E-Mail</label>
					<input type="text" 
					style="
" name="mail"  id="mail" />
					<?php spryMesaj(fmHata(dil(154),"left")); ?>
					<?php spryFormat(fmHata(dil(153),"left")) ?>
			
			</div>
		<div class="grid-12-12">
			<label for="sifre">Password</label>
			<input type="password" 
			style="
" id="sifre" name="sifre"  />
			<?php spryMesaj(fmHata(dil(154),"left")); ?>
			
		</div>
		<div class="grid-12-12">
		<input class="formee-button" style="  background: rgb(0, 141, 210);
  border: none;
  font-size: 12px;
  font-family: regular;
  font-size: 32px;
  display: block;
  margin: 0 auto;" type="button" id="oturumB" value="Giriş Yap" />
		</div>
		
	
	</form>
	</blok4>
	<script type="text/javascript">
		<?php spryEmail("mailAlan"); ?>
		<?php spryGerekli("adiAlan"); ?>
		<?php spryGerekli("soyadiAlan"); ?>
		<?php spryGerekli("sifreAlan"); ?>
	
	</script>
	<?php } ?>
	</div>
	</div>
	</div>
	</orta>
	<?php
	//pAna(); Anasayfa içerikleri
	// _pOrta(); //içerik işlemleri sonu
	
//pAlt(); //body html sonu

?>