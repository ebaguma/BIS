<?php
/* @var $this EmolumentratesController */
/* @var $model Emolumentrates */

$this->breadcrumbs=array(
	'Emolumentrates'=>array('admin'),
	'Manage',
);

$this->menu=array(
	//array('label'=>'List Emolumentrates', 'url'=>array('index')),
	array('label'=>'Create Emolumentrates', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#emolumentrates-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Emolumentrates</h1>


<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'emolumentrates-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		//'id',
		'employee0.employee',
		'travel_in_ug_op',
		'travel_in_ug_cap',
		'weekend_lunch',
		'weekend_transport',		
		'out_of_station',
		'acting_allowance',/*
		'mobile_phone_allowance',
		'risk_allowance',
		'responsibility_allowance',
		'driving_allowance',
		'mileage',
		'soap',
		'shift',
		'milk',
		'leave_in_lieu',
		'overtime_weekdayhrs',
		'overtime_weekdaydays',
		'overtime_weekend_hrs',
		'overtime_weekend_days',
		'shift_hours',
		'shift_days',
		'leave_start',
		'leave_end',
		*/
		array(
			'class'=>'CButtonColumn',
			'template'=>'{update}{view}{delete}',
			'buttons'=>array(
			'update' => 
				array(
				'url' =>'Yii::app()->createUrl("emolumentrates/updateemp", array("emp"=>$data->employee))',

				)
			)
		),
	),
)); ?>
