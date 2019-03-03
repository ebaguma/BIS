<?php
/* @var $this TravelController */
/* @var $model Travel */

$this->breadcrumbs=array(
	'Travels'=>array('admin','m'=>$_REQUEST['m']),
	$model->course=>array('view','id'=>$model->id,'m'=>$_REQUEST['m']),
	'Update',
);

$this->menu=array(
	array('label'=>'View', 'url'=>array('view', 'id'=>$model->id,'m'=>$_REQUEST['m'])),
	array('label'=>'List Travel', 'url'=>array('admin','m'=>$_REQUEST['m'])),
	array('label'=>'Add New ', 'url'=>array('create','m'=>$_REQUEST['m'])),
);
?>

<h1>Update Travel: <?php echo $model->course; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>