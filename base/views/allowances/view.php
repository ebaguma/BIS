<?php
/* @var $this AllowancesController */
/* @var $model Allowances */

$this->breadcrumbs=array(
	'Allowances'=>array('admin'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Allowances', 'url'=>array('index')),
	array('label'=>'Create Allowances', 'url'=>array('create')),
	array('label'=>'Update Allowances', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Allowances', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Allowances', 'url'=>array('admin')),
);
?>

<h1>View Allowances #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'allowancetype',
		'units',
	),
)); ?>
