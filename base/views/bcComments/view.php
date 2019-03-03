<?php
/* @var $this BcCommentsController */
/* @var $model BcComments */

$this->breadcrumbs=array(
	'Bc Comments'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List BcComments', 'url'=>array('index')),
	array('label'=>'Create BcComments', 'url'=>array('create')),
	array('label'=>'Update BcComments', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete BcComments', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage BcComments', 'url'=>array('admin')),
);
?>

<h1>View BcComments #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'request',
		'initiator',
		'owner',
		'comments',
		'requestdate',
	),
)); ?>
