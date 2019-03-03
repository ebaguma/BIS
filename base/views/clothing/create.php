<?php
/* @var $this ClothingController */
/* @var $model Clothing */

$this->breadcrumbs=array(
	'Clothings'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Clothing', 'url'=>array('index')),
	array('label'=>'Manage Clothing', 'url'=>array('admin')),
);
?>

<h1>Create Clothing</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>