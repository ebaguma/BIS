<?php
/* @var $this CostcentresController */
/* @var $model Costcentres */

$this->breadcrumbs=array(
	'Costcentres'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Costcentres', 'url'=>array('index')),
	array('label'=>'Manage Costcentres', 'url'=>array('admin')),
);
?>

<h1>Create Costcentres</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>