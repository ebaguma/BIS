<?php
/* @var $this VehiclesController */
/* @var $model Vehicles */

$this->breadcrumbs=array(
	'Vehicles'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Vehicles', 'url'=>array('admin')),
	array('label'=>'Manage Vehicles', 'url'=>array('admin')),
);
?>

<h1>Create Vehicles</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>