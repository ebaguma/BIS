<?php
/* @var $this EmolumentratesController */
/* @var $model Emolumentrates */

$this->breadcrumbs=array(
	'Emolumentrates'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Emolumentrates', 'url'=>array('admin')),
	//array('label'=>'Create Emolumentrates', 'url'=>array('create')),
	array('label'=>'View Emolumentrates', 'url'=>array('view', 'id'=>$model->id)),
	//array('label'=>'Manage Emolumentrates', 'url'=>array('admin')),
);
?>

<h1>Update Emoluments for <?php echo $model->employee0->employee; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>