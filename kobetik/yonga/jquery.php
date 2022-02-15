<?php function jquery() {?>
<script type="text/javascript" src="kobetik/eklentiler/js/jquery-1.7.1.min.js"></script>
<?php }?>
<?php function resimHataGizle() { ?>
<script>
$(function(){
	$("img").error(function(){
	  $(this).hide();
	});


});
</script>
<?php } ?>
<?php 
function popup() {
?>
<script>
function tamekran(url,isim) 
{
 var params  = 'width='+screen.width;
 params += ', height='+screen.height;
 params += ', top=0, left=0';
 params += ', fullscreen=yes';

 var newwin = window.open(url, isim, params);
 if (window.focus) {
	newwin.focus();
	}
 return false;
}
</script>
<?php 
}

 ?>
<?php 
$fx = array(
			'fadeIn',
			'fadeOut',
			'fadeTo',
			'show',
			'hide',
			'toggle',
			'slideDown',
			'slideUp',
			'slideDown',
			'slideToggle',
			'animate'
			);
$stiller = array(
			   'kenar' => 'border',
			   'duz' => 'solid',
			   'kesik' => 'dashed', 
			   'noktali' => 'dotted',
			   'kenar-boyut' => 'border-width',
			   'renk' => 'border-color',
			   'kalin' => '3px',
			   'font' => 'font-family',
			   'font-boyut' => 'font-size',
			   'arkaplan' => 'background-color',
			   'en' => 'width' ,
			   'boy' => 'height',
			   'tasma' => 'overflow',
			   'imlec' => 'cursor' ,
			   'parmak' => 'pointer' ,
			   'pozisyon' => 'position',
			   'mutlak' => 'absolute',
			   'sabit' => 'fixed',
			   'nispi' => 'relative',
			   'ust' => 'top',
			   'alt' => 'alt',
			   'sol' => 'left',
			   'sag' => 'right',
			   'saydam' => 'opacity',
			   'yari' => '0.5',
			   'tam' => '0',
			   'yok' => '1'
			   
			   );

?>
<?php function dogrula($form,$s1="",$s2="",$uyari="Alanlar uyusmuyor") { 
?>
<script language="javascript1.1" type="text/javascript">$(function(){
																   $("<?php echo $form ?>").submit(function(){
																											var s1 = $("<?php echo $s1 ?>").val();
																											var s2 = $("<?php echo $s2 ?>").val();
																											
																											if (s1 != s2) {
																												alert("<?php echo $uyari ?>");
																												return false;
																											} else {
																												return true;
																											}
																											});
																   
																   });</script>
<?php } ?>
<?php function input_ajax($adres,$sinif=".input_d",$debug="") { ?>
<script language="javascript1.1" type="text/javascript">
$(function(){
						   $(<?php echo veri($sinif); ?>).blur(function(){
														
													   var yer = $(this);
																yer.fadeTo("normal",0.5);
																yer.attr("disabled","disabled");
																var jtablo = yer.attr("tablo"); //tablo adi
																var jd_alan = yer.attr("d_alan"); //SET alan adi
																var js_alan = yer.attr("s_alan"); // WHERE alan adi
																var js_kriter = yer.attr("s_kriter"); // sorgu WHere alan degeri
																var jd_kriter = $(this).val(); // degistirilen SET alan degeri
																
																$.post(<?php echo veri($adres); ?>,{
																	   tablo : jtablo,
																	   d_alan : jd_alan,
																	   s_alan : js_alan,
																	   s_kriter : js_kriter,
																	   d_kriter : jd_kriter
																	   },function(data){
																	   <?php if ($debug!="") {  ?>
																		   alert(data);
																		   <?php } ?>
																		   //alert(data);
																		   yer.fadeTo("normal",1);
																		   yer.removeAttr("disabled");
																		   });
													   }); 
													   });
</script>													

<?php } ?>
<?php function jblok($etiket,$olay,$yapilacak) {
	return '$("'. $etiket . '").' . $olay . '(function(){' . $yapilacak . '});'
	?>
<?php }?>
<?php function jis($kodlar) {
$u = strlen($kodlar);
$kodlar = substr($kodlar,0,$u-1);
	return "{" . $kodlar . "}";
	?>
    <?php }?>
