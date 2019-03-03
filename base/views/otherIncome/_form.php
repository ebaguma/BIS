<?php
/* @var $this OtherIncomeController */
/* @var $model OtherIncome */
/* @var $form CActiveForm */
?>
<style>
.vvs {
	width:900px;
}
.vvs td {
	font-weigiht:bold;
	font-size:14px;
}
.even {
	background-color:rgb(220,220,220);
}
.vvs tr {
	line-height:10px;
		height:10px;
		padding:0px;
		margin:0px;
}

</style>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'otherIcome-form',
	'enableAjaxValidation'=>false,
)); ?>
	<?php echo $form->errorSummary($model); ?>	
	<TABLE >
		<?php 
				$grps = array(
					//'30'	=> 'Energy Sales',
					//'31'	=>	'Cost of Sales',
					'32'	=>	'Other Income'
				);
				foreach($grps as $rkey=>$rvalue) {
				?>
					<tr><td><fieldset class='myfi' style='border:1px solid #9fc9FF;'><legend class='myle'> <?php echo $rvalue?></legend><table class=vvs>
				<thead>
					<tr>
						<th>&nbsp;</th>
						<th colspan=4 style='text-align:center;letter-spacing:4px;font-size:16px'>Amounts per Quarter (UGX)</th>
					</tr>
					<tr>
						<th>Client</th>
						<th>Q1</th>
						<th>Q2</th>
						<th>Q3</th>
						<th>Q4</th>
					</tr>
			</thead>
				<?php								
				$codes=Yii::app()->db->createCommand("select * from v_revenue where  accountcode regexp '^".$rkey."[0-9]{4}$' and budget='".user()->budget['id']."' order by item")->queryAll();
				foreach($codes as $code) { $cl++;
					$cls= $cl%2==0 ? "even" : "odd";
				?>
				<tr class="<?php echo $cls; ?>">
					<td><?php echo $code[accountcode]."  ".$code[item]; ?></td>
					<td><?php echo CHtml::numberField("OtherIncome[1$code[id]]",$code[amount1],array('style'=>'width:120px')); ?></td>
					<td><?php echo CHtml::numberField("OtherIncome[2$code[id]]",$code[amount2],array('style'=>'width:120px')); ?></td>
					<td><?php echo CHtml::numberField("OtherIncome[3$code[id]]",$code[amount3],array('style'=>'width:120px')); ?></td>
					<td><?php echo CHtml::numberField("OtherIncome[4$code[id]]",$code[amount4],array('style'=>'width:120px')); ?></td>
				</tr>
				<?php } ?>	
	<tr>
		<td colspan=5 style='text-align:right'>	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Save' : 'Save'); ?>
	</div>
</td></tr>				
					</table></fieldset></td></tr>
	<?php } ?>
	<!--=<tr>
		<td style='text-align:right'>	<div class="row buttons">
		<?php // echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>
</td></tr>--></table>

<?php $this->endWidget(); ?>

</div><!-- form -->