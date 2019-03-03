<?php
/* @var $this AllowancesRatesController */
/* @var $model AllowancesRates */

$this->breadcrumbs=array(
	'Allowances Rates'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List AllowancesRates', 'url'=>array('index')),
	array('label'=>'Create AllowancesRates', 'url'=>array('create')),
	array('label'=>'View AllowancesRates', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage AllowancesRates', 'url'=>array('admin')),
);
?>

<h1>Update AllowancesRates <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>