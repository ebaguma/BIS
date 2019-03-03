<?php
/* @var $this GuaranteesBudgetController */
/* @var $model GuaranteesBudget */

$this->breadcrumbs=array(
	'Guarantees Budgets'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List GuaranteesBudget (%)', 'url'=>array('admin')),
//	array('label'=>'Create GuaranteesBudget', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#guarantees-budget-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Guarantees Budgets</h1>


<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'guarantees-budget-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
//		'id',
		'guarantee0.name',
		array(
			'type'=>'raw',
			'value'=>'number_format($data->guarantee0->amount)',
			'header'=>'Amount',			
		),
		array(
			'type'=>'raw',
			'value'=>'number_format($data->arrangement*$data->guarantee0->amount)',
			'header'=>'Arrangment Fees',			
		),
		array(
			'type'=>'raw',
			'value'=>'number_format($data->establishment*$data->guarantee0->amount)',
			'header'=>'Establishment ',			
		),
		array(
			'type'=>'raw',
			'value'=>'number_format(4*$data->quarterly*$data->guarantee0->amount)',
			'header'=>'Quarterly',			
		),
		array(
			'type'=>'raw',
			'value'=>'number_format($data->annualrenewal*$data->guarantee0->amount)',
			'header'=>'Annual renewal',			
		),
		array(
			'type'=>'raw',
			'value'=>'number_format(($data->arrangement+$data->establishment+4*$data->quarterly+$data->annualrenewal)*$data->guarantee0->amount)',
			'header'=>'Total',			
		),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
