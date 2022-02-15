<script type="text/javascript">
$(function(){
	$("#eMail").blur(function(){
		$.post('pfi-ajax.php?islem=mail',{
		'mail' : $(this).val()
		},function(d){
		//alert(d);
			if(d==1){
			
				$("#eMail").select();
				$("#eMail").focus();
				$("#eMailHata").show("slow");
			}
		});
	}).keydown(function(){
		$("#eMailHata").hide();
	});
	
	//oturum işlemi gönderme
		var yanlis = 0;
	function oturumAc(url){
		if(url==undefined) {
			url="admin";
		}
		$("#oturumBekle").show();
		$("#oturumButon").hide();
		var ePosta = $("#mail").val();
		var sifre = $("#sifre").val();
		//alert(ePosta);
		$.post("logincore.php",{
		'mail' : ePosta,
		'sifre' : sifre
		},function(d){
			alert(d);
			if (d==1){ //oturum açıldı!
				$("#girisYap").hide();
				$("#oturumTamam").fadeIn("slow",function(d){
					location.href = url;
				});
				
			} else { // oturum açılmadı!
				if(yanlis<10){
				$("#girisYap").hide();
				$("#oturumHata").fadeIn("slow",function(d){
						$("#oturumHata").fadeOut("fast",function(d){
								$("#oturumBekle").hide();
								$("#oturumButon").show();
								$("#girisYap").show();
						});
				});
				yanlis++;
				} else {
					$("#girisYap").hide();
					$("#oturumEngel").fadeIn("slow");
					
				}
			}
		});	
	}
	$("#oturumB").click(function(){
		var url = $(this).attr("url");
		oturumAc(url);
	});//click
	$("#sifre").keydown(function (e){
		var kar = e.keyCode;
		if(kar==13) {
			//alert("tamam");
			oturumAc();
		}
	});
});
</script>
