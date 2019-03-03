<?php
/* @var $this SubsistenceController */
/* @var $model Subsistence */

$this->breadcrumbs=array(
	'Subsistences'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	//array('label'=>'List Subsistence', 'url'=>array('index')),
	array('label'=>'Create Subsistence', 'url'=>array('create')),
	array('label'=>'View this activity', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Subsistence', 'url'=>array('admin')),
);
?>

<h1>Update Subsistence <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>