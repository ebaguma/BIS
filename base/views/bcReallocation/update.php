<?php
/* @var $this BcReallocationController */
/* @var $model BcReallocation */

$this->breadcrumbs=array(
	'Bc Reallocations'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List BcReallocation', 'url'=>array('index')),
	array('label'=>'Create BcReallocation', 'url'=>array('create')),
	array('label'=>'View BcReallocation', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage BcReallocation', 'url'=>array('admin')),
);
?>

<h1>Update BcReallocation <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>