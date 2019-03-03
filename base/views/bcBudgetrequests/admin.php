<?php

$this->breadcrumbs=array('Bc Budgetrequests'=>array('index'),'Manage');

$this->menu=array(array('label'=>'New Budget Request', 'url'=>array('create')));

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#bc-budgetrequests-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>My Budget Requests</h1>


<?php // echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php // $this->renderPartial('_search',array('model'=>$model)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'bc-budgetrequests-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
	//	'id',
	array(
		'name'=>'subject',
		'type'=>'raw',
		'value'=>'CHtml::link($data->subject,array("bcBudgetrequests/view","id"=>$data->id))'
	 ), 
	array(
	    'name'=>'requestdate',			
	    'value'=>'Yii::app()->dateFormatter->format("d MMM y",strtotime($data->requestdate))'
	),
	array(
		'header'=>'Status',
		'value'=>array($this,'gridDataColumn'), 
	),	
	array(
		'class'=>'CButtonColumn',
		'template'=>'{view}'
	),
	),
)); ?>
