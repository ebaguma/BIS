<?php
/* @var $this AccountcodesController */
/* @var $model Accountcodes */

$this->breadcrumbs=array(
	'Accountcodes'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Accountcodes', 'url'=>array('index')),
	array('label'=>'Create Accountcodes', 'url'=>array('create')),
	array('label'=>'Update Accountcodes', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Accountcodes', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Accountcodes', 'url'=>array('admin')),
);
?>

<h1>View Accountcodes #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'accountcode',
		'item',
	),
)); ?>
