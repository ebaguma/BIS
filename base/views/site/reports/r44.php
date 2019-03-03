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
$st=!empty($_REQUEST['c']) ? "none" : "block";
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
$ht = "<div id='foo'  class='grid-view'><table style='border: 1px solid;width:1400px' class=items>";
$depts=app()->db->CreateCommand("SELECT * from dept")->queryAll();
$ht.="<tr><th>AccountID</th><th>Account Code</th>";
foreach($depts as $dep) {
	$ht.="<th style='width:100px'>".$dep[shortname]."</th>";
}
$ht.="<th>Total</th></tr>";
foreach($cs as $c) {
$total=0;
$taccd=0;
$codes=Yii::app()->db->createCommand("select * from accountcodes where accountcode regexp '^".$c[accountcode]."[0-9]{4}$' order by item")->queryAll();				
foreach($codes as $cd) {
	$cl= $ctr%2==0 ? 'even' : 'odd';
	$ht.= "<tr class='$cl'><td><a class='reportlinks' href='".$_SERVER['REQUEST_URI']."&c=".$cd[accountcode]."'>".$cd[accountcode]."</a></td><td><a class='reportlinks'  href='".$_SERVER['REQUEST_URI']."&c=".$cd[accountcode]."'>".$cd[item]."</a></td>";
	$linetot=0;$ctr++;
	foreach($depts as $dep) {
		$bdgt=Yii::app()->db->createCommand("select sum(amount*qty) a from budget where accountcode ='".$cd[id]."' and budget='".user()->budget['id']."' and dept in (select id from sections where department='".$dep['id']."')")->queryAll();
	//if($bdgt[0][a] > 0) { 
		$total += $bdgt[0][a];
		$linetot +=$bdgt[0][a];
		$taccd += $bdgt[0][a];
		$ht.= "<td style='text-align:right'>".number_format($bdgt[0][a])."</td>";
	}
		
		$ht.="<td style='text-align:right'>".number_format($linetot)."</td></tr>";
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
	
	$e="report_".$_REQUEST['c'];
	if(function_exists($e))
		$e();
	else
		rgeneral();
}
function rgeneral() {
	$cs=Yii::app()->db->createCommand("select * from accountcodes where accountcode='".$_REQUEST['c']."'")->queryAll();
	echo "<h3> Details for ".$cs['0']['accountcode']."-".$cs['0']['item']."</h3>";		
	echo "<div class='grid-view'><table class='items' style='border: 1px solid;width:70%'>";
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

function report_440006() {
	echo "<h2> Details for Sub Stations</h2>";			
	$mysecs=Yii::app()->db->createCommand("SELEct distinct section from v_subsistence order by sectionname asc")->queryAll();
	foreach($mysecs as $mysec) {
		$cs=Yii::app()->db->createCommand("select * from v_subsistence where budget='".user()->budget['id']."' and section='".$mysec[section]."'")->queryAll();
		echo "<h3>".$cs[0][dept].": ".$cs[0][sectionname]."</h3>";
	
		echo "<div class='grid-view'><table class='items' style='border: 1px solid;width:70%'>";
				echo "<thead><tr><th style='width:100px'>Activity NO.</th><th style='width:200px'>Line Cost Item</th><th style='width:200px'>Site</th><th>Start Date</th><th>Duration</th><th>Total Cost</th></tr></thead>";
		//$codes=Yii::app()->db->createCommand("select * from v_budget where accountcode = '".$cs['0']['id']."' and budget='".user()->budget['id']."'")->queryAll();	
		$tot=0;	$ct=0;
		foreach($cs as $csd) {		
			$cl=$ct %2==0? "odd" : "even";
			$itembudget=$csd['amount']*$csd['qty'];
			$date1=  strtotime($csd['startdate']);
			$date2= 	strtotime($csd['enddate']);
			$days=($date2-$date1)/86400;
		
			//echo "<tr><td colspan=6> <table style='width:1000px'>";
			$ht_sub= "<tr  class='$cl'><td width=10%><a href='#' onClick='return ddi(".$csd['activity'].");'> ".$csd['activity']."</a></td><td width=20%>".$csd['itemname']."</td><td width=20%>".$csd['sitename']."</td><td>".$csd['startdate']."</td><td>".$days." days</td><td style='text-align:right'>";//.$days."</td></tr>";
			$dhsub= "<tr  class='$cl'><td colspan=6>"; 

			$dhsub.=  "<div style='text-align:right;display:none;' id='d".$csd['activity']."'><table style='margin-left:20px'>";
			$dhsub.=  "<tr><td colspan='4'><b>Operational Materials</b></td></tr>";
			$dhsub.=  "<tr><td><b>Item</b></td><td><b>Quantity</b></td><td><b>Unit Price</b></td><td><b>Total</b></td></tr>";
			$det=Yii::app()->db->createCommand("select * from v_subsistence_details where activity='".$csd['id']."'")->queryAll();
			$mtot=$subt=0;
			foreach($det as $e) {
				$tot=$e['quantity']*$e['price'];
				$mtot +=$tot;
				$dhsub.=  "<tr><td>".$e['detailname']."</td><td>".$e['quantity']."</td><td>".number_format($e['price'])."</td><td>".number_format($tot)."</td></tr>";
			}
			$dhsub.= "<tr><td><b>Total</b></td><td>&nbsp;</td><td>&nbsp;</td><td><strong>".number_format($mtot)."</strong></td></tr>";
			$dhsub.= "<tr><td colspan='4'><b>Subsistence</b></td></tr>";
			$dhsub.= "<tr><td><b>Staff</b></td><td><b>Salary Scale</b></td><td><b>Rate</b></td><td><b>Total</b></td></tr>";
			$det=Yii::app()->db->createCommand("select * from v_subsistence_staff where activity='".$csd['id']."'")->queryAll();
			$alr=array();
			foreach($det as $e) {
				if(!in_array($e['employeename'],$alr)) {
					$tot=$e['quantity']*$e['price'];
					$dhsub.= "<tr><td>".$e['employeename']."</td><td>".$e['salaryscale']."</td><td>".number_format($e['amount'])."</td><td>".number_format($days*$e['amount'])."</td></tr>";			}
					$alr[]=$e['employeename'];
			}
		
			$dhsub.= "</table></div</td></tr>";
			$ht_sub.=number_format($mtot)."</td></tr>";
			echo $ht_sub.$dhsub;
			//echo "";
			/*
			echo "<tr style='display:block;'><td colspan=12>";
			echo "Wilson";
				//<table style='width:1000px; border:1px solid #111111'>";
			
			$det=Yii::app()->db->createCommand("select * from v_subsistence_details where activity='".$csd['id']."'")->queryAll();
			foreach($det as $e)
				$tot=$e['quantity']*$e['price'];
			//echo "<tr><td>".$e['detailname']."</td><td>".$e['quantity']."</td><td>".$e['price']."</td><td>".$tot."</td></tr>";
			
			echo "</td></tr>";*/
			//echo "</table></td></tr>";
			$tot +=$itembudget;$ct++;
		}
		//echo "<tr><td><b>Total</b></td><td colspan=4><b>".number_format($tot)."</b></td></tr>";
		echo "</table></div>";
}
	if($_REQUEST['print'] !=1) echo "<a href='?r=site/exportDetails&c=".$_REQUEST['c']."'>Export to Excel</a>| <a href='".$_SERVER['REQUEST_URI']."&print=1'>View in Report Format</a>";
}

?>