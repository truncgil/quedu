<?php include("sablon.php"); ?>
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

$sira = sorgu("SELECT SUM(total) AS total, users FROM (
SELECT SUM(u2score) AS total, u2 AS users FROM play WHERE kat='{$cat['slug']}'  GROUP BY users 
UNION ALL
SELECT SUM(u1score) AS total, u1 AS users FROM play WHERE kat='{$cat['slug']}' GROUP BY users 
)
derived 
WHERE  users IS NOT NULL
GROUP BY users 
ORDER BY total DESC
LIMIT 0,10
");

?>

<?php 
$sort = array();
$k=0;
while($s = kd($sira)) { 
$user = user($s['users']);
$adi =$user['adi'];
$soyadi =$user['soyadi'];
$totalgame= totalgame($s['users']); 
$puan = $s['total'];
$sort[$k]['sira'] = $k+1;
$sort[$k]['color'] = $user['color'];
$sort[$k]['oyuncu'] = "$adi $soyadi";
$sort[$k]['url'] = "profile2.php?id={$user['id']}";
$sort[$k]['derece'] = round($puan/$totalgame,2);
$sort[$k]['oyun'] = $totalgame;
$sort[$k]['puan'] = $puan;

$k++;
}
 ?>
<table data-role="table" id="table-column-toggle" data-column-btn-text="<?php le("Sütun Göster") ?>" data-mode="columntoggle" class="radius10 ui-responsive table-stroke pumpkin" style="">
     <thead>
       <tr>
         <th data-priority="2"><?php le("Sıra") ?></th>
         <th><?php le("Oyuncu") ?></th>
         <th data-priority="3"><?php le("Toplam Oyun") ?></th>
         <th data-priority="1"><?php le("Derece") ?></th>
         <th data-priority="4"><?php le("Puan") ?></th>
       </tr>
     </thead>
     <tbody>
<?php 
asort($sort);
foreach($sort AS $s) { 
?>
       <tr>
         <th><?php e($s['sira']) ?></th>
         <td><a href="profile2.php?id=<?php e($s['url']) ?>"  class="ui-btn padding0 <?php e($s['color']) ?>"><i class="fa fa-user"></i> <?php 


e($s['oyuncu']); ?></a></td>
         <td><?php e($s['oyun']) ?></td>
         <td><?php e($s['derece']) ?></td>
         <td><?php e($s['puan']) ?></td>
       </tr>
<?php 
$k++;
} ?>
     </tbody>
   </table>
</div>

<?php b(); ?>