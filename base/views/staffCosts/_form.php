<style>
.subtable {
 border: 1px #aaaaaa ridge;

}
.subtable tr {
	height:5px !important;
	padding-top: 10px !important;
}
div.background {
   border: 0px solid black;

}
div.background img.bg {
	position: absolute;
	left: 20%;
	top: 20%;
	    width: 60%;
	    height: auto;
	    opacity: 0.07;
		 z-index:-1;
		 -khtml-opacity:0.07; 
		 -moz-opacity:0.07; 
		  -ms-filter:”alpha(opacity=7)”;
		   filter:alpha(opacity=7);
		   filter: progid:DXImageTransform.Microsoft.Alpha(opacity=7);
}
#myform {
	padding:20px;
}
</style>

<div class=background>
	<img src='images/earth.jpg' class='bg'/>
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'staff-costs-form',
	'enableAjaxValidation'=>false,
)); 
if(budget_locked()) { $this->renderPartial('/site/locked_warning'); } 
?>
	
	<div class="row">
		<?php 
		$cas = $_REQUEST['ac']=='41' ? " or accountcode='400018'": "";
		echo $form->labelEx($model,'accountcode'); 
		echo $form->dropDownList($model,'accountcode',
			Chtml::ListData(Accountcodes::model()->findAll("active=1 and (accountcode REGEXP '^".$_REQUEST['ac']."[0-9]{4}$' $cas) order by item"),'id','item'),			
				array(
					'prompt'=>'- Select -',
					'ajax' => array(
						'type'=>'POST',
						'url'=>CController::createUrl('staffCosts/item'), 
						'update'=>'#StaffCosts_items',
					),
					'style'=>'width:265px'
				)
			); ?>
		<?php echo $form->error($model,'accountcode'); ?>
	</div>
		<!-- div class="row" id="redate" style="display:block">
	    <?php  //echo $form->labelEx($model,'Date Needed (Approximate)'); ?>
	<?php 
	/***
	$this->widget('zii.widgets.jui.CJuiDatePicker',array(
	    'name'=>'StaffCosts[dateneeded]',
	    // additional javascript options for the date picker plugin
	    'options'=>array(
	        'showAnim'=>'clip',
			'dateFormat'=>'yy-mm-dd',
			'yearRange'=>'2015:2016',
	    ),
		'value'=>$model->dateneeded,
	    'htmlOptions'=>array('style'=>'width:265px;'),
	));   
	***/
	?> 
	    </div -->
		 <div id='ajax_loader' style="position: fixed; left: 30%; top: 40%; display: none;">
		     <img src=images/loading.gif></img>
		 </div>
		 <script type="text/javascript">
		     jQuery(function ($){
		         $(document).ajaxStop(function(){
		             $("#ajax_loader").hide();
		          });
		          $(document).ajaxStart(function(){
		              $("#ajax_loader").show();
		          });    
		     });    
		 </script>
    <div class="grid-view row" id="StaffCosts_items"></div>
	<input id='submit' type='submit' value='Submit' />
<?php $this->endWidget(); ?>
</div><!-- form --></div>
<?php $this->widget('ext.ScrollTop');  ?>