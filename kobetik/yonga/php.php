<?php require_once('siniflar/class.upload.php');
?>
<?php function ed($deger,$degilse_deger="") {
	if($deger!="") {
		echo $deger;
	} else {
		echo $degilse_deger;
	}
} ?>
<?php 
function para($val,$r=2)
{
$veri = number_format($val,$r,",",".");
$veri = str_replace(",000000000","",$veri);
if($val!=0) { 
    return "<div class='fa fa-try'></div> ".  $veri;
}

}

?>

<?php function truncgil(){
	echo "<a href='http://truncgil.com/' target='_blank'><img src='kobetik/truncgil.png' width='100' alt='' /></a>";
} ?>
<?php function strtoupperTR($str)
{
$str = str_replace(array('i', 'ı', 'ü', 'ğ', 'ş', 'ö', 'ç'), array('İ', 'I', 'Ü', 'Ğ', 'Ş', 'Ö', 'Ç'), $str);
return strtoupper($str);
}
 ?>
<?php 
function slug($str, $ayrac='-') {
	$sonuc = @iconv('UTF-8', 'ASCII//TRANSLIT', $str);
	$sonuc = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $sonuc);
	$sonuc = strtolower(trim($sonuc, '-'));
	$sonuc = preg_replace("/[\/_|+ -]+/", $ayrac, $sonuc);
	return $sonuc;
}
?>
<?php function buyuKar($metin){
return strtoupper( strtr( $metin,'ğüşıiöç', 'ĞÜŞIİÖÇ') );
} ?>
<?php function kucuKar($metin){
return strtolower(strtr( $metin,'ĞÜŞIİÖÇ','ğüşıiöç'));
} ?>
<?php function turkceTarih($tarih) {
$gunDizi = array("","Pazartesi","Salı","Çarşamba","Perşembe","Cuma","Cumartesi","Pazar");
$ayDizi = array("","Ocak","Şubat","Mart","Nisan","Mayıs","Haziran","Temmuz","Ağustos","Eylül","Ekim","Kasım","Aralık");
return buyukTarih($tarih,$gunDizi,$ayDizi);
} ?>
<?php function tAy($tarih) {
$gunDizi = array("","Pazartesi","Salı","Çarşamba","Perşembe","Cuma","Cumartesi","Pazar");
$ayDizi = array("","Ocak","Şubat","Mart","Nisan","Mayıs","Haziran","Temmuz","Ağustos","Eylül","Ekim","Kasım","Aralık");
return buyukTarih($tarih,$gunDizi,$ayDizi,"diger","ay");
} ?>
<?php function buyukTarih($tarih="",$gunDizi,$ayDizi,$tur="hepsi",$icerik="gun") {
$tarih = explode("-",$tarih);
$tarih = mktime(0,0,0,$tarih[1],$tarih[2],$tarih[0]);
$t = getdate($tarih);
if($tur=="hepsi") {
	return sprintf("%s %s %s %s",$t['mday'],$ayDizi[$t['mon']],$gunDizi[$t['wday']],$t['year']);
} else {
	$diziTarih = array(
		"gun" => $t['mday'],
		"ay" => $ayDizi[$t['mon']],
		"gunIsim" => $gunDizi[$t['wday']],
		"yil" => $t['year']
	);
	return $diziTarih[$icerik];
}
} ?>
<?php 
class MobilAlgi
{

	protected $accept;
	protected $userAgent;
	protected $isMobile = false;
	protected $isAndroid = null;
	protected $isAndroidtablet = null;
	protected $isIphone = null;
	protected $isIpad = null;
	protected $isBlackberry = null;
	protected $isBlackberrytablet = null;
	protected $isOpera = null;
	protected $isPalm = null;
	protected $isWindows = null;
	protected $isWindowsphone = null;
	protected $isGeneric = null;
	protected $devices = array(
		"android" => "android.*mobile",
		"androidtablet" => "android(?!.*mobile)",
		"blackberry" => "blackberry",
		"blackberrytablet" => "rim tablet os",
		"iphone" => "(iphone|ipod)",
		"ipad" => "(ipad)",
		"palm" => "(avantgo|blazer|elaine|hiptop|palm|plucker|xiino)",
		"windows" => "windows ce; (iemobile|ppc|smartphone)",
		"windowsphone" => "windows phone os",
		"generic" => "(kindle|mobile|mmp|midp|pocket|psp|symbian|smartphone|treo|up.browser|up.link|vodafone|wap|opera mini)"
	);

