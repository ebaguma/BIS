<?php
/* @var $this OtherIncomeController */
/* @var $model OtherIncome */

$this->breadcrumbs=array(
	'Other Incomes'=>array('index'),
	'Create',
);
/*
$this->menu=array(
	array('label'=>'List OtherIncome', 'url'=>array('index')),
	array('label'=>'Manage OtherIncome', 'url'=>array('admin')),
);
*/
?>

<h1>Create Other Income</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>