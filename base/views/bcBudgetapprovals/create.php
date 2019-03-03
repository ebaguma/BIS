<?php
/* @var $this BcBudgetapprovalsController */
/* @var $model BcBudgetapprovals */

$this->breadcrumbs=array(
	'Bc Budgetapprovals'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List BcBudgetapprovals', 'url'=>array('index')),
	array('label'=>'Manage BcBudgetapprovals', 'url'=>array('admin')),
);
?>

<h1>Create BcBudgetapprovals</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>