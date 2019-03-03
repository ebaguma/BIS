<?php
/* @var $this BcBudgetrequestsController */
/* @var $model BcBudgetrequests */

$this->breadcrumbs=array(
	'Bc Budgetrequests'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List BcBudgetrequests', 'url'=>array('index')),
	array('label'=>'Create BcBudgetrequests', 'url'=>array('create')),
	array('label'=>'View BcBudgetrequests', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage BcBudgetrequests', 'url'=>array('admin')),
);
?>

<h1>Update BcBudgetrequests <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>