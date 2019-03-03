<?php
/* @var $this BcItembudgetsController */
/* @var $model BcItembudgets */

$this->breadcrumbs=array(
	'Bc Itembudgets'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List BcItembudgets', 'url'=>array('index')),
	array('label'=>'Create BcItembudgets', 'url'=>array('create')),
	array('label'=>'Update BcItembudgets', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete BcItembudgets', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage BcItembudgets', 'url'=>array('admin')),
);
?>

<h1>View BcItembudgets #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'item',
		'section',
		'amount',
		'budget',
		'reason',
		'reasonid',
		'status',
		'dateadded',
		'addedby',
	),
)); ?>
