<?php include("sablon.php"); ?>
<?php include("secure.php"); 
include("gamedelete.php");
if(getisset("red")) {
	$id = veri(post("playid"));
	dGuncelle("play",array(
	"u2score" => "0",
	"u2info" => "Red"
	),"id =$id AND u2 = {$user['id']}");
}
?>
<?php a("Zomni"); ?>
<div id="logz"></div>
<a href="#" id="temizle" class="ui-btn"><i class="fa fa-trash"></i> Tümünü okudum temizle</a>
<script type="text/javascript">
$(function(){
	$("#logz").load("ajax.php?tip=gamepad");
	
	$("#temizle").click(function(){
		$.get("ajax.php",{
			tip : "okundu"
		},function(d){
			$("sayi").hide();
			$("#logz *").fadeOut();
			$("#temizle").fadeOut();
			
		});
	});
		
	
});
</script>
<?php 

b(); ?>