<?php
function baslik($icerik="Kobetik Örnek Doküman") {
return "<title>". $icerik . "</title>";
}?>
<?php
function karset($icerik="utf-8") {
return '<meta http-equiv="Content-Type" content="text/html"; charset=' . $icerik . ' />';
}?>
<?php
function p($isim="Kobetik Örnek Paragraf",$kimlik=NULL,$dp="") {
return "<p id=". $kimlik ." ".  $dp . ">". $isim . "</p>";
}?>
<?php
function b($s="1",$isim="Kobetik Örnek Başlık",$dp="") {
return "<h" . $s . " " . $dp  . ">". $isim  . "</h" . $s  . ">";
}?>
<?php
function resim($yol="kobetik/resim/yok.png",$en="",$dp="") {
	if (dosyaVarmi($yol)==false) {
		$yol = "kobetik/resim/yok.png";
	}	
	if ($en!="") {
		$url = "kobetik/yonga/resim.php?p=../../" . $yol . "&w=" . $en;
	} else {
		$url = $yol;
	}
	if ($dp!="") {
		switch ($dp) {
			case "orta":
			$dp = "align='absmiddle'";
			break;
			case "sol":
			$dp = "align='left'";
			break;
			case "sag":
			$dp = "align='right'";
			break;
		}
	}
return "<img src='" . $url . "' " .$dp . " />";
}?>
<?php
function resim_png($yol="kobetik/resim/logo.png",$en="",$dp="") {
	if ($en!="") {
		$url = $yol;
		$en = "width='" . $en . "'";
	} else {
		$url = $yol;
	}
return "<img src='" . $url . "' " . $en . " " .$dp . " />";
}?>
<?php
function kopru($isim="Kobetik Örnek Köprü",$yol="#",$hedef="_self",$dp="") {
return "<a href='". $yol . "' target='" . $hedef . "' ". $dp . ">" .  $isim . "</a>";
}?>
<?php
function liste($maddeler="<li>Kobetik Örnek Madde</li>", $dp="") {
return "<ul " .  $dp . ">" . $maddeler . "</ul>";
}?>
<?php
function nliste($maddeler="<li>Kobetik Örnek Madde</li>", $dp="") {
return "<ol " .  $dp . ">" . $maddeler . "</ol>" ;
 }?>
<?php
function madde($icerik="Kobetik Örnek Madde", $dp="") {
	 "<li " . $dp . ">" . $icerik . "</li>" ;
}?>
<?php
function aliste($bas="Kobetik Örnek Madde",$maddeler="<li>Kobetik Örnek Madde</li>", $dp="") {
	return $bas . "<ul " . $dp . ">" . $maddeler . "</ul>"  ;
}?>
<?php
function naliste($bas="Kobetik Örnek Madde",$maddeler="<li>Kobetik Örnek Madde</li>", $dp="") {
	return $bas  . "<ol " . $dp . ">" . $maddeler . "</ol>" ;
}?>
<?php
function tablo($satirlar="<tr><td>Kobetik Örnek Satır</td></tr>", $kimlik=NULL, $dp="") {
return "<table id='". $kimlik ."' ".  $dp . ">" . $satirlar . "</table>"; 
 }?>
<?php
function satir($sutunlar="<td>Kobetik Örnek Sütun</td>", $dp="") {
	 "<tr " . $dp . ">" . $sutunlar . "</tr>" ;
}?>
<?php
function tbas($satirlar="<tr><th>Kobetik Örnek Başlık</th></tr>", $dp="") {
 "<thead " .  $dp . ">" . $satirlar . "</thead>"; 
 }?>
<?php
function tgovde($satirlar="<tr><tr>Kobetik Örnek Satır</tr></tr>", $dp="") {
 "<tbody " .  $dp . ">" . $satirlar . "</tbody>"; 
 }?>
<?php
function sutun($icerik="<td>Kobetik Örnek Sütun</td>", $dp="") {
	 "<td " . $dp . ">" . $icerik . "</td>" ;
}?>
<?php
function bsutun($icerik="<td>Kobetik Örnek Sütun</td>", $dp="") {
	 "<th " . $dp . ">" . $icerik . "</th>" ;
}?>
<?php
function katman($icerik="Kobetik Örnek Katman İçeriği", $kimlik=NULL, $dp="",$d=1) {
if ($d == 0) {
	$d = "style='display:none'";
} else {
	$d= "";
}
	return "<div id='". $kimlik ."' ".  $dp . " " . $d . ">" . $icerik . "</div>" ;
}?>
<?php
function span($icerik="Kobetik Örnek Katman İçeriği", $kimlik=NULL, $dp="",$d=1) {
if ($d == 0) {
	$d = "style='display:none'";
} else {
	$d= "";
}
	return "<div id='". $kimlik ."' ".  $dp . " " . $d . ">" . $icerik . "</div>" ;
}?>