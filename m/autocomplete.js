$(function(){
	
$( "#autocomplete" ).on( "filterablebeforefilter", function ( e, data ) {
        var $ul = $( this ),
            $input = $( data.input ),
            value = $input.val(),
            html = "";
		var n = $(this);
        $ul.html( "" );
        if ( value && value.length > 0 ) {
           $(".loader").show();
            $ul.listview( "refresh" );
			console.log($input.val());
            $.ajax({
                url: "ajax.php?search",
                dataType: "json",
                crossDomain: true,
                data: {
                    q: $input.val()
                }
            })
            .then( function ( response ) {
				//salert(response);
				console.log(response);
                $.each( response, function ( i, val ) {
					var logo = "";
					
				//	alert(val.logo);
				//	alert(val.pic);
					if(val.logo!=undefined) {
					//	alert(val.logo);
						logo = "<img src='../file/"+val.logo+"' />";
					} else {
						
						if(val.pic!=undefined) {
							if(val.pic=="") {
								logo = "<img src='user.png' />";
							} else {
								logo = "<img src='"+val.pic+"' />";
							}
							
						} else {
							logo = "<img src='user.png' />";
						}
					}
					
					html += "<li><a href='"+val.url+"'>" +logo+ val.title + "</a></li>";
					if(val!="") { $(".loader").hide(); }
                });

                $ul.html( html );
                $ul.listview( "refresh" );
                $ul.trigger( "updatelayout");
				

            });
        } else {
			$(".loader").hide();
		}
    });  
});  