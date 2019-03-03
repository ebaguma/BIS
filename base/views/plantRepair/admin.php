<?php
/* @var $this PlantRepairController */
/* @var $model PlantRepair */

$this->breadcrumbs=array(
	'Plant Repairs'=>array('admin'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List PlantRepair', 'url'=>array('index')),
	array('label'=>'Create PlantRepair', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#plant-repair-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Plant Repairs</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'plant-repair-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'item',
		'section',
		'subsection',
		'site',
		'activity',
		/*
		'labour_source',
		'repair_items',
		'startdate',
		'enddate',
		'casuals',
		'petrol',
		'diesel',
		'description',
		'budget',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
