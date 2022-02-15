<?php 
ob_start("ob_gzhandler");
include("sablon.php"); ?>
<?php include("secure.php");
$kim = content(get("id"));
if($kim==0) {
yonlendir("profile.php");
} else {
$cat = kd($kim);
}
?>
<?php a("Sıralama"); ?>
<?php echo hiyerarsi(get("id")); ?>
<div id="profil" data-demo-html="true">
<img src="../file/<?php e(catlogo($cat['slug'])) ?>" alt="" width="128" /><h1><?php e($cat['title']) ?> </h1>
<h2><i class="fa fa-trophy"></i> <?php le("Top 10 Sıralaması") ?></h2>
<?php

$sira = sorgu("SELECT *,SUM(score) AS puan FROM scores WHERE kat = '{$cat['slug']}' GROUP BY uid ORDER BY SUM(score) DESC");

?><table data-role="table" id="table-column-toggle" data-column-btn-text="<?php le("Sütun Göster") ?>" data-mode="columntoggle" class="radius10 ui-responsive table-stroke pumpkin" style="">
     <thead>
       <tr>
         <th data-priority="2"><?php le("Sıra") ?></th>
         <th><?php le("Oyuncu") ?></th>
         <!-- <th data-priority="3"><?php le("Toplam Oyun") ?></th>-->
          <!-- <th data-priority="4"><?php le("Derece") ?></th>-->
         <th data-priority="1"><?php le("Puan") ?></th>
       </tr></thead>
     <tbody><?php
$k = 0;
while($s = kd($sira)) {
$k++;
$user = user($s['uid']);
?><tr><th><?php e($k) ?></th><td><a href="profile2.php?id=<?php e($s['uid']) ?>"  class="ui-btn padding0" style="text-align:left;"><img src="<?php e($user['resim']) ?>" alt="" style="float: left;width: 24px;height: 24px;position: relative;margin: 1px 10px;" class="profilepic" /><?php
e($user['adi']); ?> <?php e($user['soyadi']) ?></a></td><td><?php e($s['puan']) ?></td></tr><?php
}
?></tbody></table></div>

<?php b(); ?>