<?php
/* @var $this BcReallocationController */
/* @var $model BcReallocation */

$this->breadcrumbs=array(
	'Bc Reallocations'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'My Re-Allocation Requests', 'url'=>array('admin')),
);
?>
<h1>Budget  Re-Allocation</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>