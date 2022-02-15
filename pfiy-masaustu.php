<?php 
include("admin.core.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php printf(dil("mB"),$baslik);?></title>
<?php 
include("pfiy-he-in.php");
	//formee
//	js($betik . "formee/js/formee.js") . _js();
//	linkCss($betik . "formee/css/formee-structure.css");
//	linkCss($betik . "formee/css/formee-style.css")

?>
<?php 
	//dock
	linkCss($betik . "dock/dock-stil.css"); 
	js($betik . "dock/dock-betik.js") . _js();
	
	//pencere
	linkCss($betik . "window/css/jquery.window.css"); 
	js($betik . "window/jquery.window.min.js") . _js();
	tablesorter();
?>
<link rel="stylesheet" href="tema/font/font.css" />
<link rel="stylesheet" href="admin.css" />
<script type="text/javascript" src="tema/truncgil.google.search.js"></script>

<script>
$(function(){
		   		
				
		   });
</script>
<style type="text/css">

</style>
           

</head>

<body>

<?php include("admin.php"); ?>

</body>
</html>