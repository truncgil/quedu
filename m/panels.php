		<div data-role="panel" id="profile">
		<ul data-role="listview"  clasS="yatay" >
		<?php if(!isMobile()) { ?>
			<li><a href="#" class="ui-btn ui-btn-inline" id="view-fullscreen" onclick="this.style.display='none';$('#cancel-fullscreen').show();"><i class="fa fa-desktop"></i> Tam Ekran Moduna Geç</a></li>
			<li><a href="#" class="ui-btn ui-btn-inline" id="cancel-fullscreen" onclick="this.style.display='none';$('#view-fullscreen').show();" style="display:none;"><i class="fa fa-desktop"></i> Tam Ekran Modundan Çık</a></li>
		<?php } ?>
			
			<li><a href="profile.php" class="<?php e($user['color']) ?>"><i class="fa fa-user"></i> <?php le("Profilim") ?> </a></li>
			<li><a href="games.php" ><i class="fa fa-gamepad"></i> <?php le("Oyun Geçmişiniz") ?> </a></li>
			<li><a href="category.php" ><i class="fa fa-pencil-square"></i> <?php le("Kategoriler") ?></a></li>
			<li><a href="university.php" style="display:none;"><i class="fa fa-university"></i> <?php le("Üniversiteler") ?></a></li>
			<li><a href="account.php" style="display:none"><i class="fa fa-cog"></i> <?php le("Hesabım") ?></a></li>
			<li><a href="https://app.gakk.k12.tr"><i class="fa fa-sign-out"></i> <?php le("Okulun Uygulamasına Dön") ?></a></li>
		</ul>
		
		
	</div><!-- /panel -->		


<div data-role="panel" data-display="overlay" data-theme="c"  data-position="right" id="ara">
<form class="ui-filterable">
    <input id="autocomplete-input" data-theme="a" data-inset="false" data-type="search" placeholder="<?php le("Ara") ?>..." autofocus>
<?php loading(true); ?>

</form>
<ul id="autocomplete" data-role="listview" data-filter="true" data-input="#autocomplete-input"></ul>	
  
</div><!-- /panel -->