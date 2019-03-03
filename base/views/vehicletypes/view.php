<?php
/* @var $this VehicletypesController */
/* @var $model Vehicletypes */

$this->breadcrumbs=array(
	'Vehicletypes'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Update Category', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Category', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this vehicle category?')),
	array('label'=>'Manage Categories', 'url'=>array('admin')),
);
?>

<h1>View Vehicletypes #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'vehicletype',
		'serviceinterval',
		'descr',
	),
)); ?>
