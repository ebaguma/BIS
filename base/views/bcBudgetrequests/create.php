<?php
/* @var $this BcBudgetrequestsController */
/* @var $model BcBudgetrequests */

$this->breadcrumbs=array(
	'Bc Budgetrequests'=>array('index'),
	'Create',
);

$this->menu=array(
	//array('label'=>'List BcBudgetrequests', 'url'=>array('index')),
	array('label'=>'My Budget Requests', 'url'=>array('admin')),
);
?>

<h1>New Budget Check Request</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>