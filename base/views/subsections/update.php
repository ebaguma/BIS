<?php
/* @var $this SubsectionsController */
/* @var $model Subsections */

$this->breadcrumbs=array(
	'Subsections'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Subsections', 'url'=>array('index')),
	array('label'=>'Create Subsections', 'url'=>array('create')),
	array('label'=>'View Subsections', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Subsections', 'url'=>array('admin')),
);
?>

<h1>Update Subsections <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>