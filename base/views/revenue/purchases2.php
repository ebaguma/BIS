<?php
	$codes=app()->db->createCommand("select * from v_revenue_purchases where budget='".user()->budget['id']."'")->queryAll();
	$cst=0;
	$capacity_payments=$fixed_payments=$fixed_local=$capacity_local=0;
	foreach($codes as $code) { $cl++;
		$mp=ItemsPricesView::model()->findByAttributes(array('name'=>'Capacity Payment ', 'accountcode'=>$code[id],'budget'=>user()->budget['id'])); }
		
		if($mp==null) {
			echo $code[item]."<br>";
		} else {
		print_r($mp->priceugx);
			exit;
	}
		$mi=Items::model()->findByAttributes(array('accountcode'=>$code[id],'name'=>'Capacity Payment'));
		if($mi==null) {
			$mi=new Items;
			$mi->attributes=array('accountcode'=>$code[id],'name'=>'Capacity Payment');
			$mi->save();
		}
		$mp=ItemsPricesView::model()->findByAttributes(array('itemid'=>$mi->id,'budget'=>user()->budget['id']));
		/*
		if($mp==null) {
			$mp=new ItemsPrices;
			$mp->attributes=array('price'=>0,'item'=>$mi->id,'budget'=>user()->budget['id'],'currency'=>3,'createdby'=>1);
			$mp->save();
		}
		$mp=ItemsPricesView::model()->findByAttributes(array('itemid'=>$mi->id,'budget'=>user()->budget['id']));
		* /
		$cp_item=Items::model()->findByAttributes(array('accountcode'=>$code[id],'name'=>'Capacity Payment'));
		if($cp_item==null) {
			$cp_item=new Items;
			$cp_item->attributes=array('accountcode'=>$code[id],'name'=>'Capacity Payment');
			$cp_item->save();
		}
		$cp_price=ItemsPricesView::model()->findByAttributes(array('itemid'=>$cp_item->id,'budget'=>user()->budget['id']));
		if($cp_price==null) {
			$cp=new ItemsPrices;
			$cp->attributes=array('price'=>$mp->price,'item'=>$cp_item->id,'budget'=>user()->budget['id'],'currency'=>3,'createdby'=>1);
			$cp->save();
			$cp_price=ItemsPricesView::model()->findByAttributes(array('itemid'=>$cp_item->id,'budget'=>user()->budget['id']));
		}
		if($mp->price != $cp_price->price) {
			$cp_price=ItemsPrices::model()->findByAttributes(array('item'=>$cp_item->id,'budget'=>user()->budget['id']));
			$cp_price->attributes=array('price'=>$mp->price,'item'=>$cp_item->id,'budget'=>user()->budget['id'],'currency'=>3,'createdby'=>1);
			$cp_price->save();			
		}
		
		
	}
//	exit;

		$b=Budget::model()->findByAttributes(array('item'=>$cp_item->id,'budget'=>user()->budget['id']));
		if($b==null) {
			$a=StaffCosts::model()->findByAttributes(array('item'=>$cp_item->id,'budget'=>user()->budget['id']));
			if($a==null) {
				$a = new StaffCosts;
				$a->attributes=array('accountcode'=>	$relac,'item'=>$cp_item->id,'period'=>'Monthly','dept'=>253,'budget'=>user()->budget['id'],'createdby'=>1,'dateneeded'=>date('Y-m-d'),'quantity'=>1);//));
				$a->save();	
				$a=StaffCosts::model()->findByAttributes(array('item'=>$cp_item->id,'budget'=>user()->budget['id']));
			}
			$b = new Budget;
			$b->attributes=array('dateneeded'=>date('Y-m-d'),'descr'=>'cp','budget'=>user()->budget['id'],'dept'=>253,'item'=>$cp_item->id,'qty'=>1,'tbl'=>'staff_costs','tblcolumn'=>'cp','createdby'=>1,'tblid'=>$a->id);
			$b->save(); 
		}		
		$fixed_payments+=$mp->priceugx;
		if($code[local]==1)
			$fixed_local +=$mp->priceugx;

		$mi=Items::model()->findByAttributes(array('accountcode'=>$code[id],'name'=>'Unit Price'));
		if($mi==null) {
			$mi=new Items;
			$mi->attributes=array('accountcode'=>$code[id],'name'=>'Unit Price');
			$mi->save();
		}
		$mp=ItemsPricesView::model()->findByAttributes(array('itemid'=>$mi->id,'budget'=>user()->budget['id']));
		if($mp==null) {
			$mp=new ItemsPrices;
			$mp->attributes=array('price'=>1,'item'=>$mi->id,'budget'=>user()->budget['id'],'currency'=>3,'createdby'=>1);
			$mp->save();
			$mp=ItemsPricesView::model()->findByAttributes(array('itemid'=>$mi->id,'budget'=>user()->budget['id']));
		}		
		$capacity_payments +=$mp->priceugx*($code[amount1]+$code[amount2]+$code[amount3]+$code[amount4]);
		if($code[local]==1)
			$capacity_local+=$mp->price*($code[amount1]+$code[amount2]+$code[amount3]+$code[amount4]);
		//}
	$relac=Accountcodes::model()->findByAttributes(array('accountcode'=>330004))->id;
	$el=Items::model()->findByAttributes(array('name'=>'Rural Electrification Levy Percentage','accountcode'=>$relac));
	if($el==null) {
		$el=new Items;
		$el->attributes=array('name'=>'Rural Electrification Levy Percentage','accountcode'=>$relac);
		$el->save();
	}
	$elp=ItemsPrices::model()->findByAttributes(array('item'=>$el->id,'budget'=>user()->budget['id']));
		if($elp==null) {
			$elp=new ItemsPrices;
			$elp->attributes=array('price'=>0,'item'=>$el->id,'budget'=>user()->budget['id'],'currency'=>1,'createdby'=>1);
			$elp->save();
		}
	$el=Items::model()->findByAttributes(array('name'=>'Rural Electrification Levy','accountcode'=>$relac));
	if($el==null) {
		$el=new Items;
		$el->attributes=array('name'=>'Rural Electrification Levy','accountcode'=>$relac);
		$el->save();
	}
	$newrel=$elp->price*($capacity_local+$fixed_local)/100;
	$elp=ItemsPricesView::model()->findByAttributes(array('itemid'=>$el->id,'budget'=>user()->budget['id']));
	if($elp==null)  {
		$elp= new ItemsPrices;
		$elp->attributes=array('price'=>$newrel,'currency'=>3,'item'=>$el->id,'budget'=>user()->budget['id'],'createdby'=>1);
		$elp->save();		
		$elp=ItemsPricesView::model()->findByAttributes(array('itemid'=>$el->id,'budget'=>user()->budget['id']));
	}
	if($elp->price !=$newrel) {
		$elp2=ItemsPrices::model()->findByAttributes(array('item'=>$el->id,'budget'=>user()->budget['id']));
		$elp2->attributes=array('price'=>$newrel,'currency'=>3,'item'=>$el->id,'budget'=>user()->budget['id'],'createdby'=>1);
		$elp2->save();		
		
		$elp=ItemsPricesView::model()->findByAttributes(array('itemid'=>$el->id,'budget'=>user()->budget['id']));
	}
	$b=Budget::model()->findByAttributes(array('item'=>$el->id,'budget'=>user()->budget['id']));
	if($b==null) {
		//echo "b is null<br>";
		$a=StaffCosts::model()->findByAttributes(array('item'=>$el->id,'budget'=>user()->budget['id']));
		if($a==null) {
			$a = new StaffCosts;
			$a->attributes=array('accountcode'=>	$relac,'item'=>$el->id,'period'=>'Monthly','dept'=>253,'budget'=>user()->budget['id'],'createdby'=>1,'dateneeded'=>date('Y-m-d'),'quantity'=>1);//));
			$a->save();	
			$a=StaffCosts::model()->findByAttributes(array('item'=>$el->id,'budget'=>user()->budget['id']));
		}
		$b=new Budget;
		$b->attributes=array('dateneeded'=>date('Y-m-d'),'descr'=>'rel','budget'=>user()->budget['id'],'dept'=>253,'item'=>$el->id,'qty'=>1,'tbl'=>'staff_costs','tblcolumn'=>'rel','createdby'=>1,'tblid'=>$a->id);
		$b->save(); 
	}	
	*/
