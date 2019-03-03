<?php
/* @var $this ReallocationController */
/* @var $model Reallocation */

$this->breadcrumbs=array(
	'Reallocations'=>array('admin'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Reallocation', 'url'=>array('index')),
	array('label'=>'Create Reallocation', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#reallocation-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Reallocations</h1>

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
	'id'=>'reallocation-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'acfrom',
		'acto',
		'requestor',
		'approval1',
		'approval1_by',
		/*
		'approval2',
		'approval2_by',
		'approval3',
		'approval3_by',
		'approval4',
		'approval4_by',
		'disbursed',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
