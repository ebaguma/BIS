<?php
/* @var $this TravelDetailsController */
/* @var $model TravelDetails */

$this->breadcrumbs=array(
	'Travel Details'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List TravelDetails', 'url'=>array('index')),
	array('label'=>'Create TravelDetails', 'url'=>array('create')),
	array('label'=>'Update TravelDetails', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete TravelDetails', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage TravelDetails', 'url'=>array('admin')),
);
?>

<h1>View TravelDetails #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'item',
		'amount',
		'training',
	),
)); ?>
