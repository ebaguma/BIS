<?php
/* @var $this StaffCostsController */
/* @var $model StaffCosts */

$this->breadcrumbs=array(
	'Staff Costs'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List StaffCosts', 'url'=>array('index')),
	array('label'=>'Create StaffCosts', 'url'=>array('create')),
	array('label'=>'View StaffCosts', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage StaffCosts', 'url'=>array('admin')),
);
?>

<h1>Update StaffCosts <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>