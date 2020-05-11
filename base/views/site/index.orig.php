<style>
.chart-label {
	line-height:30px;
}

</style>
	
<?php $this->pageTitle=Yii::app()->name; ?>

<h1>Welcome to <i><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>
<style>
.db table tr.odd {
	background-color:#dfffee;
}
.db table tr.even {
	background-color:#bbffee;
}
.db table td {
	vertical-align:top;
	text-align:center;
	width:500px;
}
.db table td table td {
	vertical-align:top;
	text-align:left;
}

.db table tr.even {
	background-color:#bbffee;
}

</style>
<div class='db'>
<?php	
if(user()->isGuest) {
	echo "<script>document.href.location='index.php?r=site/login';</script>";
	exit;
}

if(is_dept_head() && !corporate_report()) {
	$ad.="  realdept=(select department from sections where id='".user()->dept[id]."')";
	$ad2.="  deptid=(select department from sections where id='".user()->dept[id]."')";
}
if(!is_dept_head() && !corporate_report()) { 
	$ad.="  dept='".user()->dept[id]."'";
	$ad2.="  section='".user()->dept[id]."'";
}
if(strlen($ad) > 1 ) $ad.=" and ";
if(strlen($ad2) > 1 ) $ad2.=" and ";


$btotal=0;
$tbudget= Yii::app()->db->createCommand('select sum(amount) a from v_budget where '.$ad.' budget='.user()->budget[id]."  and accountid not regexp '^3'")->queryAll();
foreach($tbudget as $cds) {
	$btotal+=$cds[a];
}
if($btotal > 0) {
	//echo 'select sum(amount) a from v_bc_itembudgets  where '.$ad2.' budget='.user()->budget[id]."  and status='COMMITED' and reason in (3,6) and accountcode not regexp '^3'";
	//echo 'select sum(amount) a from v_bc_itembudgets  where '.$ad2.' budget='.user()->budget[id]."  and (reason in (2,4,5) or (reason in (3,6) and status='PENDING')) and accountcode not regexp '^3'";
	$sp=Yii::app()->db->createCommand('select sum(amount) a from v_bc_itembudgets  where '.$ad2.' budget='.user()->budget[id]."  and  reason in (3,6) and status='COMMITED' and accountcode not regexp '^3'")->queryAll();
	$bspent=(float)$sp[0][a]*-1;
	//$sp2=Yii::app()->db->createCommand('select sum(amount) a from v_bc_itembudgets  where '.$ad2.' budget='.user()->budget[id]."  and reason in (1,2,4,5) and status='COMMITED' and accountcode not regexp '^3'")->queryAll();
	$bavail=$btotal-$bspent;//(float)$sp2[0][a];
	?>
<TABLE style='widthi:1000px'><tr>
	<td style='width:500px;border:0px solid'><fieldset class='myfi' style='border:1px solid #9fc9FF;'><legend class='myle'> Budget Overview</legend>

	<?php
	$list= array();
	$list[0]=array('gender'=>'Spent Budget ('.round($bspent/$btotal*100).'%)',		'c'=>$bspent);
	$list[1]=array('gender'=>'Available Budget ('.round($bavail/$btotal*100).'%)',	'c'=>$bavail);
	
	$v=array();
	$colors = array(0=>'rgba(20,120,220,1)',1=>'rgba(20,220,120,1)',2=>'rgba(40,80,120,100)',3=>'rgba(20,120,120,100)');
	$v[0]=array('value'=>$bspent,'color'=>'rgba(20,120,220,1)','label'=>'Spent Budget ('.round($bspent/$btotal*100).'%)');
	$v[1]=array('value'=>$bavail,'color'=>'rgba(20,220,120,1)','label'=>'Available Budget ('.round($bavail/$btotal*100).'%)');
	
	?>

<table>
	<tr><td>Spent Budget:</td><td style='padding-right:20%;text-align:right'><?php echo number_format($bspent)?>/=</td></td>
	<tr><td>Available Budget:</td><td style='padding-right:20%;text-align:right'><?php echo  number_format($bavail)?>/=</td></td>
	<tr><td>Total Budget:</td><td style='padding-right:20%;text-align:right'><?php echo number_format($btotal)?>/=</td></td>
<tr><td colspan=2 align=center>


	<?php 
		$this->widget(
			'chartjs.widgets.ChPie', 
			array(
				'width' => 200,
				'height' => 200,
				'htmlOptions' => array(),
				'drawLabels' => true,
				'datasets' => $v,
				'options' => array()
			)
		); 
	?>		
</td>
</table>

<?php

$colors = array(
		"rgba(1,200, 250,10)",
		"rgba(0,178,0,1)",
		"rgba(20,100,220,1)",
		"rgba(10,70,150,255)",
		"rgba(25,120,120,1)",
		"rgba(1,1,150,255)",
		"rgba(10,80,10,255)",
		"rgba(146,79,255,10)",
		"rgba(90,150,220,200)"		
		);	

$cgrps= Yii::app()->db->createCommand("select * from accountcodes where accountcode regexp '^4[0-9]$' or accountcode like '10' ")->queryAll();	
$t=0;
$vs=array();
$n=array();
foreach ($cgrps as $cgrp) {
	$amt=0;
	$codes	= Yii::app()->db->createCommand("select amount a from v_budget where $ad  accountcode in (SELECT id from accountcodes where accountcode like '".$cgrp['accountcode']."%') and budget =".user()->budget[id])->queryAll();
	foreach($codes as $cds) {
		if($cds[qty])
			$amt+=$cds[qty]*$cds[a];
		else
			$amt+=$cds[a];
	}
		$vs[] 	= $amt; 
		$n[]	= $cgrp['accountcode']." - ".$cgrp['item']." (".round($amt*100/$btotal)."%)";
}
$dsets=array();
for($i=0;$i<count($vs);$i++) {
	$vv = $vs[$i] ? $vs[$i] : 0;
	$cc = $colors[$i] ? $colors[$i] : "rgba(20,150,150,10)";
	$nn = $n[$i] ? $n[$i] : "default";
	$dsets[] = array(
        "value" => $vv*100/$btotal,
        "color" => $cc,
        "label" => $n[$i]
	);
}
?>
</fieldset>
</td><td style='width:600px'><fieldset class='myfi' style='border:1px solid #9fc9FF;'><legend class='myle'> O&M Budget</legend>
	<?php 
	        $this->widget(
	            'chartjs.widgets.ChDoughnut', 
	            array(
	                'width' => 300,
	                'height' => 200,
	                'htmlOptions' => array(),
	                'drawLabels' => true,
	                'datasets' =>  $dsets,/*array(
	                   array(
	                    ),
	                    array(
	                        "value" => 250,
	                        "color" => "rgba(1,250,166,1)",
	                        "label" => "Other Staff Costs (17%)"
	                    ),
	                    array(
	                        "value" => 40,
	                        "color" => "rgba(20,100,220,1)",
	                        "label" => "Transport (28%)"
	                    ),
	                    array(
	                        "value" => 15,
	                        "color" => "rgba(20,120,120,1)",
	                        "label" => "Repairs (10%)"
	                    ),
	                    array(
	                        "value" => 15,
	                        "color" => "rgba(10,70,150,255)",
	                        "label" => "Admin Expenses (10%)"
	                    )

	                ),*/
	                'options' => array()
	            )
	        ); 
	    ?>
</fieldset></td></tr>
<tr><td style="vertical-align: text-top;"><fieldset class='myfi' style='border:1px solid #9fc9FF;'><legend class='myle'> Useful Links</legend>
<br>
	<ul style='text-align:left;padding-left:30px;font-size:14px'>
		<li><a href='#'>UETCL Budgeting Process</a></li>
		<li><a href='#'>New Budgeting Guidelines as per PPDA Regulations</a></li>
		<li><a href='#'> Past Budgets (Reference only)</a></li>		
	</ul>
</fieldset></td><td><fieldset class='myfi' style='border:1px solid #9fc9FF;'><legend class='myle'>Budget Check</legend>
<br>
	<ul style='text-align:left;padding-left:30px;font-size:14px'>
		
		<?php if(is_budget_officer()) { ?>
			<li><a href='?r=bcBudgetrequests/create'>New Budget Check Request</a></li>
			<li><a href='?r=bcBudgetrequests/admin'>My Budget Check Requests</a></li>
		<?php } ?>
		<?php if (is_sat() || is_pbfo() || is_sys_admin()) {
			echo  "<li><a href='?r=bcBudgetrequests/rejected'>Rejected Budget Requests</a></li>
				<li><a href='?r=bcBudgetrequests/capture'>Direct Budget Capture</a></li>
				<li><a href='?r=bcReallocation/capture'>Direct Re-Allocation Capture</a></li>
				<li><a href='?r=bcItembudgets/create'>Add New Budget Item</a></li>"; 
		}	?>
		
		<li><a href='?r=bcBudgetapprovals/admin'>Budget Check Approvals</a></li>
		<li><a href='?r=bcReallocation/create'>Re-Allocation Form</a></li>
	</ul>
	
	
</fieldset></td></tr>
</table>
<?php } ?>
</div>
