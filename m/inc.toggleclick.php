	<script type="text/javascript">
	$(function(){
		<?php 
		
		if($fvarmi==0) { ?>
		var k = 0;
		<?php } else { ?>
		var k = 1;
		<?php } ?>
		$("#takip").on("tap",function(){
		//	alert(k);
			
			var user = "<?php e(get("id")) ?>";
			
			
			if(k==0) {
				$(this).children(".fa").removeClass("fa-plus-circle");
				$(this).children(".fa").addClass("fa-minus-circle");
				$(this).children("span").html("Takibi Bırak");
				$(this).removeClass("nephritis");
				$(this).addClass("concrete");
				k=1; 
			} else {
				$(this).children(".fa").addClass("fa-plus-circle");
				$(this).children(".fa").removeClass("fa-minus-circle");
				$(this).children("span").html("Takip Et");
				$(this).addClass("nephritis");
				$(this).removeClass("concrete");
				k=0;
			}
			$.post("?follow",{
				user : user,
				k : k
			},function(d){
				//alert(d);	
			});
			
			
			
		});
		$("#favori").on("tap",function(){
		//	alert(k);
			
			var user = "<?php e(get("slug")) ?>";
			
			
			if(k==0) {
				$(this).children(".fa").removeClass("fa-heart");
				$(this).children(".fa").addClass("fa-heart-o");
				$(this).children("span").html("Favorilerimden Kaldır");
				$(this).removeClass("nephritis");
				$(this).addClass("concrete");
				k=1; 
			} else {
				$(this).children(".fa").addClass("fa-heart");
				$(this).children(".fa").removeClass("fa-heart-o");
				$(this).children("span").html("Favorilerime Ekle");
				$(this).addClass("nephritis");
				$(this).removeClass("concrete");
				k=0;
			}
			$.post("?follow",{
				cat : user,
				k : k
			},function(d){
				//alert(d);	
			});
			
			
			
		});
	});
	</script>