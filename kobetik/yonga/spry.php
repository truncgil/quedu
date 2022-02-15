<?php function spryKur($id){ ?>
var spry<?php echo $id ?> = new Spry.Widget.ValidationTextField("<?php echo $id ?>", "currency", {validateOn:["blur", "change"], format:"dot_comma", useCharacterMasking:true});
<?php } ?>
<?php function spryDesen($id, $desen) { ?>
var spry<?php echo $id ?> = new Spry.Widget.ValidationTextField("<?php echo $id ?>", "custom", {useCharacterMasking:true, pattern:"<?php echo $desen ?>"});
<?php }  ?>
<?php function spryTextArea($id, $min, $max) { ?>
var spry<?php echo $id ?> = new Spry.Widget.ValidationTextarea("<?php echo $id ?>", {counterType:"chars_count", counterId:"<?php echo $id ?>_sayac", minChars:<?php echo $min ?>, maxChars:<?php echo $max ?>});
<?php } ?>
<?php function spryEmail($id) { ?>
var spry<?php echo $id ?> = new Spry.Widget.ValidationTextField("<?php echo $id ?>", "email", {validateOn:["blur", "change"]});
<?php } ?>
<?php function spryTarih($id,$desen) { ?>
var spry<?php echo $id ?> = new Spry.Widget.ValidationTextField("<?php echo $id ?>", "date", {format:"<?php echo $desen ?>", validateOn:["blur", "change"], useCharacterMasking:true});
<?php } ?>
<?php function sprySayisal($id,$min,$mak) { ?>
var spry<?php echo $id ?> = new Spry.Widget.ValidationTextField("<?php echo $id ?>", "integer", {useCharacterMasking:true, minChars:<?php echo $min ?>, maxChars:<?php echo $mak ?>});
<?php } ?>
<?php function spryTextJS() { ?>
<script src="kobetik/eklentiler/SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="kobetik/eklentiler/SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<?php } ?>
<?php function spryTextAreaJS() { ?>
<script src="kobetik/eklentiler/SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="kobetik/eklentiler/SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
<?php } ?>
<?php function spryTeyitJS() { ?>
<script src="kobetik/eklentiler/SpryAssets/SpryValidationConfirm.js" type="text/javascript"></script>
<link href="kobetik/eklentiler/SpryAssets/SpryValidationConfirm.css" rel="stylesheet" type="text/css" />
<?php } ?>
<?php function spryGerekli($id) { ?>
var spry<?php echo $id ?> = new Spry.Widget.ValidationTextField("<?php echo $id ?>","none", {validateOn:["blur", "change"]});
<?php } ?>
<?php function spryDGerekli($dizi) { 
foreach($dizi as $deger) {
?>
var spry<?php echo $deger ?> = new Spry.Widget.ValidationTextField("<?php echo $deger ?>","none", {validateOn:["blur", "change"]});
<?php 
}
} ?>
<?php function spryMesaj($mesaj) { ?>
<span class="textfieldRequiredMsg"><?php echo $mesaj; ?></span>
<?php } ?>
<?php function spryFormat($mesaj) { ?>
<span class="textfieldInvalidFormatMsg"><?php echo $mesaj; ?></span>
<?php } ?>
<?php function spryTeyit($id,$tid) { ?>
var spry<?php echo $id ?> = new Spry.Widget.ValidationConfirm("<?php echo $id ?>", "<?php echo $tid ?>", {validateOn:["blur", "change"]});
<?php } ?>
<?php function spryTeyitMesaj($mesaj) { ?>
<span class="confirmRequiredMsg"><?php e($mesaj); ?></span>
<?php } ?>
<?php function spryTeyitYok($mesaj) { ?>
<span class="confirmInvalidMsg"><?php e($mesaj); ?></span>
<?php } ?>