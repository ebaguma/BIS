<?php
/* @var $this TelephonesController */
/* @var $model Telephones */

$this->breadcrumbs=array(
	'Telephones'=>array('admin'),
	$model->id,
);

$this->menu=array(
//	array('label'=>'List Telephones', 'url'=>array('index')),
//	array('label'=>'Create Telephones', 'url'=>array('create')),
	array('label'=>'Update Telephones', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Telephones', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Telephones', 'url'=>array('admin')),
);
?>

<h1>View Telephones #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
//		'id',
		'number',
		'purpose',
		'owner0.employee',
	),
)); ?>
