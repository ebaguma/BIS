<?php
/* @var $this BudgetitemsController */
/* @var $model Budgetitems */

$this->breadcrumbs=array(
	'Budgetitems'=>array('admin'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Budgetitems', 'url'=>array('index')),
	array('label'=>'Create Budgetitems', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#budgetitems-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Budgetitems</h1>

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
	'id'=>'budgetitems-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
	//	'id',
		array(
			'name' =>'item',			
			'value' =>'$data->item0->name'
			),

		'quantity',
		array(
			'name' =>'costcentre',
			
			'value' =>'$data->costcentre0->name'
			),
		array(
			'name' =>'dept',
			
			'value' =>'$data->dept0->dept'
			),
		array(
			'name' =>'budget',
			
			'value' =>'$data->budget0->name'
			),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
