<h3>Company Budget By Department: <?php echo user()->budget['name'] ?></h3>
<?php
echo "<div class='grid-view'><table class='items' style='border: 1px solid;width:70%'>";
echo "<thead><tr><th>Department</th><th>Budget</th></tr></thead><tbody>";
	$bdgt	= Yii::app()->db->createCommand("select realdptname d, sum(amount) a from v_budget where budget =".user()->budget[id]."  and (accountid regexp '4[0-7][0-9]{4}$' or accountid regexp '10[0-9]{4}$') group by realdptshortname")->queryAll();
	foreach($bdgt as $rw) {
		$ct+=$rw[a];
		$r=$ctr%2==0 ? "even" : "odd";$ctr++;
		echo "<tr class=$r><td>".$rw['d']."</td><td style='text-align:right'>".number_format($rw[a])."</td></tr>";
	}
	echo "<tr class=$r><td><strong>Total</strong></td><td style='text-align:right'><strong>".number_format($ct)."</strong></td></tr>";
?>
</tbody></table>