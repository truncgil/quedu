<?php include("pfi-tema.php");
$url = "http://quiz.truncgil.com";
$liste = ksorgu("content","WHERE kid IS NULL");
$json = array();
$k=0;
while($l = kd($liste)) {
	$json[$k]['image'] = "$url/r.php?w=128&p=file/{$l['pic']}"; 
	$json[$k]['title'] = "{$l['title']}"; 
	$json[$k]['rating'] = $l['html']; 
	$json[$k]['releaseYear'] = 2015; 
	$json[$k]['slug'] = $l['slug']; 
	$k++;
}
echo json_encode($json);
?>