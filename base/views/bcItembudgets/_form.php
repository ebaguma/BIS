<div class="form">

	<?php $form = $this->beginWidget('CActiveForm', array(
		'id' => 'bc-itembudgets-form',
		'enableAjaxValidation' => false,
	)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
	<div class="row">
		<?php echo $form->labelEx($model, 'Cost Centre');
		$rl = app()->db->CreateCommand("select * from accountcodes where accountcode regexp '^[0-9]{2}$' order by accountcode asc")->queryAll();
		$role_list = array();
		foreach ($rl as $r) $role_list[$r[accountcode]] = $r[accountcode] . " - " . $r[item];
		echo Chtml::dropDownList(
			'costcentre',
			array(),
			$role_list,
			array(
				'empty' => ' - Select a Cost Centre - ',
				'style' => 'width:270px',
				'ajax' => array(
					'type' => 'POST',
					'url' => CController::createUrl('Items/item'),
					'update' => '#accountcode',

				),
			)
		);
		?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model, 'Account Code');
		echo Chtml::dropDownList('accountcode', array(), array(), array(
			'style' => 'width:270px',
			'empty' => ' - Select an Account Code - ',
			'ajax' => array(
				'type' => 'POST',
				'url' => CController::createUrl('Items/item2'),
				'update' => '#BcItembudgets_item',
			),

		));
		?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model, 'Item');
		echo $form->dropDownList($model, 'item', array(), array(
			'style' => 'width:270px',
			'empty' => ' - Select an Item - '
		));
		?>
	</div>

	<div class="row">
		<?= Chtml::label('Section', false); ?>
		<?php
		$rl = app()->db->CreateCommand("select * from v_sections order by dshortname,sshortname")->queryAll();
		$role_list = array();
		foreach ($rl as $r) $role_list[$r['sectionid']] = $r['dshortname'] . " - " . $r['sshortname'];
		echo $form->dropDownList($model, 'section', $role_list, array('onChange' => "document.getElementById('ProcurementSpending_items').innerHTML='';document.getElementById('accountcode').value=''", 'style' => 'width:270px', 'empty' => ' - Select a Section - ')); ?>
	</div>

	<div class="row buttons"><?php echo CHtml::submitButton($model->isNewRecord ? 'Add to Budget' : 'Save'); ?></div>

	<?php $this->endWidget(); ?>

</div><!-- form -->