<?php function fx($tur,$ayar=NULL,$secici="this") {
global $fx; 
?>
<?php if($secici!="this") {
	$secici = '"' . $secici . '"'; 
}
if (array_key_exists($tur,$fx)) {
					 $tur = $fx[$tur];
					 }
echo '$('. $secici . ').' . $tur . '(' . $ayar .');';
 }?>
<?php function sfx($tur,$secici="this") {
	global $fx;?>
<?php if($secici!="this") {
	$secici = '".' . $secici . '"'; 
}
return '$('. $secici . ').' . $fx[$tur] . '();';
 }?>
<?php function kfx($tur,$secici="this") {
	global $fx;
?>
<?php if($secici!="this") {
	$secici = '"#' . $secici . '"'; 
}
return '$('. $secici . ').' . $fx[$tur] . '();';
 }?>
<?php function sinifAta($sinif="",$secici="this") {?>
<?php if($secici!="this") {
	$secici = '"' . $secici . '"'; 
}
return '$('. $secici . ').addClass("' . $sinif . '");';
 }?>
<?php function sinifSil($sinif="",$secici="this") {?>
<?php if($secici!="this") {
	$secici = '"' . $secici . '"'; 
}
return '$('. $secici . ').removeClass("' . $sinif . '");';
 }?>
<?php function ssa($sinif="",$secici="this") {?>
<?php if($secici!="this") {
	$secici = '".' . $secici . '"'; 
}
return '$('. $secici . ').addClass("' . $sinif . '");';
 }?>
<?php function ksa($sinif="",$secici="this") {?>
<?php if($secici!="this") {
	$secici = '"#' . $secici . '"'; 
}
return '$('. $secici . ').addClass("' . $sinif . '");';
 }?>
<?php function css($icerik,$secici="this") {?>
<?php if($secici!="this") {
	$secici = '"' . $secici . '"'; 
}
$u = strlen($icerik);
$icerik = substr($icerik,0,$u-1);
return '$('. $secici . ').css({' . $icerik . '});';
 }?>
<?php function jo($ozellik="kenar",$deger) {?>
<?php 
global $stiller;
if (array_key_exists($ozellik,$stiller)) {
					 $ozellik = $stiller[$ozellik];
					 }
if (array_key_exists($deger,$stiller)) {
					 $deger = $stiller[$deger];
					 }
return veri($ozellik,"yazi") . ":" . veri($deger,"yazi") . ',';
 }?>
<?php function kose_yuvarla($deger) {?>
<?php 
return "'-moz-border-radius':" . veri($deger,"yazi") . ',' . "'border-radius':" . veri($deger,"yazi") . ',' ."'-webkit-border-radius':" . veri($deger,"yazi") . ',' ;
 }?>
<?php function jget($adres,$veriler,$netice="alert(veri);") {?>
<?php 
return sprintf("$.get('%s',%s,function(veri){%s});",$adres,$veriler,$netice) ;
 }?>
<?php function jpost($adres,$veriler,$netice="alert(veri);") {?>
<?php 
return sprintf("$.post('%s',%s,function(veri){%s});",$adres,$veriler,$netice) ;
 }?>
 <?php function yaz($icerik,$secici="this") {?>
<?php if($secici!="this") {
	$secici = '"' . $secici . '"'; 
}
return '$('. $secici . ').html(' . $icerik . ');';
 }?>
 <?php function deger($icerik="",$secici="this") {?>
<?php if($secici!="this") {
	$secici = '"' . $secici . '"'; 
}
return '$('. $secici . ').val(' . $icerik . ');';
 }?>
 <?php function ilave($icerik,$secici="this") {?>
<?php if($secici!="this") {
	$secici = '"' . $secici . '"'; 
}
return '$('. $secici . ').append(' . $icerik . ');';
 }?>
 <?php function uilave($icerik,$secici="this") {?>
<?php if($secici!="this") {
	$secici = '"' . $secici . '"'; 
}
return '$('. $secici . ').prepend(' . $icerik . ');';
 }?>
 <?php function animasyon($icerik,$sure="1000",$hiz="swing",$secici="this") {?>
<?php if($secici!="this") {
	$secici = '"' . $secici . '"'; 
}
return sprintf('$(%s).animate(%s,%s,%s);',$secici,$icerik,veri($sure),veri($hiz));
 }?>