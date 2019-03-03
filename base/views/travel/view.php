<?php
/* @var $this TravelController */
/* @var $model Travel */

$this->breadcrumbs=array(
	'Travels'=>array('admin','m'=>$_REQUEST['m']),
	$model->course,
);

$this->menu=array(
	array('label'=>'Back to Travel', 'url'=>array('admin&m='.$_REQUEST['m'])),
//	array('label'=>'Create Ano', 'url'=>array('create')),
	array('label'=>'Update This', 'url'=>array('update', 'id'=>$model->id,'m'=>$_REQUEST['m'])),
	array('label'=>'Delete', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
//	array('label'=>'Manage Travel', 'url'=>array('admin')),
);
?>

<h1>View Travel: <?php echo $model->mission; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
//		'id',
		'employee0.employee',
		array('label'=>'Mission','name'=>'course'),
		'purpose',
		'centre',
	//	'mission',
//		array('label'=>'Budget')'budget0.name',
	),
)); ?>
<br>
<h3>Travel Details</h3>
<div class="grid-view">
<table class="items" style='width:750px'><tr><th>#</th><th>Detail</th><th>Amount</th><th>Currency</th><th>Amount (UGX)</th></tr><tbody id="additional-inputs">
<?php
$td=VTravel::model()->findAll('training='.$model->id);
$tot=0;
$ct=0;
foreach ($td as $det) {
	$ct++;
	$class=$ct%2==1 ? "even" : "odd";
	$lt=$det['amount']*$det[exchangerate];
	$tot+=$lt;
	echo "<tr class=$class><td>".$ct."</td><td>".$det['item']."</td><td style='text-align:right'>".number_format($det['amount'])."</td><td>".$det['currency']."<td style='text-align:right'>".number_format($lt)."</td></tr>"; 
}
echo "<tr  class=$class><td>&nbsp;</td><td colspan=3><strong>Total</strong></td><td style='text-align:right'><strong>".number_format($tot)."</strong></td></tr>"; 
?>	
	
	
</tbody></table>
</div>
