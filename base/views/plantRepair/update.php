<?php
/* @var $this PlantRepairController */
/* @var $model PlantRepair */

$this->breadcrumbs=array(
	'Plant Repairs'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List PlantRepair', 'url'=>array('index')),
	array('label'=>'Create PlantRepair', 'url'=>array('create')),
	array('label'=>'View PlantRepair', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage PlantRepair', 'url'=>array('admin')),
);
?>

<h1>Update PlantRepair <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>