<?php include("sablon.php"); ?>
<?php include("facebook.php"); ?>
<?php include("cookie.php"); 
include("gamedelete.php");
?>

<?php a("Hoşgeldiniz",1) ?>
<script>
/
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '1459822474326327',
      xfbml      : true,
      version    : 'v2.5'
    });
var debug  = $("#debug");
    function onLogin(response) {
		var durum  = $("#fb-welcome");
		
		durum.html("Yükleniyor...");
		debug.html(response);
	  if (response.status == 'connected') {
		FB.api('/me?fields=cover,locale,link,hometown,first_name,last_name,id,birthday,name,picture.type(large),email,gender,location,work,education', function(data) {
			console.log(data);
		    durum.html("Hoşgeldin " + data.first_name + " <br /> Oturum Açılıyor...");
			$.post("?facebookLogin",{
				"array" : data
			},function(d){
				console.log(d);
				//console.log("test");
				  location.href="profile.php";
			});
		  
		});
	  }
	}
	
	FB.getLoginStatus(function(response) {
	  if (response.status == 'connected') {
		onLogin(response);
		debug.html(response.status);
	  } else {
		FB.login(function(response) {
			console.log(response);
		  onLogin(response);
		}, {scope: 'user_friends, email'});
	  }
	});	
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
   function login() {
		FB.login(function(response) {
			console.log(response);
		  onLogin(response);
		}, {scope: 'user_friends, email'});
	}
	function onLogin(response) { // bağlanıldığında
	  if (response.status == 'connected') {
		FB.api('/me?fields=cover,locale,link,hometown,first_name,last_name,id,birthday,name,picture.type(large),email,gender,location,work,education', function(data) {
			
		  var welcomeBlock = document.getElementById('fb-welcome');
		  welcomeBlock.innerHTML = data.first_name + ' Merhaba, Bağlanıyorsun!';
			location.href="profile.php";
		  
		});
	  }
	}
</script>
	<?php // print_r($_COOKIE); ?>
           <!-- <p class="mc-top-margin-1-5"><b>Zaten Üyeyim</b></p>
            <a href="login.php" class="ui-btn">Giriş Yap</a>
            <p class="mc-top-margin-1-5"><b>Hâlâ Üye Değilim?</b></p>-->
            <!--<a href="signup.php" class="ui-btn">Kaydol</a>-->

			<script type="text/javascript">
		
			</script>
			
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/tr_TR/sdk.js#xfbml=1&version=v2.5&appId=848401271867985";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
			
		<div id="debug" style="display:none"></div>
				<h1 id="fb-welcome" style="text-align:center;"></h1>
			</div>
			<!--<a class="ui-btn" href="#" onclick="login();" style="background:#155B9A;"><i class="fa fa-facebook-square"></i> Facebook İle Bağlan</a>-->
            <p></p>
<?php b(""); ?>