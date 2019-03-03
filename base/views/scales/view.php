<?php
/* @var $this ScalesController */
/* @var $model Scales */

$this->breadcrumbs=array(
	'Scales'=>array('admin'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List Scales', 'url'=>array('index')),
	array('label'=>'Create Scales', 'url'=>array('create')),
	array('label'=>'Update Scales', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Scales', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Scales', 'url'=>array('admin')),
);
?>

<h1>View Scales #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'salary',
	),
)); ?>
