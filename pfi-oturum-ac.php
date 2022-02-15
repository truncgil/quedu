<?php include("pFiBDYonga.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php printf(dil(97),$baslik);?></title>
<style type="text/css">
<!--
#site {
	display: none;
	height: 100%;
	width: 100%;
	position: absolute;
	left: 0px;
	top: 0px;
}
#oturumAc {
	width: 600px;
	margin-top: 0px;
	margin-right: auto;
	margin-bottom: 0px;
	margin-left: auto;
}
-->
</style>
<?php jquery();
js($betik . "formee/js/formee.js") . _js();
linkCss($betik . "formee/css/formee-structure.css");
linkCss($betik . "formee/css/formee-style.css")

?>
<script>
$(function(){
		   var giris = 0;
		   function masaustuGoster() {
						 $.post("pfiy-masaustu.php",{
								
								},
								function(d){
											$("#site").html(d);
											$("#site").show("slow");
											}
								);
					   }
			function oturumAcGoster(){
					$("#oturumAc").fadeIn("slow");
					
				}
		   if (giris==1) {
			   $("#oturumAc").hide();
			   masaustuGoster();
		   } else {
				$("#site").hide("slow");
			   oturumAcGoster();
		   }
		   $("#giris").click(function(){
									  //kontrol et
									  
									  //eğer gerçek kişi varsa giriş panelini yok et masaüstünü getir
									  
									  $("#oturumAc").fadeOut("slow",function(){
																		
																		  });
									  masaustuGoster();
									  });
		   $("#cikis").click(function(){
									  alert("dfdsa");
									  //kontrol et
									  
									  //eğer gerçek kişi varsa giriş panelini yok et masaüstünü getir
									  
									  $("#site").fadeOut("slow",function(){
																		
																		  });
									  oturumAcGoster();
									  });
		   });
</script>
</head>

<body>
<div id="oturumAc">
<?php pFiAmblem(); ?>

<form action="#" method="post" class="formee" onsubmit="javascript:void(0)">
  <fieldset>
    <legend>Oturum Aç</legend>
        <div class="grid-12-12">
                <label><?php dile(94); ?><em class="formee-req">*</em></label>
               <input type="text" id="kullanici" name="kullanici" value="" required />
        </div>
        <div class="grid-12-12">
                <label><?php dile(95); ?><em class="formee-req">*</em></label>
               <input type="password" id="sifre" name="sifre" value="" required />
        </div>
        <div class="grid-12-12">
         <input type="button" id="giris" title="<?php dile(96); ?>" value="<?php dile(96); ?>" />
         </div>
  </fieldset>
</form></div>
<div id="site"></div>
</body>
</html>