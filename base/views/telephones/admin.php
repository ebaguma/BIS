<?php
/* @var $this TelephonesController */
/* @var $model Telephones */

$this->breadcrumbs=array(
	'Telephones'=>array('admin'),
	'Manage',
);

$this->menu=array(
//	array('label'=>'List Telephones', 'url'=>array('index')),
//	array('label'=>'Create Telephones', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#telephones-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Telephones</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'telephones-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		//'id',
		'number',
		'purpose',
		'owner0.employee',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
