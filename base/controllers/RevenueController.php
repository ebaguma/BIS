<?php

class RevenueController extends Controller
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
		if(is_finance_officer() || is_manager_finance() || is_sys_admin()) $a[]=user()->name;		
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('view','admin','delete'),
				'users'=>array('no one'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','revenuerequirement','createcosts','pl'),
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
	public function actionRevenuerequirement()
	{
		$model=new Revenue;
		if($_POST['tshld'] && $_POST['toffp'] && $_POST['tpeak'])
		{
			$q=app()->db->createCommand("SELECT * from v_revenue_sales where accountcode !='300002' and accountcode !='300003' and local=1 and budget=".budget())->queryAll();
			foreach($q as $cd) {
				$i=Items::model()->findByAttributes(array('name'=>'Energy Sales','accountcode'=>$cd[accountid]));	
				if($i==null) {
					$i=new Items;
					$i->attributes=array('name'=>'Energy Sales','accountcode'=>$cd[accountid]);
					$i->save();
					$i=Items::model()->findByAttributes(array('name'=>'Energy Sales','accountcode'=>$cd[accountid]));
				}
				$ip=ItemsPrices::model()->findByAttributes(array('item'=>$i->id,'budget'=>budget()));
				if($ip==null) $ip=new ItemsPrices;
				$ip->attributes=array('item'=>$i->id,'budget'=>budget(),'currency'=>1,'price'=>$_POST['tshld'],'createdby'=>user()->id,'cretaedon'=>date("Y-m-d"));
				$ip->save();
			}
			// Offpeak
			$q=app()->db->createCommand("SELECT * from v_revenue_sales where accountcode ='300002' and local=1 and budget=".budget())->queryAll();
			foreach($q as $cd) {
				$i=Items::model()->findByAttributes(array('name'=>'Energy Sales','accountcode'=>$cd[accountid]));	
				if($i==null) {
					$i=new Items;
					$i->attributes=array('name'=>'Energy Sales','accountcode'=>$cd[accountid]);
					$i->save();
					$i=Items::model()->findByAttributes(array('name'=>'Energy Sales','accountcode'=>$cd[accountid]));
				}
				$ip=ItemsPrices::model()->findByAttributes(array('item'=>$i->id,'budget'=>budget()));
				if($ip==null) $ip=new ItemsPrices;
				$ip->attributes=array('item'=>$i->id,'budget'=>budget(),'currency'=>1,'price'=>$_POST['tpeak'],'createdby'=>user()->id,'cretaedon'=>date("Y-m-d"));
				$ip->save();
			}
			//Peak
			$q=app()->db->createCommand("SELECT * from v_revenue_sales where accountcode ='300003' and local=1 and budget=".budget())->queryAll();
			foreach($q as $cd) {
				$i=Items::model()->findByAttributes(array('name'=>'Energy Sales','accountcode'=>$cd[accountid]));	
				if($i==null) {
					$i=new Items;
					$i->attributes=array('name'=>'Energy Sales','accountcode'=>$cd[accountid]);
					$i->save();
					$i=Items::model()->findByAttributes(array('name'=>'Energy Sales','accountcode'=>$cd[accountid]));
				}
				$ip=ItemsPrices::model()->findByAttributes(array('item'=>$i->id,'budget'=>budget()));
				if($ip==null) $ip=new ItemsPrices;
				$ip->attributes=array('item'=>$i->id,'budget'=>budget(),'currency'=>1,'price'=>$_POST['toffp'],'createdby'=>user()->id,'cretaedon'=>date("Y-m-d"));
				$ip->save();
			}
			
			
		}

		$this->render('createrequirement',array('model'=>$model));
	}
	public function actionView($id) {
		$this->render('view',array('model'=>$this->loadModel($id)));
	}
	public function actionPl() { $this->render('pl'); }

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreatecosts()
	{
		$model=new Revenue;
		if(isset($_POST['rev']))
		{
			foreach($_POST['rev'] as $rkey=>$rvalue) {
				
				$amt=substr($rkey,0,1);
				$acctcode=substr($rkey,1);
				$rv=Revenue::model()->findByAttributes(array('accountcode'=>$acctcode,'budget'=>user()->budget['id']));
				if($rv==null) {
					$rv=new Revenue;
					$rv->attributes=array('budget'=>user()->budget['id'],'accountcode'=>$acctcode);
				}
				$rv->attributes=array('amount'.$amt=>$rvalue);
				//dump($rv,false);
				$rv->save();
				
				$pr=ItemsPricesView::model()->findByAttributes(array('name'=>'Unit Price','budget'=>user()->budget['id']));
				$uc=$pr==null ? 1 : $pr->currencyid;
				$up=$pr==null ? 0 : $pr->price;
				$m=Items::model()->findByAttributes(array('accountcode'=>$acctcode,'name'=>'Q'.$amt));
				if($m==null) {
					$m=new Items;
					$m->attributes=array('accountcode'=>$acctcode,'name'=>'Q'.$amt);
					$m->save();
				}
				/*
				$ip=ItemsPrices::model()->findByAttributes(array('item'=>$m->id,'budget'=>user()->budget['id']));
				if($ip==null) {
					$ip=new ItemsPrices();
					$ip->attributes=array('item'=>$m->id,'budget'=>user()->budget['id'],'currency'=>$uc,'price'=>$up);
				} else
					$ip->attributes=array('price'=>$up);					
				$ip->save();
				
				$b=Budget::model()->findByAttributes(array('item'=>$m->id,'budget'=>user()->budget[id]));
				if($b==null) {
					$b=new Budget;
					$b->attributes=array('dateneeded'=>date('Y-m-d'),'descr'=>'cp','budget'=>user()->budget['id'],'dept'=>253,'item'=>$m->id,'qty'=>$rvalue,'tbl'=>'revenue','tblcolumn'=>'cp','createdby'=>1,'tblid'=>$rv->id,'createdon'=>date("Y-m-d"));
				} else
					$b->attributes=array('qty'=>$rvalue);
				$b->save();*/
			}
		}
		$this->render('createcosts',array('model'=>$model));
	}
	public function actionCreate()
	{
		$model=new Revenue;

		if(isset($_POST['rev']))
		{
			foreach($_POST['rev'] as $rkey=>$rvalue) {
				$amt=substr($rkey,0,1);
				$acctcode=substr($rkey,1);
				Yii::app()->db->createCommand("update revenue set amount".$amt."='".$rvalue."' where accountcode='".$acctcode."' and budget='".user()->budget['id']."'")->execute();
			}
		}

		$this->render('create',array('model'=>$model,
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

		if(isset($_POST['Revenue']))
		{
			$model->attributes=$_POST['Revenue'];
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
		$dataProvider=new CActiveDataProvider('Revenue');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Revenue('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Revenue']))
			$model->attributes=$_GET['Revenue'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Revenue the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Revenue::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Revenue $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='revenue-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
