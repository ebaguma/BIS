<script type="text/javascript">
function toggle_visibility(id) {
   var e = document.getElementById(id);
   if(e.style.display == 'block')
      e.style.display = 'none';
   else
      e.style.display = 'block';
}
function ddi(w) {
	var x='d'+w;
	if(document.getElementById(x).style.display=='block')
		document.getElementById(x).style.display='none';
	else
		document.getElementById(x).style.display='block';
	return false;
}
</script>
<?php
$st=!empty($_REQUEST['c']) ? "none" : "block";

switch ($_REQUEST['p']) {
	case 	"all":
	$sql ="accountcode regexp '^4[0-9]$' or accountcode regexp '^10$'";
	break;
	case 	"42":
	$sql ="accountcode regexp '^".$_REQUEST['p']."$' or accountcode regexp '^43$'";
	break;
	default:
	$sql ="accountcode regexp '^".$_REQUEST['p']."$'";
}
$rd='realdept';
$cs=Yii::app()->db->createCommand("select * from accountcodes where report=1 and $sql")->queryAll();
$bname="Corporate";
$depts=app()->db->CreateCommand("SELECT * from dept order by ordering asc")->queryAll();
if(is_dept_head() && !corporate_report()) {
	$ad=" where id=(select department from sections where id='".user()->dept[id]."')";
	$bname="Department";
	$ee=Sections::model()->findByPk(user()->dept[id]);
	$depts=app()->db->CreateCommand("SELECT * from sections where department in (select department from sections where  id='".user()->dept[id]."')")->queryAll();
	$rd='dept';
}
if(!is_dept_head() && !corporate_report())  {
	$ad=" where id=(select department from sections where id='".user()->dept[id]."')";
	$bname="Section";
	$depts=app()->db->CreateCommand("SELECT * from sections where   id='".user()->dept[id]."'")->queryAll();
	$rd='dept';
}

?>
<style>
.above {
	color:red;
}
.below {
	color:black;
}
.odd2 {
	background-color: rgb(250,250,250);
}
.even2 {
	background-color: rgb(230,230,230);
}
.ri {
	text-align:right;
}
.reportlinks {
	background:none;
}
#foo {
	display:<?php echo $st;?>
}
</style>

<h1><?php echo $bname;?> Budget: <?php echo user()->budget['name']?></h1>
<?php
$e=BudgetCaps::model()->findAll('budget='.budget());
foreach ($e as $as)
	$cap[$as[dept]][$as[accountcode]]=$as[cap];

if(!$_REQUEST['c']) {
$ht = "<div id='foo'  class='grid-view'>";

$aht="<tr><th>AccountID</th><th>Account Code</th>";
foreach($depts as $dep)
	$aht.="<th style='width:100px'>".$dep[shortname]."</th>";
$aht.="<th>Total</th></tr>";
foreach($cs as $c) {
	$ht.="<h3>".$c[accountcode]."&nbsp;&nbsp; - &nbsp;&nbsp;".$c[item]."</h3>";
	$ht.="<table style='border: 1px solid;width:1000px;max-width:1400px' class=items>";
	$ht.=$aht;

$total=0;
$taccd=0;
$mydep=array();
$codes=Yii::app()->db->createCommand("select * from accountcodes where report=1 and accountcode regexp '^".$c[accountcode]."[0-9]{4}$' order by accountcode")->queryAll();
foreach($codes as $cd) {
	$cl= $ctr%2==0 ? 'even' : 'odd';
	$ht.= "<tr class='$cl'><td><a class='reportlinks' href='".$_SERVER['REQUEST_URI']."&c=".$cd[accountcode]."'>".$cd[accountcode]."</a></td><td><a class='reportlinks'  href='".$_SERVER['REQUEST_URI']."&c=".$cd[accountcode]."'>".$cd[item]."</a></td>";
	$linetot=0;$ctr++;
	$dctr=0;
	foreach($depts as $dep) {
		$bdgt=Yii::app()->db->createCommand("select sum(amount) a from v_budget where accountcode ='".$cd[id]."' and budget='".user()->budget['id']."' and $rd='".$dep['id']."' $ad2")->queryAll();
		$total += $bdgt[0][a];
		$linetot +=$bdgt[0][a];
		$taccd += $bdgt[0][a];
		$dc=$cap[$dep['id']][$cd[accountcode]] > 0 && $bdgt[0][a]  > $cap[$dep['id']][$cd[accountcode]] ? "above" : "below";

		$ht.= "<td style='text-align:right' class=$dc>".number_format($bdgt[0][a])."</td>";
		$mydep[$dctr] +=$bdgt[0][a];$dctr++;
	}
		if(is_dept_head() && !corporate_report()) {
			$dic=$cap[$ee->department][$cd[accountcode]] > 0 && $linetot > $cap[$ee->department][$cd[accountcode]] ? "above" : "below";
			if($dic=="above") $ti="title='".number_format($cap[$ee->department][$cd[accountcode]])."'";
		}
		$ht.="<td class='".$dic."' $ti style='text-align:right'>".number_format($linetot)."</td></tr>";
}

//$ht.="<tr><td colspan=3><h3>Total</h3></td><td style='text-align:right'><h3>".number_format($taccd)."/=</h3></td></tr>";
$ht.= "<tr class=$r><th colspan=2><strong>Totals</strong></th>";
for($myctr=0;$myctr <count($mydep);$myctr++) {
	$ht.="<th>".number_format($mydep[$myctr])."</th>";
}
$ht .="<th style='text-align:right'><strong>".number_format($taccd)."</strong></th></tr>";
$ht.="</table><div class=pbrk></div>";
}

}
if(!$_REQUEST['print']) $ht.="<a href='".$_SERVER['REQUEST_URI']."&print=1'>View this Report</a>";

