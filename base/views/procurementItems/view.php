<?php
/* @var $this ProcurementItemsController */
/* @var $model ProcurementItems */

$this->breadcrumbs=array(
	'Procurement Items'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ProcurementItems', 'url'=>array('index')),
	array('label'=>'Create ProcurementItems', 'url'=>array('create')),
	array('label'=>'Update ProcurementItems', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ProcurementItems', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ProcurementItems', 'url'=>array('admin')),
);
?>

<h1>View ProcurementItems #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'spending',
		'item',
		'quantity',
		'description',
		'actual_spent',
		'delivery_date',
	),
)); ?>
