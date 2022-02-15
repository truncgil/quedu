$(document).bind("mobileinit", function(){
  //$.mobile.loader.prototype.options.html = "<span class='ui-bar ui-overlay-c ui-corner-all' style='display:none !important;opacity:1 !important;'><img src='onlylogo.png' width='200' /><h2 style='font-size:30px;'> Yükleniyor... </h2></span>";  
  $.mobile.defaultPageTransition = "flip";
  $.mobile.ajaxEnabled = false;
  $.mobile.ajaxLinksEnabled = false;
 
  
 
});

function loading(s){
	$(s).html('<i class="fa fa-refresh fa-spin" style="padding:10px;"></i>');
}
function blank(s,m) {
	$(s).html('<div class="ui-btn sunflower">'+m+'</div>');
}

$( document ).on( "pagecreate", "#zomnipage", function() {
	$("img").error(function(){
		$(this).hide();
	});
	$("sayi2:contains('0'), sayi:contains('0')").hide();
	$("[data-rel='popup'][ajax]").click(function(){
		var s = $(this).attr("href");
		var l = $(this).attr("ajax");
		var m = $(this).attr("blank");
		var o = $(this).attr("see");
		console.log(s);
		console.log(l);
		loading(s);
		$.get(l,function(d){
			if(d.trim()!="") {
				$(s).html(d);
			} else {
				blank(s,m);
			}
		});
		$(this).children("sayi2").hide();
		$(this).children("sayi").hide();
		window.setTimeout(function(){
			$.get(o,function(d){
				console.log("see");
				
			});	
		},3000);
		
		
	});
	//$(".ui-btn").attr("data-ajax","false");
	//$(".select").removeAttr("data-ajax");
	$("a").on("tap",function(){
	var url = $(this).attr("href");
	//alert($(this).attr("ajax"));
/*	$("a").removeClass("select");
	$(this).addClass("select");
	if($(this).attr("ajax")==undefined) {
		if(url.substring(0,1)!="#") {
			//alert("asd");
			location.href=url;
		//	$(this).click();
			return false;
			
		}
	}
*/
		var state = { 'page_id': 1, 'user_id': 5 };
		var title = 'Zomni';
		if(url.substring(0,1)!="#") {
		//	history.pushState(state, title, url);
			//$(body).fadeTo(0.5);
			//$.post(url,function(d){
				location.href=url;
			//});
			return false;
				
		}
	});  
   
	$( "#bolum" ).on( "filterablebeforefilter", function ( e, data ) {
        var $ul = $( this ),
            $input = $( data.input ),
            value = $input.val(),
            html = "";
		var n = $(this);
        $ul.html( "" );
        if ( value && value.length > 1 ) {
			$(".loader").show();
            $ul.listview( "refresh" );
            $.ajax({
                url: "bolum.php",
                dataType: "json",
                crossDomain: true,
                data: {
                    q: $input.val()
                }
            })
            .then( function ( response ) {
				
                $.each( response, function ( i, val ) {
					console.log(val);
				html += "<li><a href='?id="+val+"' data-ajax='false'>" + val + "</a></li>";
					if(val!="") { $(".loader").hide(); }
                });

                $ul.html( html );
                $ul.listview( "refresh" );
                $ul.trigger( "updatelayout");
				$(".ui-screen-hidden").show();

            });
        } else {
			$(".loader").css("display","block !important");
		}
    });
});

