 <script type="text/javascript">
 $(function(){
	var toplam = 0;
	var toplam2 = 0;
	var maxscore = 154;
	function progress(kim,score) {
		var hesap = score*100/maxscore;
		toplam += hesap;
		console.log(toplam);
		$(kim).css("height",toplam+"%");
	}
	function progress2(kim,score) {
		var hesap = score*100/maxscore;
		toplam2 += hesap;
		console.log(toplam2);
		$(kim).css("height",toplam2+"%");
	}
	function progresspuan(score) {
		$(".p1 puan").html("+"+score).fadeIn().delay(1000).fadeOut();
	}
	function progresspuan2(score) {
		$(".p2 puan").html("+"+score).fadeIn().delay(1000).fadeOut();
	}
	
	 $.post("?goruldu",{
		 "isGoruldu" : "1" 
		 
	 },function(d){
		console.log(d);
	 });
	
	 
	
	 
	var speed = 0;
	var eksilt =0;
	var sure=10;
	var u1score = $("#u1score");
	var u2score = $("#u2score");
	var saniye = $(".counter saniye");
	var interval=false;
	var puanVerildi = 0;
	
	
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
	 //diğer oyuncunun bilgisini alalım 
	 var vs = JSON.parse('<?php e($sorular['u1info']) ?>');
	$(".profiles").hide(speed);
	$(".sorular").hide(speed);
	$(".start").show(speed);
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
			interval=true;
			},1000);
		},3000);
	
	/*Finish*/
	
	
	 $("durum").html(sure);		
	
	 window.setInterval(function(){
		 if(interval) {
			sureStart();	
		 }
	 },1000);
	 var round = 1;
	 
	 var totalround = $(".soru").length;
	 $("round").html(round + "/"+ totalround);
	 function finish() {
		$("#sonscore").html("Yükleniyor...");
		$(".profiles").hide(speed);
		$(".sorular").hide(speed);
		$(".start").hide(speed);
		$(".finish").fadeIn(speed);
		$(".loading").show(speed);
		//son olarak skoru al
		$.post("?finish",function(d){
			$(".loading").hide();
			var u2score = eval("<?php e($sorular['u1score']) ?>");
			if(Number(d)) {
				$("#u1score2").html(d.trim());
			}
			$("#u2score2").html(u2score);
//			progress2(".p2",u2score);
			if(d.trim()>u2score) {
				$("#sonscore").html("Kazandın!");
				$("#sonscore").addClass("nephritis");
			} else if(d.trim()==u2score) {
				$("#sonscore").html("Berabere!");
				$("#sonscore").addClass("sunflower");
			} else {
				$("#sonscore").html("Kaybettin!");
				$("#sonscore").addClass("pomegranate");
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
		//diğer oyuncuyu simule et
		//diğer oyuncu hangi saniyede ne kadar score aldı?
		console.log("onunsüresi:"+vs[round-1].sure);
		if((vs[round-1].sure==sure || vs[round-1].sure==11)) { // bazen 11sn de veriliyor cevap ondan dolayı
			if(puanVerildi==0) {
			//	alert(vs[round-1].score);
				var puan = eval(eval(u2score.html())+eval(vs[round-1].score));
				u2score.html(puan);
				progress2(".p2",eval(vs[round-1].score));
				progresspuan2(eval(vs[round-1].score));
				puanVerildi=1; //tekerrür puana engel olmak için
			}
		}
		console.log("puanverildi:"+puanVerildi);
		
		

		if(sure==0) { // süre bitti
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
					
					//doğru cevabı göster
					$(".soru:eq("+sira+") .cevap").each(function(){ //doğru cevabı göster
						var fark = eval($(this).attr("d")-$(this).attr("cevap")*3); 
						console.log(fark);
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
		interval=false;
		var bu = $(this);
		var cevap = $(this).attr("cevap");
		var soruno = $(this).parent().index();
		var onunki = $("[cevap='"+vs[round-1].cevap+"']");
		window.setTimeout(function(){
			var fark = eval(onunki.attr("d")-onunki.attr("cevap")*3);
			console.log("onun farkı");
			console.log(fark);
			if(fark==0) { //diğer oyuncunun verdiği cevabı göster
				onunki.addClass("pomegranate");
			} else {
				onunki.addClass("greensea");
			}	
		},1000);
		
		//eğer diğer oyuncunun verdiği cevaptan önce tıklanıldıysa
			if(puanVerildi==0) {
				var puan = eval(eval(u2score.html())+eval(vs[round-1].score));
				u2score.html(puan);
				progress2(".p2",eval(vs[round-1].score));
				progresspuan2(eval(vs[round-1].score));
				puanVerildi=0;//bir sonraki roundda puan verilsin
			}
		if(tikla) {
			interval = false;
			var isDogru = eval($(this).attr("d")-$(this).attr("cevap")*3); 
			var score = 0;
			if(isDogru==1) { //puanı ver
				u1score.html(eval(u1score.html())+(sure+1)*2);
				score = (sure+1)*2;
				progress(".p1",score);
				progresspuan(score);
				bu.addClass("dogru");
				tikla=false;
				//diğer oyuncu ne cevap verdi?
				
				
				
			} else {
				score=0;
				bu.addClass("yanlis");
				tikla=false;
				window.setTimeout(function(){
					var sira = round-1;
					$(".soru:eq("+sira+") .cevap").each(function(){
						var fark = eval($(this).attr("d")-$(this).attr("cevap"));
						//alert(fark);
						if(fark==1) {
						$(this).addClass("dogru");
						}
					});
				},500);
				
				//doğru cevabı göster
				window.setTimeout(function(){
					var sira2 = round-1;
					$(".soru:eq("+sira2+") .cevap").each(function(){ //doğru cevabı göster
						var fark = eval($(this).attr("d")-$(this).attr("cevap")*3); 
						console.log(fark);
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
					console.log(d);
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
			/*
			//doğru mu yanlış mı
			$.ajax({
				type:"POST",
				dataType:"json",
				url:"?isTrue",
				data:"cevap="+cevap,
				success : function(d) {
					var isDogru=d[0].dogrumu;
					//alert(isDogru);
					
					if(isDogru) {
						bu.addClass("dogru");
						tikla=false;
						
						sonrakiSoru(soruno);
					} else {
						bu.addClass("yanlis");
						$(".cevap:contains('"+d[0].dogrusu+"')").addClass("dogru");
						tikla=false;
						sonrakiSoru(soruno);
					
					}
					
					
				}
 			}); */
			
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
						$(".soru:eq("+sonraki+") *").hide(speed);
						$(".soru:eq("+sonraki+") h1").delay(500).show(speed);
						$(".soru:eq("+sonraki+") .soruResim").delay(500).show(speed);
						$(".soru:eq("+sonraki+") .cevaplar").delay(500).show(speed);
						var basla=0;
						for(k=0;k<=3;k++) {
							console.log(k);
							var sure = 1000+300*k;
							console.log(sure);
							$(".soru:eq("+sonraki+") .cevap:eq("+k+")").delay(sure).show(speed);
						}
						window.setTimeout(function(){
							tikla=true;
							interval=true;
							puanVerildi=0;
						},1400);
							
						
					});	
				},1000);
					
			});
		},1000);	
	}
 });
 </script>
 
