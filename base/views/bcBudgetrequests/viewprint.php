<style>
.iright {
	text-align:right;
}
.bright {
	border-width:1px #000000 solid;
	border-right-style:solid;
	background-color:white;
}
.bleft {
	border-width:1px;
	border-left-style:solid;

}
.btop {
	border-width:1px;
	border-top-style: solid;

}
.bbottom {
	border-width:1px;
	border-bottom-style:solid;
}

.ball {
	border:1px solid;
}
.bnone {
	border:0px;
}
</style>
<div class='pbrki'>

	<table class='bright'><tr><td>
	<table width="100%" class='bright'>
		<tr valign="top">
	   	<td style='text-align:center'>
	   		<img src="images/uetcl.png" width="100" />
	   		<br />
	         Serial No. <span style='color:red'>0<?=$model->id?></span>
	    </td>
	   <td  style='text-align:center'>
	   	<span style='font-weight:bold; font-size:19px'>UGANDA ELECTRICITY TRANSMISSION COMPANY LIMITED</span>
	      <table width="100%" style='border:0px'><tr><td  width="33%">&nbsp;</td><td width="33%" align="center"><p style='font-weight:bold; size:120%'>FORM <?=$model->ppform?></p></td><td align="right"><span style="font-weight:500; font-size:9px; font-style:italic"> Regulation 3(5), 12(3), 13(3), 14(4), 15(4), 17(2), 44(5), 45(4),</span></td></tr></table>
	      THE PUBLIC PROCUREMENT AND DISPOSAL OF PUBLIC ASSETS ACT, 2003<BR />
	      <SPAN STYLE='text-decoration:underline;font-weight:700'>REQUEST FOR APPROVAL OF PROCUREMENT</SPAN><BR />
	      PART I: REQUEST BY USER DEPARTMENT FOR APPROVAL OF PROCUREMENT
	      <br/>

	   </td>
	   </tr>
	</table>
	<table width="100%" style='border:0px' cellpadding="0" cellspacing="0">
	      	<tr>
	         	<td class='bright bleft bbottom'></td>
	         	<td class='bright bbottom'>Procurement Reference Number</td>
	         	<td class='bright bbottom'></td>
	         	<td class='bright bbottom'></td>
	         </tr>
	      	<tr>
	         	<td class='bright bleft bbottom'>Code of Procuring and Disposing Entity</td>
	         	<td class='bright bbottom'>Supplies/Works/Non-Consultancy Services</td>
	         	<td class='bright bbottom'>Financial Year</td>
	         	<td class='bright bbottom'>Sequence Number</td>
	         </tr>
	      	<tr>
	         	<td class='bright bbottom bleft'>UETCL</td>
	         	<td class='bright bbottom'>&nbsp;</td>
				 <?php
					$budget = app()->db->createCommand("SELECT budgets.name as budget from bc_budgetrequests join budgets on bc_budgetrequests.budget = budgets.id  where bc_budgetrequests.id='".$_REQUEST['id']."'")->queryAll();
					 echo "<td class='bright bbottom'>" . $budget[0]['budget'] . "</td>";
					 ?>
	         	<td class='bright bbottom'>&nbsp;</td>
	         </tr>
	      	<tr>
	         	<td colspan="4" class='ball' style="text-align:center;font-weight:bold">Particulars of Procurement
	         	</td>
	         </tr>
	      	<tr>
	         	<td  class='bright bbottom bleft'>Subject of Procurement</td>
	         	<td colspan="3"  class='bright bbottom'><?=$model->subject?></td>
	         </tr>
					 <tr>
 	         	<td class='bright bbottom bleft'>Account Code</td>
 	         	<td colspan="3" class='bright bbottom'><?=$model->accountcode0->accountcode?> - <?=$model->accountcode0->item?></td>
 	         </tr>
	      	<tr>
	         	<td class='bright bbottom bleft'>Procurement Plan Reference</td>
	         	<td colspan="3" class='bright bbottom'><?=$model->justification?></td>
	         </tr>
	      	<tr>
	         	<td class='bright bbottom bleft'>Date Required</td>
	         	<td colspan="3"  class='bright bbottom'><?=date_format(date_create($model->requireddate), 'l jS F Y')?></td>
	         </tr>
			<tr>
	      	<td colspan="4" class='bright bleft' style="text-align:center;font-weight:bold;">Details Relating to the Procurement</td>
	      </tr>
			<!--
	      <tr>
	      <td colspan="4" align="center">  iiii      </td>
	      </tr>-->
	      </table>

	      	<table width="100%" style='margin-top: -8px' cellpadding="0" cellspacing="0">
	         	<tr>
	            	<th  class='bright bbottom' bleft>Item No.</th>
	               <th  class='bright bbottom'>Description<br /><small><i>
	               	Attach Specifications, terms of reference or scope of works</i></small>
	               </th>
	               <th class='bright bbottom'>Quantity</th>
	               <th class='bright bbottom'>Unit of Measure</th>
	               <th class='bright bbottom'>Estimated Unit Cost</th>
	               <th class='bbottom'>Mkt Price of the Procurement</th>
	           </tr>



