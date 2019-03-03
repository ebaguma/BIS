<?php
/* @var $this TransportBudgetController */
/* @var $model TransportBudget */

$this->breadcrumbs=array(
	'Transport Budgets'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TransportBudget', 'url'=>array('index')),
	array('label'=>'Create TransportBudget', 'url'=>array('create')),
	array('label'=>'View TransportBudget', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage TransportBudget', 'url'=>array('admin')),
);
?>

<h1>Update TransportBudget <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>