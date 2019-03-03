<?php
/* @var $this BcBudgetrequestsController */
/* @var $model BcBudgetrequests */

$this->breadcrumbs=array(
	'Bc Budgetrequests'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List BcBudgetrequests', 'url'=>array('index')),
	array('label'=>'Create BcBudgetrequests', 'url'=>array('create')),
);


?>

<h1>Manage Bc Budgetrequests</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'bc-budgetrequests-grid',
	'dataProvider'=>$model->q(),
	//'filter'=>$model,
	'columns'=>array(
		'subject',
		'justification',
		'requestdate',
		'requestornames',
		array(
			'class'=>'CButtonColumn',
			'template'=>'{view}',
			'buttons'=>array
			    (
			        'view' => array
			        (
			            //'label'=>'Approve/Reject',
			            'url'=>'Yii::app()->createUrl("bcBudgetrequests/ap1view", array("id"=>$data[requestid]))',
			        ),
				 )
		),
		
		//'requestid',
		/*
		'requestdate',
		'requireddate',
		'requestor',
		'budget',
		array(
			'class'=>'CButtonColumn',
		),*/
	),
)); ?>
