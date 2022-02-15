<?php include("sablon.php");
include("secure.php");
if(getisset("q")) {
	ob_end_clean();
	header('Content-Type: application/json; charset=UTF-8');
	$kriter = veri("%".get("q")."%");
	$kriter2 = veri(get("q"));
	$kriter3 = veri(get("q")."%");
	$bolum = ksorgu("bolum","WHERE title LIKE $kriter COLLATE utf8_turkish_ci GROUP BY title ORDER BY (CASE WHEN title = $kriter2 THEN 1 WHEN title LIKE $kriter3 THEN 2 ELSE 3 END),title  LIMIT 0,10");
	$json = array();
	$k=0;
	while($b = kd($bolum)) {
		$json[$k] = $b['title'];
		$k++;
	}
	e(json_encode($json));
	exit();
}
if(getisset("id")) {
	oturumAc();
	oturum("sec_bolum",get("id"));
	dGuncelle("uyeler",array(
		"okul" => oturum("sec_uni"),
		"bolum" => oturum("sec_bolum")
	),"id={$user['id']}");
	yonlendir("profile.php");
}
a("Fakülteler/Bölümler");
$bolum = ksorgu("bolum","WHERE title <>'' ORDER BY rand() LIMIT 0,10");
?>

<form class="ui-filterable">
    <input id="bolum-input" data-theme="a" data-inset="false" data-type="search" placeholder="Ara...">
</form>
	<?php loading(true); ?>

<ul id="bolum" data-role="listview" data-filter="true" data-filter-placeholder="Üniversite Adı..." data-inset="true" data-input="#bolum-input">
<?php
while($u = kd($bolum)) {
	
	e("<li><a href='?id={$u['title']}'>{$u['title']}</a></li>");
}
?>
</ul>
<style type="text/css">
.ui-screen-hidden {
	display:block !important;
}
</style>
<?php
b();
 ?>