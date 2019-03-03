<?php
/* @var $this GuaranteesBudgetController */
/* @var $model GuaranteesBudget */

$this->breadcrumbs=array(
	'Guarantees Budgets'=>array('index'),
	'Create',
);
/*
$this->menu=array(
	array('label'=>'List GuaranteesBudget', 'url'=>array('index')),
	array('label'=>'Manage GuaranteesBudget', 'url'=>array('admin')),
);
*/
?>

<h1>Create Bank Guarantees Budget</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>