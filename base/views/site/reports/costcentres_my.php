<?php
$bname="Corporate ";
if(is_dept_head() && !corporate_report()) {
	$ad=" where id=(select department from sections where id='".user()->dept[id]."')";
	$bname="Department";
}
if(!is_dept_head() && !corporate_report())  {
	$ad=" where id=(select department from sections where id='".user()->dept[id]."')";
	$ad2=" and dept='".user()->dept[id]."'";
	$bname="Section";
}
$ht = "<h1>Multi-Year ".$bname." Budget:</h1>";
$ht .= "<div id='foo'  class='grid-view'><table style='border: 1px solid;max-width:1400px' class=items>";
$depts=app()->db->CreateCommand("SELECT * from dept $ad order by ordering asc")->queryAll();
$yrs=array(3=>2016,4=>2017,5=>2018,6=>2019,7=>2020,8=>2021);
$ht.="<tr><th>Cost Centre</th>";
foreach($yrs as $yr=>$yrn) {
	$ht.="<th style='width:100px'>".$yrn."</th>";
}
$ht.="<th>Total</th></tr>";

	$ct=0;
	$ccentres = Yii::app()->db->createCommand("select * from accountcodes where accountcode regexp '^4.$' or accountcode ='10'")->queryAll();
	$mydep=array();
	foreach ($ccentres as $cc) {
		$cl= $ctr%2==0 ? 'even' : 'odd'; $ctr++;
		$ht .="<tr class=$cl><td><a href='index.php?old=1&p=r_my&r=site/reports&pc=".$cc[accountcode]."'>".$cc[accountcode]." - ".$cc[item]."</td>";
		$cstotal=0;
		$dctr=0;
		foreach($yrs as $yr=>$yrn) {

			$dt=0;
			$bdgt	= Yii::app()->db->createCommand("select amount a, qty from v_budget where budget =".$yr." and accountcode in (select id from accountcodes where accountcode like '".$cc[accountcode]."%') ")->queryAll();
			foreach($bdgt as $rw) {
				$qty=1;
				$dt+=$rw['a'];
				$ct+=$dt;
			}
			$ht.= "<td style='text-align:right'>".number_format($dt)."</td>";

			$cstotal+=$dt;
			$mydep[$dctr] +=$dt;$dctr++;
		}
		$ht.= "<td style='text-align:right'>".number_format($cstotal)."</td></tr>";
		$mtotal+=$cstotal;
	}
	$ht.= "<tr class=$r><th><strong>Totals</strong></th>";
	for($myctr=0;$myctr <count($mydep);$myctr++) {
		$ht.="<th>".number_format($mydep[$myctr])."</th>";
	}
	$ht .="<th style='text-align:right'><strong>".number_format($mtotal)."</strong></th></tr>";
	echo $ht;
?>
</tbody></table>
