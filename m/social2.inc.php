 <script type="text/javascript">
	$( document ).on( "pagecreate", "#zomnipage", function() {
		function swipeleft() {
			/*
		$(".dialogbox.me").on("swiperight",function(){
			$.get("profile.php",{
				sil : $(this).attr("mid")
			});
			$(this).addClass("left").on( "webkitTransitionEnd transitionend otransitionend", function() {
                      $(this).remove();
                    });
			return false;
		});
			*/
		}
		
		$(".deleteMessage").click(function(){
			$.get("profile.php",{
				sil : $(this).attr("mid")
			},function(d){
			//	alert(d);
			});
			$(this).parent().parent().parent().parent().addClass("gizle");
			$(this).parent().parent().parent().parent().addClass("left").on( "webkitTransitionEnd transitionend otransitionend", function() {
                      $(this).remove();
                    });
			return false;
		});
		$("#sendMessage").on("click",function(){
			if($("#message").val()!="") {
				$(".dialogform").fadeOut();
				$(".yukleme").fadeIn();
				$.post("profile.php?ekle",{
					message : $("#message").val()
				},function(d){
					$(".dialogform").fadeIn();
					var item = $(d).addClass("gizle").prependTo(".dialogzone").addClass("goster");
					swipeleft();
					$("#message").val("");
					$(".yukleme").fadeOut();
				});
				
				
			} else {
				
				$("#message").attr("placeholder","Bir şeyler yazmalısın");
				$("#message").focus();
			}
			
			return false;
		});
		
		swipeleft();
	});
	</script>
	<style type="text/css">
	.left {
		transform: translateX(100%);
		opacity:0;
	}
	.gizle {
		opacity:0;
		transform: translatey(-50%);
		transition:all 0.5s;
	}
	.goster {
		transform: translatey(0%);
		opacity:1;
		transition:all 0.5s;
	}
	
	</style>