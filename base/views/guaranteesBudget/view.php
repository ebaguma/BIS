<?php
/* @var $this GuaranteesBudgetController */
/* @var $model GuaranteesBudget */

$this->breadcrumbs=array(
	'Guarantees Budgets'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List GuaranteesBudget', 'url'=>array('index')),
	//array('label'=>'Create GuaranteesBudget', 'url'=>array('create')),
	array('label'=>'Update GuaranteesBudget', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete GuaranteesBudget', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage GuaranteesBudget', 'url'=>array('admin')),
);
?>

<h1>View GuaranteesBudget #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
	//	'id',
		'guarantee0.name',
		'guarantee0.amount',
		'arrangement',
		'establishment',
		'quarterly',
		'annualrenewal',
		'budget0.name',
	),
)); ?>
