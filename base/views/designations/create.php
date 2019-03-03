<?php
$this->breadcrumbs=array(
	'Designations'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Manage Designations', 'url'=>array('admin')),
);
?>

<h1>Create Designations</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>