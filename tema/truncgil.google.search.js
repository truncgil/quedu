	$(function(){
		$(".google").autocomplete({
        source: function(request, response) {
            $.getJSON("http://suggestqueries.google.com/complete/search?callback=?",
                {
                  "hl":"tr", 
                  "jsonp":"donenDeger", 
                  "q":request.term, 
                  "client":"youtube"
                }
            );
            donenDeger = function (data) {
                var degerler = [];
                $.each(data[1], function(key, val) {
                    degerler.push({"value":val[0]});
                });
                degerler.length = 5; 
                response(degerler);
            };
        }
    })
	
	});