	public function __construct()
	{
		$this->userAgent = $_SERVER['HTTP_USER_AGENT'];
		$this->accept = $_SERVER['HTTP_ACCEPT'];

		if (isset($_SERVER['HTTP_X_WAP_PROFILE']) || isset($_SERVER['HTTP_PROFILE'])) {
			$this->isMobile = true;
		} elseif (strpos($this->accept, 'text/vnd.wap.wml') > 0 || strpos($this->accept, 'application/vnd.wap.xhtml+xml') > 0) {
			$this->isMobile = true;
		} else {
			foreach ($this->devices as $device => $regexp) {
				if ($this->isDevice($device)) {
					$this->isMobile = true;
				}
			}
		}
	}

	/**
	 * Overloads isAndroid() | isAndroidtablet() | isIphone() | isIpad() | isBlackberry() | isBlackberrytablet() | isPalm() | isWindowsphone() | isWindows() | isGeneric() through isDevice()
	 *
	 * @param string $name
	 * @param array $arguments
	 * @return bool
	 */
	public function __call($name, $arguments)
	{
		$device = substr($name, 2);
		if ($name == "is" . ucfirst($device) && array_key_exists(strtolower($device), $this->devices)) {
			return $this->isDevice($device);
		} else {
			trigger_error("Method $name not defined", E_USER_WARNING);
		}
	}

	/**
	 * Returns true if any type of mobile device detected, including special ones
	 * @return bool
	 */
	public function isMobile()
	{
		return $this->isMobile;
	}

	protected function isDevice($device)
	{
		$var = "is" . ucfirst($device);
		$return = $this->$var === null ? (bool) preg_match("/" . $this->devices[strtolower($device)] . "/i", $this->userAgent) : $this->$var;
		if ($device != 'generic' && $return == true) {
			$this->isGeneric = false;
		}

		return $return;
	}

}
 ?>
<?php 
function WebTarayici()
{
    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    $bname = 'Bilinmiyor';
    $platform = 'Bilinmiyor';
    $version= "";

    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'linux';
    }
    elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'mac';
    }
    elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'windows';
    }
   
    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent))
    {
        $bname = 'Internet Explorer';
        $ub = "MSIE";
    }
    elseif(preg_match('/Firefox/i',$u_agent))
    {
        $bname = 'Mozilla Firefox';
        $ub = "Firefox";
    }
    elseif(preg_match('/Chrome/i',$u_agent))
    {
        $bname = 'Google Chrome';
        $ub = "Chrome";
    }
    elseif(preg_match('/Safari/i',$u_agent))
    {
        $bname = 'Apple Safari';
        $ub = "Safari";
    }
    elseif(preg_match('/Opera/i',$u_agent))
    {
        $bname = 'Opera';
        $ub = "Opera";
    }
    elseif(preg_match('/Netscape/i',$u_agent))
    {
        $bname = 'Netscape';
        $ub = "Netscape";
    }
   
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
    ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
    }
   
    $i = count($matches['browser']);
    if ($i != 1) {
        if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
            $version= $matches['version'][0];
        }
        else {
            $version= $matches['version'][1];
        }
    }
    else {
        $version= $matches['version'][0];
    }
   
    if ($version==null || $version=="") {$version="?";}
   
    return array(
        'uzunAd' => $u_agent,
        'isim'      => $bname,
        'versiyon'   => $version,
        'platform'  => $platform,
        'desen'    => $pattern
    );
}

 ?>
