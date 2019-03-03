<style>
.iright {
	text-align:right;
}
</style>

<?php

$this->breadcrumbs=array('Bc Budgetrequests'=>array('index'),$model->id);
$this->menu=array(
	array('label'=>'List  Requests', 'url'=>array('admin')),
	array('label'=>'New  Request', 'url'=>array('create')),
//	array('label'=>'Update this Request', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Request', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
//	array('label'=>'Manage BcBudgetrequests', 'url'=>array('admin')),
);
?>

<h1>View Budget Check Request</h1>

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
	<tr><th>#</th><th>Item</th><th>Quantity</th><th>Unit Amount (UGX)</th><th>Total (UGX)</th><th>Committed Funds</th><th>Pending Approvals</th><th>Running Balance</th></tr>
<?php

$c=app()->db->createCommand("SELECT * from v_bc_budgetrequests_items where requestid='".$_REQUEST['id']."'")->queryAll();
foreach($c as $ln) {
	//echo "SELECT sum(amount) a from bc_itembudgets where  amount < 0  and status='COMMITED' and section='".$ln['section']."' and budget='".budget()."' and item='".$ln['itemid']."' ";
	$commited=app()->db->createCommand("SELECT sum(amount) a from bc_itembudgets where reason in (3,6)  and status='COMMITED' and section='".$ln['section']."' and budget='".budget()."' and item='".$ln['itemid']."' ")->queryAll();
	$pending=app()->db->createCommand("SELECT sum(amount) a from bc_itembudgets where reason in (3,6)  and status='PENDING' and section='".$ln['section']."' and budget='".budget()."' and item='".$ln['itemid']."' ")->queryAll();
//	echo "SELECT sum(amount) a from bc_itembudgets where reason in (3,6)  and status='PENDING' and section='".$ln['section']."' and budget='".budget()."' and item='".$ln['itemid']."' ";
	//$fds3=app()->db->createCommand("SELECT sum(amount) a from bc_itembudgets where  reason in (1,2,4,5)  and section='".$ln['section']."' and budget='".budget()."' and item='".$ln['itemid']."' ")->queryAll();
	//$fds3=app()->db->createCommand("SELECT sum(amount) a from bc_itembudgets where  reason in (1,2,4,5)  and section='".$ln['section']."' and budget='".budget()."' and item='".$ln['itemid']."' ")->queryAll();
	//echo "SELECT sum(amount) a from bc_itembudgets where amount > 0  and section='".$ln['section']."' and budget='".budget()."' and item='".$ln['itemid']."' ";
	$running=app()->db->createCommand("SELECT sum(amount) a from bc_itembudgets where section='".$ln['section']."' and budget='".budget()."' and item='".$ln['itemid']."' ")->queryAll();
//	echo "SELECT sum(amount) a from bc_itembudgets where section='".$ln['section']."' and budget='".budget()."' and item='".$ln['itemid']."' ";
	$i++;
	$cl=$i%2==0? "even" : "odd";
	$lntotal=$ln['quantity']*$ln['price'];
	$total +=$lntotal;
	echo "<tr class=$cl>
		<td>".$i."</td>
		<td>".$ln['itemname'].CHtml::link(' [Details]',array('bcItembudgets/accountcodes',
                   'section'=>$ln['section'],'accountcode'=>$ln['accountid'],'item'=>$ln['itemid']), array('target'=>'_blank'))."   </td>
		<td class=iright>".number_format($ln['quantity'])."</td>
		<td class=iright>".number_format($ln['price'])."</td>
		<td class=iright>".number_format($lntotal)."</td>
		<td class=iright>".number_format($commited[0]['a']*-1)."</td>
		<td class=iright>".number_format($pending[0]['a']*-1)."</td>
		<td class=iright>".number_format($running[0]['a'])."</td>
	</tr>";
}
$i++;
$cl=$i%2==0? "even" : "odd";
echo "<tr class=$cl><td>&nbsp;</td><td colspan=3><strong>Total Amount Requested</strong></td><td class=iright><strong>".number_format($total)."</strong></td><td colspan=3>&nbsp;</td></tr>";
?>	
</table>
</div>

<script>
function showemployee(d) {
	if(d=='QUERY' || d=='RE-ASSIGN')
		$("#toemp").show();
	 else
		 $("#toemp").hide();
}
</script>

<?php
	$finalised=1;
	$c1=app()->db->createCommand("SELECT * from v_bc_approvals where request='".$_REQUEST['id']."' order by approverdate desc limit 1")->queryAll();
	if(count($c1)===1 and $c1[0]['decision']==='APPROVE' and $c1[0]['nextapprover_level']==null) {
		echo "<h3><a href='index.php?r=bcBudgetrequests/print&id=".$model->id."'>Print PP Form</a></h3>";
	} else {$finalised=0;}
	
?>
	
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
				<span class="cd-date"><?=date_format(date_create(),"l jS F Y g:ia")?></span>
			</div>
		</div>

<?php 
} else {
	if($finalised==0) {
		$next=$ln['nextapprovernames'] ? $ln['nextapprovernames'] : $ln['nextapprover_rolename'];
		?>
		<div class="cd-timeline-block">
			<div class="cd-timeline-img cd-<?=$ln['nextapprover_role']?>">
				<img src="roleimg.php?role=<?=$ln['nextapprover_rolealias']?>" alt="<?=$ln['nextapprover_rolealias']?>">
			</div> 
			<div class="cd-timeline-content">
				
				<p style='text-align:justify'>Sent to <strong><?=$next?></strong><br/>
				on <?=date_format(date_create($ln['approverdate']),"l jS F Y g:ia")?>. <em>Awaiting Action.</em></p>
			</div>
		</div>
		<?php
	}
}
$c=app()->db->createCommand("SELECT * from v_bc_approvals where request='".$_REQUEST['id']."' order by approverdate desc")->queryAll();
foreach($c as $ln) {
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