$ht .="</div>";
echo $ht;
?>
<br/>
<?php

if($_REQUEST['c']) {
	switch ($_REQUEST['c']) {
		case "400004":// NSSF
      if(!budget_locked()) nssf_calc();
			report_400001();
			break;
		case "400008":// Gratuity
    if(!budget_locked()) gratuity_calc();
			report_400001();
			break;
		case "400010":// Local Leave Expense
      if(!budget_locked()) leave_calc();
			report_400001();
			break;
		case "400007":// Standby
      if(!budget_locked()) standby_calc();
			report_400001();
			break;
		case "400019":// Shift
      if(!budget_locked()) shift_calc();
			report_400001();
			break;
		case "400001":// salary
		case "400021":// Soap
		case "400014":// Other Allowance (Contracts commitee)
		case "400025":// Mobile phone
		case "400012":// Risk
		case "410004":// Medical
			report_400001();
			break;
		case "400002": // Over time
		case "400026": // Out of station
		case "400005": // Acting
		case "400003": // Weekend Lunch
		case "400022": // Weekend Transport
		case "400016": // Pay in lieu of leave
		case "400006": // Subsistence
		case "400011": // Responsibility
			report_allowances();
			break;
		case "440006": //Substation
		case "440004"://Pole Plant
		case "440014"://Transmission Lines
		case "440011"://Communication Equipment
			report_440006();
			break;
		case "420001"://Repairs
			r_repairs();
			break;
		case "420002"://Tyres/Batteries
			r_tyres_battery();
			break;
		case "420003"://Service
			r_service();
			break;
		case "430002"://Tyres/Batteries
		case "430001"://Tyres/Batteries
			r_fuel();
			break;
		default:
			rgeneral();
	}
}
if(!$_REQUEST['print']) $this->widget('ext.ScrollTop');
function r_fuel() {
	$f=$_REQUEST['c']=='430001' ? 'Petrol' : 'Diesel';
	$ht='<div id="employees-grid" class="grid-view">';
	$ht.= "<table class='items' style='border: 1px solid;width:1000px'>";
	$ht.= '<thead><tr>
			<th>Reg No.</th>
			<th>Vehicle Category</th>
			<th>Section</th>
			<th>Mileage (Ltrs)</th>
			<th>Consumption (KM/L)</th>
			<th>Total Fuel (Ltrs)</th>
			<th>Price (Per Ltr)</th>
			<th>Total Price</th>
	</thead>';
	$tt=$tb=0;
	$qdep=app()->db->createCommand("select * from v_transport where fueltype='".$f."' and fueltotalprice >0 and   budget=".budget()." order by dept,section,regno")->queryAll();
	foreach($qdep as $c) {
		$tt+=$c['fueltotalprice'];
		$cl=$ct %2==0? "odd" : "even"; $ct++;
		$ht.="<tr class=$cl>
					<td>".$c['regno']."</td>
					<td>".$c['type']."</td>
					<td>".$c['sectionname']."</td>
					<td>".$c['mileage']."</td>
					<td class=ri>".$c['fuelconsumption']."</td>
					<td class=ri>".number_format($c['fuelqty'])."</td>
					<td class=ri>".number_format($c['fuelprice'])."</td>
					<td class=ri>".number_format($c['fueltotalprice'])."</td>
				</tr>";
	}
	$cl=$ct %2==0? "odd" : "even"; $ct++;
	$ht.="<tr class=$cl>
				<td><strong>Total</strong></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td><td>&nbsp;</td>
				<td class=ri>&nbsp;</td>
				<td class=ri><strong>".number_format($tt)."</strong></td>
			</tr>";

	$ht.="</table>";
	$ht.="</div>";
	echo $ht;
}

