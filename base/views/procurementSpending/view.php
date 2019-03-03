<?php
/* @var $this ProcurementSpendingController */
/* @var $model ProcurementSpending */

$this->breadcrumbs=array(
	'Procurement Spendings'=>array('admin'),
	$model->id,
);

$this->menu=array(
	//array('label'=>'List ProcurementSpending', 'url'=>array('index')),
	//array('label'=>'Create ProcurementSpending', 'url'=>array('create')),
	array('label'=>'Update', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this entry?')),
	array('label'=>'My Procurement Requests', 'url'=>array('admin')),
);
?>

<h1>View ProcurementSpending #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'subject',
		'location',
		'reference',
		'date_required',
		'accountcode',
		'budget',
	),
)); ?>
