<?php
/* @var $this ProcurementSpendingController */
/* @var $model ProcurementSpending */

$this->breadcrumbs=array(
	'Procurement Spendings'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ProcurementSpending', 'url'=>array('index')),
	array('label'=>'Create ProcurementSpending', 'url'=>array('create')),
	array('label'=>'View ProcurementSpending', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ProcurementSpending', 'url'=>array('admin')),
);
?>

<h1>Update ProcurementSpending <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>