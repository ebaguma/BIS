<?php
/* @var $this BcCommentsController */
/* @var $model BcComments */

$this->breadcrumbs=array(
	'Bc Comments'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List BcComments', 'url'=>array('index')),
	array('label'=>'Manage BcComments', 'url'=>array('admin')),
);
?>

<h1>Create BcComments</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>