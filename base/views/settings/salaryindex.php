<?php
/* @var $this SettingsController */
/* @var $model Settings */

$this->breadcrumbs=array(
	'Settings'=>array('salaryindex'),
	'Salary Index',
);

$this->menu=array(
	array('label'=>'List Settings', 'url'=>array('salaryindex')),
	array('label'=>'Manage Settings', 'url'=>array('admin')),
);
?>

<h1>Update Salary Index</h1>

<?php $this->renderPartial('_form_salary', array('model'=>$model)); ?>