<?php
/* @var $this ClothingController */
/* @var $model Clothing */

$this->breadcrumbs=array(
	'Clothings'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Clothing', 'url'=>array('index')),
	array('label'=>'Create Clothing', 'url'=>array('create')),
	array('label'=>'Update Clothing', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Clothing', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Clothing', 'url'=>array('admin')),
);
?>

<h1>View Clothing #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'item',
		'size',
		'quantity',
		'employee',
		'budget',
	),
)); ?>
