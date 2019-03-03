<?php
/* @var $this ReallocationController */
/* @var $model Reallocation */

$this->breadcrumbs=array(
	'Reallocations'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'My Reallocation Requests', 'url'=>array('index')),
//	array('label'=>'Manage Reallocation', 'url'=>array('admin')),
);
?>

<br/><br/>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>