<?php include("kobetik.php"); 
$fonksiyonlar = get_defined_functions();
$kfonk = $fonksiyonlar['user'];
//----//
sort($kfonk);
$toplamf = count($kfonk); 
kobetik();
	head("KobetiK'in Mevcut İşlev Listesi");
	?>
	<style>
		body{font-family:Arial;}
		#liste li {
			float:left;
			margin:5px;
			padding:5px;
			border:solid 1px #666;
			list-style:none;
			<?php echo keyu("5px"); ?>
		}
		#liste li:hover {
			background:yellow;
			border:solid 1px #000;
			cursor:pointer;
			}
	</style>
	
	<?php
	_h();
	body();
		?>
		<h1>KobetiK'in Mevcut İşlev Listesi</h1>
		<h2>Toplam <?php echo $toplamf ?> İşlev</h2>
		<ul id="liste">
		<?php foreach($kfonk as $deger) { ?>
			<li><?php echo $deger; ?></li>
			<?php } ?>
		</ul>
		
		<?php
	_b();
_k();
?>
