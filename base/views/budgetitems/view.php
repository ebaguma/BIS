<?php
/* @var $this BudgetitemsController */
/* @var $model Budgetitems */

$this->breadcrumbs=array(
	'Budgetitems'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Budgetitems', 'url'=>array('index')),
	array('label'=>'Create Budgetitems', 'url'=>array('create')),
	array('label'=>'Update Budgetitems', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Budgetitems', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Budgetitems', 'url'=>array('admin')),
);
?>

<h1>View Budgetitems #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'item',
		'quantity',
		'costcentre',
		'dept',
		'budget',
	),
)); ?>