function r_service() {
	$ht='<div id="employees-grid" class="grid-view">';
	$ht.= "<table class='items' style='border: 1px solid;width:1000px'>";
	$ht.= '<thead><tr>
			<th>Reg No.</th>
			<th>Vehicle Category</th>
			<th>Section</th>
			<th>Mileage (Ltrs)</th>
			<th>Service Interval (KM)</th>
			<th>No. of Service</th>
			<th>Unit Price</th>
			<th>Total Price</th>
	</thead>';
	$tt=0;
	$qdep=app()->db->createCommand("select * from v_transport where mileage>0 and serviceinterval >0 and budget=".budget()." order by dept,section,regno")->queryAll();
	foreach($qdep as $c) {
		$svc=round($c['mileage']/$c['serviceinterval']);
		$tb=$c['serviceprice']*$svc;
		$tt+=$tb;
		$cl=$ct %2==0? "odd" : "even"; $ct++;
		$ht.="<tr class=$cl>
					<td>".$c['regno']."</td>
					<td>".$c['type']."</td>
					<td>".$c['sectionname']."</td>
					<td>".$c['mileage']."</td>
					<td class=ri>".$c['serviceinterval']."</td>
					<td class=ri>".$svc."</td>
					<td class=ri>".number_format($c['serviceprice'])."</td>
					<td class=ri>".number_format($tb)."</td>
				</tr>";
	}
	$cl=$ct %2==0? "odd" : "even"; $ct++;
	$ht.="<tr class=$cl>
				<td><strong>Total</strong></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td><td>&nbsp;</td>
				<td class=ri>&nbsp;</td>
				<td class=ri><strong>".number_format($tt)."</strong></td>
			</tr>";

	$ht.="</table>";
	$ht.="</div>";
	echo $ht;
}
function r_repairs() {
	$ht='<div id="employees-grid" class="grid-view">';
	$ht.= "<table class='items' style='border: 1px solid;width:1000px'>";
	$ht.= '<thead><tr>
			<th>Reg No.</th>
			<th>Vehicle Category</th>
			<th>Section</th>
			<th>Mileage (Ltrs)</th>
			<th>Consumption (KM/L)</th>
			<th>Total Fuel (Ltrs)</th>
			<th>Price (Per Ltr)</th>
			<th>Total Price</th>
			<th>Repairs</th>
	</thead>';
	$tt=$tb=0;
	$qdep=app()->db->createCommand("select * from v_transport where fueltotalprice >0 and   budget=".budget()." order by dept,section,regno")->queryAll();
  $repairitem=Items::model()->findByAttributes(array('name'=>'VehicleRepairPercentage','accountcode'=>'119'));
  $repairprice=ItemsPrices::model()->findByAttributes(array('item'=>$repairitem->id,'budget'=>budget()))->price;
	foreach($qdep as $c) {
		$tt+=$c['fueltotalprice'];
		$cl=$ct %2==0? "odd" : "even"; $ct++;
		$ht.="<tr class=$cl>
					<td>".$c['regno']."</td>
					<td>".$c['type']."</td>
					<td>".$c['sectionname']."</td>
					<td>".$c['mileage']."</td>
					<td class=ri>".$c['fuelconsumption']."</td>
					<td class=ri>".number_format($c['fuelqty'])."</td>
					<td class=ri>".number_format($c['fuelprice'])."</td>
					<td class=ri>".number_format($c['fueltotalprice'])."</td>
					<td class=ri>".number_format($c['fueltotalprice']*$repairprice)."</td>
				</tr>";
	}
	$cl=$ct %2==0? "odd" : "even"; $ct++;
	$ht.="<tr class=$cl>
				<td><strong>Total</strong></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td><td>&nbsp;</td>
				<td class=ri>&nbsp;</td>
				<td class=ri><strong>".number_format($tt*$repairprice)."</strong></td>
			</tr>";

	$ht.="</table>";
	$ht.="</div>";
	echo $ht;
}

