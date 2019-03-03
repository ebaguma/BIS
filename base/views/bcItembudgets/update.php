<?php
/* @var $this BcItembudgetsController */
/* @var $model BcItembudgets */

$this->breadcrumbs=array(
	'Bc Itembudgets'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List BcItembudgets', 'url'=>array('index')),
	array('label'=>'Create BcItembudgets', 'url'=>array('create')),
	array('label'=>'View BcItembudgets', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage BcItembudgets', 'url'=>array('admin')),
);
?>

<h1>Update BcItembudgets <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>