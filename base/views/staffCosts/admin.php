<?php
/* @var $this StaffCostsController */
/* @var $model StaffCosts */

$this->breadcrumbs=array(
	'Staff Costs'=>array('admin'),
	'Manage',
);
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
if(!$h)
	die("Unknown costs code");
$this->menu=array(
//	array('label'=>'List StaffCosts', 'url'=>array('index')),
//	array('label'=>'Create StaffCosts', 'url'=>array('create')),
);
?>

<h1>Manage <?php echo $h;?></h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'staff-costs-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'accountcode0.item',
		'dept0.dept',
		'item',
		'period',
		'quantity',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
