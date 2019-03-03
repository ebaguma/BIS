<?php
/* @var $this ItemsPricesController */
/* @var $model ItemsPrices */

$this->breadcrumbs=array(
	'Items Prices'=>array('admin'),
	'Create',
);

$this->menu=array(
//	array('label'=>'List ItemsPrices', 'url'=>array('index')),
	array('label'=>'Manage ItemsPrices', 'url'=>array('/items/list')),
);
?>

<h1>Create ItemsPrices</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>