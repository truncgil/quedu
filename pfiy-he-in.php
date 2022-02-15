<?php 
// PeyamFi - Yönetici Sayfası Head Include bolumleri
	//uniform
	?>
	<?php
	jquery();
    jquery_ka("custom-theme/jquery-ui-1.8.5.custom.css");
	js($betik . "uniform/jquery.uniform.min.js") . _js();;
	linkCss($betik . "uniform/css/uniform.default.css"); 
	js($betik . "jquery.form.js") . _js();
	//colortips
//	linkCss($betik . "colortips/styles.css");
	linkCss($betik . "colortips/colortip-1.0/colortip-1.0-jquery.css");
	js($betik. "colortips/colortip-1.0/colortip-1.0-jquery.js") . _js();
	js($betik. "colortips/script.js") . _js();
	//kobetik metin editörü
	//meditor(); beş kuruş etmez bir editör
	//sağ menü
	js($betik . "sagmenu/jquery.contextMenu.js") . _js();
	js($betik . "sagmenu/jquery.ui.position.js") . _js();
	linkCss($betik . "sagmenu/jquery.contextMenu.css" );
	//gelişmiş metin editörü
	js($betik . "metinEditoru/js/elrte.min.js") . _js();
	linkCss($betik . "metinEditoru/css/elrte.min.css");
	//dil dosyası
	js($betik . "metinEditoru/js/i18n/elrte.tr.js") . _js();
	//gelişmiş dosya yöneticisi
	js($betik . "elfinder2/js/elfinder.min.js") . _js();
	?>
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo $betik . "elfinder2/" ?>css/elfinder.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo $betik . "elfinder2/" ?>css/theme.css">	
		<script type="text/javascript" src="<?php echo $betik . "elfinder2/" ?>js/elfinder.min.js"></script>
		<script type="text/javascript" src="<?php echo $betik . "elfinder2/" ?>js/i18n/elfinder.tr.js"></script>
	<?php
	//dil dosyası
	//js($betik . "elfinder/js/i18n/elfinder.tr.js") . _js();
	spryTextJS();
	spryTextAreaJS();
	spryTeyitJS();
	tablesorter();
	linkCss($betik . "window/css/jquery.window.css"); 
	js($betik . "window/jquery.window.min.js") . _js();
?>
<link rel="stylesheet" href="tema/font/css/font-awesome.min.css" />

<?php
//inputtan blur olma olayında ajax ile post işlemi gerçekleştirir
input_ajax($via ."ajax=input",".ajaxDuzenle");
?>

    <style type="text/css" media="screen">
      h1 {
	margin-top: 0;
	font-size: 18px;
      }
      h2 {
	margin-top: 0;
	font-size: 16px;
      }
	  td .fa {
		text-decoration:none;
		color: gray;
		padding:3px;
		font-size: 21px;
		
	  }
	  td .fa:hover {
		text-decoration:none;
		color: #000;
		background:#eee;
		outline:solid 1px #ccc;
	  }
	  
body {
	font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
	color: #000;
}
      form ul {
        list-style: none;
        padding: 0;
        margin: 0;
      }
      form li {
	float: left;
	margin: 10px;
	position: relative;
      }
form li.submit {
	position: absolute;
	right: 0px;
	bottom: -25px;
	z-index: 1000;
}
      label {
        font-size: 12px;
        font-weight: bold;
        display: block;
        margin-bottom: 3px;
        clear: both;
      }
form {
	margin: 10px;
	position: relative;
}
.icerik ul {
	margin: 0px;
	padding: 0px;
}
.icerik li {
  margin: 5px;
  float: left;
  height: 128px;
  width: 128px;
  overflow: hidden;
  position: relative;
  /* opacity: 0.7; */
  border: solid 1px #369FD2;
  -moz-border-radius: 5px;
  border-radius: 5px;
  -webkit-border-radius: 5px;
  background-color: rgb(54, 159, 210);
}
.icerik li > a {
color: #FFF;
  text-decoration: none;
  position: absolute;
  left: 0px;
  bottom: 0px;
  width: 100%;
  padding: 3px;
  background-color: #2B8EBE;
  /* font-weight: bold; */
  font-family: regular;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  font-size: 15px;
  box-shadow: 0px 0px 14px #000;
  text-shadow: 0px 2px 1px rgba(0, 0, 0, 0.4);
}
.icerik li > a:hover {
	background-color:#000;
	color:#FFF;
	opacity:1;
}
.tablesorter input {
	width:100%;
	border:none;
	background:none;
}
.icerik li:hover {
	opacity : 1;
	<?php echo kgolge("0px","3px","2px","#666") ;?>
}

	fieldset {
	border:solid 1px #999;
		<?php echo keyu("10px"); ?>
		padding:5px;
	background-color: #FFF;
	}
	form legend {
		background-color:#FFF;
	}
.icerik sil {
	position: absolute;
	height: 16px;
	width: 16px;
	top: 3px;
	right: 3px;
	display:none;
	background-color:#FFF;
	<?php echo keyu("5px") ?>
	cursor:pointer;
	padding:5px;
	opacity:0.7;
}
sil:hover {
	opacity:1;
	}
.icerik li:hover sil {
	display:block;
}
.icerik {
	overflow:auto;
	}
.icerik sayi {
    position: absolute;
    top: 3px;
    /* background-color: #F00; */
    -moz-border-radius: 10px;
    border-radius: 10px;
    -webkit-border-radius: 10px;
    cursor: pointer;
    color: #FFF;
    left: 3px;
    text-align: center;
    padding-top: 3px;
    padding-right: 5px;
    padding-bottom: 0px;
    padding-left: 5px;
    text-shadow: 0px 2px 3px #000;
    font-size: 20px;
    width: 100%;
	
}

