<?php
/* @var $this BudgetitemsController */
/* @var $model Budgetitems */

$this->breadcrumbs=array(
	'Budgetitems'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Budgetitems', 'url'=>array('index')),
	array('label'=>'Create Budgetitems', 'url'=>array('create')),
	array('label'=>'View Budgetitems', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Budgetitems', 'url'=>array('admin')),
);
?>

<h1>Update Budgetitems <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>