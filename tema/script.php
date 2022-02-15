<script type="text/javascript">
	//	$("#bekliyoruz").draggable();
	/*
	$(document).ready(function(){ 
  document.oncontextmenu = function() {return false;};

  $(document).mousedown(function(e){ 
    if( e.button == 2 ) { 
      return false; 
    } 
    return true; 
  }); 
});

*/
	
	</script>
<script type="text/javascript">
			$(function(){
					

		   $.datepicker.setDefaults( $.datepicker.regional[ "tr" ] );
				// Accordion
				$(".akordeon").accordion({ header: "h3", autoHeight: false });
	
				// Tabs
				$('.sekme').tabs();
	

				// Dialog			
				$('#pencere').dialog({
					autoOpen: false,
					width: 1000,
					buttons: {
						"Kapat": function() { 
							$(this).dialog("close"); 
						} 
					}
				});
				
				// Dialog Link
				$('#pen_buton').click(function(){
					$('#pencere').dialog('open');
					return false;
				});

				$(".dugme").button();
				$(".ddugme").button({
									disabled : true
									});
				//$("input[type=submit]").button();
				$('#dialog_link, ul#icons li').hover(
					function() { $(this).addClass('ui-state-hover'); }, 
					function() { $(this).removeClass('ui-state-hover'); }
				);
				$("a").click(function(){
									  var t = $(this).attr("teyit");
									  var h = $(this).attr("href");
									  var ajax = $(this).attr("ajax");
									  if (t==undefined) {
										return true;
									  } else {
										  $("#teyit").html(t);
											$( "#teyit" ).dialog({
												resizable: false,
												height:200,
												modal: true,
												autoOpen: true,
												title: "Uyarı!",
												buttons: {
													"Evet": function() {
														$( this ).dialog( "close" );
														if (ajax==undefined) {
														location.href=h;
														} else {
															$(ajax).fadeTo("normal",0.5);
														$.get(h,{
														},function(d){
															$(ajax).hide();
														})
														}
													},
													"İptal": function() {
														$( this ).dialog( "close" );
														return false;
													}
												}
								 });
									  	return false; 
									  
									  }
									  });
			});
		</script>