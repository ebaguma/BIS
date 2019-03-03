<?php
/* @var $this VehicletypesController */
/* @var $model Vehicletypes */

$this->breadcrumbs=array(
	'Vehicletypes'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Categories', 'url'=>array('admin')),
);
?>

<h1>Create Vehicle Category</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>