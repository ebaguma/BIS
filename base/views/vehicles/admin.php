<?php
/* @var $this VehiclesController */
/* @var $model Vehicles */

$this->breadcrumbs=array(
	'Vehicles'=>array('admin'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Vehicles', 'url'=>array('index')),
	array('label'=>'Create Vehicles', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#vehicles-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Vehicles</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'vehicles-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
	//	'id',
		'regno',
		'glcode',
		array(
			'name'=>'vehicletype',
			'value'=>'$data->vehicletype0->vehicletype'
		),
		'fueltype',
		
		//'description',		
	//	'dept0.dept',
		array(
			'name'=>'section',
			'value'=>'$data->section0->section',
		),
		//'hired',
		/*
		'subsection',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); $this->widget('ext.ScrollTop');  ?>
