<?php
/* @var $this BudgetitemsController */
/* @var $model Budgetitems */

$this->breadcrumbs=array(
	'Budgetitems'=>array('admin'),
	'Create',
);

$this->menu=array(
	//array('label'=>'List Budgetitems', 'url'=>array('index')),
	array('label'=>'Manage Budgetitems', 'url'=>array('admin')),
);
?>

<h1>Create a Budget Item</h1>

<?php 
if($_REQUEST['cat'] == 2 || $_REQUEST['cat'] == 1  )
	$this->renderPartial('_form2', array('model'=>$model)); 
else
	$this->renderPartial('_form', array('model'=>$model)); 

?>