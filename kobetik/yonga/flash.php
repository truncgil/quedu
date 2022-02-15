<?php function mp3Oynatici($url,$oynat="1") { ?>
  <object type="application/x-shockwave-flash" data="kobetik/eklentiler/player_mp3_mini.swf" width="100%" height="20">
	<param name="movie" value="kobetik/eklentiler/player_mp3_mini.swf" />
	<param name="bgcolor" value="666666" />
	<param name="FlashVars" value="mp3=<?php echo $url ?>&autoplay=<?php echo $oynat ?>" />
</object>
<?php } ?>