function r_tyres_battery() {
	$ht='<div id="employees-grid" class="grid-view">';
	$ht.="<h3>Tyes & Tubes</h3>";
	$ht.= "<table class='items' style='border: 1px solid;width:1000px'>";
	$ht.= '<thead><tr>
			<th>Reg No.</th>
			<th>Section</th>
			<th>Vehicle Category</th>
			<th>Tyre Type</th>
			<th>No. of Tyres</th>
			<th>Unit Price</th>
			<th>Total Price</th>
	</thead>';
	$tt=$tb=0;
	$qdep=app()->db->createCommand("select * from v_transport where tyresprice > 0 and budget=".budget()." order by dept,section,regno")->queryAll();
	foreach($qdep as $c) {
		$tt+=$c['tyresprice'];
		$cl=$ct %2==0? "odd" : "even"; $ct++;
		$ht.="<tr class=$cl>
					<td>".$c['regno']."</td>
					<td>".$c['sectionname']."</td>
					<td>".$c['type']."</td>
					<td>".$c['tyresname']."</td>
					<td class=ri>".$c['num_tyres']."</td>
					<td class=ri>".number_format($c['tyresunitprice'])."</td>
					<td class=ri>".number_format($c['tyresprice'])."</td>
				</tr>";
	}
	$cl=$ct %2==0? "odd" : "even"; $ct++;
	$ht.="<tr class=$cl>
				<td><strong>Total (Tyres & Tubes)</strong></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td><td>&nbsp;</td>
				<td class=ri>&nbsp;</td>
				<td class=ri><strong>".number_format($tt)."</strong></td>
			</tr>";

	$ht.="</table>";
	$ht.="<h3><br/>Batteries</h3>";

	$ht.= "<table class='items' style='border: 1px solid;width:1000px'>";
	$ht.= '<thead><tr>
			<th>Reg No.</th>
			<th>Section</th>
			<th>Vehicle Category</th>
			<th>Battery Type</th>
			<th>No. of Batteries</th>
			<th>Unit Price</th>
			<th>Total Price</th>
	</thead>';
	foreach($qdep as $c) {
		$cl=$ct %2==0? "odd" : "even"; $ct++;
		$tb+=$c['batteryprice'];
		$ht.="<tr class=$cl>
					<td>".$c['regno']."</td>
					<td>".$c['sectionname']."</td>
					<td>".$c['type']."</td>
					<td>".$c['batteryname']."</td>
					<td class=ri>".$c['num_battery']."</td>
					<td class=ri>".number_format($c['batteryunitprice'])."</td>
					<td class=ri>".number_format($c['batteryprice'])."</td>
				</tr>";
	}
	$cl=$ct %2==0? "odd" : "even"; $ct++;
	$ht.="<tr class=$cl>
				<td><strong>Total (Batteries)</strong></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td><td>&nbsp;</td>
				<td class=ri>&nbsp;</td>
				<td class=ri><strong>".number_format($tb)."</strong></td>
			</tr>";
	$cl=$ct %2==0? "odd" : "even"; $ct++;
	$ht.="<tr class=$cl>
				<td><strong>Total</strong></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td><td>&nbsp;</td>
				<td>&nbsp;</td>
				<td class=ri>&nbsp;</td>
				<td class=ri><strong>".number_format($tb+$tt)."</strong></td>
			</tr>";
	$ht.="</table>";

	$ht.="</div>";
	echo $ht;
}
function report_allowances() {
	if(is_dept_head() && !corporate_report())
		$ad=" and department=(select department from sections where id='".user()->dept[id]."')";
	if(!is_dept_head() && !corporate_report())
		$ad=" and section='".user()->dept[id]."'";
	$cs=Yii::app()->db->createCommand("select * from v_employees where accountid='".$_REQUEST['c']."'  and budget='".user()->budget['id']."' $ad order by section, employee asc, amount desc")->queryAll();
	echo "select * from v_employees where accountid='".$_REQUEST['c']."'  and budget='".user()->budget['id']."' $ad order by section, employee asc, amount desc";
	echo "<h2> Details for ".$cs['0']['accountid']."-".$cs['0']['accountitem']."</h2>";
	echo '<div id="employees-grid" class="grid-view">';
	echo "<table class='items' style='border: 1px solid;max-width:100%'>";
	$thead= '<thead><tr>
			<th>CheckNo</th>
			<th>Names</th>
			<th>Designation</th>
			<th>Scale</th>
			<th>'.($_REQUEST['c']== "400002"? "Hours" : "Days").'</th>
			<th>Rate</th>
			<th>Annual</th></tr>
	</thead>';
	$tot=0;	$ct=0;
	$qdep=app()->db->createCommand("select * from dept where id in (select distinct department from v_employees where 1 $ad) order by dept asc")->queryAll();
	foreach($qdep as $dep) {
		echo "<tr><td colspan=7><h2>Department: ".$dep['dept']."</h2></td></tr>";
		echo $thead;
		$s="";
		$deptotal=$sectotal=0;
		foreach($cs as $csd) {
			$amt=$csd['amount']*$csd['qty'];
			if($csd['department']==$dep[id]) {
				$deptotal +=$amt;
				if($csd['sectionname'] != $s) {
					$s=$csd['sectionname'];
					if($sectotal > 0) echo "<tr><td colspan=5><b>Section Total</b></td><td style='text-align:right'></td><td style='text-align:right'><b>".number_format($sectotal)."</b></td></tr>";
					echo "<tr><td colspan=7><h3>Section: ".$csd['sectionname']."</h3></td></tr>";
					$sectotal=0;
				}
				$sectotal +=$amt;
				$cl=$ct %2==0? "odd" : "even";
				echo "<tr class='$cl'>
					<td>".$csd['checkno']."</td>
					<td>".$csd['employee']."</td>
					<td>".$csd['designationname']."</td>
					<td>".$csd['scalename']."</td>
					<td>".$csd['qty']."</td>
					<td style='text-align:right'>".number_format($csd['amount'])."</td>
					<td style='text-align:right'>".number_format($amt)."</td>
				</tr>";
				$tot +=$amt;$ct++;
			}
		}
		if($sectotal > 0) echo "<tr><td colspan=5><b>Section Total</b></td><td style='text-align:right'></td><td style='text-align:right'><b>".number_format($sectotal)."</b></td></tr>";

		echo "<tr><td colspan=5><b>Department Total</b></td><td style='text-align:right'></td><td style='text-align:right'><b>".number_format($deptotal)."</b></td></tr>";

	}
	echo "<tr><td colspan=5><b>Grand Total</b></td><td style='text-align:right'></td><td style='text-align:right'><b>".number_format($tot)."</b></td></tr>";

	if($_REQUEST['print']!=1)  echo "<tr><td colspan=5><a href='".$_SERVER['REQUEST_URI']."&print=1'>View in Report Format</a></td><td style='text-align:right'><b>&nbsp;</b></td></tr>";
	echo "</tbody></table></div>";
}

