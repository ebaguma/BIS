<script>
function ddi(w) {
	var x='d'+w;
	if(document.getElementById(x).style.display=='block')
		document.getElementById(x).style.display='none';
	else
		document.getElementById(x).style.display='block';
//	alert('hi '+x);
	return false;
}
</script>
<?php
$st=!empty($_REQUEST['c']) ? "none" : "none";
$cs=Yii::app()->db->createCommand("select * from accountcodes where accountcode regexp '^44$'")->queryAll();				
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
<h2><?php echo $cs[0][accountcode]."&nbsp;&nbsp;&nbsp;". $cs[0][item];?>
<?php if($_REQUEST['print']!=1) { ?><small><a href="#" onclick="toggle_visibility('foo');">Show/Hide Budget Summary</a></small><?php } ?></h2>


<?php
$ht = "<div id='foo'><table style='border: 1px solid;width:500px' class=items>";
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
		$ht.= "<tr><td><a class='reportlinks' href='".$_SERVER['REQUEST_URI']."&c=".$cd[accountcode]."'>".$cd[accountcode]."</a></td><td><a class='reportlinks'  href='".$_SERVER['REQUEST_URI']."&c=".$cd[accountcode]."'>".$cd[item]."</a></td><td style='text-align:right'>".number_format($bdgt[0][a])."</td></tr>";
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
	$tot=0;	$ct=0;
	foreach($codes as $csd) {		
		$cl=$ct %2==0? "odd" : "even";
		$itembudget=$csd['amount']*$csd['qty'];
		echo "<tr  class='$cl'><td>".$csd['name']."</td><td>".number_format($csd['qty'])."</td><td>".number_format($csd[amount])."</td><td>".number_format($itembudget)."</td></tr>";
		$tot +=$itembudget;$ct++;
	}
	echo "<tr><td><b>Total</b></td><td colspan=3><b>".number_format($tot)."</b></td></tr>";
	echo "</table></div>";
	if($_REQUEST['print'] !=1) echo "<a href='?r=site/exportDetails&c=".$_REQUEST['c']."'>Export to Excel</a>| <a href='".$_SERVER['REQUEST_URI']."&print=1'>View in Report Format</a>";
}

?>


<?php

if($_REQUEST['d']) {
	echo "<div class='grid-view'><table class='items' style='border: 1px solid;width:70%'>";
	$cs=Yii::app()->db->createCommand("select * from v_subsistence where budget='".user()->budget['id']."'")->queryAll();
	echo "<h3> Details for ".$cs['0']['accountcode']."-".$cs['0']['item']."</h3>";		
	echo "<thead><tr><th style='width:100px'>Activity NO.</th><th style='width:200px'>Line Cost Item</th><th style='width:200px'>Site</th><th>Start Date</th><th>Duration</th><th>Total</th></tr></thead>";
	//$codes=Yii::app()->db->createCommand("select * from v_budget where accountcode = '".$cs['0']['id']."' and budget='".user()->budget['id']."'")->queryAll();	
	$tot=0;	$ct=0;
	foreach($cs as $csd) {		
		$cl=$ct %2==0? "odd" : "even";
		$itembudget=$csd['amount']*$csd['qty'];
		$date1=  strtotime($csd['startdate']);
		$date2= 	strtotime($csd['enddate']);
		$days=($date2-$date1)/86400;
		
		echo "<tr><td colspan=6> <table style='width:1000px'>";
		echo "<tr  class='$cl'><td width=10%><a href='#' onClick='return ddi(".$csd['activity'].");'> ".$csd['activity']."</a></td><td width=20%>".$csd['itemname']."</td><td width=20%>".$csd['sitename']."</td><td>".$csd['startdate']."</td><td>".$days." days</td><td>".$days."</td></tr>";
		echo "<tr  class='$cl'><td colspan=6>"; 

		echo "<div style='text-align:right;display:none;' id='d".$csd['activity']."'><table style='margin-left:20px'>";
		echo "<tr><td colspan='4'><b>Operational Materials</b></td></tr>";
		echo "<tr><td><b>Item</b></td><td><b>Quantity</b></td><td><b>Unit Price</b></td><td><b>Total</b></td></tr>";
		$det=Yii::app()->db->createCommand("select * from v_subsistence_details where activity='".$csd['id']."'")->queryAll();
		foreach($det as $e)
			$tot=$e['quantity']*$e['price'];
		echo "<tr><td>".$e['detailname']."</td><td>".$e['quantity']."</td><td>".number_format($e['price'])."</td><td>".number_format($tot)."</td></tr>";
		
		echo "<tr><td colspan='4'><b>Subsistence</b></td></tr>";
		echo "<tr><td><b>Staff</b></td><td><b>Salary Scale</b></td><td><b>Rate</b></td><td><b>Total</b></td></tr>";
		$det=Yii::app()->db->createCommand("select * from v_subsistence_staff where activity='".$csd['id']."'")->queryAll();
		foreach($det as $e)
			$tot=$e['quantity']*$e['price'];
		echo "<tr><td>".$e['employeename']."</td><td>".$e['salaryscale']."</td><td>".number_format($e['amount'])."</td><td>".number_format($days*$e['amount'])."</td></tr>";
		
		echo "</table></div";
		echo "</td></tr>";
		/*
		echo "<tr style='display:block;'><td colspan=12>";
		echo "Wilson";
			//<table style='width:1000px; border:1px solid #111111'>";
			
		$det=Yii::app()->db->createCommand("select * from v_subsistence_details where activity='".$csd['id']."'")->queryAll();
		foreach($det as $e)
			$tot=$e['quantity']*$e['price'];
		//echo "<tr><td>".$e['detailname']."</td><td>".$e['quantity']."</td><td>".$e['price']."</td><td>".$tot."</td></tr>";
			
		echo "</td></tr>";*/
		echo "</table></td></tr>";
		$tot +=$itembudget;$ct++;
	}
	//echo "<tr><td><b>Total</b></td><td colspan=4><b>".number_format($tot)."</b></td></tr>";
	echo "</table></div>";
	if($_REQUEST['print'] !=1) echo "<a href='?r=site/exportDetails&c=".$_REQUEST['c']."'>Export to Excel</a>| <a href='".$_SERVER['REQUEST_URI']."&print=1'>View in Report Format</a>";
}

?>