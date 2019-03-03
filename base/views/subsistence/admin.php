<?php
/* @var $this SubsistenceController */
/* @var $model Subsistence */

$this->breadcrumbs=array(
	'Subsistences'=>array('admin'),
	'Manage',
);
/*
$this->menu=array(
	array('label'=>'List Subsistence', 'url'=>array('index')),
	array('label'=>'Create Subsistence', 'url'=>array('create')),
);
*/

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#subsistence-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Subsistences</h1>

<?php // echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'subsistence-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
//		'id',
'activity',
		'item0.item',
		'section0.section',
//		'subsection',
		'site0.site',
		/*
		'petrol',
		'diesel',
		'casuals',
		'startdate',
		'enddate',
		'description',
		'budget',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
