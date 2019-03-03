<?php
/* @var $this BudgetCapsController */
/* @var $model BudgetCaps */

$this->breadcrumbs=array(
	'Budget Caps'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List BudgetCaps', 'url'=>array('index')),
	array('label'=>'Create BudgetCaps', 'url'=>array('create')),
	array('label'=>'View BudgetCaps', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage BudgetCaps', 'url'=>array('admin')),
);
?>

<h1>Update BudgetCaps <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>