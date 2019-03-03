<?php
/* @var $this ProcurementItemsController */
/* @var $model ProcurementItems */

$this->breadcrumbs=array(
	'Procurement Items'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ProcurementItems', 'url'=>array('index')),
	array('label'=>'Create ProcurementItems', 'url'=>array('create')),
	array('label'=>'View ProcurementItems', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ProcurementItems', 'url'=>array('admin')),
);
?>

<h1>Update ProcurementItems <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>