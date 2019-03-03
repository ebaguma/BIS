<?php
/* @var $this RevenueController */
/* @var $model Revenue */

$this->breadcrumbs=array(
	'Revenues'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Revenue', 'url'=>array('index')),
	array('label'=>'Create Revenue', 'url'=>array('create')),
	array('label'=>'Update Revenue', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Revenue', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Revenue', 'url'=>array('admin')),
);
?>

<h1>View Revenue #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'budget',
		'accountcode',
		'amount',
		'createdby',
		'createdon',
		'updatedby',
		'updatedon',
	),
)); ?>
