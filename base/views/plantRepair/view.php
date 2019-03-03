<?php
/* @var $this PlantRepairController */
/* @var $model PlantRepair */

$this->breadcrumbs=array(
	'Plant Repairs'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List PlantRepair', 'url'=>array('index')),
	array('label'=>'Create PlantRepair', 'url'=>array('create')),
	array('label'=>'Update PlantRepair', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete PlantRepair', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PlantRepair', 'url'=>array('admin')),
);
?>

<h1>View PlantRepair #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'item',
		'section',
		'subsection',
		'site',
		'activity',
		'labour_source',
		'repair_items',
		'startdate',
		'enddate',
		'casuals',
		'petrol',
		'diesel',
		'description',
		'budget',
	),
)); ?>
