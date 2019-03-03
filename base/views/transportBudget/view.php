<?php
/* @var $this TransportBudgetController */
/* @var $model TransportBudget */

$this->breadcrumbs=array(
	'Transport Budgets'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List TransportBudget', 'url'=>array('index')),
	array('label'=>'Create TransportBudget', 'url'=>array('create')),
	array('label'=>'Update TransportBudget', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete TransportBudget', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TransportBudget', 'url'=>array('admin')),
);
?>

<h1>View TransportBudget #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'accountcode',
		'item',
		'period',
		'quantity',
		'budget',
		'dept',
		'createdon',
		'createdby',
		'updatedon',
		'updatedby',
		'dateneeded',
		'vehicle',
	),
)); ?>
