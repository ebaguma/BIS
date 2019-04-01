<?php

class BcReallocationController extends Controller
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
		$a=['admin'];
		if(is_sat() or is_pbfo()) $a[]=user()->details['username'];		
		return array(
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','items','itemo','itemf','admin','deilete','view'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('capture','itemst','itemsf'),
				'users'=>$a,
			),			
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	public function actionCapture() {
		$model=new BcReallocation;
		if(isset($_POST['BcReallocation'])) { 
			$model->attributes=$_POST['BcReallocation'];
			if(!$model->save()){ echo "no save bcreallocation"; dump($_POST,false);dump($model); echo "ho".$model->getErrors();	 }
			$model_to=new BcItembudgets;

			$model_to->attributes=array(
				'item'		=>$_POST['BcReallocation']['toitem'],
				'section'	=>$_POST['BcReallocation']['tosection'],
				'amount'	=>$_POST['BcReallocation']['amount'],
				'budget'	=>budget(),
				'reason'	=>5,
				'reasonid'	=>$model->id,
				'status'	=>'COMMITED'
			);
			
			if(!$model_to->validate()) { echo "no save to"; dump($_POST,false);dump($model_to); echo $model_to->getErrors();	}
			if(!$model_to->save()) die("failed to save model_to");
			$model_fr=new BcItembudgets;
			$model_fr->attributes=array(
				'item'		=>$_POST['BcReallocation']['fromitem'],
				'section'	=>$_POST['BcReallocation']['fromsection'],
				'amount'	=>$_POST['BcReallocation']['amount']*-1,
				'budget'	=>budget(),
				'reason'	=>5,
				'reasonid'	=>$model->id,
				'status'	=>'COMMITED'
			);
			if(!$model_fr->validate()) { echo "no save from";dump($_POST,false);dump($model_fr); echo $model_fr->getErrors();	}
			if(!$model_fr->save()) die("failed to save model_fr");
			$msg="The Budget has been updated accordingly. Please access the reports to see the new figures";
			} 
			$this->render('capture',array('message'=>$msg,'model'=>$model));		
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array('model'=>$this->loadModel($id)));
	}
	public function actionItemsf() {
//		$sc = $_REQUEST['BcReallocation']['fromsection'] ? 
		$s=app()->db->createCommand("SELECT distinct item,itemname from v_bc_itembudgets where section=".$_REQUEST['BcReallocation']['fromsection']." and accountid='".$_REQUEST['accountcode']."' and budget=".budget())->queryAll();
		 $st=CHtml::tag('option', array('value'=>$value),CHtml::encode('- select -'),true);
		foreach($s as $dt )		{
			$st.= CHtml::tag('option', array('value'=>$dt['item']),CHtml::encode($dt['itemname']),true);
		}
		echo CJSON::encode(array('sites'=>$st));			
	}
	public function actionItemst() {
		$s=app()->db->createCommand("SELECT distinct item,itemname from v_bc_itembudgets where section=".$_REQUEST['BcReallocation']['tosection']." and accountid='".$_REQUEST['accountcode2']."' and budget=".budget())->queryAll();
		 $st=CHtml::tag('option', array('value'=>$value),CHtml::encode('- select -'),true);
		foreach($s as $dt )		{
			$st.= CHtml::tag('option', array('value'=>$dt['item']),CHtml::encode($dt['itemname']),true);
		}
		echo CJSON::encode(array('sites'=>$st));			
	}	
	public function actionItems() {
		$s=app()->db->createCommand("SELECT distinct item,itemname from v_bc_itembudgets where section=".$_REQUEST['BcReallocation']['fromsection']." and accountid='".$_REQUEST['accountcode']."' and budget=".budget())->queryAll();
		 $st=CHtml::tag('option', array('value'=>$value),CHtml::encode('- select -'),true);
		foreach($s as $dt )		{
			$st.= CHtml::tag('option', array('value'=>$dt['item']),CHtml::encode($dt['itemname']),true);
		}
		echo CJSON::encode(array('sites'=>$st));			
	}
	public function actionItemo() {
		$s=app()->db->createCommand("SELECT sum(amount) amt from bc_itembudgets where budget=".budget()." and section=".$_REQUEST['BcReallocation']['tosection']."  and item=".$_REQUEST['BcReallocation']['toitem'])->queryScalar();
	echo CJSON::encode(array('sites'=>number_format($s)));		
	}
	public function actionItemf() {
		$s=app()->db->createCommand("SELECT sum(amount) amt from bc_itembudgets where budget=".budget()." and section=".$_REQUEST['BcReallocation']['fromsection']."  and item=".$_REQUEST['BcReallocation']['fromitem'])->queryScalar();
	echo CJSON::encode(array('sites'=>number_format($s)));		
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new BcReallocation;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['BcReallocation']))
		{
			$model->attributes=$_POST['BcReallocation'];
			if($model->save()) {
				$as=array(
					'reallocation'				=>$model->id,
					'approver_id'				=>user()->id,
					'approver_role'			=>'CREATE',
					'decision'					=>'CREATE',
					'comments'				=>$_POST['BcReallocation']['justification'],
					'approver_level'			=>1,
					'nextapprover_role'		=>"APPROVE",
					'nextapprover_level'		=>2
				);
				$m2=new BcBudgetapprovals;
				$m2->attributes=$as;
				if(!$m2->save()) dump($m2->getErrors());
				
				$this->redirect(array('view','id'=>$model->id));
			}
				
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
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['BcReallocation']))
		{
			$model->attributes=$_POST['BcReallocation'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
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
		$dataProvider=new CActiveDataProvider('BcReallocation');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new BcReallocation('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['BcReallocation']))
			$model->attributes=$_GET['BcReallocation'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return BcReallocation the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=BcReallocation::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param BcReallocation $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='bc-reallocation-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
