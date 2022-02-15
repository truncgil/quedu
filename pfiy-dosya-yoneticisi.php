<?php include("pfi-yonetici-yetki.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Dosya Yöneticisi</title>
<?php 
include("pfiy-he-in.php");
?>
	<script type="text/javascript" charset="utf-8">
		$().ready(function() {
			
		var elf = $('#dosyaYoneticisi').elfinder({
					 //lang: 'tr',             // language (OPTIONAL)
					url : 'betikler/elfinder/php/connector.php'  // connector URL (REQUIRED)
				}).elfinder('instance');
			
		});
	</script>

</head>

<body>
<div id="dosyaYoneticisi" style="width:100%;"></div>
</body>
</html>