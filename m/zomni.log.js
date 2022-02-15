$(function(){
	var loading= '<a href="" class="ui-btn sunflower"><i class="fa fa-refresh fa-spin"></i></a>';
	function getGamepad(s) {
		if(s==1) {
		$("#logz").html(loading);
		}
		$.get("ajax.php",{
			tip:"sayi"
		},function(d) {
			if(d.trim()==0) {
				$("sayi:contains(0)").hide();
			} else {
				if(Number(d)) {
				$("sayi").html(d.trim());
				$("sayi").fadeIn();
				}
			}
			
		});
	
		$.get("ajax.php",{
				tip:"gamepad"
			},function(d){
			//	alert(d);
				
					$("#logz").html(d);
					
			});
	}
	getGamepad(1);
	window.setInterval(function(){		
		getGamepad(0);
		$("sayi:contains(0)").hide();
	},10000);
	$(".gamepad .yanlis").click(function(){
		var id = $(this).attr("playid");
		$.post("?red",{
			"playid" : id
		},function(d){
			
		});
		$(this).parent().fadeOut("slow");
		
	});
});