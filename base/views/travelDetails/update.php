<?php
/* @var $this TravelDetailsController */
/* @var $model TravelDetails */

$this->breadcrumbs=array(
	'Travel Details'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List TravelDetails', 'url'=>array('index')),
	array('label'=>'Create TravelDetails', 'url'=>array('create')),
	array('label'=>'View TravelDetails', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage TravelDetails', 'url'=>array('admin')),
);
?>

<h1>Update TravelDetails <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>