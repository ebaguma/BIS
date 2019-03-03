<?php
/* @var $this AccountcodesController */
/* @var $model Accountcodes */

$this->breadcrumbs=array(
	'Accountcodes'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Accountcodes', 'url'=>array('index')),
	array('label'=>'Create Accountcodes', 'url'=>array('create')),
	array('label'=>'View Accountcodes', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Accountcodes', 'url'=>array('admin')),
);
?>

<h1>Update Accountcodes <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>