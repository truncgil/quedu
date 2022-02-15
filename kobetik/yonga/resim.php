<?php
 
error_reporting(0);
 
// G�sterilecek resmin yolu.
$p = $_GET['p'];
 
// Resmin istenilen geni�li�i.
// Olas� k�t� ama�l� kullan�mlara kar�� maximum geni�li�i 1024px olarak ayarl�yoruz.
$w = intval($_GET['w']) > 1024 ? 1024 : intval($_GET['w']);
 
// Resmin istenilen y�ksekli�i
// Olas� k�t� ama�l� kullan�mlara kar�� maximum y�ksekli�i 768px olarak ayarl�yoruz
$h = intval($_GET['h']) > 768 ? 768 : intval($_GET['h']);
 
// Belirtilen resim dosya sisteminde varsa...
if(file_exists($p)) {
	// Dosya ad�n� ve uzant�s�n� ayr� ayr� al.
	$dosyaAdi 	= substr($p, 0, strrpos($p, '.'));
	$uzanti 	= substr($p, strrpos($p, '.'));
 
	// Thumbnail dosya ad�n� ��ren
	/**
	 * Thumbnail dosya ad�, scriptin sonraki �al��mas�nda kontrol edece�i
	 * i�inde istenilen geni�li�in ve y�ksekli�in belirtildi�i isimdir.
	 * �rne�in thumb.php?p=resim.jpg&w=100&h=75 �eklinde �al��t�r�lan script
	 * i�in thumbnail dosya ad� "resim_100_75.jpg" olarak belirlenecektir.
	 */
	$thumbFileName = $dosyaAdi;
	$thumbFileName .= $w>0 ? '_w'.$w : '';
	$thumbFileName .= $h>0 ? '_h'.$h : '';
	$thumbFileName .= $uzanti;
 
	// �stenilen �l��lerde thumbnail daha �nce talep edilmi� ve dosya sistemine kaydedilmi�se...
	if(file_exists($thumbFileName)) { // ... thumbnail dosyas�na y�nlen ve �al��may� durdur.
		header("Location: {$thumbFileName}");
		exit;
	} else { // ... ilk defa talep edilen thumbnail dosyas� i�in �al��maya ba�la
 
		// Resmin bilgilerini al
		$resim = getimagesize($p);
 
		if($w && !$h) { // Max. Geni�lik manuel olarak belirtilmi� ve y�kseklik belirtilmemi�se...
			// ... geni�li�i istenilen �l��ye getir ...
			$genislik = $w;
			// ... y�ksekli�i geni�li�e orant�l� bir �ekilde hesapla.
			$yukseklik = round(($genislik*$resim[1])/$resim[0]);
		} elseif(!$w && $h) { // Max. Y�kseklik manuel olarak belirtilmi�se ve geni�lik belirtilmemi�se
			// ... y�ksekli�i istenilen �l��ye getir ...
			$yukseklik = $h;
			// ... geni�li�i y�ksekli�e orant�l� bir �ekilde hesapla.
			$genislik = round(($yukseklik*$resim[0])/$resim[1]);
		} elseif($w && $h) { // Her iki �zellikte manuel olarak belirtilmi�se ...
			// ... �zellikleri istenilen �l��ye getir.
			$yukseklik = $h;
			$genislik = $w;
		} else { // Her iki �l�� de girilmemi�se ana resme git ve �al��may� durdur.
			header('Location: '. $p);
			exit;
		}
 
		// Resmin t�r�ne g�re ana resmi belle�e kopyala
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
 
		// Belirlenen �l��lerde bo� bir resim olu�tur
		$thumb = imagecreatetruecolor($genislik, $yukseklik);
		// Belle�e kopyalanan ana resmi istenilen �l��lere g�re k���lterek olu�turulan resmi
		// az �nce olu�turdu�umuz bo� resmin i�ine yazd�r.
		imagecopyresampled($thumb, $kopya_resim, 0, 0, 0, 0, $genislik, $yukseklik, $resim[0], $resim[1]);
 
		if($h) {
			/**
			 * E�er maximum y�kseklik de�eri manuel olarak girilmi�se ve bu de�er
			 * scriptin olu�turdu�u de�erden farkl�ysa scriptin otomatik de�eri yoksay�l�p
			 * elle girilen de�er dikkate al�narak thumbnail yeniden boyutland�r�l�r
			 */
 
			if($yukseklik>$h) $yukseklik = $h;
 
			$thumb2 = imagecreatetruecolor($genislik, $yukseklik);
 
			imagecopy($thumb2, $thumb, 0, 0, 0, (($h-$yukseklik)/2), $genislik, $yukseklik);
			$sonuc = $thumb2;
		} else {
			$sonuc = $thumb;
		}
 
		/** �stenilen boyuttaki thumbnail art�k haz�r
		 * Resmin t�r�ne g�re olu�turulan thumbnaili dosya sistemine yazd�rmay� deneyece�iz.
		 * Resmin bulundu�u klas�r�n yazma izinleri verilmi�se thumbnail dosyas� yukar�da
		 * ayarlanan isimle klas�re kaydedilir ve script kaydedilen bu dosyaya y�nlendikten sonra
		 * �al��may� durdurur. Yazma izinlerinde sorun varsa -ki bu scriptin esprisini yok eder-
		 * olu�turulan thumbnail'i direkt olarak browser'a yollar ve her seferinde yukar�daki i�lemleri yapar
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
 
		// T�m i�lemler bittikten sonra bellek bo�alt�l�p bir nebze olsun sunucu rahatlat�l�r
		imagedestroy($sonuc);
		
	}
}
?>