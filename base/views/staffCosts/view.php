<?php
/* @var $this StaffCostsController */
/* @var $model StaffCosts */
switch($_REQUEST['ac']) {
	case 41:
		$h="Staff Costs";
		break;	
	case 45:
		$h="Admin Expenses";
		break;	
	case 44:
		$h="Repairs & Maintainence";
		break;	
	case 10:
		$h="Capital Expenditure";
		break;	
	case 46:
		$h="Depreciation Expenses";
		break;	
	case 47:
		$h="Finance Charges";
		break;	

}
//if(!$h)	die("Unknown costs code");
$this->breadcrumbs=array(
	'Staff Costs'=>array(''),
	$model->id,
);

$this->menu=array(
	array('label'=>'List '.$h, 'url'=>array('index')),
//	array('label'=>'Create StaffCosts', 'url'=>array('create')),
	array('label'=>'Update this item', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete this item', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
//	array('label'=>'Manage StaffCosts', 'url'=>array('admin')),
);

?>


<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'accountcode0.item',
		'unit',
		'item0.name',
		'period',
		'quantity',
	),
)); ?>
