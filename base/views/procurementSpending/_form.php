<style>
.subtable {
 border: 1px #aaaaaa ridge;

}
.subtable tr {
	height:5px !important;
	padding-top: 10px !important;
}
div.background {
   border: 0px solid black;

}
div.background img.bg {
		position: absolute;
	    left: 0%;
	    top: 20%;
	    width: 90%;
	    height: auto;
	    opacity: 0.1;
		 z-index:-2;
}
#myform {
	padding:20px;
}
</style>

<div class=background>
	<img src='images/world.png' class='bg'/>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'procurement-spending-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

<?php
/*
echo CHtml::ajaxLink('View Popup', 'procurementSpending/popup', 
    array('update' => '#simple-div'), 
    array('id' => 'simple-link-'.uniqid())
);
*/
?>
<!--<div id="simple-div">gwe</div>-->

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>


	<div class="row">
		<?php echo $form->labelEx($model,'subject'); ?>
		<?php echo $form->textField($model,'subject',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'subject'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'justification'); ?>
		<?php echo $form->textField($model,'justification',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'justification'); ?>
	</div>
	
<table style='width:150px'>
	<tr><td>
	<div class="row">
		<?php //echo $form->labelEx($model,'location'); ?>
		<?php //echo $form->dropDownList($model,'location',Chtml::ListData(DeliveryLocations::model()->findAll(),'id','name')); ?>
		<?php //echo $form->error($model,'location'); ?>
	</div>
</td><td>
	<div class="row">
		<?php echo $form->labelEx($model,'date_required'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
		    'name'=>'ProcurementSpending[date_required]',
		    // additional javascript options for the date picker plugin
		    'options'=>array(
		        'showAnim'=>'clip',
				'dateFormat'=>'yy-mm-dd',
				'yearRange'=>'2014:2015',
		    ),
		    'htmlOptions'=>array(
		        'style'=>'height:20px;'
		    ),
		));   ?>
		<?php echo $form->error($model,'date_required'); ?>
	</div>
</td></tr></table>
	<div class="row">
		<?php echo $form->labelEx($model,'Add Attachment');
		$this->widget('CMultiFileUpload', array(
		                'name' => 'appendix',
		                'accept' => 'jpeg|jpg|gif|png|doc|docx|pdf|txt|rtf|xls|xlsx|ppt|pptx',
		                'duplicate' => 'Duplicate file!',
		                'denied' => 'Invalid file type.',
						'max'=>5,
		            ));		
		?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Cost Centre'); 
		    $rl = app()->db->CreateCommand("select * from accountcodes where accountcode regexp '^[0-9]{2}$' order by accountcode asc")->queryAll();
			 $role_list=array();
			 foreach($rl as $r) $role_list[$r[accountcode]]=$r[accountcode]." - ".$r[item];
			echo Chtml::dropDownList('costcentre', array(), $role_list,
				array(
					'style'=>'width:270px',
					'empty' => ' - Select a Cost Centre - ',
					'ajax' => array(
						'type'=>'POST',
						'url'=>CController::createUrl('Items/item'), 
						'update'=>'#ProcurementSpending_accountcode',
					),	
			)); 
?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'Account Code'); 
			echo $form->dropDownList($model,'accountcode', array(),array(
				'style'=>'width:270px',
				'prompt'=>'- select -',
				'ajax' => array(
					'type'=>'POST',
					'url'=>CController::createUrl('ProcurementSpending/item'), 
					'update'=>'#ProcurementSpending_items',
				),
				
			)); 
			?>
	</div>
<?php /* ?>
	<div class="row">
		<?php echo $form->labelEx($model,'Items'); ?>
		<?php echo $form->dropDownList($model,'accountcode',Chtml::ListData(Accountcodes::model()->findAll("accountcode regexp '^4[1-9][0-9]{4}$' order by item asc"),'id','item'),array(
	'ajax' => array(
	'type'=>'POST',
	'url'=>CController::createUrl('ProcurementSpending/item'), 
	'update'=>'#ProcurementSpending_items',
	))); ?>
		<?php echo $form->error($model,'accountcode'); ?>
	</div>
	<?php */?>
<div class="row grid-view" id="ProcurementSpending_items"></div>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form --></div>