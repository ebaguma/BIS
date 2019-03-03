<?php
/* @var $this BcBudgetrequestsController */
/* @var $model BcBudgetrequests */




?>

<h1>View Budget Check Approval Request: <?php echo $model->subject; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'subject',
		'justification',
		'requestdate',
		'requireddate',
		'requestornames',
		//'budget',
	),
)); 

?>
<style>
.iright {
	text-align:right;
}
</style>
<div id="bc-budgetrequests-grid" class="grid-view">
<table class="items">
	<tr><th>#</th><th>Item</th><th>Quantity</th><th>Unit Amount (UGX)</th><th>Total (UGX)</th><th>Available Funds</th><th>Running Balance</th></tr>
<?php
$c=app()->db->createCommand("SELECT * from v_bc_budgetrequests_items where requestid='".$_REQUEST['id']."'")->queryAll();
foreach($c as $ln) {
	$fds=app()->db->createCommand("SELECT sum(amount) a from bc_itembudgets where section='".user()->dept['id']."' and budget='".budget()."' and item='".$ln['itemid']."'")->queryAll();
	$i++;
	$cl=$i%2==0? "even" : "odd";
	$lntotal=$ln['quantity']*$ln['price'];
	$total +=$lntotal;
	echo "<tr class=$cl><td>".$i."</td><td>".$ln['itemname']."</td><td class=iright>".number_format($ln['quantity'])."</td><td class=iright>".number_format($ln['price'])."</td><td class=iright>".number_format($lntotal)."</td><td class=iright>".number_format($fds[0]['a'])."</td><td class=iright>".number_format($fds[0]['a']-$lntotal)."</td></tr>";
}
$i++;
$cl=$i%2==0? "even" : "odd";
echo "<tr class=$cl><td>&nbsp;</td><td colspan=3><strong>Total</strong></td><td class=iright><strong>".number_format($total)."</strong></td><td></td><td></td></tr>";
?>	

</table>
</div>
<script>
function showemployee(d) {
	if(d=='Query' || d=='Re-Assign')
		$("#toemp").show();
	 else
		 $("#toemp").hide();
}
</script>
<form>
	<table>
		<tr><td colspan=2><table><tr><td>Approval Decision:</td><td><select onChange="showemployee(this.value);">
			<option></option>
			<option>Reject</option>
			<option>Approve</option>
			<option value='Query'>Query</option>
			<option value='Re-Assign'>Re-Assign</option>
		</select></td><td><div id=toemp style='display:none'><table><tr><td>To Employee:</td><td><select>
			<option> list of employees</option>
		</select></td></tr></table><div></td></tr></table></td></tr>
		<tr><td>Comments:</td><td><textarea rows=4 cols=80></textarea></td></tr>
		<tr><td></td><td><input type='submit' value='Submit'></td></tr>
	</table>
</form>