<?php
/* @var $this SectionsController */
/* @var $model Sections */

$this->breadcrumbs=array(
	'Sections'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Create Sections', 'url'=>array('create')),
	array('label'=>'Update Sections', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Sections', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Sections', 'url'=>array('admin')),
);
?>

<h1>View Section: <?php echo $model->section; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		//'id',
		'section',
		'shortname',
		'department0.dept',
	),
)); ?>