<!--<div id="bc-budgetrequests-grid" class="grid-view">
<table class="items">
	<tr><th>#</th><th>Item</th><th>Quantity</th><th>Unit Amount (UGX)</th><th>Total (UGX)</th><th>Available Funds</th><th>Running Balance</th></tr>-->
<?php
$c=app()->db->createCommand("SELECT * from v_bc_budgetrequests_items where requestid='".$_REQUEST['id']."'")->queryAll();
foreach($c as $ln) {
	$fds=app()->db->createCommand("SELECT sum(amount) a from bc_itembudgets where status='COMMITED' and section='".user()->dept['id']."' and budget='".budget()."' and item='".$ln['itemid']."' ")->queryAll();
	$fds2=app()->db->createCommand("SELECT sum(amount) a from bc_itembudgets where section='".user()->dept['id']."' and budget='".budget()."' and item='".$ln['itemid']."' ")->queryAll();
	$i++;
	$cl=$i%2==0? "even" : "odd";
	$lntotal=$ln['quantity']*$ln['price'];
	$total +=$lntotal;
	echo "
		<tr class=$cl>
			<td>".$i."</td>
			<td>".$ln['itemname']."</td>
			<td class=iright>".number_format($ln['quantity'])."</td>
			<td class=iright>Units</td>
			<td class=iright>".number_format($ln['price'])."</td>
			<td class=iright>".number_format($lntotal)."</td>
			<!--<td class=iright>".number_format($fds[0]['a'])."</td>
			<td class=iright>".number_format($fds2[0]['a'])."</td>-->
		</tr>";
}
$i++;
$cl=$i%2==0? "even" : "odd";
//echo "<tr class=$cl><td>&nbsp;</td><td colspan=3><strong>Total</strong></td><td class=iright><strong>".number_format($total)."</strong></td><td></td><td></td></tr>";
?>

<!--</table>
</div>-->



	<!--			<tr>
	               <td class='bright'>a&nbsp;</td>
	               <td class='bright'>b&nbsp;</td>
	               <td class='bright'>c&nbsp;</td>
	               <td class='bright'>f&nbsp;</td>
	               <td class='bright'>s&nbsp;</td>
	               <td>w&nbsp;</td>
	            </tr>-->

	         </table>
	         <table width="100%">
	         	<tr>
	            <td width="50%">
	            	<strong>(1) Request for Procurement (Head of Section)</strong><br/>
						<?php
						$timeline=app()->db->createCommand("SELECT * from v_bc_approvals where request='".$_REQUEST['id']."' order by approverdate desc")->queryAll();
						foreach($timeline as $s) {
							if($s['decision']==='APPROVE' && $s['approver_rolealias']==='HOS') {
								$hos=$s['approvernames'];
								$hos_date=$s['approverdate'];
							}
							if($s['decision']==='APPROVE' && $s['approver_rolealias']==='HOD') {
								$hod=$s['approvernames'];
								$hod_date=$s['approverdate'];
							}
							if($s['decision']==='APPROVE' && $s['approver_rolealias']==='MFAS') {
								$mfas=$s['approvernames'];
								$mfas_date=$s['approverdate'];
							}
							if($mfas && $hos && $hod) break;
						}
						?>
						<?php if($hos) { ?>
						<table  class='bnone'>
	               	<tr><td>Name:</td>       <td><?=$hos?></td></tr>
	                  <tr><td>Date:</td>     <td><?=date_format(date_create($hos_date),"l jS F Y g:ia")?></td></tr>
	               </table>
               	<?php } ?>
	            </td>
	            <td>
	            	<strong>(1) Request for Procurement (Head of Department)</strong><br/>
						<?php if($hod) { ?>
						<table  class='bnone'>
	               	<tr><td>Name:</td>       <td><?=$hod?></td></tr>
	                  <tr><td>Date:</td>     <td><?=date_format(date_create($hod_date),"l jS F Y g:ia")?></td></tr>
	               </table>
						<?php } ?>
	            </td>
	            </tr>

	         </table>
	         <b><i>Availability of funds to be confirmed prior to approval by Accounting Officer:</i></b>
	           	<table width="100%"  cellpadding="0" cellspacing="0">
	         	<tr>
	            	<th class='bright bbottom'>Vote/Head no</th>
	               <th class='bright bbottom'>Programme</th>
	               <th class='bright bbottom'>Sub-Programme</th>
	               <th class='bright bbottom'>Item</th>
	               <th class='bbottom'>Balance Remaining</th>
	           </tr>
					<tr>
	               <td class='bright bbottom'>&nbsp;</td>
	               <td class='bright bbottom'>&nbsp;</td>
	               <td class='bright bbottom'>&nbsp;</td>
	               <td class='bright bbottom'>&nbsp;</td>
	               <td class='bbottom'>&nbsp;</td>
	            </tr>

	         </table>
					 <!--<small><i><b>Signatue is required below to certify that the funds are available/budgeted for the requiement and that approval for the procurement is granted.</b></i></small>-->
					 <small><i><b>The log and event trail attached below suffices to certify that the funds are available for the requirement and that approval for the procurement is granted.</b></i></small>
	                  <table width="100%">
	         	<tr>
	            <td width="60%">
	            	<strong>(3) Confirmation of funding and approval to procure (Delegated to Manager Finance, Accounts & Sales)</strong><br/>
						<?php if($mfas) { ?>
						<table>
	               	<tr><td>Name:</td>       <td><?=$mfas?></td></tr>
	                  <tr><td>Date:</td>     <td><?=date_format(date_create($mfas_date),"l jS F Y g:ia")?></td></tr>
	               </table>
               <?php } ?>
	            </td>
	            <td>
	            	Continue additional pages if neccessary. Any attahments must be signed in the same  way as this form.

	            </td>
	            </tr>
	         </table>
	</td></tr></table>
