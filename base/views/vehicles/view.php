<?php
/* @var $this VehiclesController */
/* @var $model Vehicles */

$this->breadcrumbs=array(
	'Vehicles'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Vehicles', 'url'=>array('admin')),
	array('label'=>'Create Vehicle', 'url'=>array('create')),
	array('label'=>'Update Vehicle', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Vehicle', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Vehicles', 'url'=>array('admin')),
);
?>

<h1>View Vehicles #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'regno',
		'vehicletype0.vehicletype',
		'fueltype',
		array(
			'label'=>'Battery',
			'value'=>$model->battery0->name
		),
		array(
			'label'=>'Tyres',
			'value'=>$model->tyres0->name
		),
		'description',
		'dept0.dept',
		'section0.section',
		'subsection0.subsection',
	//	'hired',
	),
)); ?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'vehicles-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
	//	'id',
		'regno',
		'vehicletype0.vehicletype',
		'fueltype',
		//'glcode',
		'description',		
		//'dept0.dept',
		'section0.section',
		//'hired',
		/*
		'subsection',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>