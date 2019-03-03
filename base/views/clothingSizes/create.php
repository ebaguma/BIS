<?php
/* @var $this ClothingSizesController */
/* @var $model ClothingSizes */

$this->breadcrumbs=array(
	'Clothing Sizes'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ClothingSizes', 'url'=>array('index')),
	array('label'=>'Manage ClothingSizes', 'url'=>array('admin')),
);
?>

<h1>Create ClothingSizes</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>