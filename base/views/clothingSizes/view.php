<?php
/* @var $this ClothingSizesController */
/* @var $model ClothingSizes */

$this->breadcrumbs=array(
	'Clothing Sizes'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ClothingSizes', 'url'=>array('index')),
	array('label'=>'Create ClothingSizes', 'url'=>array('create')),
	array('label'=>'Update ClothingSizes', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ClothingSizes', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ClothingSizes', 'url'=>array('admin')),
);
?>

<h1>View ClothingSizes #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'size',
	),
)); ?>
