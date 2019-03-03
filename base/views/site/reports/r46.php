<style>
.reportlinks {
	background:none;
}
</style>
<h1>Company Budget: 2015</h1>
<?php
$ht="<table style='border: 1px solid;width:500px'>";
$cs=Yii::app()->db->createCommand("select * from accountcodes where accountcode regexp '^46$'")->queryAll();				

foreach($cs as $c) {
$ht ."<tr><td><h2><?php echo $c[accountcode]; ?></h2></td><td colspan=2><h2><?php echo $c[item];?></h2></td></tr>";
$total=0;
$taccd=0;
$codes=Yii::app()->db->createCommand("select * from accountcodes where accountcode regexp '^".$c[accountcode]."[0-9]{4}$'")->queryAll();				
foreach($codes as $cd) {
	$bdgt=Yii::app()->db->createCommand("select sum(amount*qty) a from budget where accountcode ='".$cd[id]."' and budget='".user()->budget['id']."'")->queryAll();
	//if($bdgt[0][a] > 0) { 
		$total += $bdgt[0][a];
		$taccd += $bdgt[0][a];
		$ht.= "<tr><td><a class='reportlinks' href='?r=site/reports&p=adminexpenses&c=".$cd[accountcode]."'>".$cd[accountcode]."</a></td><td><a class='reportlinks'  href='?r=site/reports&p=adminexpenses&c=".$cd[accountcode]."'>".$cd[item]."</a></td><td style='text-align:right'>".number_format($bdgt[0][a])."</td></tr>";
		//}
}

$ht.="<tr><td colspan=2><h3>Total</h3></td><td style='text-align:right'><h3>".number_format($taccd)."/=</h3></td></tr>";

}
$ht.="</table>";
echo $ht;

?>
<a href='?r=site/exportReport&ac=45'>Export to Excel</a>
<br/>
<?php

if($_REQUEST['c']) {
	echo "<table style='border: 1px solid;width:500px'>";
	$cs=Yii::app()->db->createCommand("select * from accountcodes where accountcode='".$_REQUEST['c']."'")->queryAll();
	echo "<h3> Details for ".$cs['0']['accountcode']."-".$cs['0']['item']."</h3>";		
	
	$codes=Yii::app()->db->createCommand("select * from budget where accountcode = '".$cs['0']['id']."' and budget='".user()->budget['id']."'")->queryAll();	
	$tot=0;	
	foreach($codes as $csd) {
		$itembudget=$csd['amount']*$csd['qty'];
		echo "<tr><td>".$csd['descr']."</td><td>".number_format($itembudget)."</td></tr>";
		$tot +=$itembudget;
	}
	echo "<tr><td><b>Total</b></td><td><b>".number_format($tot)."</b></td></tr>";
	echo "</table>";
	echo "<a href='?r=site/exportDetails&c=".$_REQUEST['c']."'>Export to Excel</a>";
}

?>