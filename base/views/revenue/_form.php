
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
	'id'=>'revenue-form',
	'enableAjaxValidation'=>false,
)); ?>
<fieldset class='myfi' style='border:1px solid #9fc9FF;'><legend class='myle'>Energy Sales</legend><table class=vvs>
				<thead>
					<tr>
						<th>&nbsp;</th>
						<th colspan=4 style='text-align:center;letter-spacing:4px;font-size:16px'>Number of Units (KWh)</th>
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
				$ht="var ids=[";
				$codes=Yii::app()->db->createCommand("select * from v_revenue_sales where accountcode regexp '^30[0-9]{4}$' and budget='".user()->budget['id']."' order by accountcode")->queryAll();
				foreach($codes as $code) { $cl++;
					$cls= $cl%2==0 ? "even" : "odd";
					$t1+=$code[amount1];
					$t2+=$code[amount2];
					$t3+=$code[amount3];
					$t4+=$code[amount4];
					if($code[unitp]>0) $ht.="'".$code[accountcode]."',";
				?>
				<tr class="<?php echo $cls; ?>">
					<td><?php echo $code[accountcode]."  ".$code[item]; ?></td>
					<td><?php echo CHtml::numberField("rev[1$code[id]]",$code[amount1],array('onChange'=>'e();','onKeyUp'=>'e();','id'=>'u1'.$code[accountcode], 'style'=>'width:100px')); ?></td>
					<td><?php echo CHtml::numberField("rev[2$code[id]]",$code[amount2],array('onChange'=>'e();','onKeyUp'=>'e();','id'=>'u2'.$code[accountcode], 'style'=>'width:100px')); ?></td>
					<td><?php echo CHtml::numberField("rev[3$code[id]]",$code[amount3],array('onChange'=>'e();','onKeyUp'=>'e();','id'=>'u3'.$code[accountcode], 'style'=>'width:100px')); ?></td>
					<td><?php echo CHtml::numberField("rev[4$code[id]]",$code[amount4],array('onChange'=>'e();','onKeyUp'=>'e();','id'=>'u4'.$code[accountcode], 'style'=>'width:100px')); ?></td>
				</tr>
				<?php }
				$ht=substr($ht,0,strlen($ht)-1)."];";
				 ?>	
				 <tr><td colspan=5>&nbsp;</td></tr>
				 <tr>
					 <td> <strong>Total</strong></td>
					 <td><?php echo number_format($t1)?></td>
					 <td><?php echo number_format($t2)?></td>
					 <td><?php echo number_format($t3)?></td>
					 <td><?php echo number_format($t4)?></td>
				 </tr>
	<tr>
		<td colspan=5 style='text-align:right'>	<div class="row buttons">
		<?php echo CHtml::submitButton('Save'); ?>
	</div>