<!--	<p>&nbsp;</p>-->



</div>
<?php /*?><div class='pbrki' style='display:none'>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
	//	'id',
		'accountcode0.item',
		'subject',
		'section0.section',
		array(
			'label'=>'Requestor',
			 'value'=>$model->requestor0->names
		),
//		'requestor0.names',
		'justification',
		'requestdate',
		'requireddate',
	),
)); ?>
<p><h3>Requested Items</h3></p>
<div id="bc-budgetrequests-grid" class="grid-view">
<table class="items">
	<tr><th>#</th><th>Item</th><th>Quantity</th><th>Unit Amount (UGX)</th><th>Total (UGX)</th><th>Available Funds</th><th>Running Balance</th></tr>
<?php
$c=app()->db->createCommand("SELECT * from v_bc_budgetrequests_items where requestid='".$_REQUEST['id']."'")->queryAll();
foreach($c as $ln) {
	$fds=app()->db->createCommand("SELECT sum(amount) a from bc_itembudgets where status='COMMITED' and section='".user()->dept['id']."' and budget='".budget()."' and item='".$ln['itemid']."' ")->queryAll();
	$fds2=app()->db->createCommand("SELECT sum(amount) a from bc_itembudgets where section='".user()->dept['id']."' and budget='".budget()."' and item='".$ln['itemid']."' ")->queryAll();
	$i++;
	$cl=$i%2==0? "even" : "odd";
	$lntotal=$ln['quantity']*$ln['price'];
	$total +=$lntotal;
	echo "<tr class=$cl><td>".$i."</td><td>".$ln['itemname']."</td><td class=iright>".number_format($ln['quantity'])."</td><td class=iright>".number_format($ln['price'])."</td><td class=iright>".number_format($lntotal)."</td><td class=iright>".number_format($fds[0]['a'])."</td><td class=iright>".number_format($fds2[0]['a'])."</td></tr>";
}
$i++;
$cl=$i%2==0? "even" : "odd";
echo "<tr class=$cl><td>&nbsp;</td><td colspan=3><strong>Total</strong></td><td class=iright><strong>".number_format($total)."</strong></td><td></td><td></td></tr>";
?>

</table>
</div>
</div><?php */?>
<script>
function showemployee(d) {
	if(d=='QUERY' || d=='RE-ASSIGN')
		$("#toemp").show();
	 else
		 $("#toemp").hide();
}
</script>
<p><h3>Approval Timeline</h3></p>
	<section id="cd-timeline" class="cd-container">
<?php

