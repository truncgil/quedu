<?php $gundem="DATEDIFF(NOW(),tarih)<7"; ?>
<?php function games($tip="user") {
	global $user;		
	?>
		<div data-role="popup" id="oyunSec" data-theme="a"><ul data-role="listview" data-inset="true" style="min-width:210px;"><li data-role="list-divider"><?php le("Bir Konu Seçiniz") ?></li>
		<?php 	
			$kat = sorgu("select kat,count(*) AS toplam from soru 
			inner join content on soru.kat = content.slug
			where tip='soru' group by kat   order by rand() limit 0,100");
			while($f = kd($kat)) {
				$logo = catlogo($f['kat']);
				if(!file_exists("../file/".$logo)) {
					$logo = "onlylogo.png";	
				} else {
					$logo ="../file/$logo";
				}
				if($tip=="random") {
					$link = "selectuser.php?hemenoyna={$f['kat']}&user={$user['id']}";
				} else {
					$link = "category.php?slug={$f['kat']}";
				}
				$title = cattitle($f['kat']);
				if($title!="") {
				e("<li><a href='$link'><img src='$logo' width='64' class='center'  />$title</a></li>");
				}
			}
				
			?>
        </ul></div>
		<div data-role="popup" id="kelime_gelistirme" style="" data-theme="a"><ul data-role="listview" data-inset="true" style="min-width:210px;"><li data-role="list-divider"><?php le("Bir Konu Seçiniz") ?></li>
		<?php 	
			$kat = contents("kelime-gelistirme");
			while($f = kd($kat)) {
				$logo = catlogo($f['slug']);
				if(!file_exists("../file/".$logo)) {
					$logo = "onlylogo.png";	
				} else {
					$logo ="../file/$logo";
				}
				if($tip=="random") {
					$link = "selectuser.php?hemenoyna={$f['slug']}&user={$user['id']}";
				} else {
					$link = "category.php?slug={$f['slug']}";
				}
				$title = cattitle($f['slug']);
				if($title!="") {
				e("<li><a href='$link' style='background: #3B97D4;'><img src='$logo' width='64' class='center'  />$title</a></li>");
				}
			}
				
			?>
        </ul></div>
	<?php
} ?>
<?php 
function isMobile() {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}
 ?>
<?php function user2($id) {
		$adi = trim(username($id));
		if($adi!="") {
	?>
		<a href="profile2.php?id=<?php e($id) ?>" class="ui-btn ui-btn-inline users <?php echo user($id,"color") ?>">
			<?php profilepic($id); ?>
			<span><?php echo $adi ?></span>
		</a>
	<?php 
		}
} ?>
<?php function users($sql) { //bir kullanıcılar dizisi döndürür
	$sorgu = sorgu($sql);
	?>
	<?php
	while($s = kd($sorgu)) {
		$id = $s['uid'];
		$adi = trim(username($id));
		if($adi!="") {
	?>
		<a href="profile2.php?id=<?php e($id) ?>" class="ui-btn ui-btn-inline users <?php echo user($id,"color") ?>">
			<?php profilepic($id); ?>
			<span><?php echo $adi ?></span>
		</a>
	<?php 
		}
	}
	?>
	<?php
} ?>
<?php function trends() {
	?>
<?php $social = sorgu("select hash,count(*) as toplam from social where hash IS NOT NULL AND hash NOT LIKE '%Oyun%' group by hash ORDER BY tarih DESC,toplam DESC LIMIT 0,5"); ?>
		<?php if($social!=0) { ?>
		<div data-role="popup" id="trendsoylesi" class="clouds panelAlan">
			<h3><i class="fa fa-globe"></i> Trend Söyleşiler</h3>
			<ol data-role="listview" clasS="yatay ">
			<?php while($g = kd($social)) {
				if($g['hash']!="") {
				?>
				<li><a href="hashtag.php?tag=<?php e($g['hash']) ?>" class="clouds">#<?php e($g['hash']) ?></a></li>
				<?php
				}
			} ?>
			</ol>
		</div>
		<?php } ?>
		<div data-role="popup" id="yeniguncellenen" class="clouds panelAlan">
			<h3><i class="fa fa-refresh"></i> <?php le("Yeni Güncellenen") ?></h3>
			<?php $gundem = sorgu("select kat,MAX(id) from soru WHERE tip='soru' GROUP BY kat order by id DESC LIMIT 0,5"); ?>
			<ol data-role="listview" clasS="yatay">
			<?php while($g = kd($gundem)) {
				$title = cattitle($g['kat']);
				if($title!="") {
				?>
				<li><a href="category.php?slug=<?php e($g['kat']) ?>" class="clouds"><?php e($title) ?></a></li>
				<?php
				}
			} ?>
			</ol>
		</div>
		<div data-role="popup" id="trendkonular" class="clouds panelAlan" style="">
			<h3><i class="fa fa-list"></i> <?php le("Trend Konular") ?></h3>
			<?php $gundem = sorgu("select kat,tarih,COUNT(*) AS toplam from results WHERE datediff(now(),tarih)<30 group by kat ORDER BY MAX(tarih) DESC,toplam DESC LIMIT 0,5"); ?>
			<ol data-role="listview" clasS="yatay ">
			<?php while($g = kd($gundem)) {
				?>
				<li><a href="category.php?slug=<?php e($g['kat']) ?>" class="clouds"><?php e(cattitle($g['kat'])) ?></a></li>
				<?php
			} ?>
			</ol>
		</div>
		<div data-role="popup" id="populer" class=" panelAlan clouds">
		<h3><i class="fa fa-list"></i> <?php le("Bu Hafta Popüler") ?></h3>
		<?php $gundem = pop_user(); ?>
			<?php while($g = kd($gundem)) {
				user2($g['uid']);
			} ?>
		</div>
		<div data-role="popup" id="encokkazanan" class=" panelAlan clouds">
		<h3><i class="fa fa-list"></i> <?php le("En Çok Kazananlar") ?></h3>
		<?php $bw = best_winner(); ?>
			<?php while($b=kd($bw)) {
					user2($b['uid']);
			} ?>
		</div>
	<?php
} ?>
<?php function whilejson($sorgu,$tablo="") {
	printjson();
	$sorgu = sorgu($sorgu);
	$json = array();
	while($d = kd($sorgu)) {
		if($tablo!="") {
			switch($tablo) {
				case "play" :	
					if(isset($d['u1'])) $d['u1'] = user($d['u1'],"adi") . " " . user($d['u1'],"soyadi");
					if(isset($d['u2'])) $d['u2'] = user($d['u2'],"adi") . " " . user($d['u2'],"soyadi");
					$d['logo'] = catlogo($d['kat']);
					$d['kat'] = cattitle($d['kat']);
					$d['date'] = zf($d['date']);
				break;
			}
		}
		array_push($json,$d);
	}
	echo json_encode($json);
	
} ?>
<?php function nickname($uid) {
	$e = explode("@",user($uid,"mail"));
	return $e[0]."_".user($uid,"id");
} ?>
<?php function getcevap($c) {
	$dogru = $c['id']*3 +$c['dogru']; //soruların cevaplarını gizlemek için matematiksel algoritma
	if(strlen($c['val'])>25) {
		$class="cevap cevap2";
	}else {
		$class="cevap";
	}
	e("<a href='#' cevap='{$c['id']}' d='$dogru'  id='c1' class='ui-btn $class'>{$c['val']}</a>");
} ?>

<?php function user_score($kat,$uid=""){
	if($uid=="") {
		global $user;
		$uid = $user['id'];
	}
	 $t = kd(sorgu("select SUM(score) as toplam from scores where kat='$kat' and uid = $uid"));
	 return $t['toplam'];
	
} ?>
<?php function rasgele_user($kat,$uid=""){ //bir kategorideki rasgele oyuncuyu kendi seviyesine yakın olanı seçer
	//oyuncu puanı
	if($uid=="") {
		global $user;
		$uid = $user['id'];
	}
	$puan=user_score($kat,$uid);	//$kat kategorisindeki $uid kullanıcısının puanı
	$min = yuvarla($puan/4,2); 		//4 katı düşük olanı
	$max=yuvarla($puan*4,2);			//4 katı yüksek olanı
	$sql = "
	select uid,SUM(score) as toplam from scores 
	inner join uyeler on uyeler.id = scores.uid
	where kat='$kat' and uid<>{$user['id']} AND uyeler.seviye = '{$user['seviye']}' AND uyeler.bolum='{$user['bolum']}'
	group by uid 
	having (SUM(score)<$max and SUM(score)>$min) 
	order by rand()
	";
	//e($sql);
		$sorgu = sorgu($sql);
		$toplam = sToplam($sorgu);
	if($toplam<10) { // eğer karşılaşabileceğim oyuncu sayısı 10'dan küçük ise havuzdan rasgele seç
		$sql ="
		select uid,SUM(score) as toplam from scores 
		inner join uyeler on uyeler.id = scores.uid
		where uid<>{$user['id']} AND uyeler.seviye = '{$user['seviye']}'
		group by uid 
		order by rand()
		";
		$sorgu = sorgu($sql);
	}
	$u = kd($sorgu);
	return $u['uid'];
} ?>

<?php function intclear($str) {
	return preg_replace("/[^0-9]/","",$str);
} ?>
<?php function resultsocial(){
//e($_SERVER['PHP_SELF']);	
global $durum2;
global $global;
$id = veri(get("id"));
$game = kd(ksorgu("play","where id=$id"));
$at1 = nickname($game['u1']);
$at2 = nickname($game['u2']);
if($game['u1']==$user['id']) {
	$etiket = "@{$at2} ";
}elseif($game['u2']==$user['id']) {
	$etiket = "@{$at1} ";
} else {
	$etiket = "@{$at1} @{$at2} ";
}
dialogbox($durum2,"#{$_GET['id']}Oyunu: $etiket"); ?>
<div class="dialogzone">
<?php 
$id = veri("%".get("id")."%");
$zone = ksorgu("social","where hash LIKE $id ORDER BY id DESC");
while($z = kd($zone)) {
	socialbox($z);
}
 ?>	
</div>
<?php } ?>
<?php function sonuclar($sorgu) { 
global $user;
 $sonuclar = sorgu($sorgu); ?>
<?php while($s = kd($sonuclar)) {
	$user2 = user($s['uid2']);
	$user = user($s['uid']);
	$u1score = kd(ksorgu("scores","WHERE uid={$s['uid']} AND tarih='{$s['tarih']}'"));
	$u1score =$u1score['score'];
	$u2score = kd(ksorgu("scores","WHERE uid={$s['uid2']} AND tarih='{$s['tarih']}'"));
	$u2score = $u2score['score'];
	if($u1score<$u2score) {
		$ifade = "{$user['adi']} {$user['soyadi']}, {$user2['adi']} {$user2['soyadi']} kişisini yendi";
		$color="nephritis";
		$color2="emerland";
	} elseif($u1score<$u2score) {
		$ifade = "{$user['adi']} {$user['soyadi']}, {$user2['adi']} {$user2['soyadi']} kişisine yenildi";
		$color="pomegranate";
		$color2="carrot";
	} else {
		$ifade = "{$user['adi']} {$user['soyadi']}, {$user2['adi']} {$user2['soyadi']} kişisiyle berabere kaldı";
		$color="carrot";
		$color2="sunflower";
	}
	?>
	<?php 
		$ifade = "{$user2['adi']} {$user2['soyadi']} VS {$user['adi']} {$user['soyadi']}";
		$color="clouds";
		$color2="emerland";
	?>
	<a href="result2.php?id=<?php e($s['pid']) ?>" class="ui-btn <?php e($color) ?> resultitem">
	<img src="<?php e($user2['resim']) ?>" alt="" style="float:left;" class="profilepic" />
	<div class="user1uni"><?php if($user2['id']!="") unilogo($user2['id']) ?></div>
	<div class="user2uni"><?php if($user['id']!="") unilogo($user['id']) ?></div>
	<img src="<?php e($user['resim']) ?>" alt="" style="float:right;" class="profilepic" />
	<img src="onlylogo.png" alt="" style="
    width: 50px;
    height: 50px;" class="profilepic" />
	<?php le($ifade) ?>
	<span class="ui-btn sunflower" style="    font-size: 18px !important;padding:5px;position:absolute;right:10px;bottom:10px;"><?php e($u1score) ?></span>
	<span class="ui-btn sunflower" style="    font-size: 18px !important;padding:5px;position:absolute;left:10px;bottom:10px;"><?php e($u2score) ?></span>
	<span class="ui-btn <?php echo $color2 ?>" style="    font-size: 12px;position: relative;top: 0px;right: 0px;padding: 2px 6px;display: block;margin: 0 auto !important;width: 100px;"><?php e(zf($s['tarih'])); ?></span>
	</a>
	<?php
	
} ?>

<?php } ?>

<?php 
function console( $data ) {

    if ( is_array( $data ) )
        $output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
    else
        $output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";

    echo $output;
}
 ?>

<?php 
function google($title,$result=0,$start=0) {
	if($title!="") {
		$title = urlencode($title);
		$json = file_get_contents("http://ajax.googleapis.com/ajax/services/search/images?v=1.0&q=$title&start=$start");
		$obj = json_decode($json);
		return $obj->responseData->results[$result];
	}
}
 ?>
<?php function dialogbox($ph="Neler Oluyor?",$tags="") {
	global $user;
	?>
<div class="panelAlan clouds dialogbox">
<?php profilepic($user['id']); ?>
<i class="fa fa-refresh fa-spin yukleme" style="position: absolute;
    z-index: 1000;
    background: white;
    padding: 10px;
    border-radius: 82px;
    width: 32px;
    height: 32px;
    text-align: center;
    font-size: 32px;
	display:none
	" ></i>
	<form action="?ekle" method="post" class="dialogform">
	

		<textarea name="message" contenteditable="true" id="message" placeholder="<?php le($ph) ?>" cols="30" rows="10" onfocus="$(this).val('<?php e($tags) ?>')"></textarea>
		<button id="sendMessage" style="    border-bottom: none !important;
font-size: 34px !important;
/* right: 18px; */
width: 84px;"><i class="fa fa-paper-plane"></i></button>
	</form>
<clear></clear>
</div>
	<?php
} ?>
<?php
function socialbox($a){
	global $user;
	?>
<div class="panelAlan clouds dialogbox <?php if($a['uid']==$user['id']) e("me"); ?>" mid="<?php e($a['id']) ?>">
<?php profilepic($a['uid']); ?>
	<strong><a href="profile2.php?id=<?php e($a['uid']) ?>" ><?php e(username($a['uid'])) ?></a>: </strong><?php e(htlink($a['message'])); ?>
	<span class="date"><i class="fa fa-calendar"></i> <?php e(zf($a['tarih'])); ?></span>
	<?php if($a['uid']==$user['id']) { ?>
		<div data-role="navbar">
			<ul>
				<!--<li><a href=""><i class="fa fa-heart"></i> Favori</a></li>
				<li><a href=""><i class="fa fa-retweet"></i> İlet</a></li>-->
				<li><a class="deleteMessage" mid="<?php e($a['id']) ?>" href="?<?php if(getisset("tag")) e("tag={$_GET['tag']}&"); ?>sil=<?php e($a['id']) ?>"><i class="fa fa-trash"></i></a></li>
			</ul>
		</div>
	<?php } ?>
<clear></clear>
</div>	
	<?php
}
function removeht($str) {
	return preg_replace('#[^a-zöçşğüıİÖÜĞŞÇ0-9_]#i', '', $str);
}
function trigger2(){
	e('$("body").trigger( "create" );');
}
function trigger() { ?>
<script type="text/javascript">
$("body").trigger( "create" );
</script>
<?php
}
function emoji($str) {
	$str = str_replace(":)",'<i class="fa fa-smile-o"></i>',$str);
	$str = str_replace(":|",'<i class="fa fa-meh-o"></i>',$str);
	$str = str_replace(":(",'<i class="fa fa-frown-o"></i>',$str);
	return $str;
}
function htlink($str){
	//hastag
	$regex = "/#+([\w.]+)/";
	$regex2 = "/@+([\w.]+)/";

	//link
	$m = '|([\w\d]*)\s?(https?://([\d\w\.-]+\.[\w\.]{2,6})[^\s\]\[\<\>]*/?)|i';
	$r = '$1 <a href="$2" target="_blank">$3</a>';
	$str = preg_replace($regex, '<a href="hashtag.php?tag=$1">$0</a>', $str);
	$str = preg_replace($regex2, '<a href="profile2.php?id=$1">$0</a>', $str);
	$str = preg_replace($m, $r, $str);
	$str = emoji($str);
	return($str);
}

function ht($str){
	preg_match_all('/#([^\s]+)/', $str, $matches);
	$hashtags = implode(',', $matches[1]);
	return($hashtags);
}
function at($str){
	preg_match_all('/@([^\s]+)/', $str, $matches);
	$hashtags = implode(',', $matches[1]);
	return($hashtags);
}
 ?>
<?php function username($uid) {
	$user = user($uid);
	return "{$user['adi']} {$user['soyadi']}";
} ?>
<?php function fb_post($uid,$mesaj) {
	/*
global $facebook;
$uid = getFBID($uid);
$token = $facebook->getAccessToken();
$params = array(
  access_token => $token, 
  message 	   => $mesaj,
  link 		   => $link,
  picture 	   => $picture
);
$test = $facebook->api("/$uid/feed", "POST", $params);

*/
} ?>
<?php function getFBID($url) {
	$fb = explode("/",$url);
	return $fb[4];
} ?>
<?php function fb_bildirim($kisi_id,$mesaj,$url="http://zomni.xyz/m") {
	global $facebook;
	$kisi  = kd(ksorgu("uyeler","WHERE id = '$kisi_id'"));
	/*
	$fb = explode("/",$kisi['facebook']);
$token = $facebook->getAccessToken();
$response = $facebook->api("/{$fb[4]}/notifications",'POST',array(
                'template' => $mesaj,
                'href' => $url,
                'access_token' => $facebook->getAppId().'|'.$facebook->getApiSecret()
            ));  
			*/
} ?>
<?php function totalistek2() {
global $_SESSION;
$total = totalistek(oturum("uid"));

?>

<sayi <?php if($total==0) e("style='display:none'"); ?>><?php e($total) ?></sayi>
<?php } ?>
<?php function totalistek($id) {
	$t1=toplam("play","u2=$id AND u2score IS NULL AND u1score IS NOT NULL ORDER BY date DESC");
	$t2=toplam("log","uid=$id AND okundu=0");
	return $t1+$t2;
	
	
} ?>
<?php function zmail($uid,$konu,$html,$url="http://zomni.xyz/m/",$urlm="Giriş Yap") {
	require("../mail/include/class.php");
	
	$mail = user($uid,"mail");
	$year = date("Y");
$html = "
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml'>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
<title>Zomni Mail</title>
</head>

<body>
<table width='50%' style='    background: #306c7e;
    color: white;
    font-family: sans-serif;
    border-radius: 10px;
    padding: 15px;
    min-height: 300px;
	 text-shadow: 0px 2px 1px rgba(0, 0, 0, 0.25);
	' border='0' align='center'>
  <tr style='    height: 56px;'>
    <td>&nbsp;</td>
    <td align='center'><img src='http://zomni.xyz/m/logo2.png' /></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td style='    text-align: center;
    vertical-align: top;
   '>
	$html
	<a href='https://zomni.xyz/m/$url' style='    text-decoration: none;
    color: white;
    display: block;
    padding: 10px;
    background: #1C93B7;
    width: 100%;
    margin: 0 auto;
    border-radius: 6px;
    border-bottom: solid 3px rgba(0, 0, 0, 0.36);'>$urlm</a>
	</td>
    <td>&nbsp;</td>
  </tr>
  <tr style='    height: 10px;font-size:12px;'>
    <td>&nbsp;</td>
    <td align='center'>Zomni Eğitsel Oyun &copy $year </td>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
";
$mail_adresiniz	= "noreply@zomni.xyz";
$mail_sifreniz	= "Wy9dJ9Hz";
$gidecek_adres	= $mail;
$domain_adresi	= "zomni.xyz";
$mail = new PHPMail();
$mail->Host       = "smtp.".$domain_adresi;
$mail->SMTPAuth   = true;
$mail->Username   = $mail_adresiniz;
$mail->Password   = $mail_sifreniz;
$mail->IsSMTP();
$mail->AddAddress($gidecek_adres);
$mail->From       = $mail_adresiniz;
$mail->FromName   = "Zomni";
$mail->Subject    = $konu;
$mail->Body       = $html;
$mail->AltBody    = "Zomni Eğitsel Oyun";

$mail->Send();
	} ?>
<?php function logz($uid,$title,$html="",$url=""){
	dEkle("log",array(
		"uid" => $uid,
		"title" => $title,
		"html" => $html,
		"url" => $url,
		"tarih" => simdi()
	));
	fb_bildirim($uid,$html,$url);
	@zmail($uid,substr($html,0,50)."...",$html,$url);
} ?>
<?php function printjson(){
	ob_end_clean();
	header('Content-Type: application/json');
} ?>
<?php function profilepic($id) {
	$pic = kd(ksorgu("uyeler","WHERE id=$id"));
	if($pic['resim']!="") {
	e("<img class='profilepic' src='{$pic['resim']}' />");
	} else {
	e("<img class='profilepic' src='user.png' />");
		
	}
} ?>
<?php function usertabs() { 
global $user;
?>
<div data-role="tabs" id="tabs">
	<div data-role="navbar" id="navi">
		<ul>
			<li><a href="ajax.php?tip=heart" ajax><i class="fa fa-heart"></i>
			</a></li>
			<li><a href="ajax.php?tip=gamepad" ajax ><i class="fa fa-gamepad"></i>
				<span><?php echo totalgame($user['id']); ?></span>
			</a></li>
			<li class="ui-state-active"><a href="ajax.php?tip=gamepad" ajax ><i class="fa fa-list-alt"></i>
				<span><?php echo rand(10,99) ?></span>
			</a></li> 
			
			<li><a href="ajax.php?tip=envelope" ajax ><i class="fa fa-envelope"></i>
				<span><?php echo rand(10,99) ?></span>
			</a></li>
			<li><a href="ajax.php?tip=users" ajax><i class="fa fa-users"></i>
			<span>19</span>
			</a>
				
			</li>
			
		</ul>
	</div><!-- /navbar -->
		
	</div><!-- /tabs -->
<?php } ?>
<?php function usertabs2() { 
global $user;
global $gundem;
?>
<div data-role="popup" id="ilgialanlari" class="alizarin padding10 margin10 radius10">
	<h3 class="padding0 margin0"><i class="fa fa-heart"></i> <?php le("İlgi Alanları") ?></h3>
	<?php 
		$favorite = ksorgu("favorite","WHERE uid={$user['id']}");
		if($favorite!=0) {
			while($f = kd($favorite)) {
				$logo = catlogo($f['cat']);
				$title = cattitle($f['cat']);
				e("<a href='category.php?slug={$f['cat']}' class='ui-btn ui-btn-inline'><img src='../file/$logo' width='64' class='center'  />$title</a>");
			}
		} else {	
			e("<a href='category.php' class='ui-btn wisteria'><i class='fa fa-heart'></i>");
			le("Hemen Favorilerini Oluştur");
			e("</a>");
		}
	?>

</div>	
<?php if(totalgame2($user['id'])!=0) { ?>
<div id="basariyuzdesi"  class="clouds margin10 padding10 radius10" style="text-align:center;">
<h3 clasS="padding0 margin0 " style="text-align:left;"><i class="fa fa-pie-chart"></i> <?php le("Başarı Yüzdesi") ?></h3>
	<div id="canvas-holder" style="float:left;
    width: 50%;">
		<span><?php le("Tüm Zamanlar") ?></span>
		<canvas id="chart-area2"  style="display: block;width:100%"/>
</div>	
	<div id="canvas-holder" style="float:right;
    width: 50%;">
		<span><?php le("Bu Hafta") ?></span>
		<canvas id="week" style="display: block;width:100%"/>
	</div>
	<clear></clear>

	</div>

<script>

		

			$(function(){
				
				Chart.defaults.global.responsive = false;
				Chart.defaults.global.animation = false;
				var pieData = [
				{
					value: <?php e(toplam("results","uid={$user['id']} AND sonuc='Win'")) ?>,
					color: "#46BFBD",
					highlight: "#5AD3D1",
					label: "<?php le("Kazanılan Oyun") ?>"
				},
				{
					value: <?php e(toplam("results","uid={$user['id']} AND sonuc='Quits'")) ?>,
					color: "#FDB45C",
					highlight: "#FFC870",
					label: "<?php le("Berabere Kalınan Oyun") ?>"
				},
				{
					value: <?php e(toplam("results","uid={$user['id']} AND sonuc='Lost'")) ?>,
					color:"#F7464A",
					highlight: "#FF5A5E",
					label: "<?php le("Kaybetilen Oyun") ?>"
				}

				];
				<?php $gundem = "AND $gundem"; ?>
			//	console.log("<?php e($gundem); ?>");
				var pieData2 = [
				{
					value: <?php e(toplam("results","uid={$user['id']} AND sonuc='Win' $gundem")) ?>,
					color: "#46BFBD",
					highlight: "#5AD3D1",
					label: "<?php le("Kazanılan Oyun") ?>"
				},
				{
					value: <?php e(toplam("results","uid={$user['id']} AND sonuc='Quits' $gundem")) ?>,
					color: "#FDB45C",
					highlight: "#FFC870",
					label: "<?php le("Berabere Kalınan Oyun") ?>"
				},
				{
					value: <?php e(toplam("results","uid={$user['id']} AND sonuc='Lost' $gundem")) ?>,
					color:"#F7464A",
					highlight: "#FF5A5E",
					label: "<?php le("Kaybetilen Oyun") ?>"
				}

				];
					var ctx = document.getElementById("chart-area2").getContext("2d");
					window.myPie = new Chart(ctx).Doughnut(pieData);
					var ctx2 = document.getElementById("week").getContext("2d");
					window.myPie = new Chart(ctx2).Doughnut(pieData2);
				
				
			});
				
			



	</script>
<?php } ?>

<?php include("games.inc.php"); ?>
<?php } ?>
<?php function userdurum(){ 
global $user;
?>
	<form action="?durumekle" method="post" style="position:relative;margin:0 5px;">
		<input type="text" name="" id="" style="    font-size: 20px;    padding-right: 76px;
		height: 46px !important;"  placeholder="<?php le("Ne düşünüyorsun") ?>" />
		<button type="submit" style="    position: absolute;
		top: 1px;
		right: 2px;
		width: 50px;
		font-size: 20px;
    padding: 5px;"> <i class="fa fa-send"></i></button>
	</form>
<?php } ?>
<?php 
function bestwinner($uid) { //haftanın en çok kazananı
	global $gundem;
	
	$winner = sorgu("select uid,kat,count(sonuc) as toplam from results where sonuc='Win' and $gundem group by uid order by toplam DESC LIMIT 0,3");
	$k=1;
	$islem="";

	while($w = kd($winner)) {
		//e($w['uid']);
		if($w['uid']==$uid) {
			if($islem=="") { //bir şey bulunamadıysa
				return $k;
				
				$islem="ok"; //bulundu
			}
		} else {
			if($islem=="") { //bir şey bulunamadıysa
			//return -1;
			}
		}
		$k++;
		
	}
} ?>
<?php 
function best_winner() {
	global $gundem;
	return sorgu("select uid,kat,count(sonuc) as toplam from results where sonuc='Win' and $gundem  group by uid order by toplam DESC LIMIT 0,10");
} ?>
<?php function pop_user() {
	global $gundem;
	return sorgu("select uid,tarih,COUNT(*) AS toplam from results WHERE $gundem group by uid ORDER BY toplam DESC LIMIT 0,10");
	
} ?>
<?php function totalmesaj($uid) {
	global $user;
	echo "<sayi2>".toplam("message","u1={$user['id']} and okundu=0")."</sayi2>";
} ?>
<?php function userprofile() { 
global $user;
global $_SESSION;
?>
<div id="profil" class="<?php e($user['color']) ?>">
	<div id="cover" <?php if($user['cover']!="") { e("style=background:url({$user['cover']}) center "); } else { e("style=display:none"); }  ?>></div>
		<?php $sonrozet = kd(ksorgu("rozets","where uid={$user['id']}")); ?><?php if($sonrozet['rozet']!="") { ?><div class="rozet <?php e($sonrozet['rozet']); ?>"><span><?php echo cattitle($sonrozet['kat']); ?></span></div><?php } ?>
		<?php if($_SESSION['uid']==$user['id']) {?>
			<div style="position: absolute;z-index:1000;top:10px;left:10px;" class="clouds radius10">
				<a href="#bildirimler" see="ajax.php?tip=okundu" ajax="ajax.php?tip=gamepad" data-rel="popup" data-transition="slideup" class="ui-btn clouds" style="    "><i class="fa fa-globe" style="font-size:30px;"></i><?php totalistek2(oturum("uid")) ?></a>
				<a href="#mesajlar" blank="Mesajınız yok" ajax="ajax.php?tip=mesajlar" data-rel="popup" data-transition="slideup" class="ui-btn clouds" style="    "><i class="fa fa-envelope" style="font-size:30px;"></i><?php totalmesaj(oturum("uid")) ?></a>
			</div>
		<div data-role="popup" id="mesajlar">
		
		</div>
		<div data-role="popup" id="bildirimler">
			
		</div>
		<?php } ?>
		<?php 
		$winner = bestwinner($user['id']);
		if($winner!=0) { ?><div class="rozet rozet<?php e($winner) ?>"><span>Best Winner</span></div><?php } ?>
		<div id="resim" style="background:url(<?php e(ed($user['resim'],"user.png")); ?>) center;width:200px;height:200px;margin:0 auto;    border-radius:20px;
    border: solid 4px #fff;
    box-shadow: 0px 3px 8px #000;"></div>
		<div id="isim"><?php e($user['adi']) ?> <?php e($user['soyadi']) ?>
		
		<?php 
		$ben = veri(oturum("uid"));
		$istakip = ksorgu("friend","WHERE uid={$user['id']} AND uid2=$ben");
		if($istakip!=0) {
			?>
			<span style="    font-size: 12px;
    position: absolute;
    color: white;
    background: #CA0C0C;
    padding: 10px 5px;
    border-radius: 10px;
    margin: 10px;">
			<?php le("Seni takip ediyor"); ?>
			</span>
			<?php
		}
		?>
		
		</div>
		<!--<div id="unvan"><i class="fa fa-trophy"></i> İngilizce'nin Üstadı</div>-->
		<?php if($user['okul']!="") { ?><div id="okul"><i class="fa fa-university"></i>
		<?php e($user['okul']) ?> <br />
		<?php e($user['bolum']) ?>
		</div>
		<?php } ?>
		<?php if($user['location']!="") { ?><div id="sehir"><i class="fa fa-map-marker"></i> <?php e($user['location']) ?></div><?php } ?>
		<?php userstatus(); ?>
	</div>
<?php } ?>
<?php function ed($deger,$deger2){
	if($deger=="") {
		return $deger2;
	} else {
		return $deger;
	}
} ?>
<?php function totalgame($user) {
	$total = kd(sorgu("SELECT SUM(total) AS total FROM (
SELECT COUNT(*) AS total FROM play WHERE u1=$user
UNION ALL
SELECT COUNT(*) AS total FROM play WHERE u2=$user
)
derived
"));
return $total['total'];
} ?>
<?php function totalgame2($user) {
	$total = kd(sorgu("SELECT COUNT(*) AS total FROM results WHERE uid=$user"));
return $total['total'];
} ?>
<?php function userstatus() {
	global $user;
	?>
<div data-role="navbar">
	<ul>
		<li><a href="games.php" class="ui-btn belizehole"><span class="middleicon"><?php e(totalgame2($user['id'])) ?></span> Oyun</a></li>
		<li><a href="takip.php?id=<?php e($user['id']) ?>" class="ui-btn wetasphalt"><span class="middleicon"><?php e(following($user['id'])) ?></span> Takip Edilen</a></li>
		<li><a href="takip.php?ci&id=<?php e($user['id']) ?>" class="ui-btn asbestos"><span class="middleicon"><?php e(follower($user['id'])) ?></span> Takipçi</a></li>
	</ul>
</div>	
	<?php
} ?>
<?php function following($id) {
	return toplam("friend","uid=$id");
} ?>
<?php function follower($id) {
	return toplam("friend","uid2=$id");
} ?>
<?php function soru($id,$alan="") {
	$soru = kd(ksorgu("soru","WHERE tip='soru' AND id = $id"));
	if($alan=="") {
		return $soru;
	} else {
		return $soru[$alan];
	}
	
} ?>
<?php function cattitle($slug){
	$cat = kd(content($slug));
	return $cat['title'];
	
} ?>
<?php function catlogo($slug){
	$cat = kd(content($slug));
	if($cat['pic']!="") {
	return $cat['pic'];
	} else {
		$cat = kd(content($cat['kid']));
		return $cat['pic'];
	}
	
} ?>
<?php function cevaps($soru_id) {
	$cevaps = ksorgu("soru","WHERE tip='cevap' AND ust=$soru_id");
	$total = array();
	while($c = kd($cevaps)) {
		array_push($total,$c['id']);
	}
} ?>
<?php function unilogo($id) {
	
	$user = user($id);	
	if($user['okul']!="") {
		$pic = @kd(ksorgu("university","where title='{$user['okul']}'"));
		$pic = $pic['logo'];
		e("<img src='$pic' class='unilogo'/>");
	}
} ?>
<?php function user($id,$alan="") {
	$ne = kd(ksorgu("uyeler","WHERE id = $id"));
	if($alan!="") {
		return $ne[$alan];
	} else {
		return $ne;
	}
} ?>
<?php function content($slug,$where="") {
	$content = ksorgu("content","WHERE y=1 AND slug='$slug' $where");
	return $content;
} ?>
<?php function content_id($id,$where="") {
	$content = ksorgu("content","WHERE y=1 AND id='$id' $where");
	return $content;
} ?>
<?php function contents($slug,$where="") {
	$content = ksorgu("content","WHERE y=1 AND kid='$slug' $where ORDER BY s ASC");
	return $content;
} ?>
<?php function loading($hidden=false,$size=30){
	?>
<div class="loader" <?php if($hidden!=false) { e("style='display:none;'"); } ?>>
  <i class="fa fa-spinner bigicon" style="-webkit-animation: rotate 2s linear infinite;
    animation: rotate 2s linear infinite;
    z-index: 2;
    width: <?php e($size) ?>px;
    font-size: <?php e($size) ?>px;" ></i>
</div>	
	<?php
	
} ?>
<?php function le($ifade) {
	oturumAc();
	global $_COOKIE;
	if(!isset($_COOKIE['lang'])) {
		$_COOKIE['lang'] = "Türkçe";
	}
	$varmi = ksorgu("language","WHERE ifade='$ifade' AND lang='{$_COOKIE['lang']}'");
	if($varmi==0) {
		echo $ifade;
	} else {
		$i = kd($varmi);
		echo $i['deger'];
	}
	
} ?>
<?php function lr($ifade) {
	oturumAc();
	global $_COOKIE;
	if(!isset($_COOKIE['lang'])) {
		$_COOKIE['lang'] = "English";
	}
	$varmi = ksorgu("language","WHERE ifade='$ifade' AND lang='{$_COOKIE['lang']}'");
	if($varmi==0) {
		return $ifade;
	} else {
		$i = kd($varmi);
		return $i['deger'];
	}
	
} ?>
<?php function caticon($slug) {
	$kim = kd(ksorgu("content","WHERE slug='$id' AND y=1"));
	if($kim['pic']=="") {
		if($kim['kid']!="") {
			caticon($kim['kid']);
		} else {
			$icon = "logo.png";
		}
		
	} else {
		$icon = $kim['pic'];
	}
	return $icon;
} ?>
<?php 
$hiyerarsi="";
function hiyerarsi($id,$url="category.php",$title="<i class='fa fa-home'></i>") {
global $hiyerarsi;
	$kat = kd(ksorgu("content","WHERE slug='$id'"));
	$isim = $kat['title'];
	$a = $kat['slug'];
	if($kat['kid']!="") {
		$hiyerarsi =  "<li><a class='ui-btn ui-btn-inline' href='category.php?slug=$a'>$isim <i class='fa fa-chevron-right'></i></a></li>" . $hiyerarsi;
	}
	if($kat['kid']!="") {
		hiyerarsi($kat['kid']);
	}
	if($hiyerarsi!="") {
		return "<div  data-role='navbar'><ul><li><a class='ui-btn ui-btn-inline' href='$url'>$title</a></li> $hiyerarsi</ul></div>";
	} else {
		return "";
	}
}
 ?>