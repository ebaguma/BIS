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
<h1>Corporate Budget: <?php echo user()->budget['name']?></h1>

<?php
$cs=Yii::app()->db->createCommand("select * from accountcodes where accountcode regexp '^41$'")->queryAll();				
?>
<h2><?php echo $cs[0][accountcode]."&nbsp;&nbsp;&nbsp;". $cs[0][item];?>
<?php if($_REQUEST['print']!=1) { ?><small><a href="#" onclick="toggle_visibility('foo');">Show/Hide Budget Summary</a></small><?php } ?></h2>

<div id="foo">	 
<div class='grid-view'><table style='border: 1px solid;width:500px' class=items>

<?php 
foreach($cs as $c) {
$total=0;
$taccd=0;
$codes=Yii::app()->db->createCommand("select * from accountcodes where accountcode regexp '^".$c[accountcode]."[0-9]{4}$'")->queryAll();				
foreach($codes as $cd) {
	$bdgt=Yii::app()->db->createCommand("select sum(amount*qty) a from budget where accountcode ='".$cd[id]."' and budget='".user()->budget['id']."'")->queryAll();
	$cls= $i++%2==0 ? "even" : "odd";
	if($bdgt[0][a] > 0) { 
		$total += $bdgt[0][a];
		$taccd += $bdgt[0][a];		
		echo "<tr class=$cls><td><a class='reportlinks' href='?r=site/reports&p=staffcosts&c=".$cd[accountcode]."'>".$cd[accountcode]."</a></td><td><a class='reportlinks'  href='?r=site/reports&p=staffcosts&c=".$cd[accountcode]."'>".$cd[item]."</a></td><td style='text-align:right'>".number_format($bdgt[0][a])."</td></tr>";
	} else
		echo "<tr class=$cls><td>".$cd[accountcode]."</td><td>".$cd[item]."</td><td style='text-align:right'>0</td></tr>";
}
?>
<tr><td colspan=2><h3>Total</h3></td><td style='text-align:right'><h3><?php echo number_format($taccd); ?>/=</h3></td></tr>

<?php		
}
?>
</table></div>

<?php if($_REQUEST['print']!=1) { ?><a href='?r=site/exportReport&ac=41'>Export to Excel</a> | <a href='index.php?r=site/reports&p=staffcosts&print=1'>Print</a><?php } ?>
<br/>
</div>
<?php

if($_REQUEST['c']) {
	$e="report_".$_REQUEST['c'];
	if(function_exists($e))
		$e();
	else
		c_41();
}
function rieport_4100021() {
	echo "Yes.! Mbalina";
}
function c_41() {
	
	echo "<div class='grid-view'><table style='border: 1px solid;width:600px' class=items>";
	echo "<tr><th>Item</th><th>Quantity</th><th>Price</th><th>Total</th></tr>";
	$cs=Yii::app()->db->createCommand("select * from accountcodes where accountcode='".$_REQUEST['c']."'")->queryAll();
	echo "<h3> Details for ".$cs['0']['accountcode']."-".$cs['0']['item']."</h3>";		
	
	$codes=Yii::app()->db->createCommand("select * from budget where accountcode = '".$cs['0']['id']."' and budget='".user()->budget['id']."'")->queryAll();	
	$tot=0;	
	foreach($codes as $csd) {
		$cls= $i++%2==0 ? "even" : "odd";
		$itembudget=$csd['amount']*$csd['qty'];
		echo "<tr class=$cls><td>".$csd['descr']."</td><td>".$csd['qty']."</td><td>".number_format($csd['amount'])."</td><td>".number_format($itembudget)."</td></tr>\n";
		$tot +=$itembudget;
	}
	echo "<tr><td colspan=3><b>Total</b></td><td><b>".number_format($tot)."</b></td></tr>";
	echo "</table></div>";
	 if($_REQUEST['print']!=1) { echo "<a href='?r=site/exportDetails&c=".$_REQUEST['c']."'>Export to Excel</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href='".$_SERVER['REQUEST_URI']."&print=1'>View in Report Format</a>";
	 }
}
?>