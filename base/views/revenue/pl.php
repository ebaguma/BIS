<?php
function accting_format($amount) {
    if ($amount < 0) return '(' . number_format(abs($amount)) . ')';
    return  number_format($amount);
}
	$codes=app()->db->createCommand("select * from v_revenue_purchases where capacity_price > 0 and contract_capacity >0 and budget='".user()->budget['id']."'")->queryAll();
	$cst=0;
	$capacity_payments=$fixed_payments=$fixed_local=$capacity_local=0;
	foreach($codes as $c) $capacity_payments+=$c[capacity_price]*$c[contract_capacity]*24*365;

	//Communication Levy: 2% of Fiber Revenue
	$codes=app()->db->createCommand("select * from items_prices_view where budget='".user()->budget['id']."' and accountid='320008'")->queryAll();
	foreach($codes as $c) $fiberIncome+= $c[priceugx];
	$commlevy=0.02*$fiberIncome;
	$itemid=Items::model()->findByAttributes(array('name'=>'Communication Levy','accountcode'=>202))->id;
	$bt1=ItemsPrices::model()->findByAttributes(array('budget'=>budget(),'item'=>$itemid));
	if($bt1==null) $bt1=new ItemsPrices;
	$bt1->attributes=array('budget'=>budget(),'item'=>$itemid,'price'=>$commlevy);
	$bt1->save();
	$bt=Budget::model()->findByAttributes(array('budget'=>budget(),'item'=>$itemid));
	if($bt==null) $bt=new Budget;
	$bt->attributes=array("item"=>$itemid,"dept"=>user()->dept['id'],"qty"=>1,"tbl"=>"revenue","tblcolumn"=>'communicationlevy',"tblid"=>1,"descr"=>'Communication levy',"createdon"=>date("Y-m-d"),"createdby"=>user()->id,"dateneeded"=> date("Y-m-d"));
	$bt->save();
	
	// Generation Levy: 0.3% of Export Revenue
	$codes=app()->db->createCommand("select * from v_revenue_sales where local=0 and budget='".user()->budget['id']."'")->queryAll();
	foreach($codes as $c) $exportRevenue+= $c[unitp]*($c[amount1]+$c[amount2]+$c[amount3]+$c[amount4]);
	$genlevy=0.003*$exportRevenue;
	$itemid=Items::model()->findByAttributes(array('name'=>'Generation Levy','accountcode'=>193))->id;
	$bt1=ItemsPrices::model()->findByAttributes(array('budget'=>budget(),'item'=>$itemid));
	if($bt1==null) $bt1=new ItemsPrices;
	$bt1->attributes=array('budget'=>budget(),'item'=>$itemid,'price'=>$genlevy);
	$bt1->save();
	$bt=Budget::model()->findByAttributes(array('budget'=>budget(),'item'=>$itemid));
	if($bt==null) $bt=new Budget;
	$bt->attributes=array("item"=>$itemid,"dept"=>user()->dept['id'],"qty"=>1,"tbl"=>"revenue","tblcolumn"=>'generationlevy',"tblid"=>1,"descr"=>'generation levy',"createdon"=>date("Y-m-d"),"createdby"=>user()->id,"dateneeded"=> date("Y-m-d"));
	$bt->save();

	// Rural Electrification Levy: 5% of Internally generated power costs
	$codes=app()->db->createCommand("select * from v_revenue_purchases where local=1 and budget='".user()->budget['id']."'")->queryAll();
	foreach($codes as $c) $internalRevenue +=  $c[unitp]*($c[amount1]+$c[amount2]+$c[amount3]+$c[amount4]);
	$relevy=0.05*$internalRevenue;
	$itemid=Items::model()->findByAttributes(array('name'=>'Rural Elecrification Levy','accountcode'=>66))->id;
	$bt1=ItemsPrices::model()->findByAttributes(array('budget'=>budget(),'item'=>$itemid));
	if($bt1==null) $bt1=new ItemsPrices;
	$bt1->attributes=array('budget'=>budget(),'item'=>$itemid,'price'=>$relevy);
	$bt1->save();
	$bt=Budget::model()->findByAttributes(array('budget'=>budget(),'item'=>$itemid));
	if($bt==null) $bt=new Budget;
	$bt->attributes=array("item"=>$itemid,"dept"=>user()->dept['id'],"qty"=>1,"tbl"=>"revenue","tblcolumn"=>'ruralelectrificationlevy',"tblid"=>1,"descr"=>'rural electrification levy',"createdon"=>date("Y-m-d"),"createdby"=>user()->id,"dateneeded"=> date("Y-m-d"));
	$bt->save();

	//VAT on Imported Power2: 18% of Imported Power
	$codes=app()->db->createCommand("select * from v_revenue_purchases where local=0 and budget='".user()->budget['id']."'")->queryAll();
	foreach($codes as $c) $importedPower +=  $c[unitp]*($c[amount1]+$c[amount2]+$c[amount3]+$c[amount4]);
	$vat=0.18*$importedPower;
	$itemid=Items::model()->findByAttributes(array('name'=>'VAT on Imported Power','accountcode'=>66))->id;
	/*$bt1=ItemsPrices::model()->findByAttributes(array('budget'=>budget(),'item'=>$itemid));
	if($bt1==null) $bt1=new ItemsPrices;
	$bt1->attributes=array('budget'=>budget(),'item'=>$itemid,'price'=>$vat);
	$bt1->save();
	$bt=Budget::model()->findByAttributes(array('budget'=>budget(),'item'=>$itemid));
	if($bt==null) $bt=new Budget;
	$bt->attributes=array("item"=>$itemid,"dept"=>user()->dept['id'],"qty"=>1,"tbl"=>"revenue","tblcolumn"=>'ruralelectrificationlevy',"tblid"=>1,"descr"=>'rural electrification levy',"createdon"=>date("Y-m-d"),"createdby"=>user()->id,"dateneeded"=> date("Y-m-d"));
	$bt->save();*/
	
	//Other Income
	$codes=app()->db->createCommand("select * from items_prices_view where budget='".user()->budget['id']."' and accountid !='320008' and accountid regexp '^32[0-9]{4}$'")->queryAll();
	foreach($codes as $c) $otherIncome+= $c[priceugx];
	$codes=app()->db->createCommand("select * from v_revenue_sales where accountcode !='300002'  and accountcode !='300003' and local=1 and budget='".user()->budget['id']."'")->queryAll();
	foreach($codes as $c) $energysales += $c[amount1]+$c[amount2]+$c[amount3]+$c[amount4];
	$peaks=app()->db->createCommand("select * from v_revenue_sales where accountcode ='300002'  and local=1 and budget='".user()->budget['id']."'")->queryAll();
	$peaksales=$peaks[0][amount1]+$peaks[0][amount2]+$peaks[0][amount3]+$peaks[0][amount4];
	$peaks=app()->db->createCommand("select * from v_revenue_sales where accountcode ='300003'  and local=1 and budget='".user()->budget['id']."'")->queryAll();
	$offpeaksales=$peaks[0][amount1]+$peaks[0][amount2]+$peaks[0][amount3]+$peaks[0][amount4];
	
