<?php
/* @var $this ClothingItemsController */
/* @var $model ClothingItems */

$this->breadcrumbs=array(
	'Clothing Items'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ClothingItems', 'url'=>array('index')),
	array('label'=>'Manage ClothingItems', 'url'=>array('admin')),
);
?>

<h1>Create ClothingItems</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>