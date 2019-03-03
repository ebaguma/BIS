<?php
/* @var $this ClothingItemsController */
/* @var $model ClothingItems */

$this->breadcrumbs=array(
	'Clothing Items'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ClothingItems', 'url'=>array('index')),
	array('label'=>'Create ClothingItems', 'url'=>array('create')),
	array('label'=>'View ClothingItems', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ClothingItems', 'url'=>array('admin')),
);
?>

<h1>Update ClothingItems <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>