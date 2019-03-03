<?php
/* @var $this AllowancesController */
/* @var $model Allowances */

$this->breadcrumbs=array(
	'Allowances'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Allowances', 'url'=>array('index')),
	array('label'=>'Manage Allowances', 'url'=>array('admin')),
);
?>

<h1>Create Allowances</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>