$c=app()->db->createCommand("SELECT * from v_bc_approvals where request='".$_REQUEST['id']."' and nextapprover_done is null")->queryAll();
$ln=$c[0];
if(cancomment($_REQUEST['id'])) {
?>
		<div class="cd-timeline-block">
			<div class="cd-timeline-img cd-NOW">
				<img src="roleimg.php?role=<?=$ln['nextapprover_rolealias']?>" alt="<?=$ln['nextapprover_rolealias']?>">
			</div>
			<div class="cd-timeline-content">
				<h2><?=user()->details['names']." - ".$ln['nextapprover_rolealias']?></h2><hr/>
				<p style='text-align:justify'>

					<form method=post enctype="multipart/form-data" id='comment-appove-form'>
						<input type='hidden' name='r' value='bcBudgetrequests/view&id=<?=$_REQUEST['id']?>'>
						<input type='hidden' name='id' value='<?=$_REQUEST['id']?>'>
						<table>
							<tr><td colspan=2><strong>Decision:</strong></td></tr>
								<tr><td><select name='decision' onChange="showemployee(this.value);">
									<option>- select -</option>
									<?php if($ln['nextapprover_role']=='QUERY' && $ln['nextapprover_id'] ==user()->id) { ?><option value='REPLY'>Reply</option><?php }   if(canapprove($_REQUEST['id'])) {?>
									<option value='REJECT'>Reject</option>
									<option value='APPROVE'>Approve</option>
									<option value='RE-ASSIGN'>Re-Assign</option>
									<?php } ?>
									<option value='QUERY'>Query</option>
									</select></td>
									<td><div id=toemp style='display:none'>To Employee:<select name=emp>
										<option></option>
										<?php
										$e=app()->db->createCommand("SELECT * from users order by names asc")->queryAll();
										foreach($e as $u) echo "<option value='".$u['id']."'>".$u['names']."<?option>\n";
										?>
									</select><div></td>
								</tr>
							<tr><td colspan=2>Comments:</td></tr>
							<tr><td colspan=2><textarea name=comments rows=6 cols=50></textarea></td></tr>
							<tr><td colspan=2>Attachments:<br/>
								<?php
								$this->widget('CMultiFileUpload', array(
								                'name' => 'appendix',
								                'accept' => 'jpeg|jpg|gif|png|doc|docx|pdf|txt|rtf|xls|xlsx|ppt|pptx',
								                'duplicate' => 'Duplicate file!',
								                'denied' => 'Invalid file type.',
												'max'=>5,
								            ));
								?>
							</td></tr>
							<tr><td></td><td><input type='submit' value='Submit'></td></tr>
						</table>
					</form>

				</p>
				<span class="cd-date"><?=date_format(date_create($ln['approverdate']),"l jS F Y g:ia")?></span>
			</div>
		</div>

<?php
}
foreach($timeline as $ln) {
	$att="";
	//Yii::getPathOfAlias('webroot').'/appendix/bc'.Yii::app()->user->budget['id'].'/'.Yii::app()->user->id.'-'.$model->id.'-'.$m2->id.'-'.$pic->name)
	$dir=Yii::getPathOfAlias('webroot').'/appendix/bc'.Yii::app()->user->budget['id'];//.'/'.Yii::app()->user->id.'-'.$model->id.'-'.$m2->id.'-'.$pic->name)
	if(is_dir($dir)) {
		$s=scandir($dir);
		$p='/^'.$ln['approver_id'].'-'.$ln['request'].'-'.$ln['id'].'-/';
		foreach($s as $d) {
			if(preg_match($p,$d))
				$att.="<a href='appendix/bc".Yii::app()->user->budget['id']."/".$d."' target=_blank>".$d."</a><br/>";
		}
	}
?>

		<div class="cd-timeline-block">
			<div class="cd-timeline-img cd-<?=$ln['decision']?>">
				<img src="roleimg.php?role=<?=$ln['approver_rolealias']?>" alt="<?=$ln['approver_rolealias']?>">
			</div>
			<div class="cd-timeline-content">
				<h2><?=$ln['approvernames']." - ".$ln['approver_rolealias']?></h2><hr/>
				<p style='text-align:justify'><?=$ln['comments']?></p>
				<?php if($att) {?>Attachments:<br/><?=$att?><?php } ?>
				<span class="cd-date"><?=date_format(date_create($ln['approverdate']),"l jS F Y g:ia")?></span>
			</div>
		</div>
<?php } ?>
	</section> <!-- cd-timeline -->
