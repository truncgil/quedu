<?php include("pfi-tema.php");
		oturumAc();
		if(isset($_SESSION['oturumHata']) && $_SESSION['oturumHata']>10){ //eğer oturum hatası 4 ten büyük olmadığı durumlarda
			$girisYasak = 0;
			//yonlendir("pfi-uye-formu.php?giris");
		}
		if(!isset($girisYasak)) {
			$uye = kSorgu("uyeler",
				sprintf("WHERE mail = %s AND sifre = %s", //kullanıcı adını ve şifrenin kriptolanmış şeklini kontrol et
					veri(trim(post("mail"))),
					veri(kripto(post("sifre")))
				)
			);
			$u = kd($uye);
			if (!isset($_SESSION['oturumHata'])) { //daha önce hata değişkeni oluşturulmamışsa
			oturum("oturumHata",0); //oluştur
			
			}
			if($uye!=0) { //eğer böyle bir üye varsa
				oturumAc(); //oturum değişkenlerini yaz
				oturum("uid", $u['id']);
				oturum("pFiMail", $u['mail']);
				oturum("pFiUser", $u['user']);
				oturum("Seviye2",$u['seviye']);
				oturum("adi", $u['adi']);
				oturum("soyadi", $u['soyadi']);
				oturum("Seviye","peyamFi");
				oturumSil("kayitTamam");
						
				$sonuc = 1;
			} else { //eğer böyle bir üye yoksa
				$sonuc = 0;
				$hata=oturum("oturumHata"); //son oturum hata değerini al
				$hata++; // hata değerini bir arttır
				oturum("oturumHata",$hata); //hata değerini yaz
				if (isset($_GET['y'])){
					//$url = $_GET['y'] . "&sonuc=0";
					
				} else {
					//$url = $_SERVER['REQUEST_URI'] . "&sonuc=0";
					//yonlendir("pfi-uye-formu.php?giris");
				}
				
			}
		} else {
			$sonuc =-1;
		}
echo $sonuc;
 ?>