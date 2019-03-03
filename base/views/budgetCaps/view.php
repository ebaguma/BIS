<?php
/* @var $this BudgetCapsController */
/* @var $model BudgetCaps */

$this->breadcrumbs=array(
	'Budget Caps'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List BudgetCaps', 'url'=>array('index')),
	array('label'=>'Create BudgetCaps', 'url'=>array('create')),
	array('label'=>'Update BudgetCaps', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete BudgetCaps', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage BudgetCaps', 'url'=>array('admin')),
);
?>

<h1>View BudgetCaps #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'dept',
		'cap',
		'year',
		'updatedby',
		'updatedate',
	),
)); ?>
