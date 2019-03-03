<?php
/* @var $this CostcentresController */
/* @var $model Costcentres */

$this->breadcrumbs=array(
	'Costcentres'=>array('admin'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Costcentres', 'url'=>array('index')),
	array('label'=>'Create Costcentres', 'url'=>array('create')),
	array('label'=>'View Costcentres', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Costcentres', 'url'=>array('admin')),
);
?>

<h1>Update Costcentres <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>