?>
<div class="grid-view">

<?php 
	$cb=Yii::app()->db->createCommand("select sum(amount) a from v_budget where budget='".user()->budget['id']."' and (accountid regexp '^4[0-9]{5}$' or accountid regexp '^10[0-9]{4}$')")->queryAll(); 
	$ob=$cb[0][a];
	$cb=Yii::app()->db->createCommand("select sum(totalsales) a from v_revenue_sales where budget='".user()->budget['id']."'")->queryAll(); 
	$sales=$cb[0][a];
	$cb=Yii::app()->db->createCommand("select sum(totalcosts) a from v_revenue_purchases where budget='".user()->budget['id']."'")->queryAll(); 
	$costs=$cb[0][a];
	$codes=app()->db->createCommand("select sum(priceugx) a from items_prices_view where budget='".user()->budget['id']."' and accountid regexp '^32[0-9]{4}$'")->queryAll();
	$otherincome=$codes[0][a];
	
	$c=app()->db->createCommand("select sum(amount) a from v_budget where budget='".user()->budget['id']."' and accountid regexp '^40[0-9]{4}$'")->queryAll();
	$staff_costs=$c[0][a];
	$c=app()->db->createCommand("select sum(amount) a from v_budget where budget='".user()->budget['id']."' and accountid regexp '^41[0-9]{4}$'")->queryAll();
	$ostaff_costs=$c[0][a];
	$c=app()->db->createCommand("select sum(amount) a from v_budget where budget='".user()->budget['id']."' and accountid regexp '^4[2-3][0-9]{4}$' and accountid !='430004'")->queryAll();
	$transport_costs=$c[0][a];
	$c=app()->db->createCommand("select sum(amount) a from v_budget where budget='".user()->budget['id']."' and accountid regexp '^44[0-9]{4}$'")->queryAll();
	$grid_costs=$c[0][a];
	$c=app()->db->createCommand("select sum(amount) a from v_budget where budget='".user()->budget['id']."' and accountid regexp '^45[0-9]{4}$' and accountid not in ('450043','450031','450047')")->queryAll();
	$admin_costs=$c[0][a];
	$c=app()->db->createCommand("select sum(amount) a from v_budget where budget='".user()->budget['id']."' and accountid ='450043'")->queryAll();
	$bank_costs=$c[0][a];
	$c=app()->db->createCommand("select sum(amount) a from v_budget where budget='".user()->budget['id']."' and accountid in('450031','450047')")->queryAll();
	$era_costs=$c[0][a];
	$c=app()->db->createCommand("select sum(amount) a from v_budget where budget='".user()->budget['id']."' and accountid in ('430004','470004')")->queryAll();
	$insurance_costs=$c[0][a];
	$c=app()->db->createCommand("select sum(amount) a from v_budget where budget='".user()->budget['id']."' and accountid regexp '^46[0-9]{4}$'")->queryAll();
	$depreciation_costs=$c[0][a];
	$c=app()->db->createCommand("select sum(amount) a from v_budget where budget='".user()->budget['id']."' and accountid regexp '^47[0-9]{4}$' and accountid not in ('470004')")->queryAll();
	$other_charges=$c[0][a];

	$c=app()->db->createCommand("select sum(amount) a from v_budget where budget='".user()->budget['id']."' and accountid regexp '^10[0-9]{4}$' ")->queryAll();
	$capital=$c[0][a];
	

	$totalincome=$sales+$capacity_payments;
	$thirdparty=$relevy+$genlevy+$commlevy;
	$costsofsales=$costs+$capacity_payments+$vat;
	$gross_profit=$totalincome-$costsofsales-$thirdparty;
	$gpm='&nbsp;'.@round($gross_profit*100/$costsofsales)."%";
	$othercosts=$staff_costs+$ostaff_costs+$transport_costs+$grid_costs+$admin_costs+$bank_costs+$era_costs+$insurance_costs+$depreciation_costs+$other_charges;
	$oc_funds=$otherincome+$gross_profit;
	$om_funds=$otherincome+$gross_profit-$capital;
	$surplus=round($om_funds-$othercosts);
	$netmargin='&nbsp;'.round($surplus*100/$om_funds)."%";
	$a=array(
	'Energy Sales  - Net of Rebates'		=>$sales,
	'GOU Subsidy'						=>$capacity_payments,
	'<b>Total Income</b>'				=>$totalincome,
	'&nbsp;'								=>'',
	'Cost of Sales (Energy Purchases)'	=>-$costsofsales,
	'Third Party Charges'					=>-$thirdparty,
	'&nbsp;&nbsp;'						=>-($costsofsales+$thirdparty),
	'<b>Gross Profit</b>'				=>$gross_profit,
	'Gross Profit Margin'					=>$gpm,
	'&nbsp;&nbsp;&nbsp;'				=>'',
	'Other Operating Income'			=>$otherincome,
	'Income before Operating Costs'	=>$oc_funds,
	'Capital Expenditure'					=>-$capital,
	'<b>Funds Available for Operations</b>'	=>$om_funds,
	'Staff Costs'							=>-$staff_costs,
	'Other Staff Costs'					=>-$ostaff_costs,
	'Transport Costs'						=>-$transport_costs,
	'Grid Operations & Maintenance'	=>-$grid_costs,
	'Administrative Costs'				=>-$admin_costs,
	'Bank Guarantees'					=>-$bank_costs,
	'ERA License & Fees'					=>-$era_costs,
	'General and Motor Insurance'		=>-$insurance_costs,
	'Other Charges & Provisions'		=>-$other_charges,
	'Depreciation Charge'				=>-$depreciation_costs,
	'&nbsp;&nbsp;&nbsp;&nbsp;'		=>-$othercosts,
	'<b>Shortfall/Surplus</b>'			=>$surplus,
	'Net Profit Margin'					=>$netmargin
	);
	
	?>	
	<form method=post>
<fieldset class='myfi' style='border:1px solid #9fc9FF;'><legend class='myle'>P&L Statement</legend><table class="items vvs">
				<thead><tr><th>Item</th><th>Amount</th></tr></thead>
				<?php 
				$cl=1;
				foreach ($a as $k=>$v) {
					$cls= $cl%2==0 ? "even" : "odd"; $cl++;
					echo "<tr class=$cls><td>$k</td><td style='text-align:right'>".(round($v) != 0 ? accting_format($v) : $v)."</td></tr>";
				}?>
			
					</table></fieldset></form></div>
			
					