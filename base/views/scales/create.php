<?php
/* @var $this ScalesController */
/* @var $model Scales */

$this->breadcrumbs=array(
	'Scales'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Scales', 'url'=>array('index')),
	array('label'=>'Manage Scales', 'url'=>array('admin')),
);
?>

<h1>Create Scales</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>