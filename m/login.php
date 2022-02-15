<?php 
include("sablon.php"); 
include("facebook.php"); 
if(!getisset("cikildi")) {
	include("cookie.php"); 
} else {
	setcookie("uid","",time() - (30*60*60*24));
	//print_r($_COOKIE);
}
if(getisset("giris")) {
	$mail = veri(trim(post("txt-email")));
	$sifre = veri(kripto(trim(post("txt-password"))));
	$varmi = ksorgu("uyeler","WHERE mail=$mail AND sifre = $sifre");
	if($varmi ==0 ) {
	oturumAc();
	if(!oturumisset("uid")) {
		yonlendir("login.php");
	} else {
		yonlendir("profile.php");
	}
	
	} else {
		oturumAc();
		$kisi = kd($varmi);
		$_SESSION['uid'] = $kisi['id'];
		if($kisi['lang']!="") { 
			setcookie("lang",$kisi['lang'],time() + (30*60*60*24));
		} else {
			setcookie("lang","English",time() + (30*60*60*24));
		}
		//if($_POST['rememberme']) {
			setcookie("uid",$kisi['id'],time() + (30*60*60*24));
	//	}
		//print_r($_SESSION);
	//	e("1");
	yonlendir("profile.php");
	}
	exit();
}
?>
<?php a("Giriş Yap",1) ?>

<div data-role="popup" id="yanlis" data-overlay-theme="a" data-theme="a" style="max-width:400px;" class="ui-corner-all">        
	<div data-role="header" data-theme="a" class="ui-corner-top">
		<h1><?php le("Giriş Başarısız!") ?></h1>
	</div>
	<div data-role="content" data-theme="a" class="ui-corner-bottom ui-content">    
	<i class="fa fa-warning bigicon"></i>
		<p><?php le("E-Mail adresiniz ya da Parolanız yanlış") ?></p>
		<a href="#" data-role="button" data-rel="back" data-theme="c">OK</a>    
	</div>
</div>
<div data-role="popup" id="dogru" data-overlay-theme="a" data-theme="a" style="max-width:400px;" class="ui-corner-all">        
	<div data-role="header" data-theme="a" class="ui-corner-top">
		<h1><?php le("Giriş başarılı") ?></h1>
	</div>
	<div data-role="content" data-theme="a" class="ui-corner-bottom ui-content">   
		<?php loading(false,100); ?>
	</div>
</div>
<div data-role="popup" id="yukleniyor" data-overlay-theme="a" data-theme="a" style="max-width:400px;" class="ui-corner-all">        
	<div data-role="header" data-theme="a" class="ui-corner-top">
		<h1><?php le("Yükleniyor...") ?></h1>
	</div>
	<div data-role="content" data-theme="a" class="ui-corner-bottom ui-content">    
		<p></p>
	</div>
</div>
<form action="?giris" id="giris2" method="post">
				<a class="ui-btn" href="<?php e($login) ?>" style="background:#155B9A;"><i class="fa fa-facebook-square"></i> Facebook İle Bağlan</a>
 	          <label for="txt-email"><?php le("E-Posta veya Kullanıcı Adı") ?></label>
           <input type="email" name="txt-email"  id="txt-email" value="">
            <label for="txt-password"><?php le("Parolanız") ?></label>
            <input type="password" name="txt-password" id="txt-password" value="">
            <fieldset data-role="controlgroup">
                <input type="checkbox" name="rememberme" id="rememberme" checked>
                <label for="rememberme"><?php le("Beni anımsa") ?></label>
            </fieldset>
     	<button type="submit"><?php le("Giriş Yap") ?></button>
            <p class="mc-top-margin-1-5"><a href="reset.php"><?php le("Neden bağlanamıyorum?") ?></a></p>
        
</form>
<?php b(""); ?>