<?php function kelime($metin,$sayi) { 
	$dilim = explode(" ",$metin);
	$toplam = count($dilim);
	$sonuc="";
	if ($toplam>=$sayi) {
	for ($k=0;$k<=$sayi;$k++) {
		@$sonuc = $sonuc . " " . $dilim[$k];
	}
		@$sonuc = $sonuc . "...";
	} else  {
		@$sonuc = $metin;
	}
	return $sonuc;
}
?>
<?php function e($deger) {
		echo $deger;
} ?>
<?php function dosyaVarmi($adres) {
	if (file_exists($adres)) {
		return true;
	} else {
		return false;
	}
} ?>
<?php function dizgeSayi($veri,$ayrac="\n") {
return count(explode($ayrac, $veri));
} ?>
<?php function dizge($veri,$ayrac="\n") {
return explode($ayrac, $veri);
} ?>
<?php 
function dosyaBilgi($url,$bilgi="uzanti") {
$path_parts = pathinfo($url);

switch ($bilgi) {
	case "klasor" : 
		return $path_parts['dirname'];
		break;
	case "tamDosya" :
		return $path_parts['basename'];
		break;
	case "uzanti" :
		return $path_parts['extension'];
		break;
	case "dosya" : 
		return $path_parts['filename']; 
		break;
	default :
		return $path_parts['extension'];
		break;		
		}
}
?> 
<?php function dosyaKopyala($url, $klasor) { 
	@$dosya = fopen($url,"rb");
	if (!$dosya) {
		return false;
	} else {
		$isim = basename($url);
		$dc = fopen($klasor."$isim","wb");
		while (!feof($dosya)) {
			$satir = fread($dosya,1028);
			fwrite($dc,$satir);
		}
		fclose($dc);
		return $isim;
	}
		

}
?>
<?php function dosya_sil($url) {
	return unlink($url);
	}
 ?>
