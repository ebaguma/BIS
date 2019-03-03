<?php

class ItemsController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		$heads=array('adminnn');
		if (is_sys_admin() || is_sat() || is_pbfo())
			$heads[]=Yii::app()->user->name;
		$bo=array('adminnn');
		if (is_budget_officer() || is_dept_head() || is_sys_admin())
			$bo[]=Yii::app()->user->name;
		
		return array(
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('item2','admin','create','update','list','accountcode','delete','index','details'),
				'users'=>$heads,
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('item','accountcode'),
				'users'=>$bo,
			),

			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	public function actionAccountcode() {
		$data=CHtml::listData(Items::model()->findAll("accountcode='".$_REQUEST[accountcode]."' order by name asc"),'id','name');
		echo "<option value=''> - Select - </option>";
		foreach($data as $value=>$name)
			echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
	}

	public function actionItems() {
		$data=CHtml::listData(Items::model()->findAll("accountcode='".$_REQUEST[accountcode]."' order by name asc"),'id','name');
		echo "<option value=''> - Select - </option>";
		foreach($data as $value=>$name)
			echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
	}

	public function actionDetails() {
		$data1=Yii::app()->db->createCommand("SELECT * from uom order by name")->queryAll();
		for($i=0; $i<count($data1);$i++)				
			$uomlist .="<option class=ew value=".$data1[$i]['id'].">".$data1[$i]['name']."</option>";

		$data=Yii::app()->db->createCommand("SELECT * from currencies")->queryAll();
		for($i=0; $i<count($data);$i++)				
			$csz .="<option class=ew value=".$data[$i]['id'].">".$data[$i]['sign']." ".$data[$i]['name']."</option>";
		?>
        <!-- script type="text/javascript" src="/bis/assets/dc899cdc/jquery.js"></script -->
		
		<script type="text/javascript" src="/assets/dc899cdc/jquery.js"></script>
        <script type="text/javascript">
		
		jQuery(function($) {
			var d=document.getElementById('dkeeper').innerHTML;
			$("#additional-link").bind("click",function(){ 
			d++;
			var rown = d%2==0 ? "even" : "odd";
			$("#additional-inputs").append("\n<tr class="+rown+" id=sel"+d+"><td>"+d+".</td><td><input id='it"+d+"' size=60 type=text name=Items[item][] /></td><td><select  id='uom"+d+"' name=Items[uom][]><?=$uomlist?></select></td><td><input id=qty"+d+" style='width:100px' type=number value=1 step=0.0001 name=Items[quantity][]></td><td><select  id='period"+d+"' name=Items[currency][]><?=$csz?></select></td></tr>");
			document.getElementById('dkeeper').innerHTML=d;
    	});
		$("#additional-linkr").bind("click",function(){ $("#sel" + d).remove();	d--;document.getElementById('dkeeper').innerHTML=d;});
});
</script>

<a id="additional-link" href="#">Add Item</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a id="additional-linkr" href="#" style="color:red">Remove Last Item</a>
<table class=items><tr><th>No.</th><th>Item</th><th>UOM</th><th>Price</th><th>Currency</th></tr><tbody id="additional-inputs">
<?php
//echo "SELECT * from items_prices_view where accountcode='".$_REQUEST['Items'][accountcode]."' and budget='".user()->budget['id']."' order by name";
$data2=Yii::app()->db->createCommand("SELECT * from items_prices_view where accountcode='".$_REQUEST['Items'][accountcode]."' and budget='".user()->budget['id']."' order by name")->queryAll();
for($i=0; $i<count($data2);$i++)	{
	$csz="";
	for($e=0; $e<count($data);$e++) {				
		$csz .="<option ".($data2[$i][currency]==$data[$e][symbol] ? "selected=selected" : "")." value=".$data[$e]['id'].">".$data[$e]['name']."</option>";
	}
	$uomlist="";
	for($e=0; $e<count($data1);$e++) {				
		$uomlist .="<option ".($data2[$i][uomid]==$data1[$e][id] ? "selected=selected" : "")." value=".$data1[$e]['id'].">".$data1[$e]['name']."</option>";
	}
	
	
	$rown = $i%2==0 ? "even" : "odd";
echo "<tr class=".$rown." id=sel".$i."><td>".($i+1).".</td><td><input id='it".$i."' value='".$data2[$i][name]."' size=60 type=text name=Items[item][] ".($data2[$i][readonly]==1 ? "readonly=readonly" : "")." /><td><select  id='uom".$i."' name=Items[uom][]>".$uomlist."</select></td></td><td><input id=qty".$i." style='width:100px' step='0.000001' type=number value=".$data2[$i][price]." name=Items[quantity][]></td><td><select  id='period".$i."' name=Items[currency][]>".$csz."</select></td></tr>\n";

}
?>
	
</tbody></table>
<div id="dkeeper" style='display:none;'><?php echo $i?></div>
     <?php	
	}

	public function actionItem() {
		$cs=$_REQUEST[costcentre] ? $_REQUEST[costcentre] : $_REQUEST[costcentre2];
		$data=CHtml::listData(Accountcodes::model()->findAll("accountcode regexp '^".$cs."[0-9]{4}$' order by item asc"),'id','item');
		echo CHtml::tag('option', array('value'=>$value),CHtml::encode('- select -'),true);
		foreach($data as $value=>$name)		{
			echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
		}
	}
	public function actionItem2() {
		$ac=$_REQUEST['accountcode'] ? $_REQUEST['accountcode'] : $_REQUEST['accountcode2'];
		$data=CHtml::listData(Items::model()->findAll("accountcode='".$ac."' order by name asc"),'id','name');
		echo CHtml::tag('option', array('value'=>$value),CHtml::encode('- select -'),true);
		foreach($data as $value=>$name)		{
			echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
		}
	}

	public function actionList(){
		if(isset($_POST['item'])) {
			$ad="and ";
			foreach($_POST['item'] as $key=>$value)
				if(!empty($value)) $ad.=" `$key` like '%".$value."%' and ";
		}
		$sql="SELECT * FROM items_prices_view where budget=".user()->budget['id']."  ".substr($ad,0,-4);
		$rawData = Yii::app()->db->createCommand($sql); 
		$count = Yii::app()->db->createCommand('SELECT COUNT(*) FROM (' . $sql . ') as count_alias')->queryScalar(); 
	//the count
		 $model = new CSqlDataProvider($rawData, array(
	                   'keyField' => 'itemid',
	                    'totalItemCount' => $count,
	                    'sort' => array(
	                        'attributes' => array(
	                            'accountid', 'accountitem', 'currency','price','name'
	                        ),
	                        'defaultOrder' => array(
	                            'accountid' => CSort::SORT_ASC, //default sort value
	                        ),
	                    ),
	                    'pagination' => array(
	                        'pageSize' => 200,
	                    ),
	                ));
 
	        $this->render('viewd', array(
	            'model' => $model,
	        ));
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Items;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Items']))
		{
			$model->attributes=$_POST['Items'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate()
	{
		$model=new Items;
		if(isset($_POST['Items']))
		{			
//			dump($_POST['Items']);
			for ($a=0;$a<count($_POST['Items']['item']);$a++) {
				if(!$_POST['Items']['item'][$a]) continue;
				$im=Items::model()->findByAttributes(array('name'=>strip($_POST['Items']['item'][$a]),'accountcode'=>$_POST['Items']['accountcode']));
				if($im==null) $im=new Items;
				$im->attributes=array('uom'=>$_POST['Items']['uom'][$a],'name'=>strip($_POST['Items']['item'][$a]),'accountcode'=>$_POST['Items']['accountcode']);
				//dump($im->attributes);
				$im->save();
				
				$pm=ItemsPrices::model()->findByAttributes(array('item'=>$im->id,'budget'=>user()->budget['id']));
				if($pm==null) $pm=new ItemsPrices;
				$pm->attributes=array('item'=>$im->id,'budget'=>user()->budget['id'],'price'=>$_POST['Items']['quantity'][$a],'currency'=>$_POST['Items']['currency'][$a],'insertby'=>user()->id);
				$_POST['Items']['quantity'][$a]==0 ? $pm->delete() : $pm->save();
			}
		}
		
		$this->render('update',array('model'=>$model));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Items');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Items('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Items']))
			$model->attributes=$_GET['Items'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Items the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Items::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Items $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='items-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
