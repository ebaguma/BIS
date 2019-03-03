<h3>Multi Year Company Budget By Department</h3>
<?php
echo "<div class='grid-view'><table class='items' style='border: 1px solid;width:70%'>";
echo "<thead><tr><th>Department</th><th>2016</th><th>2017</th><th>2018</th><th>2019</th><th>2020</th><th>2021</th></tr></thead><tbody>";
	$bdgt	= Yii::app()->db->createCommand("select realdptname d, budget b,sum(amount) a from v_budget where  (accountid regexp '4[0-7][0-9]{4}$' or accountid regexp '10[0-9]{4}$') group by realdptname,budget order by  realdptshortname,budget")->queryAll();
	$d=array();
	foreach($bdgt as $rw) $d[$rw[d]][$rw[b]]=$rw[a];
	//	dump($d,false);
	foreach($d as $n=>$i) {
		$r=$ctr%2==0 ? "even" : "odd";$ctr++;
		$ct3+=$i[3];$ct4+=$i[4];$ct5+=$i[5];$ct6+=$i[6];$ct7+=$i[7];$ct8+=$i[8];
		echo "<tr class=$r>
			<td>".$n."</td>
			<td style='text-align:right'>".number_format($i[3])."</td>
			<td style='text-align:right'>".number_format($i[4])."</td>
			<td style='text-align:right'>".number_format($i[5])."</td>
			<td style='text-align:right'>".number_format($i[6])."</td>
			<td style='text-align:right'>".number_format($i[7])."</td>
			<td style='text-align:right'>".number_format($i[8])."</td>

		</tr>";
	}
	echo "<tr class=$r>
		<td><strong>Total</strong></td>
		<td style='text-align:right'><strong>".number_format($ct3)."</strong></td>
		<td style='text-align:right'><strong>".number_format($ct4)."</strong></td>
		<td style='text-align:right'><strong>".number_format($ct5)."</strong></td>
		<td style='text-align:right'><strong>".number_format($ct6)."</strong></td>
		<td style='text-align:right'><strong>".number_format($ct7)."</strong></td>
		<td style='text-align:right'><strong>".number_format($ct8)."</strong></td>
		</tr>";
?>
</tbody></table>
