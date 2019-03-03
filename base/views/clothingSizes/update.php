<?php
/* @var $this ClothingSizesController */
/* @var $model ClothingSizes */

$this->breadcrumbs=array(
	'Clothing Sizes'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ClothingSizes', 'url'=>array('index')),
	array('label'=>'Create ClothingSizes', 'url'=>array('create')),
	array('label'=>'View ClothingSizes', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ClothingSizes', 'url'=>array('admin')),
);
?>

<h1>Update ClothingSizes <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>