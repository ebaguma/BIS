<?php

class TravelController extends Controller
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
		$a=array('adminn');
		if($_REQUEST['id']) {
			$m=Travel::model()->findByAttributes(array('id'=>$_REQUEST['id']));
			if(in_array($m->createdby,sectionmates())) $a[]=Yii::app()->user->name;
		}
//		print_r($a);
		return array(
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','admin'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('delete','update','view'),
				'users'=>$a,
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array('model'=>$this->loadModel($id)));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Travel;
		$this->performAjaxValidation($model);
		if(isset($_POST['Travel'])) 
			$this->saveModel();
		else 
			$this->render('create',array('model'=>$model));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		$this->performAjaxValidation($model);
		if(isset($_POST['Travel']))
			$this->saveModel($id);
		else 
			$this->render('update',array('model'=>$model));
	}
	public function saveModel($id=0) {
		if($id > 0)
			$model=$this->loadModel($id);	
		else
			$model=new Travel;
		
		if(budget_locked()) { $this->render('/site/locked'); exit; } 
		//$model->validate();
		
		TravelDetails::model()->deleteAll("training='".$id."'");
		Budget::model()->deleteAll("tbl='travel' AND tblid='".$id."'");			
		$model->attributes=$_POST['Travel'];
		if($model->save()) {
			
			$acctcode=$model->mission=='TrainingTravel' ? 103 : 113;
			Yii::app()->db->createCommand("delete from items_prices  where item in (select id from items where accountcode= '".$acctcode."' and name like '".$model->id." - %') and budget='".user()->budget['id']."'")->execute();
			Yii::app()->db->createCommand("delete from items where accountcode= '".$acctcode."' and name like '".$model->id." - %'")->execute();
			$values = $bgt = array();	
			$ii=0;
			$alr=array();
			if(count($_POST['TravelDetails']['item'])) {
			foreach ($_POST['TravelDetails']['item'] as $v) {
				if(!in_array($v,$alr)) {
					$alr[]=$v;
				$amt=intval($_POST['TravelDetails']['amount'][$ii]);
				$cur=intval($_POST['TravelDetails']['cur'][$ii]);
				if($amt > 0 ) {
					$values[] = array(
						"training"		=> $model->id,
						"item" 		=> $v,
						"amount"		=> $amt,
						"currency"	=> $cur
					);
					$it=Yii::app()->db->createCommand("SELECT item from travel_items where id=$v")->queryAll();
					$em=Yii::app()->db->createCommand("SELECT employee from employees where id=$model->employee")->queryAll();
					$itemdesc=$model->id." - ".$em['0']['employee']." - ".$model->course." - ".$it['0']['item'];
					Yii::app()->db->createCommand("insert into items (accountcode,name) values ('".$acctcode."','".strip($itemdesc)."')")->execute();
					Yii::app()->db->createCommand("insert into items_prices (item,budget,price,currency,insertby) values ((select id from items where accountcode='".$acctcode."' and name='".strip($itemdesc)."'),'".user()->budget['id']."','".$amt."','".$cur."',1)")->execute();
					$myitemid=Yii::app()->db->createCommand("select id from items where accountcode= '".$acctcode."' and name like '".strip($itemdesc)."'")->queryAll();
					//die($myitemid[0][id]);
					//)
					$bgt[] = array(
						"item"			=>$myitemid[0][id],
						"budget" 		=>	Yii::app()->user->budget['id'],
						"descr"		=>	$em['0']['employee']." - ".$model->course." - ".$it['0']['item'],
						"dept"		=>	Yii::app()->user->details['dept'],
						"qty"			=>	1,
						"createdby"	=> Yii::app()->user->details['id'],
						"tbl"			=>	"travel",
						"dateneeded"	=> $model->traveldate,
						//"column"	=>  "",
						"tblid"			=>	$model->id,
					);
					$ii++;
				}
			}
		}
	}
			if($values) GeneralRepository::insertSeveral('travel_details', $values);
			if($bgt) GeneralRepository::insertSeveral('budget', $bgt);
			$this->redirect(array('view','id'=>$model->id,'m'=>$model->mission));
		} else
			$this->render('update',array('model'=>$model));
	}
	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		TravelDetails::model()->deleteAll('training='.$id);
		Budget::model()->deleteAll("tbl='travel' AND tblid=".$id);
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
		$dataProvider=new CActiveDataProvider('Travel');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Travel('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Travel']))
			$model->attributes=$_GET['Travel'];
		$this->render('admin',array('model'=>$model));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Travel the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Travel::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Travel $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='travel-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	function oldCreateCode() {
		
		if(budget_locked()) { $this->render('/site/locked'); exit; } 
		$model->attributes=$_POST['Travel'];			
		if($model->save()) {
			$acctcode=$model->mission=='TrainingTravel' ? 103 : 113;
			Yii::app()->db->createCommand("delete from items_prices  where item in (select id from items where accountcode= '".$acctcode."' and name like '".$model->id." - %') and budget='".user()->budget['id']."'")->execute();
			Yii::app()->db->createCommand("delete from items where accountcode= '".$acctcode."' and name like '".$model->id." - %'")->execute();
			$values = $bgt = array();	
			$ii=0;
			if(count($_POST['TravelDetails']['item']) >0) {
			foreach ($_POST['TravelDetails']['item'] as $v) {
				$amt=intval($_POST['TravelDetails']['amount'][$ii]);
				$cur=intval($_POST['TravelDetails']['cur'][$ii]);
				if($amt > 0 ) {
					$values[] = array(
						"training"		=> $model->id,
						"item" 		=> $v,
						"amount"		=> $amt,
						"currency"	=> $cur
					);
					$it=Yii::app()->db->createCommand("SELECT item from travel_items where id=$v")->queryAll();
					$em=Yii::app()->db->createCommand("SELECT employee from employees where id=$model->employee")->queryAll();
					$itemdesc=$model->id." - ".$em['0']['employee']." - ".$model->course." - ".$it['0']['item'];
					Yii::app()->db->createCommand("insert into items (accountcode,name) values ('".$acctcode."','".strip($itemdesc)."')")->execute();
					Yii::app()->db->createCommand("insert into items_prices (item,budget,price,currency,insertby) values ((select id from items where accountcode='".$acctcode."' and name='".strip($itemdesc)."'),'".user()->budget['id']."','".$amt."','".$cur."',1)")->execute();
					$myitemid=Yii::app()->db->createCommand("select id from items where accountcode= '".$acctcode."' and name like '".strip($itemdesc)."'")->queryAll();
					//die($myitemid[0][id]);
					//)
					$bgt[] = array(
						"item"			=>$myitemid[0][id],
						"budget" 		=>	Yii::app()->user->budget['id'],
						"descr"		=>	$em['0']['employee']." - ".$model->course." - ".$it['0']['item'],
						"dept"		=>	Yii::app()->user->details['dept'],
						"qty"			=>	1,
						//"amount"			=>	$amt,
						"createdby"	=> Yii::app()->user->details['id'],
						"tbl"			=>	"travel",
						"dateneeded"	=> $model->traveldate,
						//"column"	=>  "",
						"tblid"			=>	$model->id,
					);
					$ii++;
				}
			}}
			if($values) GeneralRepository::insertSeveral('travel_details', $values);
			if($bgt) GeneralRepository::insertSeveral('budget', $bgt);
			$this->redirect(array('view','id'=>$model->id,'m'=>$model->mission));
		}	
		
	}
}
