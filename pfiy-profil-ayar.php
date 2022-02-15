<?php include("pfi-yonetici-yetki.php"); ?>
<?php 
$k = kd(kSorgu("uyeler",sprintf("WHERE id = %s",oturum("uid"))));

 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php dile(98);?></title>
<?php 
include("pfiy-he-in.php");
?>
<script type="text/javascript">
$(function(){
	$("#eskiSifre").blur(function(){
	//alert("sdsad");
		$.post("<?php e($via) ?>ajax=parola",{
			'sifre' : $("#eskiSifre").val()
		},function(d){
		//alert(d);
			if(d==0) {
				$("#sifreUyari").show("slow");
				$("#eskiSifre").select();
				$("#eskiSifre").focus();
			}
		});
	}).keydown(function(){
	$("#sifreUyari").hide("slow");
	
	});
});
</script>
</head>

<body>
<?php if ((isset($_GET['islem'])) && ($_GET['islem']==kripto("sifreTamam"))) { 
	bilgi(dil(176));
}?>
<div class="sekme">
	<ul>
    	<li><a href="#hesap"><?php dile(104)?></a></li>
    	<li><a href="#bildirim"><?php dile(103)?></a></li>
    	<li><a href="#imza"><?php dile(105)?></a></li>
    	<li><a href="#profil"><?php dile(106)?></a></li>
    	<li><a href="#sifreSekme"><?php dile(170)?></a></li>
    </ul>
    <div id="hesap">
        <form action="<?php e($via); ?>uyeIslem=guncelle&y=pfiy-profil-ayar.php" method="post" enctype="multipart/form-data">
				<?php 
				if ($k['resim']=="") {
					$resim = $img . "dock/12.png";
					$boyut = "";
				} else {
					$resim = $img . "uyeler/" . $k['resim'];
					$boyut = "128";
				}
				echo resim($resim,$boyut,"align='right'"); ?>
            <fieldset>
                <legend><?php dile(104)?></legend>

        	<ul>
            	<li><label><?php dile(107); ?></label><span id="emailAlan"><input name="mail" id="mail" value="<?php e($k['mail']) ?>" type="text"  /><?php spryMesaj(dil(153)) ?><?php spryFormat(dil(153)); ?></span></li>
            	<li><label><?php dile(108); ?></label><span id="adiAlan"><input name="adi" id="adi" value="<?php e($k['adi']) ?>" type="text"  /><?php spryMesaj(dil(154)) ?></span></li>
            	<li><label><?php dile(109); ?></label><span id="soyadiAlan"><input name="soyadi" value="<?php e($k['soyadi']) ?>" id="soyadi" type="text"  /><?php spryMesaj(dil(154)) ?></span></li>
            	<li><label><?php dile(169); ?></label><input name="resim" type="file" /></li>
				<input name="eskiResim" type="hidden" value="<?php e($k['resim']) ?>" />
            	<li class="submit"><input type="submit" value="<?php dile(112); ?>" /></li>
            </ul>
            </fieldset>
        </form>	
    </div>
    <div id="bildirim">
    
    </div>
	<div id="sifreSekme">
		<form action="<?php e($via); ?>uyeIslem=sifreGuncelle&y=pfiy-profil-ayar.php?islem=<?php e(kripto("sifreTamam")) ?>" method="POST">
            <div id="sifreUyari" <?php gizle(); ?>><?php uyari(dil(175)) ?></div>
			<fieldset>
                <legend><?php dile(170); ?></legend>
				<ul>
					<li><label><?php dile(171); ?></label><span id="eskiSifreAlan"><input name="eskiSifre" id="eskiSifre" type="password" /><?php spryMesaj(dil(154)) ?></span></li>
					<li><label><?php dile(172); ?></label><span id="sifreAlan"><input name="sifre" id="sifre" type="password" /><?php spryMesaj(dil(154)) ?></span></li>
					<li><label><?php dile(173); ?></label><span id="sifreTeyit"><input name="sifre2" type="password" /><?php spryMesaj(dil(154)) ?><?php spryTeyitYok(dil(156)); ?></span></li>
					<li class="submit"><input type="submit" value="<?php dile(174); ?>" /></li>
				</ul>
			</fieldset>
		</form>
	</div>
</div>
<script type="text/javascript">
<!--
<?php spryTeyit("sifreTeyit","sifre"); ?>
<?php spryDGerekli(array("sifreAlan","adiAlan","soyadiAlan","eskiSifreAlan")); ?>
<?php spryEmail("emailAlan"); ?>
-->
</script>
</body>
</html>