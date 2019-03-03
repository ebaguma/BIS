<?php
/* @var $this SubsectionsController */
/* @var $model Subsections */

$this->breadcrumbs=array(
	'Subsections'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Create Subsections', 'url'=>array('create')),
	array('label'=>'Update Subsections', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Subsections', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Subsections', 'url'=>array('admin')),
);
?>

<h1>View Subsection:<?php echo $model->unit; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		//'id',
		'unit',
		//'accountcode',
		'section0.section',
	),
)); ?>
