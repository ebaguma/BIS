<?php
/* @var $this ClothingItemsController */
/* @var $model ClothingItems */

$this->breadcrumbs=array(
	'Clothing Items'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ClothingItems', 'url'=>array('index')),
	array('label'=>'Create ClothingItems', 'url'=>array('create')),
	array('label'=>'Update ClothingItems', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ClothingItems', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ClothingItems', 'url'=>array('admin')),
);
?>

<h1>View ClothingItems #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'item',
	),
)); ?>
