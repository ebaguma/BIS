<?php
/* @var $this BcBudgetapprovalsController */
/* @var $model BcBudgetapprovals */

$this->breadcrumbs=array(
	'Bc Budgetapprovals'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List BcBudgetapprovals', 'url'=>array('index')),
	array('label'=>'Create BcBudgetapprovals', 'url'=>array('create')),
	array('label'=>'View BcBudgetapprovals', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage BcBudgetapprovals', 'url'=>array('admin')),
);
?>

<h1>Update BcBudgetapprovals <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>