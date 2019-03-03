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
	'enableAjaxValidation'=>true,
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

<table style='max-width:150px'>
	<tr>	<td><div class="row">
		<?php echo $form->labelEx($model,'ppform');
			echo $form->dropDownList($model,'ppform', array('5'=>'Form 5','18'=>'Form 18'),
				array(
					'style'=>'width:270px',
					'empty' => ' - Select a Cost Centre - ',
					'ajax' => array(
						'type'=>'POST',
						'url'=>CController::createUrl('Items/item'),
						'update'=>'#accountcode',
					),
			));
?>
	</div>

</td><td>
	<div class="row">
		<?php echo $form->labelEx($model,'requireddate'); ?>
		<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
		    'name'=>'BcBudgetrequests[requireddate]',
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
		<?php echo $form->error($model,'requireddate'); ?>
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
		<?php echo $form->labelEx($model,'Cost Category');
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
						'update'=>'#accountcode',
					),
			));
?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'Account Code');
			echo CHtml::dropDownList('accountcode', array(),array(),array(
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

<div class="row grid-view" id="ProcurementSpending_items"></div>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form --></div>
