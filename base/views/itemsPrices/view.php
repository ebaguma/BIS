<?php
/* @var $this ItemsPricesController */
/* @var $model ItemsPrices */

$this->breadcrumbs=array(
	'Items Prices'=>array('admin'),
	$model->id,
);

$this->menu=array(
//	array('label'=>'List ItemsPrices', 'url'=>array('index')),
	array('label'=>'Create ItemsPrices', 'url'=>array('create')),
	array('label'=>'Update ItemsPrices', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ItemsPrices', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ItemsPrices', 'url'=>array('admin')),
);
?>

<h1>View Item Price: <?php echo $model->item0->name; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
//		'id',
		'item0.name',
		'budget0.name',
		'price',
	),
)); ?>
