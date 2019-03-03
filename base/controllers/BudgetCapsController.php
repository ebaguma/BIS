<?php

class BudgetCapsController extends Controller
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
		if (is_finance_officer())
			$heads[]=Yii::app()->user->name;
		
		return array(
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create'),
				'users'=>$heads,
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

	public function actionCreate()
	{
		$model=new BudgetCaps;
		if(isset($_POST['cap'])) {
			$lim=array();
			foreach($_POST[cap] as $dep=>$acc) {
				foreach ($acc as $code=>$item) {	
					$bd=BudgetCaps::model()->findByAttributes(array('budget'=>budget(),'dept'=>$dep,'accountcode'=>$code));
					if($bd==null) $bd=new BudgetCaps;
					//$bd->unsetAttributes(array('updatedate'));
					if(!$item) $item=0;
					$bd->attributes= array(
					'updatedate'		=>date('Y-m-d'),
					'budget' 			=>budget(),
					'dept'				=>$dep,
					'accountcode'	=>$code,
					'cap'				=>$item,
					'updatedby'		=>user()->id,
					);
					$bd->save();
				}
			}
		}

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

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['BudgetCaps']))
		{
			$model->attributes=$_POST['BudgetCaps'];
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
		$dataProvider=new CActiveDataProvider('BudgetCaps');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new BudgetCaps('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['BudgetCaps']))
			$model->attributes=$_GET['BudgetCaps'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return BudgetCaps the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=BudgetCaps::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param BudgetCaps $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='budget-caps-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
