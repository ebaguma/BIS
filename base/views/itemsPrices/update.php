<?php
/* @var $this ItemsPricesController */
/* @var $model ItemsPrices */

$this->breadcrumbs=array(
	'Items Prices'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ItemsPrices', 'url'=>array('index')),
	array('label'=>'Create ItemsPrices', 'url'=>array('create')),
	array('label'=>'View ItemsPrices', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ItemsPrices', 'url'=>array('admin')),
);
?>

<h1>Update ItemsPrices <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>