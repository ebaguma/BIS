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
    function toggle_visibility(id) {
       var e = document.getElementById(id);
       if(e.style.display == 'block')
          e.style.display = 'none';
       else
          e.style.display = 'block';
    }
</script>
	 
	 
<h2>Employees Budget: <?php echo user()->budget['name']?>
 
	
	<?php if($_REQUEST['print']!=1) { ?><small><a href="#" onclick="toggle_visibility('foo');">Show/Hide Budget Summary</a></small><?php } ?></h2>
<div id="foo">
<table style='border: 1px solid;width:500px'>
<?php
$cs=Yii::app()->db->createCommand("select * from accountcodes where accountcode regexp '^40$'")->queryAll();				

foreach($cs as $c) {
?>

<tr><td><h2><?php echo $c[accountcode]; ?></h2></td><td colspan=2><h2><?php echo $c[item];?></h2></td></tr>
<?php
$total=0;
$taccd=0;
$codes=Yii::app()->db->createCommand("select * from accountcodes where accountcode regexp '^".$c[accountcode]."[0-9]{4}$'")->queryAll();				
foreach($codes as $cd) {
	$bdgt=Yii::app()->db->createCommand("select sum(amount) a from budget where accountcode ='".$cd[id]."' and budget='".user()->budget['id']."'")->queryAll();
	if($bdgt[0][a] > 0) { 
		$total += $bdgt[0][a];
		$taccd += $bdgt[0][a];
		echo "<tr><td><a class='reportlinks' href='?r=site/reports&p=emoluments&c=".$cd[accountcode]."'>".$cd[accountcode]."</a></td><td><a class='reportlinks'  href='?r=site/reports&p=emoluments&c=".$cd[accountcode]."'>".$cd[item]."</a></td><td>".number_format($bdgt[0][a])."</td></tr>";
	}
}
?>
<tr><td colspan=2><h3>Total</h3></td><td><h3><?php echo number_format($taccd); ?>/=</h3></td></tr>

<?php		
}
?>
</table>
<?php if($_REQUEST['print']!=1) { ?><a href='?r=site/exportReport&ac=40'>Export to Excel</a> | <a href='index.php?r=site/reports&p=emoluments&print=1'>Print</a><?php } ?>
<br/>
</div>
<?php

$emp_table=array('400001','400007','400008','400010');
if($_REQUEST['c']) {
	if(in_array($_REQUEST['c'],$emp_table)) {
		if($_REQUEST['c']=="400001")
			salarytable();
		else {
			emptable();
		}
	} else {
		//if(_)
		bgttable();
	}
}
function salarytable() {
	$cs=Yii::app()->db->createCommand("select * from v_employees_budget where accountid='".$_REQUEST['c']."'  and budget='".user()->budget['id']."' order by dept, amount desc, employee")->queryAll();	
	echo "<h2> Details for ".$cs['0']['accountid']."-".$cs['0']['accountitem']."</h2>";		
	echo '<div id="employees-grid" class="grid-view">';
	echo "<table class='items' style='border: 1px solid;width:1000px'>";
	$thead= '<thead><tr>
			<th>Names</th>
			<th>Designation</th>
			<th>Scale</th>
			<th>Spine</th>
			<th>Monthly</th>
			<th>Annual</th></tr>
	</thead>';
//	$cs=Yii::app()->db->createCommand("select * from v_employees_budget where accountid='".$_REQUEST['c']."' order by dept, employee")->queryAll();	
	$tot=0;	$ct=0;
	$qdep=app()->db->createCommand("select * from dept where id in (select distinct department from v_employees_budget)")->queryAll();
//print_r($qdep);
	foreach($qdep as $dep) {
		echo "<tr><td colspan=6><h2>Department: ".$dep['dept']."</h2></td></tr>";
		echo $thead;
		$s="";
		$deptotal=$sectotal=0;
		foreach($cs as $csd) {
			if($csd['department']==$dep[id]) {
				$deptotal +=$csd['amount'];
				if($csd['sectionname'] != $s) {
					$s=$csd['sectionname'];
					if($sectotal > 0) echo "<tr><td colspan=4><b>Section Total</b></td><td style='text-align:right'><b>".number_format($sectotal)."</b></td><td style='text-align:right'><b>".number_format($sectotal*12)."</b></td></tr>";
					echo "<tr><td colspan=6><h3>Section: ".$csd['sectionname']."</h3></td></tr>"; 
					$sectotal=0;
				}
				$sectotal +=$csd['amount'];
								
//				foreach($cs as $csd) {
					$cl=$ct %2==0? "odd" : "even";
					echo "<tr class='$cl'>
						<td>".$csd['employee']."</td>
						<td>".$csd['designationname']."</td>
						<td>".$csd['scalename']."</td>
						<td>".$csd['spinename']."</td>
						<td style='text-align:right'>".number_format($csd['amount'])."</td>
						<td style='text-align:right'>".number_format($csd['amount']*12)."</td>
					</tr>";
					$tot +=$csd['amount'];$ct++;
					//}
				
			}
		}
		if($sectotal > 0) echo "<tr><td colspan=4><b>Section Total</b></td><td style='text-align:right'><b>".number_format($sectotal)."</b></td><td style='text-align:right'><b>".number_format($sectotal*12)."</b></td></tr>";
		
		echo "<tr><td colspan=4><b>Department Total</b></td><td style='text-align:right'><b>".number_format($deptotal)."</b></td><td style='text-align:right'><b>".number_format($deptotal*12)."</b></td></tr>";
		
	}
	echo "<tr><td colspan=4><b>Grand Total</b></td><td style='text-align:right'><b>".number_format($tot)."</b></td><td style='text-align:right'><b>".number_format($tot*12)."</b></td></tr>";
	
	if($_REQUEST['print']!=1)  echo "<tr><td colspan=4><a href='".$_SERVER['REQUEST_URI']."&print=1'>View in Report Format</a></td><td style='text-align:right'><b>&nbsp;</b></td></tr>";
	echo "</tbody></table></div>";
}

