<?php include("sablon.php"); ?>
<?php include("secure.php"); ?>

<?php a(); ?>
<?php if(getisset("update")) {
	if(!postesit("sifre","")) { //şifre girilmişse
		if(postesit("sifre",post("sifre2"))) { //şifreler uyuyorsa
			$_POST['sifre'] = kripto($_POST['sifre']);
			$_POST['user'] = kripto($_post['mail']);
			unset($_POST['sifre2']);
			dGuncelle("uyeler",$_POST,"id={$user['id']}");
			le("Şifreniz ve Bilgileriniz Güncellendi!");
			$uid = oturum("uid");
			$user = kd(ksorgu("uyeler","WHERE id=$uid"));
			yonlendir("account.php");
		} else { //şifreler uymuyorsa
			e("<a href='' class='ui-btn uyari'>");
			le("Şifreler Uyuşmuyor. Lütfen tekrar deneyin");
			e("</a>");
		}
	} else {
		$_POST['user'] = kripto($_post['mail']);
		unset($_POST['sifre2']);
		unset($_POST['sifre']);
		dGuncelle("uyeler",$_POST,"id={$user['id']}");
		setcookie("lang",$_POST['lang'],time() + (30*60*60*24));
		$uid = oturum("uid");
		$user = kd(ksorgu("uyeler","WHERE id=$uid"));
		yonlendir("account.php");
	}
	
} ?>
<form action="?update" method="post">
<style type="text/css">
{
	
}
</style>

<div data-role="collapsibleset" data-theme="a" data-content-theme="a"><div data-role="collapsible">
		<h3><?php le("Seçili Temanız") ?> : <?php e($user['color']); ?></h3>
		<fieldset>
			<legend></legend>
		<?php $colors=array('turquoise','emerland','peterriver ','amethyst','wetasphalt','greensea','nephritis ','belizehole','wisteria','midnightblue','sunflower','carrot','alizarin','clouds','concrete','orange','pumpkin','pomegranate','silver','asbestos'); ?>
		<?php foreach($colors AS $color) { ?>
		<input type="radio" name="color" value="<?php e($color); ?>" id="<?php e($color) ?>" <?php if($color==$user['color']) e("checked"); ?>>
		<label for="<?php e($color) ?>" class="<?php e($color) ?>"><?php e($color) ?></label>
		<?php } ?>
		</fieldset>
	</div><div data-role="collapsible">
		<h3><?php le("Profil Ayarları") ?></h3>
		<label for="lang"><?php le("Dil") ?>
		    <select name="lang" id="lang" data-native-menu="false">
		        <option value="<?php le("Varsayılan") ?>" <?php if($user['lang']=="") e("selected"); ?>><?php le("Varsayılan") ?></option>
		        <option value="Türkçe" <?php if($user['lang']=="Türkçe") e("selected"); ?>>Türkçe</option>
		        <option value="English" <?php if($user['lang']=="English") e("selected"); ?>>English</option>
		        <option value="Français" <?php if($user['lang']=="Français") e("selected"); ?>>Français</option>
		        <option value="العربية" <?php if($user['lang']=="العربية") e("selected"); ?>>العربية</option>
		    </select>
		</label>
    </div><div data-role="collapsible">
		<h3><?php le("Kişisel Bilgileriniz") ?></h3>
		
		<!--
		<label for="pic"><?php le("Profil Resmi") ?>
			<input type="file" name="pic" id="" />
		</label>
		-->
        <label for="adi"><?php le("Adınız") ?></label>
        <input type="text" name="adi" id="adi" value="<?php e($user['adi']) ?>">
        <label for="soyadi"><?php le("Soyadınız") ?></label>
        <input type="text" name="soyadi" id="soyadi" value="<?php e($user['soyadi']) ?>">
        <label for="okul"><?php le("Okuduğunuz Üniversite") ?></label>
		<select name="okul" id="okul" data-native-menu="false" class="filterable-select">
            <?php $universite = ksorgu("university"," ORDER BY FIELD(title,'Zirve Üniversitesi') ASC"); ?>
			<?php while($u = kd($universite)) { ?>
						<option value="<?php e($u['title']) ?>" <?php if($user['okul']==$u['title']) e("selected"); ?>><?php e($u['title']) ?></option>
			<?php } ?>
 						<option value="" <?php if($user['okul']=="") e("selected"); ?>><?php le("Seçiniz") ?></option>
       </select>		
        <label for="bolum"><?php le("Okuduğunuz Bölüm") ?></label>
        <input type="text" name="bolum" id="bolum" value="<?php e($user['bolum']) ?>">
    </div><div data-role="collapsible">
		<h3>Giriş Bilgileriniz</h3>
        <label for="mail"><?php le("E-Posta Adresiniz") ?></label>
        <input type="text" name="mail" id="mail" value="<?php e($user['mail']) ?>">
        <label for="sifre"><?php le("Parolanız") ?></label>
        <input type="password" name="sifre" id="sifre" value="">
        <label for="sifre2"><?php le("Parolanız (Tekrar)") ?></label>
        <input type="password" name="sifre2" id="sifre2" value="">
</div>
</div>
		
 		
       <button type="submit"><?php le("Bilgileri Güncelle") ?></button>	
</form>
<?php b(); ?>
<script type="text/javascript">
$(function(){
	$(".ui-collapsible h3:eq(0) a").addClass("<?php e($user['color']) ?>");
});
</script>