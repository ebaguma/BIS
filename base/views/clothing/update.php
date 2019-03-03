<?php
/* @var $this ClothingController */
/* @var $model Clothing */

$this->breadcrumbs=array(
	'Clothings'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Clothing', 'url'=>array('index')),
	array('label'=>'Create Clothing', 'url'=>array('create')),
	array('label'=>'View Clothing', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Clothing', 'url'=>array('admin')),
);
?>

<h1>Update Clothing <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>