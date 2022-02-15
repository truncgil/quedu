<?php 

if(getisset("sil")) {
	oturumAc();
	print_r($_GET);
	$id = veri(get("sil"));
	$uid = veri(oturum("uid"));
	sil("social","uid=$uid AND id=$id");
	yonlendir("profile.php?news");
	exit();
}
if(getisset("ekle")) {
		$id=dEkle("social",array(
			"tarih" => simdi(),
			"uid" => oturum("uid"),
			"message" => post("message"),
			"hash" => ht(post("message")),
			"uids" => at(post("message"))
		));
		
$bu = kd(ksorgu("social","WHERE id=$id"));
//fb_post($user['facebook'],$bu['message']);
socialbox($bu);
		
trigger();
?>
<script type="text/javascript">
$(function(){
	$(".deleteMessage").click(function(){
			$.get("profile.php",{
				sil : $(this).attr("mid")
			},function(d){
			//	alert(d);
			});
			$(this).parent().parent().parent().parent().hide();
			
			return false;
		});
});
</script>
<?php
ob_end_flush();
if($bu['uids']!="") {
	$etikets=explode(",",$bu['uids']);
	foreach($etikets AS $deger) {
		$ayir = explode("_",$deger);
		ob_end_flush();
		if($ayir[1]!=$user['id']) {
			logz($ayir[1],"Bir Mesajın Var!","{$user['adi']} {$user['soyadi']} Seni bir gönderide etiketledi. Mesaj şu şekilde: {$_POST['message']}","socialmessage.php?id=$id");
		}
	}
}
exit();
	}

 ?>
 
