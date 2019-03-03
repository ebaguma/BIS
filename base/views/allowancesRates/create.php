<?php
/* @var $this AllowancesRatesController */
/* @var $model AllowancesRates */

$this->breadcrumbs=array(
	'Allowances Rates'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'List AllowancesRates', 'url'=>array('index')),
	array('label'=>'Manage AllowancesRates', 'url'=>array('admin')),
);
?>

<h1>Create AllowancesRates</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>