.icerik sayi.beyaz {
	 background-color:#FFF;
	 opacity:0.7;
	 font-size:10px;
	}
.icerik sayi.mavi {
	 background-color:#06C;
	 opacity:0.7;
	 font-size:10px;
	}
    .icerik paylas {
	background-image: url(resimler/ikon/paylas.png);
	height: 64px;
	width: 64px;
	position: absolute;
	left: 0px;
	top: -15px;
}
.icerik yayin {
	position: absolute;
	height: 32px;
	width: 32px;
	opacity: 0.9;
	left: 5px;
	top: 17px;
}
.icerik yayin:hover {
	opacity: 1;
	cursor:pointer;
	}
#ustButon {
	position: absolute;
	top: 0px;
	right: 0px;
	z-index: 3000;
}
<?php if($seviye=="Okuyucu") { ?>
.icerik yayin, .icerik li:hover sil {
	display:none;
}
<?php } ?>
    </style>
	
<script>
$(function(){
			$("yayin").click(function(){
									 var url = "pfi-bvi-yonga.php";
									 var turn =  $(this).attr("tur");
									 var id =  $(this).attr("id");
									 var deger =  $(this).attr("deger");
									//alert(deger);
									 if (deger==1) {
										 y = 0;
									 } else {
										 y = 1;
									 }
									// alert(y);
									 $.get(url,{
										   yayin : y,
										   tur : turn,
										   yid : id
										   },function(d){
											   //alert(d);
											   $("#" + id).html(d);
											   $("#" + id).attr("deger",y);
											   });
									 });
			$(".pencere").click(function(){
				var isim = $(this).attr("title");
				var site = $(this).attr("href");
									   $.window({
										   title: isim,
										   url: site,
										   showRoundCorner: true,
										   top:0,
										   width: 400,
										   height: 300
										});
				return false;
			});
			$(".mail").blur(function(){
					var nesne = $(this);
					$.post('pfi-ajax.php?islem=mail',{
					'mail' : $(this).val()
					},function(d){
					//alert(d);
						if(d==1){
						
							nesne.select();
							nesne.focus();
							alert("Bu mail adresi daha önce kayıtlıdır.");
						}
					});
				}).keydown(function(){
				
				});			
			//metin editörü
			var opts = {
				cssClass : 'el-rte',
				lang     : 'tr',
				toolbar  : 'complete',
				cssfiles : ['<?php echo $betik ?>metinEditoru/css/elrte-inner.css'],
				fmOpen : function(callback) {
					/*
					var elf = $('#myelfinder').dialog({
						width : 900, modal : true, title : 'elFinder - file manager for web'
						
					}).elfinder({
							url : 'betikler/elfinder2/php/connector.php',
							lang : 'tr',
							closeOnEditorCallback : true,
							editorCallback : callback
						}).elfinder('instance'); */
				}
			}
			$('.meditor').elrte(opts);
			// metin editörü bitiş
			$.contextMenu({
				selector: '.icerik li', 
				callback: function(key, options) {
					var m = "clicked: " + key;
					
					//window.console && console.log(m) || alert(m); 
					if (key=="edit") {
						var adres = $(this).attr("duzenle");
							if (adres!=undefined) { //eğer böyle bir değer değilse
									   location.href=adres;
							}
						
						}
					if (key=="cogalt") {
						var adres = $(this).attr("slug");
							if (adres!=undefined) { //eğer böyle bir değer değilse
									   location.href="?cogalt="+adres;
							}
						
						}
					if (key=="delete") {
								   var yazi = $(this).attr("yazi");
								   var ajax = $(this).attr("ajax");
								   var url = $(this).attr("url");
								   $("#teyit").html(yazi);
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
																location.href=url;
																} else {
																	$(ajax).fadeTo("normal",0.8);
																$.get(url,{
																},function(d){
																	//alert(d);
																	$(ajax).hide("slow");
																})
																}
															},
															"İptal": function() {
																$( this ).dialog( "close" );
																return false;
															}
														}								   
																	});
					}
					//alert($(this).attr("id"));
				},
				items: {
					"cogalt" : {name:"Çoğalt",icon:"copy"},
					"edit": {name: "Düzenle/Detay" , icon: "edit"},
					"delete": {name: "Sil", icon: "delete"}
				}
			});
			
		  // $(".meditor").wysiwyg();
		   $("sil").click(function(){
								   var yazi = $(this).attr("yazi");
								   var ajax = $(this).attr("ajax");
								   var url = $(this).attr("url");
								   $("#teyit").html(yazi);
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
											location.href=url;
											} else {
												$(ajax).fadeTo("normal",0.8);
											$.get(url,{
											},function(d){
												//alert(d);
												$(ajax).hide("slow");
											})
											}
										},
										"İptal": function() {
											$( this ).dialog( "close" );
											return false;
										}
									}								   
												});
												});
		   $("form input, textarea, select, button").uniform();
		  // $("form").draggable();
		   $(".yeniForm").button();
		   $(".yeniForm").click(function(){
										 var id = $(this).attr("form");
										 $("form#" + id ).toggle();     
										  });
			   $(".tarih").datepicker({
				dateFormat : 'yy-mm-dd',
				numberOfMonths: 3
				});
		   });
</script>
<div id="myelfinder" style="position:relative;z-index:10000"></div>
<div id="ustButon" <?php gizle(); ?>><a href="<?php e($_SERVER['REQUEST_URI']) ?>"><?php e(resim("resimler/ikon/yenile.png")) ?></a></div>