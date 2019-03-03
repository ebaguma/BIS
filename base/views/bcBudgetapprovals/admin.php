
<h1>My Pending Budget Check Approvals</h1>
<?php if($_REQUEST['msg']) { ?>
<div class="flash notice">
  <span class="close"><a href="#">X</a></span>
<?=$_REQUEST['msg']?>
</div>
<?php } ?>

<script>
	function toggle(source) {
	  checkboxes = document.getElementsByClassName('appall');
	  for(var i=0, n=checkboxes.length;i<n;i++) {
	    checkboxes[i].checked = checkboxes[i].checked ? false :true;//source.checked;
		 //alert(source.checked);
	  }
	}
	</script>
	<form method='post' action='index.php?r=bcBudgetrequests/view'>
		<input type='hidden' value='bcBudgetrequests/view' name='r' />
<div id="bc-budgetapprovals-grid" class="grid-view" style='min-width:126% !important'>
	<input type='button' onClick="toggle(this)" value='Select All' />&nbsp;&nbsp;&nbsp;
	<select name='decision'>
		<option value=''>- Select Decision - </option>
		<option value='REJECT'>Reject</option>
		<option value='APPROVE'>Approve</option>
	</select>
	<input name='submitapproval' type='submit' value='Submit'/>
<table class="items" >
	<tr>
		<th><input type='checkbox' onClick="toggle(this)"  id=call name=checkall /></th>
		<th>#</th>
		<th>Request Date</th>
		<th>Account Code</th>
		<th>Subject</th>
		<th>Requestor</th>
		<th>Section</th>
		<th>From</th>
		<th>Approving As</th>
		<th>Options</th>
	</tr>
<?php
$not=!isset($_REQUEST['q']) ? "not" : "";
$c=app()->db->createCommand("SELECT * from v_bc_approvals where (nextapprover_id ='".user()->id."'  or nextapprover_rolealias in ('".implode(myroles(),"','")."')) and approver_rolealias ".$not." in  ('".implode(myroles(),"','")."') and nextapprover_done is null union SELECT * from v_bc_approvals where nextapprover_id ='".user()->id."' and nextapprover_done is null")->queryAll();
foreach($c as $ln) {
	if(
		($ln['nextapprover_rolealias']=="HOS" && $ln['section_id']==section()) or 
		($ln['nextapprover_rolealias']=="HOD" && $ln['dept_id']==user()->dept['department']) or 
		$ln['nextapprover_id']==user()->id or 
		in_array($ln['nextapprover_rolealias'],myotherroles())
	) {
		$cl=$i%2==0? "even" : "odd";
		$lntotal=$ln['quantity']*$ln['price'];
		$total +=$lntotal;
		echo "<tr class=$cl>
			<td><input type='checkbox' id=c".$ln['request']." class='appall' name=c[] value='".$ln['request']."' /></td>
			<td>".++$i."</td>
			<td>".$ln['requestdate']."</td>
			<td>".$ln['account_id']." - ".$ln['account_item']."</td>
			<td>".$ln['subject']."</td>
			<td>".$ln['requestor_names']."</td>
			<td>".$ln['section']."</td>
			<td>".$ln['approvernames']."</td>
			<td>".$ln['nextapprover_rolealias']."</td>
			<td><a href='index.php?r=bcBudgetrequests/view&amp;id=".$ln['request']."'>[View]</a></td></tr>";
	}
}
?>	
</table>
</div>
<center><a href='?r=bcBudgetapprovals/admin&amp;q=queried'>Click here to see Requests that you queried or re-assigned to other people</a></center>

