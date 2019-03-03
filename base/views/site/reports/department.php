
<h1>Departmental Budget: 2015</h1>
<table style='border: 1px solid;width:500px'>
<?php
$cs=Yii::app()->db->createCommand("select * from accountcodes where accountcode regexp '^4[0-9]{1}$'")->queryAll();				

foreach($cs as $c) {
?>

<tr><td><h2><?php echo $c[accountcode]; ?></h2></td><td colspan=2><h2><?php echo $c[item];?></h2></td></tr>
<?php
$total=0;
$taccd=0;
$codes=Yii::app()->db->createCommand("select * from accountcodes where accountcode regexp '^".$c[accountcode]."[0-9]{4}$'")->queryAll();				
foreach($codes as $cd) {
	$bdgt=Yii::app()->db->createCommand("select sum(amount) a from budget where accountcode ='".$cd[id]."'")->queryAll();
	if($bdgt[0][a] > 0) { 
		$total += $bdgt[0][a];
		$taccd += $bdgt[0][a];
		echo "<tr><td>".$cd[accountcode]."</td><td>".$cd[item]."</td><td>".$bdgt[0][a]."</td></tr>";
	}
}
?>
<tr><td colspan=2><h3>Total</h3></td><td><h3><?php echo number_format($taccd); ?>/=</h3></td></tr>


<?php
		
}
	
?>


</table>