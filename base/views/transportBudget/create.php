<?php
/* @var $this TransportBudgetController */
/* @var $model TransportBudget */

$this->breadcrumbs=array(
	'Transport Budgets'=>array('index'),
	'Create',
);

$this->menu=array(
//	array('label'=>'List TransportBudget', 'url'=>array('index')),
//	array('label'=>'Manage TransportBudget', 'url'=>array('admin')),
);
?>

<h1>Create TransportBudget</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>