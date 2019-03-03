<?php
//$this->breadcrumbs=array('Staff Costs', 'Create');
switch($_REQUEST['ac']) {
	case 41:
		$h="Staff Costs";
		break;	
	case 43:
		$h="Other Vehicle Expenses";
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
?>
<h1><?php echo $h; ?></h1>
<br/>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>