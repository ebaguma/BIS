<?php
/* @var $this SectionsController */
/* @var $model Sections */

$this->breadcrumbs=array(
	'Sections'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'Create Sections', 'url'=>array('create')),
	array('label'=>'View Sections', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Sections', 'url'=>array('admin')),
);
?>

<h1>Update Sections <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>