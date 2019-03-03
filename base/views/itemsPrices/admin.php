<?php
/* @var $this ItemsPricesController */
/* @var $model ItemsPrices */

$this->breadcrumbs=array(
	'Items Prices'=>array('admin'),
	'Manage',
);

$this->menu=array(
//	array('label'=>'List ItemsPrices', 'url'=>array('index')),
	array('label'=>'Create ItemsPrices', 'url'=>array('create')),
	array('label'=>'Items & Prices', 'url'=>array('itemsPrices/admin')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#items-prices-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Items Prices</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'items-prices-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
//		'id',
		array(	
			'name'=>'item',
			'value'=>'$data->item0->name',
		),
		array(
			'name'=>'budget',
			'value'=>'$data->budget0->name',
		),
		'price',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
