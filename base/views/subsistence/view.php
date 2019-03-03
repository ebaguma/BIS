<?php
/* @var $this SubsistenceController */
/* @var $model Subsistence */

$this->breadcrumbs=array(
	'Subsistences'=>array(''),
	$model->id,
);

$this->menu=array(
//	array('label'=>'List Subsistence', 'url'=>array('index')),
//	array('label'=>'Create Subsistence', 'url'=>array('create')),
	array('label'=>'Update Subsistence', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Subsistence', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'List Subsistence', 'url'=>array('admin')),
);
?>

<h1>View Subsistence </h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
//		'id',
		'activity',
		//'item0.item',
		//'section0.section',
		//'subsection',
		'site0.site',
	//	'petrol',
	//	'diesel',
		'casuals',
		'startdate',
		'enddate',
		'description',
//		'budget',
	),
)); ?>
<br>
<h3>Employees on this Activity</h3>
<div class="grid-view">
<table class="items" style='width:750px'><tr><th>#</th><th>Staff </th><th>Salary Scale</th><th>Rate</th><th>Days</th><th>Total</th></tr><tbody id="additional-inputs">
<?php
$td=app()->db->CreateCommand('select * from v_subsistence_staff where activity='.$model->id)->queryAll();
$tot=0;
$ct=0;
$alr=array();
foreach ($td as $det) {
	
	if(!in_array($det['employeename'],$alr)) {
		$ct++;
		$class=$ct%2==1 ? "even" : "odd";
		
		$tot+=$det[tamount];
		echo "<tr class=$class><td>".$ct."</td><td>".$det['employeename']."</td><td style='text-align:right'>".$det['salaryscale']."</td><td>".number_format($det[amount])."</td><td>".number_format($det[days])."</td><td style='text-align:right'>".number_format($det['tamount'])."</td></tr>"; 
	}
	$alr[]=$det['employeename'];
}
echo "<tr class=$class><td>".$ct."</td><td>Total</td><td style='text-align:right'></td><td style='text-align:right;font-weight:bold' colspan=3>".number_format($tot)."</td></tr>"; 
?>	
		
</tbody></table>
<br>
<h3>Items for this Activity</h3>

<table class="items" style='width:750px'><tr><th>#</th><th>Item </th><th>Quantity</th><th>Unit Price</th><th>Total Price</th></tr><tbody id="additional-inputs">
<?php
$td=app()->db->CreateCommand('select * from v_subsistence_details where activity='.$model->id)->queryAll();
$tot=0;
$ct=0;
foreach ($td as $det) {
	$ct++;
	$tprice=$det['price']*$det['quantity'];
	$tot+=$tprice;
	$class=$ct%2==1 ? "even" : "odd";
	echo "<tr class=$class><td>".$ct."</td><td>".$det['detailname']."</td><td style='text-align:right'>".number_format($det['quantity'])."</td><td style='text-align:right'>".number_format($det['price'])."</td><td style='text-align:right'>".number_format($tprice)."</td></tr>"; 
}
echo "<tr class=$class><td>&nbsp;</td><td colspan=3><b>Total</b></td><td style='text-align:right'><b>".number_format($tot)."</b></td></tr>"; 
?>	
		
</tbody></table>
</div>
