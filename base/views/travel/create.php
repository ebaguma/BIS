<?php
/* @var $this TravelController */
/* @var $model Travel */

$this->breadcrumbs=array(
	'Travels'=>array('admin'),
	'Create',
);
$this->menu=array(
	array('label'=>'View my '.$_REQUEST[m].' Budget', 'url'=>array('admin&m='.$_REQUEST['m'])),
	//array('label'=>'Create Travel', 'url'=>array('create')),
	//array('label'=>'View Travel', 'url'=>array('view', 'id'=>$model->id)),
	//array('label'=>'Manage Travel', 'url'=>array('admin')),
);
?>

<h1>Staff Travel Details</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>