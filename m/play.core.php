 <script type="text/javascript">
 $(function(){
	var toplam = 0;
	var maxscore = 154;
	function progress(kim,score) {
		var hesap = score*100/maxscore;
		toplam += hesap;
		console.log(toplam);
		$(kim).css("height",toplam+"%");
	}
	function progresspuan(score) {
		$(".p1 puan").html("+"+score).fadeIn().delay(1000).fadeOut();
	}
	 $.post("?goruldu",{
		 "isGoruldu" : "1" 
		 
	 },function(d){
		//alert(d);
	 });
	 
	var speed = 0;
	var eksilt =0;
	var sure=10;
	var u1score = $("#u1score");
	var u2score = $("#u2score");
	var saniye = $(".counter saniye");
	var interval=false;
	
	
	
	//start animasyon düzeni begin  
	$(".start .user1").hide(speed);
	$(".start .user2").hide(speed);
	$(".start .kategori").hide(speed);
	/*
		ilk kullanıcı gelsin
		ikinci kullanıcı gelsin
		kategori resmi gelsin
	*/
	window.setTimeout(function(){
		$(".start .user1").show(speed);
		window.setTimeout(function(){
			$(".start .user2").show(speed);
			window.setTimeout(function(){
				$(".start .kategori").show(speed);
			},500);
		},500);
	},500);
	
	
	//start animasyon düzeni end
	
	
	
	
	 /* Start */
	$(".profiles").hide(speed);
	$(".sorular").hide(speed);
	$(".start").show(speed);
	$(window).load(function(){
		window.setTimeout(function(){
			$(".start").fadeOut(speed);

			
			$(".profiles").fadeIn(speed);
			
			//ilk soruyu göster begin
			$(".sorular").fadeIn(speed);
			$(".sorular *").hide(speed);
			$(".sorular .soru:eq(0)").delay(500).show(speed);
			$(".sorular .soru:eq(0) h1").delay(500).show(speed);
			$(".sorular .soru:eq(0) .soruResim").delay(500).show(speed);
			$(".sorular .soru:eq(0) .cevaplar").delay(500).show(speed);
			var basla=0;
			for(k=0;k<=3;k++) {
				console.log(k);
				var sure = 1000+300*k;
				console.log(sure);
				$(".soru:eq(0) .cevap:eq("+k+")").delay(sure).show(speed);//tek tek cevapları göster
			}
			window.setTimeout(function(){
				tikla=true;
				interval=true;
			},1400);
			console.log("soru gösterildi");
			//ilk soruyu göster end
			window.setTimeout(function(){
			//interval=true;
			},1000);
		},3000);
	});
	/*Finish*/
	
	
	 $("durum").html(sure);			
	 window.setInterval(function(){
		 if(interval) {
			 if(tikla) {
				sureStart();
			 }			
		 }
	 },1000);
	 var round = 1;
	 
	 var totalround = $(".soru").length;
	 $("round").html(round + "/"+ totalround);
	 function finish() {
		$(".profiles").hide(speed);
		$(".sorular").hide(speed);
		$(".start").hide(speed);
		$(".loading").show(speed);
		$.post("?finish",function(d){			
			$(".finish").fadeIn(speed);
			$(".loading").hide(speed);
			$("#sonscore").show(speed);
				console.log(d.trim());
				if(Number(d.trim())) {		
					$("#sonscore").html(d.trim());
				} else if(d.trim()=="Sıfır") {
					$("#sonscore").html(0);
				}
		});
	 }
	 function sureStart() {
		var saniye = $(".counter saniye");
		var mevcut = saniye.width();
		if(sure==7) {
			saniye.css("background","#E08712");
		}
		if(sure==4) {
			saniye.css("background","red");
		}

		if(sure==0) { // sonraki rounda geç
		tikla=false;
		var sira = round-1;
			$.post("?cevapclick",{
					"soru" : sira,
					"cevap" : "-1",
					"dogru" : 0,
					"sure" : 0,
					"score" : 0
				},function(d){
					console.log(d);
					$(".soru:eq("+sira+") .cevap").each(function(){ //doğru cevabı göster
						var fark = eval($(this).attr("d")-$(this).attr("cevap")*3); 
						//alert(fark);
						if(fark==1) {
						$(this).addClass("dogru");
						}
					});
					window.setTimeout(function(){
						if(round<totalround) {
							interval=false;
							sonrakiSoru(round-1);
							if(tikla==false) {
								round++;
							}
							$("round").html(round + "/"+ totalround);
						} else {
							interval=false;
							finish();
						}	
					},500);	
				});
				
			
			//sonrakisoru
		} else {
			if(eksilt==0) {
				eksilt  = mevcut/sure +5;
			}
			//alert(eval(mevcut-eksilt));
			saniye.css("width",eval((sure-1)*10) + "%");
			sure--;
			$("durum").html(sure);			
		}
	 }
	 $(".soru").hide();
	 $(".soru:eq(0)").show();
	var tikla=true;
	
	//ilk başlangıç
	
	
	//şıkka tıklandığında
	$(".cevap").on("tap",function(){
		
		var bu = $(this);
		var cevap = $(this).attr("cevap");
		var soruno = $(this).parent().index();
		if(tikla) {
			interval = false;
			console.log(bu.attr("d"));
			console.log(bu.attr("cevap")*3);
			var isDogru = eval(bu.attr("d")-bu.attr("cevap")*3);
			var score = 0;
			console.log(isDogru);
			if(isDogru==1) { //puanı ver
				u1score.html(eval(u1score.html())+(sure+1)*2);
				score = (sure+1)*2;
				progress(".p1",score);
				progresspuan(score);
				bu.addClass("dogru");
				tikla=false;	
			} else {
				score=0;
				bu.addClass("yanlis");
				tikla=false;
				window.setTimeout(function(){
					var sira = round-1;
					$(".soru:eq("+sira+") .cevap").each(function(){
						var fark = eval($(this).attr("d")-$(this).attr("cevap")*3);
						//alert(fark);
						if(fark==1) {
						$(this).addClass("dogru");
						}
					});
				},500);
			}
				$.post("?cevapclick",{
					"soru" : round-1,
					"cevap" : cevap,
					"dogru" : isDogru,
					"sure" : sure+1,
					"score" : score
				},function(d){
					window.setTimeout(function(){
					if(round<totalround) {
						interval=false;
						sonrakiSoru(round-1);
						round++;
						$("round").html(round + "/"+ totalround);
					} else {
						interval=false;
						finish();
					}
					},1000);
				});
			
			
		}
		return false;
	});
	function sonrakiSoru(soruno){
		tikla=false;
		//alert(soruno);
			window.setTimeout(function(){
				sure=10;
				saniye.css("width","100%");
				saniye.css("background","#0E9603");
				$("durum").html(sure);	
			},500);
		window.setTimeout(function(){
			var sonraki = soruno+1;
			$(".soru:eq("+soruno+")").hide(speed,function(){
				window.setTimeout(function(){
					$(".soru:eq("+sonraki+")").show(speed,function(){	
						$(".soru:eq("+sonraki+") *").hide(speed); //önce bir hepsini gizle
						$(".soru:eq("+sonraki+") h1").delay(500).show(speed); //soruyu göster
						$(".soru:eq("+sonraki+") .soruResim").delay(500).show(speed); //resmi göster
						$(".soru:eq("+sonraki+") .cevaplar").delay(500).show(speed); //cevapları göster
						var basla=0;
						for(k=0;k<=3;k++) {
							console.log(k);
							var sure = 1000+300*k;
							console.log(sure);
							$(".soru:eq("+sonraki+") .cevap:eq("+k+")").delay(sure).show(speed);//tek tek cevapları göster
						}
						window.setTimeout(function(){
							tikla=true;
							interval=true;
						},1400);
							
						
					});	
				},1000);
					
			});
		},1000);	
	}
 });
 </script>