function report_400001() {
	$annual=array('400008','410004','400010','400004');
	if(is_dept_head() && !corporate_report())
		$ad=" and department=(select department from sections where id='".user()->dept[id]."')";
	if(!is_dept_head() && !corporate_report())
		$ad=" and section='".user()->dept[id]."'";
//	echo "select * from v_employees where accountid='".$_REQUEST['c']."'  and budget='".user()->budget['id']."' $ad order by section, employee asc, amount desc";
	$cs=Yii::app()->db->createCommand("select * from v_employees where accountid='".$_REQUEST['c']."'  and budget='".user()->budget['id']."' $ad order by section, employee asc, amount desc")->queryAll();
//	echo "select * from v_employees where accountid='".$_REQUEST['c']."'  and budget='".user()->budget['id']."' $ad order by section, employee asc, amount desc";
	echo "<h2> Details for ".$cs['0']['accountid']."-".$cs['0']['accountitem']."</h2>";
	echo '<div id="employees-grid" class="grid-view">';
	echo "<table class='items' style='border: 1px solid;max-width:100%'>";
	$thead= "<thead><tr>
			<th>#</th>
			<th>#</th>
			<th>CheckNo</th>
			<th>Names</th>
			<th>Designation</th>
			<th>Scale</th>
			<th>Spine</th>
			".(!in_array($_REQUEST['c'],$annual) ? "<th>Monthly</th>" : "")."
			<th>Annual</th></tr>
	</thead>";
	$tot=$ttot=0;	$ct=1;
	$qdep=app()->db->createCommand("select * from dept where id in (select distinct department from v_employees where 1 $ad) order by dept asc")->queryAll();
	foreach($qdep as $dep) {
		$ct2=1;
		echo "<tr><td colspan=7><h2>Department: ".$dep['dept']."</h2></td></tr>";
		echo $thead;
		$s="";
		$deptotal=$sectotal=$tdeptotal=$tsectotal=0;
		foreach($cs as $csd) {
			if($csd['department']==$dep[id]) {
				$deptotal +=$csd['amount'];
				$tdeptotal +=$csd['tamount'];
				if($csd['sectionname'] != $s) {
					$s=$csd['sectionname'];
					if($sectotal > 0) echo "<tr><td colspan=6><b>Section Total</b></td>
						".(!in_array($_REQUEST['c'],$annual) ? "<td style='text-align:right'><b>".number_format($sectotal)."</b></td>" : "")."
						<td style='text-align:right'><b>".number_format($tsectotal)."</b></td></tr>";
					echo "<tr><td colspan=7><h3>Section: ".$csd['sectionname']."</h3></td></tr>";
					$sectotal=$tsectotal=0;
				}
				$sectotal +=$csd['amount'];
				$tsectotal +=$csd['tamount'];
				$cl=$ct %2==0? "odd" : "even";
				echo "<tr class='$cl'>
					<td>".$ct."</td>
					<td>".$ct2."</td>
					<td>".$csd['checkno']."</td>
					<td>".$csd['employee']."</td>
					<td>".$csd['designationname']."</td>
					<td>".$csd['scalename']."</td>
					<td>".$csd['spinename']."</td>
					".(!in_array($_REQUEST['c'],$annual) ? "<td style='text-align:right'>".number_format($csd['amount'])."</td>": "")."
					<td style='text-align:right'>".number_format($csd['tamount'])."</td>
				</tr>";
				$tot +=$csd['amount'];
				$ttot +=$csd['tamount'];
				$ct++;$ct2++;
			}
		}
		if($sectotal > 0) echo "<tr><td colspan=6><b>Section Total</b></td>
			".(!in_array($_REQUEST['c'],$annual) ? "<td style='text-align:right'><b>".number_format($sectotal)."</b></td>" : "")."
			<td style='text-align:right'><b>".number_format($tsectotal)."</b></td></tr>";

		echo "<tr><td colspan=6><b>Department Total</b></td>
			".(!in_array($_REQUEST['c'],$annual) ? "<td style='text-align:right'><b>".number_format($deptotal)."</b></td>" : "")."
		<td style='text-align:right'><b>".number_format($tdeptotal)."</b></td></tr>";

	}
	echo "<tr><td colspan=6><b>Grand Total</b></td>
		".(!in_array($_REQUEST['c'],$annual) ? "<td style='text-align:right'><b>".number_format($tot)."</b></td>" : "")."
	<td style='text-align:right'><b>".number_format($ttot)."</b></td></tr>";

	if($_REQUEST['print']!=1)  echo "<tr><td colspan=6><a href='".$_SERVER['REQUEST_URI']."&print=1'>View in Report Format</a></td><td style='text-align:right'><b>&nbsp;</b></td></tr>";
	echo "</tbody></table></div>";
}
function standby_calc() {
	$emp=Employees::model()->findAll(' budget='.budget());
	foreach($emp as $em) {
		$emp_bt=app()->db->createCommand("SELECT price a from v_budget where tbl='employees' and tblid='".$em->id."' and budget='".budget()."' and tblcolumn='salary'")->queryAll();
		// /echo $emp_bt[0][a]."<br>";
		$n=$em->id." - ".$em->checkno." - ".$em->employee." - ".$em->designation;
		$af=Items::model()->findByAttributes(array('accountcode'=>78,'name'=>$n));
		if($af==null) {
			$af=new Items;
			$af->attributes=array('accountcode'=>78,'name'=>$n);
			$af->save();
		}
		$ap=ItemsPrices::model()->findByAttributes(array('item'=>$af->id,'budget'=>budget()));
		if($ap==null)
			$ap=new ItemsPrices;
		$ap->attributes=array('currency'=>'1','item'=>$af->id,'budget'=>budget(),'price'=>$emp_bt[0][a]*0.15,'insertdate'=>date('Y-m-d'),'insertby'=>user()->id);
		$ap->save();
		$bt=Budget::model()->findByAttributes(array('budget'=>budget(),'item'=>$af->id));
		if($em->standby==1) {
			if($bt==null) $bt=new Budget;
			$bt->attributes=array('budget'=>budget(),'item'=>$af->id,'dept'=>$em->section,'qty'=>1,'tbl'=>'employees','tblcolumn'=>'standby','tblid'=>$em->id,'createdby'=>user()->id,'createdon'=>date("Y-m-d"),'dateneeded'=>date("Y-m-d"),'period'=>12);
			$bt->save();
		} else
			if($bt !=null) $bt->delete();
	}
}
function shift_calc() {
	$emp=Employees::model()->findAll(' budget='.budget());
	foreach($emp as $em) {
		$emp_bt=app()->db->createCommand("SELECT price a from v_budget where tbl='employees' and tblid='".$em->id."' and budget='".budget()."' and tblcolumn='salary'")->queryAll();
		// /echo $emp_bt[0][a]."<br>";
		$n=$em->id." - ".$em->checkno." - ".$em->employee." - ".$em->designation;
		$af=Items::model()->findByAttributes(array('accountcode'=>90,'name'=>$n));
		if($af==null) {
			$af=new Items;
			$af->attributes=array('accountcode'=>90,'name'=>$n);
			$af->save();
		}
		$ap=ItemsPrices::model()->findByAttributes(array('item'=>$af->id,'budget'=>budget()));
		if($ap==null)
			$ap=new ItemsPrices;
		$ap->attributes=array('currency'=>'1','item'=>$af->id,'budget'=>budget(),'price'=>$emp_bt[0][a]*0.20,'insertdate'=>date('Y-m-d'),'insertby'=>user()->id);
		$ap->save();
		$bt=Budget::model()->findByAttributes(array('budget'=>budget(),'item'=>$af->id));
		if($em->shift==1) {
			if($bt==null) $bt=new Budget;
			$bt->attributes=array('budget'=>budget(),'item'=>$af->id,'dept'=>$em->section,'qty'=>1,'tbl'=>'employees','tblcolumn'=>'shift','tblid'=>$em->id,'createdby'=>user()->id,'createdon'=>date("Y-m-d"),'dateneeded'=>date("Y-m-d"),'period'=>12);
			$bt->save();
		} else
			if($bt !=null) $bt->delete();
	}
}

