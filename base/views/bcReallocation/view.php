<?php
/* @var $this BcReallocationController */
/* @var $model BcReallocation */

$this->breadcrumbs=array(
	'RE-Allocations'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'New Re-Allocation', 'url'=>array('create')),
//	array('label'=>'Update BcReallocation', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this reallocation request?')),
	array('label'=>'List My Re-Allocations', 'url'=>array('admin')),
);
?>

<h1>View Re-Allocation Request</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
	//	'id',
		'fromitem0.name',
		'toitem0.name',
		'amount',
		'justification',
	//	'budget',
	//	'requestor',
		'requestdate',
	),
)); ?>

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
	
$c=app()->db->createCommand("select a.*,b.approver,r.rolename,r.alias from bc_budgetapprovals a join bc_workflow_stages b on (approver_level=b.stage and b.workflow=7) left join roles r on b.approver=r.id where reallocation='".$_REQUEST['id']."' and nextapprover_done is null")->queryAll();
$ln=$c[0];
if(cancomment($_REQUEST['id'],'reallocation')) {
?>
		<div class="cd-timeline-block">
			<div class="cd-timeline-img cd-NOW">
				<img src="roleimg.php?role=<?=$ln['nextapprover_rolealias']?>" alt="<?=$ln['nextapprover_rolealias']?>">
			</div> 
			<div class="cd-timeline-content">
				<h2><?=user()->details['names']." - ".$ln['nextapprover_rolealias']?></h2><hr/>
				<p style='text-align:justify'>
					
					<form method=post enctype="multipart/form-data" id='comment-appove-form'>
						<input type='hidden' name='r' value='BcReallocation/view&id=<?=$_REQUEST['id']?>'>
						<input type='hidden' name='id' value='<?=$_REQUEST['id']?>'>
						<table>
							<tr><td colspan=2><strong>Decision:</strong></td></tr>
								<tr><td><select name='decision' onChange="showemployee(this.value);">
									<option>- select -</option>
									<?php if($ln['nextapprover_role']=='QUERY' && $ln['nextapprover_id'] ==user()->id) { ?><option value='REPLY'>Reply</option><?php }   if(canapprove($_REQUEST['id'],'reallocation')) {?>
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
}
$c=app()->db->createCommand("SELECT * from v_bc_approvals where reallocation='".$_REQUEST['id']."' order by approverdate desc")->queryAll();
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