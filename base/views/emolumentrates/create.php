<?php
$this->breadcrumbs=array(
	'Emolumentrates'=>array(''),
	'Create',
);

$this->menu=array(
	array('label'=>'View Staff', 'url'=>array('admin')),
	//array('label'=>'Manage Emolumentrates', 'url'=>array('admin')),
);
?>
<h1>Budget for Staff Emoluments</h1>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>