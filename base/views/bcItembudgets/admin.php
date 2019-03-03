<?php
$this->breadcrumbs=array('Item Budgets'=>array('index'),'Manage');

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#bc-itembudgets-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Budget Checked Items</h1>
<style>
.container {
	display: table;
}

.row  {
	display: table-row;
}

.left, .right, .middle {
	display: table-cell;
}
</style>
<form method='get'>
	<input type='hidden' name='r' value='bcItembudgets/admin'>
<div class="search-form" style="display:block">
<div class='container'>
	<div class='row'>
		<div class='left'><?=CHtml::label('Section: ',false)?></div>
		<div class='middle'>		<?php 
    $rl = app()->db->CreateCommand("select * from v_sections order by dshortname,sshortname")->queryAll();
	 $role_list=array();
	 foreach($rl as $r) $role_list[$r['sectionid']]=$r['dshortname']." - ".$r['sshortname'];
		echo CHtml::dropDownList('section',array($_REQUEST['section']),$role_list,array('onChange'=>"document.getElementById('ProcurementSpending_items').innerHTML='';document.getElementById('accountcode').value=''",'style'=>'width:270px','empty' => ' - Select a Section- ')); ?>
	</div>
	</div>
	<div class='row'>
		<div class='left'><?=CHtml::label('Budget Check Method: ',false)?></div>
		<div class='middle'> <?php 
		echo CHtml::dropDownList('bcmethod',array($_REQUEST['bcmethod']),array(3=>'Work Flow','6'=>'Direct Capture'),array('style'=>'width:270px','empty' => ' - Select Method - ')); ?>
	</div>
	</div>
	<div class='row'>
		<div class='left'><?=CHtml::label('Period: ',false)?></div>
		<div class='middle'>		<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
			'value'=>$_REQUEST['periodfrom'],
			 'name'=>'periodfrom',
		    // additional javascript options for the date picker plugin
		    'options'=>array(
		        'showAnim'=>'clip',
				'dateFormat'=>'yy-mm-dd',
				'yearRange'=>'2014:2015',
		    ),
		    'htmlOptions'=>array(
		        'style'=>'height:20px;width:136px',			
		    ),
		));   ?>

		</div>
		<div class='middle'>		To: <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
			'value'=>$_REQUEST['periodto'],
		    'name'=>'periodto',
		    // additional javascript options for the date picker plugin
		    'options'=>array(
		        'showAnim'=>'clip',
				'dateFormat'=>'yy-mm-dd',
				'yearRange'=>'2014:2015',
		    ),
		    'htmlOptions'=>array(
		        'style'=>'height:20px;width:136px',			
		    ),
		));   ?>

		</div>
</div>
<div class='row'><div class='left'></div><div class='middle'><input type='submit' value='Search' /></div></div>
</div><!-- search-form -->
</form>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'bc-itembudgets-grid',
	'dataProvider'=>$model,
	'columns'=>array(
		//'id',
		//'subject',
	   array(
	                   //   'class'=>'CLinkColumn',
	                     // 'label'=>'subject',
					'type'=>'raw',
					//'value'=>'CHtml::encode($data->name)',
					'value' => 'CHtml::link($this->grid->dataProvider->data[$this->grid->dataProvider->pagination->currentPage *$this->grid->dataProvider->pagination->pageSize + ($row+1)-1][subject],Yii::app()->createUrl("bcBudgetrequests/view",array("id"=>$this->grid->dataProvider->data[$this->grid->dataProvider->pagination->currentPage *$this->grid->dataProvider->pagination->pageSize + ($row+1)-1][requestid])) )',
	                     // 'url'=>'users/view&id=$this->grid->dataProvider->data[$this->grid->dataProvider->pagination->currentPage *$this->grid->dataProvider->pagination->pageSize + ($row+1)-1][amount]',
	                      'header'=>'Subject'
	                      ),
		'itemname',
		'accountcode',
		'accountitem',
		'quantity',
		//'updated_at',
		array(
			//'htmlOptions'=>'array("style" => "text-align: right;")',
			'htmlOptions' => array ('style' => 'text-align: right;' ),
			'name'=>'amount',
			'value'=>'Yii::app()->numberFormatter->formatCurrency($this->grid->dataProvider->data[$this->grid->dataProvider->pagination->currentPage *$this->grid->dataProvider->pagination->pageSize + ($row+1)-1][amount]*-1,"")'//'$row*',//'print_r($this->grid->dataProvider->data[0][subject])'
		)
		,
	),
)); ?>