</td></tr>				
	</table></fieldset>
	
		<fieldset class='myfi' style='border:1px solid #9fc9FF;'><legend class='myle'>Revenue</legend><table class=vvs>
					<thead>
						<tr>
							<th>&nbsp;</th>
							<th colspan=5 style='text-align:center;letter-spacing:4px;font-size:16px'>Amounts per Quarter (UGX)</th>
						</tr>
						<tr>
							<th>Customer</th>
							<th style='text-align:right'>Q1</th>
							<th style='text-align:right'>Q2</th>
							<th style='text-align:right'>Q3</th>
							<th style='text-align:right'>Q4</th>
							<th style='text-align:right'>Totals</th>
						</tr>
				</thead>
					<?php			
					$cl=$t1=$t2=$t3=$t4=0;
					$codes=Yii::app()->db->createCommand("select * from v_revenue_sales where unitp > 0 and accountcode regexp '^30[0-9]{4}$' and budget='".user()->budget['id']."' order by accountcode")->queryAll();
					foreach($codes as $code) { $cl++;
						$cls= $cl%2==0 ? "even" : "odd";
						$t1+=$code[unitp]*$code[amount1];
						$t2+=$code[unitp]*$code[amount2];
						$t3+=$code[unitp]*$code[amount3];
						$t4+=$code[unitp]*$code[amount4];
						$ht1.= "<div id=v".$code[accountcode]." style='display:none'>".$code[unitp]."</div>";
					?>
					<tr class="<?php echo $cls; ?>">
						<td style='text-align:left'><?php echo $code[accountcode]."  ".$code[item]; ?></td>
						<td style='text-align:right' id="a1<?php echo $code[accountcode];?>"><?php echo number_format($code[unitp]*$code[amount1])?></td>
						<td style='text-align:right' id="a2<?php echo $code[accountcode];?>"><?php echo number_format($code[unitp]*$code[amount2])?></td>
						<td style='text-align:right' id="a3<?php echo $code[accountcode];?>"><?php echo number_format($code[unitp]*$code[amount3])?></td>
						<td style='text-align:right' id="a4<?php echo $code[accountcode];?>"><?php echo number_format($code[unitp]*$code[amount4])?></td>
						<td style='text-align:right' id="a5<?php echo $code[accountcode];?>"><?php echo number_format($code[unitp]*($code[amount4]+$code[amount3]+$code[amount2]+$code[amount1]))?></td>
					</tr>
					<?php } ?>
					<tr class="<?php echo $cls; ?>" style='font-weight:bold'>
						<th style='text-align:left'>Total</th>
						<th style='text-align:right' id="t1"><?php echo number_format($t1)?></td>
						<th style='text-align:right' id="t2"><?php echo number_format($t2)?></th>
						<th style='text-align:right' id="t3"><?php echo number_format($t3)?></th>
						<th style='text-align:right' id="t4"><?php echo number_format($t4)?></th>
						<th style='text-align:right' id="t5"><?php echo number_format($t4+$t3+$t2+$t1)?></th>
					</tr>

						</table></fieldset>

<?php $this->endWidget(); ?>

</div><!-- form -->
<?php echo $ht1; ?>
<script>
function e() {
	<?php echo $ht;?>
	var v1=v2=v3=v4=0;
	var t1=t2=t3=t4=0;
	var i=0;
	//alert(ids.length);
	for(var i=0;i<ids.length;i++) {
		document.getElementById('a1'+ids[i]).innerHTML=accounting.formatNumber(document.getElementById('u1'+ids[i]).value*document.getElementById('v'+ids[i]).innerHTML);
		document.getElementById('a2'+ids[i]).innerHTML=accounting.formatNumber(document.getElementById('u2'+ids[i]).value*document.getElementById('v'+ids[i]).innerHTML);
		document.getElementById('a3'+ids[i]).innerHTML=accounting.formatNumber(document.getElementById('u3'+ids[i]).value*document.getElementById('v'+ids[i]).innerHTML);
		document.getElementById('a4'+ids[i]).innerHTML=accounting.formatNumber(document.getElementById('u4'+ids[i]).value*document.getElementById('v'+ids[i]).innerHTML);
		
		t1+=document.getElementById('u1'+ids[i]).value*document.getElementById('v'+ids[i]).innerHTML; 
		t2+=document.getElementById('u2'+ids[i]).value*document.getElementById('v'+ids[i]).innerHTML; 
		t3+=document.getElementById('u3'+ids[i]).value*document.getElementById('v'+ids[i]).innerHTML; 
		t4+=document.getElementById('u4'+ids[i]).value*document.getElementById('v'+ids[i]).innerHTML; 
		
	}
	document.getElementById('t1').innerHTML=accounting.formatNumber(t1);
	document.getElementById('t2').innerHTML=accounting.formatNumber(t2);
	document.getElementById('t3').innerHTML=accounting.formatNumber(t3);
	document.getElementById('t4').innerHTML=accounting.formatNumber(t4);

}
</script>