<?php
function yukleme_body($baslik="Çoklu Dosya Yükle", $aciklama="Birden fazla dosyayı seçiniz") { ?>
         <div class="ekle_form">
          <div id="swfupload-control">
                <p align="center"><input type="button" id="button" /></p>
                <p id="queuestatus" ></p>
            <ol id="log"></ol>
          </div>
          </div>

<?php } ?>
<?php function yukleme_head($url, $turler="*.*", $taciklama="Tüm Dosyalar", $post_param="", $boyut=4096, $limit=100,$gurl="",$debug="false") { ?>
<script type="text/javascript" src="kobetik/eklentiler/js/swfupload/swfupload.js"></script>
<script type="text/javascript" src="kobetik/eklentiler/js/jquery.swfupload.js"></script>
<link rel="stylesheet" href="kobetik/eklentiler/js/jquery.swfupload.css" type="text/css" />
<script type="text/javascript">

$(function(){
	$('#swfupload-control').swfupload({
		upload_url: "<?php echo $url ?>",
		file_post_name: 'uploadfile',
		file_size_limit : "<?php echo $boyut ?>",
		file_types : "<?php echo $turler ?>",
		file_types_description : "<?php echo $taciklama ?>",
		file_upload_limit : <?php echo $limit ?>,
		flash_url : "kobetik/eklentiler/js/swfupload/swfupload.swf",
		button_image_url : 'kobetik/eklentiler/js/swfupload/resim_yukle_buton.png',
		button_width : 114,
		button_height : 29,
		button_placeholder : $('#button')[0],
		post_params: { 
			<?php echo $post_param ?>
			},
		debug: <?php echo $debug ?>
	})
		.bind('fileQueued', function(event, file){
			var listitem='<li id="'+file.id+'" >'+
				'Dosya: <em>'+file.name+'</em> ('+Math.round(file.size/1024)+' KB) <span class="progressvalue" ></span>'+
				'<div class="progressbar" ><div class="progress" ></div></div>'+
				'<p class="status" >Bekliyor</p>'+
				'<span class="cancel" >&nbsp;</span>'+
				'</li>';
			$('#log').append(listitem);
			$('li#'+file.id+' .cancel').bind('click', function(){
				var swfu = $.swfupload.getInstance('#swfupload-control');
				swfu.cancelUpload(file.id);
				$('li#'+file.id).slideUp('fast');
			});
			// start the upload since it's queued
			$(this).swfupload('startUpload');
		})
		.bind('fileQueueError', function(event, file, errorCode, message){
			alert(+file.name+' dosyası çok büyük');
		})
		.bind('fileDialogComplete', function(event, numFilesSelected, numFilesQueued){
											 if(numFilesSelected!=0) {
			$('#queuestatus').text('Seçilen dosya sayısı: '+numFilesSelected+' / Yüklemesi kabul edilen dosya sayısı: '+numFilesQueued);
											 }
		})
		.bind('uploadStart', function(event, file){
			$('#log li#'+file.id).find('p.status').text('Şu anda yükleniyor. Lütfen bekleyin. Yükleme uzun süre yanıt vermezse yüklemeyi yeniden başlatın.');
			$('#log li#'+file.id).find('span.progressvalue').text('0%');
			$('#log li#'+file.id).find('span.cancel').hide();
		})
		.bind('uploadProgress', function(event, file, bytesLoaded){
			//Show Progress
			var percentage=Math.round((bytesLoaded/file.size)*100);
			$('#log li#'+file.id).find('div.progress').css('width', percentage+'%');
			$('#log li#'+file.id).find('span.progressvalue').text(percentage+'%');
		})
		.bind('uploadSuccess', function(event, file, serverData){
			var item=$('#log li#'+file.id);
			item.find('div.progress').css('width', '100%');
			item.find('span.progressvalue').text('100%');
			var pathtofile='<a href="uploads/'+file.name+'" target="_blank" >view &raquo;</a>';
			item.addClass('success').find('p.status').html('Tamamlandı');
			<?php if ($gurl!="") {?>
			location.href='<?php echo $gurl ?>';
			<?php } ?>
		})
		.bind('uploadComplete', function(event, file){
			// upload has completed, try the next one in the queue
			$(this).swfupload('startUpload');
		})
	
});	

</script>
<?php } ?>
<?php 
function xmlcikti() {
	return header("Content-Type:text/xml");
}
?>
<?php 
function anakel($metin) {
	$dizi = explode(" ",$metin);
	$son = count($dizi);
	$sonuc = "";
	for($i=0; $i<count($dizi); $i++){
	  $sonuc = $sonuc .  $dizi[$i].", ";
	} 
	$son = strlen($sonuc);
	return substr($sonuc,0,$son-2);
}

?>
<?php 
function zf($d2){
 $d1 = date('Y-m-d H:i:s');
 
    if(!is_int($d1)) $d1=strtotime($d1);
    if(!is_int($d2)) $d2=strtotime($d2);
    $d=abs($d1-$d2);
if ($d1-$d2<0) {
$ifade = "sonra";
} else {
$ifade = "önce";
 }
$once = " "; 
    if($d>=(60*60*24*365))    $sonuc  = $once . floor($d/(60*60*24*365)) . " yıl $ifade";
    else if($d>=(60*60*24*30))     $sonuc = $once . floor($d/(60*60*24*30)) . " ay $ifade";
    else if($d>=(60*60*24*7))  $sonuc  = $once . floor($d/(60*60*24*7)) . " hafta $ifade";
    else if($d>=(60*60*24))    $sonuc  = $once . floor($d/(60*60*24)) . " gün $ifade";
    else if($d>=(60*60))   $sonuc = $once . floor($d/(60*60)) . " saat $ifade";
    else if($d>=60) $sonuc  = $once . floor($d/60)  . " dakika $ifade";
	else $sonuc = "Az $ifade";
 
    return $sonuc;
}

