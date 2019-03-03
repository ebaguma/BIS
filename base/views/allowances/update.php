<?php
/* @var $this AllowancesController */
/* @var $model Allowances */

$this->breadcrumbs=array(
	'Allowances'=>array('admin'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Allowances', 'url'=>array('index')),
	array('label'=>'Create Allowances', 'url'=>array('create')),
	array('label'=>'View Allowances', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Allowances', 'url'=>array('admin')),
);
?>

<h1>Update Allowances <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>