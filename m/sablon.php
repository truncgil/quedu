<?php
include("../kobetik/ayarlar.php");
include("kobetik.php");
include("functions.php");
 $c = "v2.0";//rand(999,99999); 
 
oturumAc();
if(oturumisset("uid")) {
	$user = kd(ksorgu("uyeler","WHERE id = '{$_SESSION['uid']}'"));
}



 function a($title="Zomni",$tur=2) {  
 global $user;
 global $c;
 ?>

<!DOCTYPE HTML>
<html lang="tr-TR">
<head>
	<meta charset="UTF-8">
	<meta name=viewport content="width=device-width, initial-scale=1">
	<meta name="google-site-verification" content="6ldHBj9H1PDoULVH1fPBejIw7lr1z9etQ3S1PEz6NCs" />
	<link rel="stylesheet" href="jm/themes/zomni.min.css?<?php e($c) ?>" />
	<link rel="shortcut icon" type="image/png" href="onlylogo.png" />
	<link rel="stylesheet" href="jm/jquery.mobile.structure-1.4.5.min.css?<?php e($c) ?>" />
	<script src="jquery-1.11.1.min.js"></script>
	<script type="text/javascript" src="zomni.js?<?php e($c) ?>"></script>
	<script src="jm/jquery.mobile-1.4.5.min.js?<?php e($c) ?>"></script>
	<title><?php e($title) ?></title>

</head>
<body>
	<div data-role="page" id="zomnipage">

<?php include("panels.php") ?>

	<?php if($tur!=3) { ?>
		<div data-role="header" data-position="fixed">
		<?php if($tur==1) { ?>
			<h1>
			<a href="#" title="<?php e($title) ?>">
				<img src="logo2.svg" alt="" />
			</a>
			<br /><?php e($title) ?>
			</h1>
		<?php } else { ?>
			<a href="#profile"><i class="fa fa-bars headerbutton"></i>
			
			</a>
			<h1>
			<a href="profile.php" title="<?php e($title) ?>">
				<img src="../logo2.svg" style="    background: white;
    padding: 5px;
    width: 150px;
    margin: 0px;
    border-radius: 10px;
    position: relative;" alt="" />
			</a>
			
			</h1>
			<a href="#ara"><i class="fa fa-search headerbutton"></i></a>
		<?php } ?>
			
		</div>
	<?php } ?>
		<div data-role="content" style="position:relative;min-height:700px;max-width:700px;margin:0 auto;overflow:hidden;">
  
		<!--<h1 style="margin:0;text-align:center;"><?php e($title) ?></h1>-->
<?php } ?>

<?php function b($title="Her hakkı saklıdır ",$tur=1) { 
 global $user;
 global $c;

?>	
		</div>
		<?php if($title!="") { ?>
		<div data-role="footer">
		<h1><?php e($title ." &copy ". date('Y')); ?></h1>
		
		</div>
		<?php } ?>
		
	</div>
<script type="text/javascript">
//$("body").trigger( "create" );
</script>	
</body>

	<link rel="stylesheet" href="font/css/font-awesome.min.css?<?php e($c) ?>" />
	<link rel="stylesheet" href="loading.css?<?php e($c) ?>" />
	<link rel="stylesheet" href="stil.css?<?php e($c) ?>" />
	<link rel="stylesheet" href="responsive.css?<?php e($c) ?>" />
	<link rel="stylesheet" href="color.css?<?php e($c) ?>" />
	<?php if($tur!=3) { ?>
	<script type="text/javascript" src="autocomplete.js?<?php e($c) ?>"></script>
	<script type="text/javascript" src="zomni.log.js?<?php e($c) ?>"></script>
	<script src="chart.js"></script> 
	<script src="charthor.js"></script> 
	<?php } ?>
	<script type="text/javascript" src="fs.js"></script>
	<link rel="stylesheet" href="jm/themes/jquery.mobile.icons.min.css?<?php e($c) ?>" />
	<link rel="stylesheet" href="caro/owl.carousel.css">
	<link rel="stylesheet" href="caro/owl.theme.css">
	<script src="caro/owl.carousel.js"></script>
	<script type="text/javascript">
	$(function(){
		$(".owl-carousel").owlCarousel({
			singleItem : true
		});
	});
	</script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-106535764-2"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-106535764-2');
</script>

	<?php if($tur==3) { ?>
 <style type="text/css">
.ui-content {
    position: absolute !important;
    max-width: initial !important;
    min-height: 100% !important;
    margin: 0 auto;
    width: 100%;
    /* top: -20px; */
    padding: 0px;
}
.ui-btn {
	border:none !important;
	border-top:none !important;
	border-bottom:none !important;
}

 </style>
	<?php } ?>
</html>
<?php } ?>