<?php include("pfi-yonetici-yetki.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Güvenli Çıkış</title>
<?php 
include("pfiy-he-in.php");
	//formee
	js($betik . "formee/js/formee.js") . _js();
	linkCss($betik . "formee/css/formee-structure.css");
	linkCss($betik . "formee/css/formee-style.css")

?>
<style type="text/css">
a {
text-decoration: none;
color:#fff;
}
.ortala {
position:relative;
margin: 0 auto;
width:600px;

}
h1{
font-size:30px;
text-align:center;
}
.sol{
	position:absolute;
	bottom:30px;
	left:30px;
}
.sag{
	position:absolute;
	bottom:30px;
	right:30px;
}
</style>
</head>

<body>
<div >

<h1><?php e(resim($img . "dock/10.png")); ?><br><?php dile(166) ?></h1>
<div class="formee-button sol"><a href="?cikis=1" target="_blank"><?php dile(167) ?></a></div> 
<div class="formee-button sag"><a href="pfiy-masaustu.php" target="_parent"><?php dile(168) ?></a></div>
</div> 
</body>
</html>