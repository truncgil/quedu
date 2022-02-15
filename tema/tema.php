<?php 


function bas($b) {
?>
<!-- Bu site bir Trunçgil ürünüdür (www.truncgil.com) -->
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title><?php e($b); ?></title>
	<script type="text/javascript" src="tema/js/jquery.js"></script>
	<script type="text/javascript" src="tema/js/jquery-ui.js"></script>
	<link rel="stylesheet" href="tema/js/jquery-ui.css" />
	<link rel="stylesheet" href="tema/truncgil.blok.css" />
<?php } ?>
<?php function _bas() { ?>
	<link rel="stylesheet" href="tema/font/font.css" />
	<link rel="stylesheet" href="tema/font/css/font-awesome.min.css" />
	<link rel="stylesheet" href="tema/stil.css" />
	<link rel="shortcut icon" type="image/png" href="tema/favicon.png" />
	<link rel="stylesheet" href="tema/layerslider/layerslider/css/layerslider.css" type="text/css">
	<script src="tema/layerslider/layerslider/js/layerslider.transitions.js" type="text/javascript"></script>
	<script src="tema/layerslider/layerslider/js/layerslider.kreaturamedia.jquery.js" type="text/javascript"></script>
	<script src="tema/layerslider/layerslider/js/greensock.js" type="text/javascript"></script>
	<script type="text/javascript" src="tema/lightbox/js/lightbox.min.js"></script>
	<script type="text/javascript" src="tema/truncgil.google.search.js"></script>
	<link rel="stylesheet" href="tema/lightbox/css/lightbox.css" />
	
	<?php include("script.php"); ?>
	
</head>
<?php } ?>
<?php function govde() { ?>
<body>
	<site>
<?php } ?>
<?php function ana() { ?>
	
	<content>
	
<?php } ?>
<?php  ?>
<?php function indeks() { ?>

	
	<orta style="
  padding: 11px;
    border-radius: 33px;
    width: 500px;
    margin-top: 0px;
    z-index: 10;
">
<margin></margin>
	
<blok4 style="width: 90%;
margin: 0 auto;
display: block;
float: none;
text-align:center;
">
	<img style="    display: block;
    margin: 20px auto;
    /* background-color: #106F84; */
    /* padding: 10px 200px; */
    /* border-radius: 17px; */
    width: 350px;" src="zomni-all.png" alt="" />
	<a href="login" class="dugme" style="border-radius:20px;padding:20px 30px;
"><i style="font-size:40px;display:block" class="fa fa-sign-in"></i> Oturum Aç</a>
	</blok4>
	</orta>
	<?php layerslider("layerslider"); ?>
	</div>
<?php } ?>
<?php function _ana() { ?>
	</content>
<?php } ?>
<?php function alt() { ?>
	</site>
<script>
$(function(){
	jQuery(".layerslider").layerSlider({
					responsive: true,
					responsiveUnder: $(window).width(),
					navPrevNext : true,
					layersContainer: 1200,
					showBarTimer: false,
					showCircleTimer : false,
					skin: 'fullwidth',
					hoverPrevNext: true,
					skinsPath: 'tema/layerslider/layerslider/skins/'
				});
	
});
function ajaxurl(response, urlPath){
     document.getElementById("content").innerHTML = response.html;
     document.title = response.pageTitle;
     window.history.pushState({"html":response.html,"pageTitle":response.pageTitle},"", urlPath);
 }
			


			
			
		
	</script>
</body>
</html>
<?php } ?>