?>
<?php 
function zfa($d1, $d2=null, $format="*"){
    if($d2==null){
        $d2=$d1;
        $d1=time();
    }
 
    if(!is_int($d1)) $d1=strtotime($d1);
    if(!is_int($d2)) $d2=strtotime($d2);
    $d=abs($d1-$d2);
 
    $format=strtolower($format);
    if(empty($format)) $format="*";
 
    $result = array();
 
    if($format=="*" || $format=="gun")    $result["gun"]   = floor($d/(60*60*24));
    if($format=="*" || $format=="ay")     $result["ay"] = floor($d/(60*60*24*30));
    if($format=="*" || $format=="yil")    $result["yil"]  = floor($d/(60*60*24*365));
    if($format=="*" || $format=="hafta")  $result["hafta"]  = floor($d/(60*60*24*7));
    if($format=="*" || $format=="saat")   $result["saat"]  = floor($d/(60*60));
    if($format=="*" || $format=="dakika") $result["dakika"]= floor($d/60);
 
    if($format!="*") return $result[$format];
    else return $result;
}

?>
<?php 
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

?>
<?php function cikis($soturum,$sseviye,$adres) {?>
<?php 
$cikis_link = $_SERVER['PHP_SELF']."?cikis=tamam";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $cikis_link .="&". htmlentities($_SERVER['QUERY_STRING']);
}

  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION[$soturum] = NULL;
  $_SESSION[$sseviye] = NULL;
  unset($_SESSION[$soturum]);
  unset($_SESSION[$sseviye]);
  $logoutGoTo = $adres;
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;

}
?>
<?php }?>
<?php 
function oturumisset($isim) {
	if (isset($_SESSION[$isim])) {
		return 1;
	} else {
		return 0;
	}
}
 ?>
<?php function oturumAc($sonuc="") { 
	if (!isset($_SESSION)) {
	  session_start();
	  echo $sonuc;
	}
	}
?>
<?php function giris($oturum="KByonetim",$odeger="kobetik",$seviye="yonetici",$adres="index.php") {?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}
?>
<?php
    $_SESSION[$oturum] = $odeger;
    $_SESSION['Seviye'] = $seviye;
	  header("Location: ". $adres); 
	  exit;