function leave_calc() {
	$emp=Employees::model()->findAll(' budget='.budget());
	foreach($emp as $em) {
		$emp_bt=app()->db->createCommand("SELECT price a from v_budget where tbl='employees' and tblid='".$em->id."' and budget='".budget()."' and tblcolumn='salary'")->queryAll();
	//echo $emp_bt[0][a]." ".$em->employee."<br>";
		$n=$em->id." - ".$em->checkno." - ".$em->employee." - ".$em->designation;
		$af=Items::model()->findByAttributes(array('accountcode'=>81,'name'=>$n));
		if($af==null) {
			$af=new Items;
			$af->attributes=array('accountcode'=>81,'name'=>$n);
			$af->save();
		}
		$ap=ItemsPrices::model()->findByAttributes(array('item'=>$af->id,'budget'=>budget()));
		if($ap==null)
			$ap=new ItemsPrices;
		$ap->attributes=array('currency'=>'1','item'=>$af->id,'price'=>intval($emp_bt[0][a]));
		//dump($ap->attributes,false);
		if(!$ap->save()) dump($ap->errors);
		$bt=Budget::model()->findByAttributes(array('budget'=>budget(),'item'=>$af->id));
		if($em->contract==1) {
			if($bt==null) $bt=new Budget;
			$bt->attributes=array('budget'=>budget(),'item'=>$af->id,'dept'=>$em->section,'qty'=>1,'tbl'=>'employees','tblcolumn'=>'leave','tblid'=>$em->id,'createdby'=>user()->id,'createdon'=>date("Y-m-d"),'dateneeded'=>date("Y-m-d"),'period'=>1);
			$bt->save();
		} else
			if($bt !=null) $bt->delete();
	}
}

function gratuity_calc() {
	$emp=Employees::model()->findAll(' budget='.budget());
	foreach($emp as $em) {
		$emp_bt=app()->db->createCommand("SELECT sum(amount) a from v_budget where tbl='employees' and tblid='".$em->id."' and budget='".budget()."' and tblcolumn='salary'")->queryAll();
		//echo "SELECT sum(amount) a from v_budget where tbl='employees' and tblid='".$em->id."' and budget='".budget()."' and tblcolumn='salary'";
//		exit;
		//echo $emp_bt[0][a]."<br>";
		$n=$em->id." - ".$em->checkno." - ".$em->employee." - ".$em->designation;
		$af=Items::model()->findByAttributes(array('accountcode'=>79,'name'=>$n));
		if($af==null) {
			$af=new Items;
			$af->attributes=array('accountcode'=>79,'name'=>$n);
			$af->save();
		}
		$ap=ItemsPrices::model()->findByAttributes(array('item'=>$af->id,'budget'=>budget()));
		if($ap==null)
			$ap=new ItemsPrices;
		$ap->attributes=array('currency'=>'1','item'=>$af->id,'budget'=>budget(),'price'=>$emp_bt[0][a]*0.3,'insertdate'=>date('Y-m-d'),'insertby'=>user()->id);
		$ap->save();
		$bt=Budget::model()->findByAttributes(array('budget'=>budget(),'item'=>$af->id));
		if($em->contract==1) {
			if($bt==null) $bt=new Budget;
			$bt->attributes=array('budget'=>budget(),'item'=>$af->id,'dept'=>$em->section,'qty'=>1,'tbl'=>'employees','tblcolumn'=>'gratuity','tblid'=>$em->id,'createdby'=>user()->id,'createdon'=>date("Y-m-d"),'dateneeded'=>date("Y-m-d"),'period'=>1);
			$bt->save();
		} else
			if($bt !=null) $bt->delete();
	}
}

