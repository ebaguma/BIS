<?php
/* @var $this EmolumentratesController */
/* @var $model Emolumentrates */

$this->breadcrumbs=array(
	'Emolumentrates'=>array('admin'),
	$model->id,
);

$this->menu=array(
	//	array('label'=>'List Emolumentrates', 'url'=>array('index')),
	//	array('label'=>'', 'url'=>array('create')),
	//	array('label'=>'Update Emolumentrates', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Emolumentrates', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Emolumentrates', 'url'=>array('admin')),
);
?>

<h1>View Emolument Rates  for <strong><?php echo $model->employee0->employee ?></strong></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
	//	'id',
		'employee0.employee',
		'travel_in_ug_op',
		'travel_in_ug_cap',
		'weekend_lunch',
		'weekend_transport',
		'out_of_station',
		'acting_allowance',
		'mobile_phone_allowance',
	// /	'risk_allowance',
		'responsibility_allowance',
		'driving_allowance',
		'mileage',
	//	'soap',
	//	'shift',
	//	'milk',
		'leave_in_lieu',
		'overtime_weekdayhrs',
		'overtime_weekdaydays',
		'overtime_weekend_hrs',
		'overtime_weekend_days',
	//	'shift_hours',
	//	'shift_days',
	//	'leave_start',
	//	'leave_end',
	),
)); ?>
