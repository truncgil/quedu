<?php include("../../pfi-yonetici-yetki.php"); 
//echo $seviye;
switch ($seviye) {
	case "Okuyucu" :
		exit();
	break;
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>elFinder 2.0</title>

		<!-- jQuery and jQuery UI (REQUIRED) -->
		<link rel="stylesheet" type="text/css" media="screen" href="../../kobetik/eklentiler/css/custom-theme/jquery-ui-1.8.5.custom.css">
		<script type="text/javascript" src="../../kobetik/eklentiler/js/jquery-1.7.1.min.js"></script>
		<script type="text/javascript" src="../../kobetik/eklentiler/js/jquery-ui-1.8.5.custom.min.js"></script>

		<!-- elFinder CSS (REQUIRED) -->
		<link rel="stylesheet" type="text/css" media="screen" href="css/elfinder.full.css">
		<link rel="stylesheet" href="../../tema/font/font.css" />

		<!-- elFinder JS (REQUIRED) -->
		<script type="text/javascript" src="js/elfinder.min.js"></script>

		<!-- elFinder translation (OPTIONAL) -->
		<script type="text/javascript" src="js/i18n/elfinder.tr.js"></script>

		<!-- elFinder initialization (REQUIRED) -->
		<script type="text/javascript" charset="utf-8">
			$().ready(function() {
				var elf = $('#elfinder').elfinder({
					lang: 'tr',             // language (OPTIONAL)
					url : 'php/connector.php'  // connector URL (REQUIRED)
				}).elfinder('instance');			
			});
		</script>
	</head>
	<body>

		<!-- Element where elFinder will be created (REQUIRED) -->
		<div id="elfinder"></div>

	</body>
</html>