function nssf_calc() {
	$nssf = array(
		'salary',
		'leave',
		'gratuity',
		'medical',
		'standby',
		'shift',
		'soap',
		'risk',
		'cc',
		'phone',
		'acting_allowance',
		'overtime_weekdayhrs',
		'weekend_lunch',
		'responsibility_allowance',
		'leave_in_lieu',
		'weekend_transport'
	);
	$emp=Employees::model()->findAll(' budget='.budget());
	foreach($emp as $em) {
		$n=$em->id." - ".$em->checkno." - ".$em->employee." - ".$em->designation;
		$emp_bt=app()->db->createCommand("SELECT sum(amount) a from v_budget where tbl='employees' and tblid='".$em->id."' and budget='".budget()."' and tblcolumn in ('".implode("','",$nssf)."')")->queryAll();
	//	echo "SELECT sum(amount) a from v_budget where tbl='employees' and tblid='".$em->id."' and budget='".budget()."' and tblcolumn in ('".implode("','",$nssf)."')";
//		dump($em);
//		dump($emp_bt[0])."<br>";
	//echo "employee: ".$em->employee.": Got ".$emp_bt[0][a]."<br>";
		$af=Items::model()->findByAttributes(array('accountcode'=>75,'name'=>$n));
		if($af==null) {
			$af=new Items;
			$af->attributes=array('accountcode'=>75,'name'=>$n);
			$af->save();
		}
		$ap=ItemsPrices::model()->findByAttributes(array('item'=>$af->id,'budget'=>budget()));
		if($ap==null)
			$ap=new ItemsPrices;
		$ap->attributes=array('currency'=>'1','item'=>$af->id,'budget'=>budget(),'price'=>$emp_bt[0][a]*0.1,'insertdate'=>date('Y-m-d'),'insertby'=>user()->id);
		$ap->save();
		$bt=Budget::model()->findByAttributes(array('budget'=>budget(),'item'=>$af->id));
		if($bt==null) $bt=new Budget;
		$bt->attributes=array('budget'=>budget(),'item'=>$af->id,'dept'=>$em->section,'qty'=>1,'tbl'=>'employees','tblcolumn'=>'nssf','tblid'=>$em->id,'createdby'=>user()->id,'createdon'=>date("Y-m-d"),'dateneeded'=>date("Y-m-d"),'period'=>1);
		$bt->save();
	}
}
function rgeneral() {
	$ht="";
	$cs=Yii::app()->db->createCommand("select * from accountcodes where report=1 and accountcode='".$_REQUEST['c']."'")->queryAll();
	$ht.= "<h3> Details for ".$cs['0']['accountcode']."-".$cs['0']['item']."</h3>";
	$ht.= "<div class='grid-view'><table class='items' style='border: 1px solid;max-width:100%'>";

	if(is_dept_head() && !corporate_report())
		$ad=" and realdept=(select department from sections where id='".user()->dept[id]."')";
	if(!is_dept_head() && !corporate_report())
		$ad=" and dept='".user()->dept[id]."'";
	$codes=Yii::app()->db->createCommand("select * from v_budget where accountcode = '".$cs['0']['id']."' and budget='".user()->budget['id']."' $ad order by realdept,dept")->queryAll();
	$tot=0;	$ct=0;
	foreach($codes as $csd) {
		$seced=0;
		$cl=$ct %2==0? "odd" : "even";
		if($csd[realdept] != $dep) {
			$dep=$csd[realdept];
			if($st >0 && $dep)
				$ht.= "<tr><td colspan=4 style='font-weight:bold;font-size:12px'>Section Total</td><td style='text-align:right;font-weight:bold;font-size:13px'>".number_format($st)."</td></tr>";	$seced=1;
			if($dt >0)
				$ht.= "<tr><td colspan=4 style='font-weight:bold;font-size:12px'>Department Total</td><td style='text-align:right;font-weight:bold;font-size:14px'>".number_format($dt)."</td></tr>";
			$ht.="<tr><th colspan=5>".$csd[realdptname]."</th></tr>";
			$ht.="<tr><th>Item</th><th>Quantity</th><th>Unit Price</th><th>Period</th><th>Total</th></tr>";
			$dt=0;
		}
		if($csd[dept] !=$sec) {
			$sec=$csd[dept];
			if($st >0 && $seced==0)
				$ht.= "<tr><td colspan=4 style='font-weight:bold;font-size:12px'>Section Total</td><td style='text-align:right;font-weight:bold;font-size:13px'>".number_format($st)."</td></tr>";
			$ht.= "<tr><td colspan=5 style='font-weight:bold;font-size:15px'>".$csd[section]."</td></tr>";
			$st=0;
		}
		if($csd[amount] > 0) $ht.= "<tr  class='$cl'><td>".$csd['name']."</td><td style='text-align:right'>".number_format($csd['qty'])."</td><td style='text-align:right'>".number_format($csd[price])."</td><td>".($csd[period]==12 ? "Monthly" : "Annually")."</td><td style='text-align:right'>".number_format($csd[amount])."</td></tr>";
		$tot +=$csd[amount];$ct++;
		$dt+=$csd[amount];
		$st+=$csd[amount];
	}
	$ht.= "<tr><td colspan=4 style='font-weight:bold;font-size:12px'>Section Total</td><td style='text-align:right;font-weight:bold;font-size:13px'>".number_format($st)."</td></tr>";
	$ht.= "<tr><td colspan=4 style='font-weight:bold;font-size:12px'>Department Total</td><td style='text-align:right;font-weight:bold;font-size:14px'>".number_format($dt)."</td></tr>";

	$ht.= "<tr><td><b>Total</b></td><td colspan=3><b>".number_format($tot)."</b></td></tr>";
	$ht.= "</table></div>";

	if($_REQUEST['print'] !=1) $ht.= "<a href='?r=site/exportDetails&c=".$_REQUEST['c']."'>Export to Excel</a>| <a href='".$_SERVER['REQUEST_URI']."&print=1'>View in Report Format</a>";
	echo $ht;
}

