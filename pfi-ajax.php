<?php include("pfi-bd-yonga.php"); 

switch ($_GET['islem']){
	case "mail":
		$mail = kSorgu("uyeler",
			sprintf("WHERE mail = %s OR mail =%s",
				trim(veri(post("mail"))),
				trim(veri(strtolower(post("mail"))))
				
			)
		);
		if($mail!=0) {
			echo 1;
		} else {
			echo 0;
		}
	break;
	case "yorumlar" : 
		?>
		<?php $yorumlar = kSorgu("yorumlar",
			sprintf("WHERE sayfa=%s AND y=1 ORDER BY id DESC",veri(get("sayfa")))
			); 
			if($yorumlar!=0) {
		while($y = kd($yorumlar)) {
		?>
		<div class="yorumAlan">
					<h3><?php e($y['baslik']) ?></h3>
					<div class="mesaj"><?php e($y['icerik']) ?></div>
					<div class="isim"><?php e($y['yazan']) ?></div>
		</div>
		<?php
		}
		} else {
			bilgi("Henüz eklenmiş ve onaylanmış bir yorum bulunamadı.");
		
		}
	break;

}
?>