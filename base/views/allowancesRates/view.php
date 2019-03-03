<?php
/* @var $this AllowancesRatesController */
/* @var $model AllowancesRates */

$this->breadcrumbs=array(
	'Allowances Rates'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List AllowancesRates', 'url'=>array('index')),
	array('label'=>'Create AllowancesRates', 'url'=>array('create')),
	array('label'=>'Update AllowancesRates', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete AllowancesRates', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage AllowancesRates', 'url'=>array('admin')),
);
?>

<h1>View AllowancesRates #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'allowance',
		'scale',
		'rate',
	),
)); ?>
