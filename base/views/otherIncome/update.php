<?php
/* @var $this OtherIncomeController */
/* @var $model OtherIncome */

$this->breadcrumbs=array(
	'Other Incomes'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List OtherIncome', 'url'=>array('index')),
	array('label'=>'Create OtherIncome', 'url'=>array('create')),
	array('label'=>'View OtherIncome', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage OtherIncome', 'url'=>array('admin')),
);
?>

<h1>Update OtherIncome <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>