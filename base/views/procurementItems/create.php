<?php
/* @var $this ProcurementItemsController */
/* @var $model ProcurementItems */

$this->breadcrumbs=array(
	'Procurement Items'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ProcurementItems', 'url'=>array('index')),
	array('label'=>'Manage ProcurementItems', 'url'=>array('admin')),
);
?>

<h1>Create ProcurementItems</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>