<?php
/* @var $this BudgetsController */
/* @var $model Budgets */

$this->breadcrumbs=array(
	'Budgets'=>array('admin'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Budgets', 'url'=>array('index')),
	array('label'=>'Create Budgets', 'url'=>array('create')),
	array('label'=>'View Budgets', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Budgets', 'url'=>array('admin')),
);
?>

<h1>Update Budgets <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>