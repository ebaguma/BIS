<?php
/* @var $this SubsectionsController */
/* @var $model Subsections */

$this->breadcrumbs=array(
	'Subsections'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Subsections', 'url'=>array('index')),
	array('label'=>'Create Subsections', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#subsections-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Subsections</h1>
<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'subsections-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'unit',
		array(
			'name'=>'section',
			'value'=>'$data->section0->section',
		),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