?>
<style>
.vvs td {
	font-weigiht:bold;
	font-size:14px;
}
.even {
	background-color:rgb(230,230,230);
}
.vvs tr {
	line-height:10px;
		height:10px;
		padding:0px;
		margin:0px;
}
.revtbl td,.revtbl th{
	text-align: right;
}
</style>
<script>
function outputUpdate2(vol) {
//document.querySelector('#shld').innerHTML = vol;
document.querySelector('#peak').innerHTML = (vol*0.8).toFixed(2);
document.querySelector('#offp').innerHTML =  (vol*1.2).toFixed(2);
}
</script>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'revenue-form',
	'enableAjaxValidation'=>false,
)); ?>
	<?php echo $form->errorSummary($model); ?>	
	<TABLE class=revtbl>
					<tr><td><fieldset class='myfi' style='border:1px solid #9fc9FF;'><legend class='myle'> Tarrif Generation</legend><table class=vvs>
				<thead><tr><th>Item</th><th>Amount (Debit)</th><th>Amount (Credit)</th></tr></thead>
				<tr class="<?php echo $cls;$cls++; ?>">
					<td>O&M Budget</td>
					<td>
						<?php $cb=Yii::app()->db->createCommand("select sum(amount) a from v_budget where budget='".user()->budget['id']."' and (accountid regexp '^4[0-9]{5}$' or accountid regexp '^10[0-9]{4}$')")->queryAll(); 
						echo number_format($cb[0][a]);
						?>
					</td>
					<td></td>
				</tr>
					<td>Energy Purchases</td>
					<td>
						<?php $cb=Yii::app()->db->createCommand("select sum(amount) a from v_budget where budget='".user()->budget['id']."' and (accountid regexp '^31[0-9]{4}$')")->queryAll(); 
						echo number_format($cb[0][a]);
						?>
					</td>
					<td></td>
				</tr>
				<tr class="<?php echo $cls; $cls++?>">
					<td>Capacity Charges</td>
					<td>12,369,237</td>
					<td></td>
					<td id="t<?php echo $rev[id] ?>"></td>
				</tr>
				<tr class="<?php echo $cls; $cls++?>">
					<td>GOU Subsidies</td>
					<td>12,369,237</td>
					<td></td>
					<td id="t<?php echo $rev[id] ?>"></td>
				</tr>

				<tr class="<?php echo $cls; $cls++?>">
					<td>Generation Levy</td>
					<td>697,878,697</td>
					<td></td>
					<td id="t<?php echo $rev[id] ?>"></td>
				</tr>
				<tr class="<?php echo $cls; $cls++?>">
					<td>Communication Levy</td>
					<td>12,369,237</td>
					<td></td>
					<td id="t<?php echo $rev[id] ?>"></td>
				</tr>
				<tr class="<?php echo $cls; $cls++?>">
					<td>Rural Electrification Levy</td>
					<td>512,319,559</td>
					<td></td>
					<td id="t<?php echo $rev[id] ?>"></td>
				</tr>
				<tr class="<?php echo $cls; $cls++?>">
					<td>VAT on Imported Power</td>
					<td>722,324,555</td>
					<td></td>
					<td id="t<?php echo $rev[id] ?>"></td>
				</tr>				
				<tr class="<?php echo $cls; $cls++?>">
					<th>Total Costs</th>
					<td>8,982,873,329,609</td>
					<td></td>
					<td id="t<?php echo $rev[id] ?>"></td>
				</tr>				
				<tr class="<?php echo $cls; $cls++?>">
					<th></th>
					<td></td>
					<td></td>
					<td id="t<?php echo $rev[id] ?>"></td>
				</tr>				
				<tr class="<?php echo $cls; $cls++?>">
					<th>Revenue</th>
					<td></td>
					<td></td>
					<td id="t<?php echo $rev[id] ?>"></td>
				</tr>				
				<tr class="<?php echo $cls; $cls++?>">
					<td>Fiber Lease</td>
					<td></td>
					<td>187,758,599</td>
					<td id="t<?php echo $rev[id] ?>"></td>
				</tr>				
				<tr class="<?php echo $cls; $cls++?>">
					<td>GOU Subsidies</td>
					<td></td>
					<td><?php //echo number_format($fixed_payments)?>7,764,778,888</td>
					<td id="t<?php echo $rev[id] ?>"></td>
				</tr>				

				<tr class="<?php echo $cls; $cls++?>">
					<td>Export Revenue</td>
					<td></td>
					<td>82,758,599</td>
					<td id="t<?php echo $rev[id] ?>"></td>
				</tr>	
				<tr class="<?php echo $cls; $cls++?>">
					<td>Other Income</td>
					<td></td>
					<td>8,108,623,378</td>
					<td id="t<?php echo $rev[id] ?>"></td>
				</tr>					
				<tr class="<?php echo $cls; $cls++?>">
					<th>Total Revenue</th>
					<td></td>
					<td>1,810,862,3378</td>
					<td id="t<?php echo $rev[id] ?>"></td>
				</tr>					
				<tr class="<?php echo $cls; $cls++?>">
					<th></th>
					<td></td>
					<td></td>
					<td id="t<?php echo $rev[id] ?>"></td>
				</tr>				
							
				<tr class="<?php echo $cls; $cls++?>">
					<th>Short Fall</th>
					<td></td>
					<td><?php // echo $debit-$credit; ?>7,182,873,329,609</td>
					<td id="t<?php echo $rev[id] ?>"></td>
				</tr>								
				<tr class="<?php echo $cls; $cls++?>">
					<th>Energy Sales (KWh)</th>
					<td></td>
					<td><?php //echo $debit-$credit; ?>918,202,912</td>
					<td id="t<?php echo $rev[id] ?>"></td>
				</tr>								

				<tr class="<?php echo $cls; $cls++?>">
					<td>Generated Tarrif</td>
					<td colspan=2 style='text-align:center'><b><?php $tarrif=7822; echo $tarrif; ?></b></td>
				</tr>				
				<tr class="<?php echo $cls; $cls++?>">
					<td></td>
					<td colspan=2 style='text-align:center'><table width=100%><tr><td width=30%>Peak</td><td width=30%>Shoulder</td><td width=30%>Off Peak</td></tr></table></td>
				</tr>				
				<tr class="<?php echo $cls; $cls++?>">
					<td></td>
					<td colspan=2 style='text-align:center'><table width=100%><tr><td width=30%  id=offp><?php echo $tarrif;?></td><td width=30%  id=shld><?php echo $tarrif;?></td><td width=30% id=peak><?php echo $tarrif;?></td></tr></table></td>
				</tr>				

				<tr class="<?php echo $cls; $cls++?>">
					<td>Tarrif rates</td>
					<td colspan=2 style='text-align:center'><table width=80%><tr><td><input oninput="outputUpdate2(value)"  type=range width=100% min=<?php echo round($tarrif*0.8); ?> value=<?php echo round($tarrif); ?> max=<?php echo round($tarrif*1.2); ?> ></td></tr></table></td>
				</tr>				

					</table></fieldset></td></tr>
	<tr>
		<td>	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>
</td></tr></table>

<?php $this->endWidget(); ?>

</div><!-- form -->