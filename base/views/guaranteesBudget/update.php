<?php
/* @var $this GuaranteesBudgetController */
/* @var $model GuaranteesBudget */

$this->breadcrumbs=array(
	'Guarantees Budgets'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List GuaranteesBudget', 'url'=>array('index')),
	//array('label'=>'Create GuaranteesBudget', 'url'=>array('create')),
	//array('label'=>'View GuaranteesBudget', 'url'=>array('view', 'id'=>$model->id)),
	//array('label'=>'Manage GuaranteesBudget', 'url'=>array('admin')),
);
?>

<h1>Update GuaranteesBudget <?php echo $model->id; ?></h1>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>