function report_440006() {

	$mysecs=Yii::app()->db->createCommand("SELECT distinct section,itemname from v_subsistence where budget='".user()->budget['id']."' and  accountcode='".$_REQUEST['c']."' order by sectionname asc")->queryAll();
echo "<h2> Details for ".$mysecs[0][itemname]."</h2>";
	foreach($mysecs as $mysec) {
		$cs=Yii::app()->db->createCommand("select * from v_subsistence where budget='".user()->budget['id']."' and section='".$mysec[section]."' and accountcode='".$_REQUEST['c']."'")->queryAll();
		echo "<h3>".$cs[0][dept].": ".$cs[0][sectionname]."</h3>";

		echo "<div class='grid-view'><table class='items' style='border: 1px solid;max-width:100%'>";
				echo "<thead><tr><th style='width:100px'>Activity No.</th><th style='width:200px'>Line Cost Item</th><th style='width:200px'>Site</th><th>Start Date</th><th>Duration</th><th>Total Cost</th></tr></thead>";
		$tot=0;	$ct=0;
		foreach($cs as $csd) {
			$cl=$ct %2==0? "odd" : "even";
			$itembudget=$csd['amount']*$csd['qty'];
			$date1=  strtotime($csd['startdate']);
			$date2= 	strtotime($csd['enddate']);
			$days=($date2-$date1)/86400;

			$ht_sub= "<tr  class='$cl'><td width=10%><a href='#' onClick='return ddi(".$csd['activity'].");'> ".$csd['activity']."</a></td><td width=20%>".$csd['itemname']."</td><td width=20%>".$csd['sitename']."</td><td>".$csd['startdate']."</td><td>".$days." days</td><td style='text-align:right'>";
			$dhsub= "<tr  class='$cl'><td colspan=6>";

			$dhsub.=  "<div style='text-align:right;display:none;' id='d".$csd['activity']."'><table style='margin-left:20px;border:0px solid red;width:96%'>";
			$dhsub.=  "<tr><td style='border:0px solid blue;' colspan='4'><b>Operational Materials</b></td></tr>";
			$dhsub.=  "<tr><td><b>Item</b></td><td></td><td><b>Quantity</b></td><td><b>Unit Price</b></td><td><b>Total</b></td></tr>";
			$det=Yii::app()->db->createCommand("select * from v_subsistence_details where activity='".$csd['id']."'")->queryAll();
			$mtot=$subt=0;
			foreach($det as $e) {
				$tot=$e['quantity']*$e['price'];
				$mtot +=$tot;
				$cl2=$ct2 %2==0? "odd2" : "even2";$ct2++;
				$dhsub.=  "<tr class=$cl2><td>".$e['detailname']."</td><td></td><td>".$e['quantity']."</td><td>".number_format($e['price'])."</td><td style='text-align:right'>".number_format($tot)."</td></tr>";
			}
			$dhsub.= "<tr><td colspan=2><b>Total</b></td><td>&nbsp;</td><td>&nbsp;</td><td style='text-align:right'><strong>".number_format($mtot)."</strong></td></tr>";
			$dhsub.= "<tr><td colspan='4'><b>Subsistence</b></td></tr>";
			$dhsub.= "<tr><td><b>Staff</b></td><td><b>Salary Scale</b></td><td><b>Rate</b></td><td><b>Days</b></td><td><b>Total</b></td></tr>";
			$det=Yii::app()->db->createCommand("select * from v_subsistence_staff where activity='".$csd['id']."'")->queryAll();
			$tot=0;
			foreach($det as $e) {
				$tot +=$e['tamount'];
				$cl2=$ct2 %2==0? "odd2" : "even2";$ct2++;
				$dhsub.= "<tr class=$cl2>
					<td>".$e['employeename']."</td>
					<td>".$e['salaryscale']."</td>
					<td>".number_format($e['amount'])."</td>
					<td>".number_format($e['days'])."</td>
					<td style='text-align:right'>".number_format($e['tamount'])."</td>
					</tr>";
				}
				$dhsub.= "<tr class=$cl2>
					<td colspan=4><strong>Total</strong></td><td style='text-align:right'><strong>".number_format($tot)."</strong></td></tr>";
				$mtot+=$tot;
				$ca=app()->db->createCommand("SELECT * from v_budget where tbl='subsistence' and tblcolumn='casuals' and tblid='".$csd['id']."' ")->queryAll();
				$dhsub.= "<tr class=$cl2>
						<td>".$ca[0][qty]." Casuals</td><td>Casuals</td><td>".$ca[0][price]." </td><td>".$ca[0][period]." <td style='text-align:right'><strong>".number_format($ca[0][amount])."</strong></td></tr>";
				$mtot+=$ca[0][amount];
			$dhsub.= "</table></div</td></tr>";
			$ht_sub.=number_format($mtot)."</td></tr>";
			echo $ht_sub.$dhsub;
			$tot +=$itembudget;$ct++;
		}
		echo "</table></div>";
}

	if($_REQUEST['print'] !=1) echo "<a href='?r=site/exportDetails&c=".$_REQUEST['c']."'>Export to Excel</a>| <a href='".$_SERVER['REQUEST_URI']."&print=1'>View in Report Format</a>";
}
?>