function emptable() {
	$cs=Yii::app()->db->createCommand("select * from v_employees_budget where accountid='".$_REQUEST['c']."'  and budget='".user()->budget['id']."' order by dept, employee")->queryAll();
	echo "<h3> Details for ".$cs['0']['accountid']."-".$cs['0']['accountitem']."</h3>";		
	echo '<div id="employees-grid" class="grid-view">';
	echo "<table class='items' style='border: 1px solid;width:1000px'>";
	echo '<thead><tr>
			<th>Names</th>
			<th>Designation</th>
			<th>Scale</th>
			<th>Spine</th>
			<th>Monthly</th>
	</thead><tbody>';
	
//	$codes=Yii::app()->db->createCommand("select * from budget where accountcode = '".$cs['0']['id']."'")->queryAll();	
	$tot=0;	$ct=0;
	foreach($cs as $csd) {
		$cl=$ct %2==0? "odd" : "even";
		echo "<tr class='$cl'>
			<td>".$csd['employee']."</td>
			<td>".$csd['designationname']."</td>
			<td>".$csd['scalename']."</td>
			<td>".$csd['spinename']."</td>
			<td style='text-align:right'>".number_format($csd['amount'])."</td>
		</tr>";
		$tot +=$csd['amount'];$ct++;
	}
	echo "<tr><td colspan=4><b>Total</b></td><td style='text-align:right'><b>".number_format($tot)."</b></td></tr>";
/*	if($_REQUEST['c']=="400001")
		echo "<tr><td colspan=4><b>Total Annual</b></td><td style='text-align:right'><b>".number_format($tot*12)."</b></td></tr>";*/
	
	if($_REQUEST['print']!=1)  echo "<tr><td colspan=4><a href='".$_SERVER['REQUEST_URI']."&print=1'>View in Report Format</a></td><td style='text-align:right'><b>&nbsp;</b></td></tr>";
	echo "</tbody></table></div>";
	
}
function bgttable() {
	echo '<div id="employees-grid" class="grid-view">';
	echo "<table class='items' style='border: 1px solid;width:500px'>";
	$cs=Yii::app()->db->createCommand("select * from accountcodes where accountcode='".$_REQUEST['c']."'")->queryAll();
	echo "<h3> Details for ".$cs['0']['accountcode']."-".$cs['0']['item']."</h3>";		
	
	$codes=Yii::app()->db->createCommand("select * from budget where accountcode = '".$cs['0']['id']."' and budget='".user()->budget['id']."'")->queryAll();	
	$tot=0; $ct=0;
	foreach($codes as $csd) {
		$cl=$ct %2==0? "odd" : "even";
		echo "<tr class='$cl'><td>".$csd['descr']."</td><td>".number_format($csd['amount'])."</td></tr>";
		$tot +=$csd['amount'];$ct++;
	}
	echo "<tr><td><b>Total</b></td><td><b>".number_format($tot)."</b></td></tr>";
	echo "</table></div>";
	echo "<a href='?r=site/exportDetails&c=".$_REQUEST['c']."'>Export to Excel</a>";
}

?>