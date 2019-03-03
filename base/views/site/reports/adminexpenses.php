<?php
	$st=!empty($_REQUEST['c']) ? "none" : "block";
?>
<style>
.reportlinks {
	background:none;
}
#foo {
	display:<?php echo $st;?>
}
</style>

<script type="text/javascript">
<!--
    function toggle_visibility(id) {
       var e = document.getElementById(id);
       if(e.style.display == 'block')
          e.style.display = 'none';
       else
          e.style.display = 'block';
    }
//-->
</script>

<h2>Company Budget:  <?php echo user()->budget['name']?><?php if($_REQUEST['print']!=1) { ?><small><a href="#" onclick="toggle_visibility('foo');">Show/Hide Budget Summary</a></small><?php } ?></h2>

<?php
$ht="<div id='foo'><table style='border: 1px solid;width:500px'>";
$cs=Yii::app()->db->createCommand("select * from accountcodes where accountcode regexp '^45$'")->queryAll();				

foreach($cs as $c) {
$ht ."<tr><td><h2><?php echo $c[accountcode]; ?></h2></td><td colspan=2><h2><?php echo $c[item];?></h2></td></tr>";
$total=0;
$taccd=0;
$codes=Yii::app()->db->createCommand("select * from accountcodes where accountcode regexp '^".$c[accountcode]."[0-9]{4}$' order by item")->queryAll();				
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
if(!$_REQUEST['print']) $ht.="<a href='?r=site/exportReport&ac=44'>Export to Excel</a> | <a href='".$_SERVER['REQUEST_URI']."&print=1'>View in Report Format</a>";
$ht .="</div>";

echo $ht;

?>
<br/>
<?php

if($_REQUEST['c']) {
	echo "<div class='grid-view'><table class='items' style='border: 1px solid;width:70%'>";
	$cs=Yii::app()->db->createCommand("select * from accountcodes where accountcode='".$_REQUEST['c']."'")->queryAll();
	echo "<h3> Details for ".$cs['0']['accountcode']."-".$cs['0']['item']."</h3>";		
	echo "<thead><tr><th>Item</th><th>Quantity</th><th>Unit Price</th><th>Total</th></tr></thead>";
	$codes=Yii::app()->db->createCommand("select * from v_budget where accountcode = '".$cs['0']['id']."' and budget='".user()->budget['id']."'")->queryAll();	
	$tot=0;	
	foreach($codes as $csd) {
				$cl=$ct %2==0? "odd" : "even";$ct++;
		$itembudget=$csd['amount']*$csd['qty'];
		echo "<tr  class='$cl'><td>".$csd['name']."</td><td>".number_format($csd['qty'])."</td><td>".number_format($csd['amount'])."</td><td>".number_format($itembudget)."</td></tr>";
		$tot +=$itembudget;
	}
	echo "<tr><td><b>Total</b></td><td colspan=3><b>".number_format($tot)."</b></td></tr>";
	echo "</table></div>";
	if($_REQUEST['print'] !=1) echo "<a href='?r=site/exportDetails&c=".$_REQUEST['c']."'>Export to Excel</a>| <a href='".$_SERVER['REQUEST_URI']."&print=1'>View in Report Format</a>";
}

?>