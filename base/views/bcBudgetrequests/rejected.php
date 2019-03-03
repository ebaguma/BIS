<?php
$this->menu=array(array('label'=>'New Budget Request', 'url'=>array('create')));
?>

<h1>Rejected Budget Requests</h1>
<div class="search-form" style="display:none">
<?php // $this->renderPartial('_search',array('model'=>$model)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'bc-budgetrequests-grid',
	'dataProvider'=>$model->rejected(),
	'filter'=>$model,
	'columns'=>array(
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
