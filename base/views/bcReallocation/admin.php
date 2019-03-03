<?php
/* @var $this BcReallocationController */
/* @var $model BcReallocation */

$this->breadcrumbs=array(
	'Bc Reallocations'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List BcReallocation', 'url'=>array('index')),
	array('label'=>'Create BcReallocation', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#bc-reallocation-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Bc Reallocations</h1>


<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'bc-reallocation-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
	//	'id',
		[
			'value'=>'$data->fromitem0->name',
			'header'=>'From Item',
			'name'=>'fromitem'
		],
		[
			'value'=>'$data->toitem0->name',
			'header'=>'To Item'
		],	
		[
			'name'=>'amount',
			 'value'=>'Yii::app()->numberFormatter->formatCurrency($data->amount, "")',
		],
		'requestdate',
		
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
