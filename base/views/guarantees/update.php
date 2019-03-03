<?php
/* @var $this GuaranteesController */
/* @var $model Guarantees */

$this->breadcrumbs=array(
	'Guarantees'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Guarantees', 'url'=>array('index')),
	array('label'=>'Create Guarantees', 'url'=>array('create')),
	array('label'=>'View Guarantees', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Guarantees', 'url'=>array('admin')),
);
?>

<h1>Update Guarantees <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>