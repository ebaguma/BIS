<?php
/* @var $this AllowancesRatesController */
/* @var $model AllowancesRates */

$this->breadcrumbs=array(
	'Allowances Rates'=>array('admin'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List AllowancesRates', 'url'=>array('index')),
	array('label'=>'Create AllowancesRates', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#allowances-rates-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Allowances Rates</h1>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'allowances-rates-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'allowance0.name',
		'scale0.name',
		'rate',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
