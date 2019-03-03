<?php
/* @var $this BudgetsController */
/* @var $model Budgets */

$this->breadcrumbs=array(
	'Budgets'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Budgets', 'url'=>array('index')),
	array('label'=>'Manage Budgets', 'url'=>array('admin')),
);
?>

<h1>Create Budgets</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>