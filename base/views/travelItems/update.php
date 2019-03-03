<?php
/* @var $this TravelItemsController */
/* @var $model TravelItems */

$this->breadcrumbs=array(
	'Travel Items'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TravelItems', 'url'=>array('index')),
	array('label'=>'Create TravelItems', 'url'=>array('create')),
	array('label'=>'View TravelItems', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage TravelItems', 'url'=>array('admin')),
);
?>

<h1>Update TravelItems <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>