?>
<?php } ?>
<?php function izin($oturum="KByonetim",$seviye="yonetici",$yer="giris.php") {
	?>
<?php 
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = $seviye;
$MM_donotCheckaccess = "false";

$MM_restrictGoTo = $yer;
if (!((isset($_SESSION[$oturum])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION[$oturum], $_SESSION['Seviye'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "izin_gerekli=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}

?>
<?php }?>
<?php 
function yonlendir($url) {
	return header("Location: " . $url);;
}
?>
<?php 
function get($isim) {
	if (isset($_GET[$isim])) { 
		return $_GET[$isim];
	} else {
		return "";
	}
}

function getisset($isim) {
	if (isset($_GET[$isim])) { 
		return 1;
	} else {
		return 0;
	}
}
?>
<?php 
function postEsit($post,$deger) {
	$post = post($post);
	if($post==$deger) {
		return 1;
	} else {
		return 0;
	}
}
function oturumEsit($oturum,$deger) {
	$oturum = oturum($oturum);
	if($oturum==$deger) {
		return 1;
	} else {
		return 0;
	}
}
function getEsit($get,$deger) {
	$get = get($get);
	if($get==$deger) {
		return 1;
	} else {
		return 0;
	}
}

function post($isim) {
	if (isset($_POST[$isim])) { 
		return $_POST[$isim];
	} else {
		return "";
	}
}
function postisset($isim) {
	if (isset($_POST[$isim])) { 
		return 1;
	} else {
		return 0;
	}
}

?>
<?php function tani($deger) {
	return isset($deger);
} ?>
<?php 
function oturum($isim,$deger="") {
	if (isset($_SESSION[$isim])) {
		if ($deger=="") {
			return $_SESSION[$isim];
		} else {
			$_SESSION[$isim] = $deger;
			return $_SESSION[$isim];
		}
	} elseif ($deger!="") {
		$_SESSION[$isim] = $deger;
		return $_SESSION[$isim];

	}
}

?>
<?php function oturum_olustur($isim,$deger) {
	return $_SESSION[$isim]=$deger; 

} ?>
<?php function oturumSil($isim) {
			$_SESSION[$isim] = NULL;
			unset($_SESSION[$isim]);
} ?>
<?php 
function cerez($isim,$deger="") {
	if (isset($_COOKIE[$isim])) {
		if ($deger=="") {
			return $_COOKIE[$isim];
		} else {
			setcookie($isim, $deger);
			return $_COOKIE[$isim];
		}
	} elseif ($deger!="") {
		setcookie($isim, $deger);
		return $_COOKIE[$isim];

	}
}
?>
<?php 
function ip() {
	return $_SERVER['REMOTE_ADDR'];
}
?>
<?php function hok($veri) {
	$veri = htmlspecialchars($veri);
	return $veri;
}
?>
<?php function tirnak($veri) {
	$veri = htmlspecialchars($veri, ENT_QUOTES);
	return $veri;
}
?>
<?php function kripto($veri) {
	$veri = md5($veri);
	return $veri;
}
?>
<?php function eger($kosul,$dogru,$yanlis=NULL) {
	if ($kosul) {
		 return $dogru;
	} else {
		 return $yanlis;
	}
}
?>
<?php function yuvarla($sayi,$basamak) {
	return round($sayi,$basamak);
}
?>
<?php function ykirp($yazi,$ilk,$son) {
	return substr($yazi,$ilk,$son);
}
?>
<?php function posta($kim, $baslik, $mesaj,$from="Siteden Mesaj") {
$bas .= "To: <$kim>" . "\r\n";
$bas .= "From: $from" . "\r\n";
$bas  = 'MIME-Version: 1.0' . "\r\n";
$bas .= 'Content-type: text/html; charset=utf-8' . "\r\n";
return mail($kim, $baslik, $mesaj, $bas);

}
?>
<?php function trd($yazi) {
	$yazi = mb_strtolower($yazi,'UTF-8');
	$tr = array('ç','Ç','ö','Ö','ü','Ü','ı','İ','ğ','Ğ','ş','Ş');
	$ing = array('c','C','o','O','u','U','i','I','g','G','s','S');
	$yazi = str_replace($ing,$tr,$yazi);
	return $yazi;
}
?>
<?php function bugun() {
	return date('Y-m-d');
}
?>
<?php function simdi() {
	return date('Y-m-d H:i:s');
}
?>
<?php 
function tt($tarih) {
	$tarih = date_format(date_create($tarih), 'd/m/Y');
	return $tarih;
}
?>
<?php 
function tarih($tarih) {
	//$tarih = date_format(date_create($tarih), $format);
	return substr($tarih,0,4);
}
?>
<?php 
function tarihf($tarih,$format="Y") {
	$tarih = date_format(date_create($tarih), $format);
	return $tarih;
}
?>
<?php 
function yukle($dosya,$url,$isim="",$tur="normal",$resim=1024) {
if ($_FILES[$dosya]['tmp_name']!="") {
	$upload = new upload($_FILES[$dosya]);

	if ($upload->uploaded)
	{
		$upload->file_auto_rename = true;
		if ($isim!="") {
		$upload->file_new_name_body	  = $isim;
		}
		if ($tur=="resim") {
		
		$upload->image_resize         = true;
		$upload->image_x              = $resim;
		$upload->image_ratio_y        = true;
		}
		$upload->process($url);
	 
		if ($upload->processed)
		{
			 $cikti = $upload->file_dst_name; 
			$upload->clean();
		}
		else
		{
			$cikti = "yok";
		}
	}
	return $cikti;
} else {
return "";
}
}
?>