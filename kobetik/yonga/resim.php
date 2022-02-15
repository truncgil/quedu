<?php
 
error_reporting(0);
 
// Gösterilecek resmin yolu.
$p = $_GET['p'];
 
// Resmin istenilen geniþliði.
// Olasý kötü amaçlý kullanýmlara karþý maximum geniþliði 1024px olarak ayarlýyoruz.
$w = intval($_GET['w']) > 1024 ? 1024 : intval($_GET['w']);
 
// Resmin istenilen yüksekliði
// Olasý kötü amaçlý kullanýmlara karþý maximum yüksekliði 768px olarak ayarlýyoruz
$h = intval($_GET['h']) > 768 ? 768 : intval($_GET['h']);
 
// Belirtilen resim dosya sisteminde varsa...
if(file_exists($p)) {
	// Dosya adýný ve uzantýsýný ayrý ayrý al.
	$dosyaAdi 	= substr($p, 0, strrpos($p, '.'));
	$uzanti 	= substr($p, strrpos($p, '.'));
 
	// Thumbnail dosya adýný öðren
	/**
	 * Thumbnail dosya adý, scriptin sonraki çalýþmasýnda kontrol edeceði
	 * içinde istenilen geniþliðin ve yüksekliðin belirtildiði isimdir.
	 * Örneðin thumb.php?p=resim.jpg&w=100&h=75 þeklinde çalýþtýrýlan script
	 * için thumbnail dosya adý "resim_100_75.jpg" olarak belirlenecektir.
	 */
	$thumbFileName = $dosyaAdi;
	$thumbFileName .= $w>0 ? '_w'.$w : '';
	$thumbFileName .= $h>0 ? '_h'.$h : '';
	$thumbFileName .= $uzanti;
 
	// Ýstenilen ölçülerde thumbnail daha önce talep edilmiþ ve dosya sistemine kaydedilmiþse...
	if(file_exists($thumbFileName)) { // ... thumbnail dosyasýna yönlen ve çalýþmayý durdur.
		header("Location: {$thumbFileName}");
		exit;
	} else { // ... ilk defa talep edilen thumbnail dosyasý için çalýþmaya baþla
 
		// Resmin bilgilerini al
		$resim = getimagesize($p);
 
		if($w && !$h) { // Max. Geniþlik manuel olarak belirtilmiþ ve yükseklik belirtilmemiþse...
			// ... geniþliði istenilen ölçüye getir ...
			$genislik = $w;
			// ... yüksekliði geniþliðe orantýlý bir þekilde hesapla.
			$yukseklik = round(($genislik*$resim[1])/$resim[0]);
		} elseif(!$w && $h) { // Max. Yükseklik manuel olarak belirtilmiþse ve geniþlik belirtilmemiþse
			// ... yüksekliði istenilen ölçüye getir ...
			$yukseklik = $h;
			// ... geniþliði yüksekliðe orantýlý bir þekilde hesapla.
			$genislik = round(($yukseklik*$resim[0])/$resim[1]);
		} elseif($w && $h) { // Her iki özellikte manuel olarak belirtilmiþse ...
			// ... özellikleri istenilen ölçüye getir.
			$yukseklik = $h;
			$genislik = $w;
		} else { // Her iki ölçü de girilmemiþse ana resme git ve çalýþmayý durdur.
			header('Location: '. $p);
			exit;
		}
 
		// Resmin türüne göre ana resmi belleðe kopyala
		switch($resim[2]) {
			case 1: // GIF
				$kopya_resim = imagecreatefromgif($p);
				$resim_mime_type = 'image/gif';
				break;
			case 2: // JPG
				$kopya_resim = imagecreatefromjpeg($p);
				$resim_mime_type = 'image/jpeg';
				break;
			case 3: // PNG
				$kopya_resim = imagecreatefrompng($p);
				imagealphablending($kopya_resim, false);
				imagesavealpha($kopya_resim, true);
				$resim_mime_type = 'image/png';
				break;
		}
 
		// Belirlenen ölçülerde boþ bir resim oluþtur
		$thumb = imagecreatetruecolor($genislik, $yukseklik);
		// Belleðe kopyalanan ana resmi istenilen ölçülere göre küçülterek oluþturulan resmi
		// az önce oluþturduðumuz boþ resmin içine yazdýr.
		imagecopyresampled($thumb, $kopya_resim, 0, 0, 0, 0, $genislik, $yukseklik, $resim[0], $resim[1]);
 
		if($h) {
			/**
			 * Eðer maximum yükseklik deðeri manuel olarak girilmiþse ve bu deðer
			 * scriptin oluþturduðu deðerden farklýysa scriptin otomatik deðeri yoksayýlýp
			 * elle girilen deðer dikkate alýnarak thumbnail yeniden boyutlandýrýlýr
			 */
 
			if($yukseklik>$h) $yukseklik = $h;
 
			$thumb2 = imagecreatetruecolor($genislik, $yukseklik);
 
			imagecopy($thumb2, $thumb, 0, 0, 0, (($h-$yukseklik)/2), $genislik, $yukseklik);
			$sonuc = $thumb2;
		} else {
			$sonuc = $thumb;
		}
 
		/** Ýstenilen boyuttaki thumbnail artýk hazýr
		 * Resmin türüne göre oluþturulan thumbnaili dosya sistemine yazdýrmayý deneyeceðiz.
		 * Resmin bulunduðu klasörün yazma izinleri verilmiþse thumbnail dosyasý yukarýda
		 * ayarlanan isimle klasöre kaydedilir ve script kaydedilen bu dosyaya yönlendikten sonra
		 * çalýþmayý durdurur. Yazma izinlerinde sorun varsa -ki bu scriptin esprisini yok eder-
		 * oluþturulan thumbnail'i direkt olarak browser'a yollar ve her seferinde yukarýdaki iþlemleri yapar
		 */
 
		switch($resim[2]) {
			case 1: // GIF
				if(@imagegif($sonuc,$thumbFileName)) {
					header('Location: '.$thumbFileName);
					exit;
				} else {
					header("Content-Type: {$resim_mime_type}");
					imagegif($sonuc);
				}
				break;
			case 2: // JPG
				if(@imagejpeg($sonuc,$thumbFileName,80)) {
					header('Location: '.$thumbFileName);
					exit;
				} else {
					header("Content-Type: {$resim_mime_type}");
					imagejpeg($sonuc,NULL,80);
				}
				break;
			case 3: // PNG
				if(@imagepng($sonuc,$thumbFileName)) {
					header('Location: '.$thumbFileName);
					exit;
				} else {
					header("Content-Type: {$resim_mime_type}");
					imagepng($sonuc);
				}
				break;
		}
 
		// Tüm iþlemler bittikten sonra bellek boþaltýlýp bir nebze olsun sunucu rahatlatýlýr
		imagedestroy($sonuc);
		
	}
}
?>