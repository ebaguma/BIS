<?php

class SettingsController extends Controller
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
		if(is_sys_admin() || is_sat() || is_pbfo()) {
			$a[]=Yii::app()->user->name;
		}
		return array(
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('budgetaddition','update','admin','view','salaryindex','move1'),
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
	public function actionSalaryindex($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Settings']))
		{
			$model->attributes=$_POST['Settings'];
			if($model->save()) {
				echo "updating salary index with ".$_POST['Settings']['value'];
				$c=app()->db->createCommand("update `items_prices_view` set price=price*".$_POST['Settings']['value']." WHERE budget='".budget()."' and accountcode in (72,73,87,82,76,79,81,90,78,92,83,105)")->execute();
				$this->redirect(array('view','id'=>$model->id));
			}
		}

		//Update salary index
		//$c=app()->db->createCommand("select * from items_prices_view ")->queryAll();
		$this->render('salaryindex',array(
			'model'=>$model,
		));
	}

	public function actionView($id)
	{
		$this->render('view',array('model'=>$this->loadModel($id)));
	}

	public function actionBudgetaddition()
	{

		if($_REQUEST['item'] && $_REQUEST['dept']) {

			$w2=app()->db->createCommand("select sum(amount) am,accountcode a from v_budget where item='".$_REQUEST['item']."' and budget=".budget()." and dept=".$_REQUEST['dept'])->queryAll();

			$budgt=app()->db->createCommand("select amount a from bc_itembudgets where item='".$_REQUEST['item']."' and budget=".budget()." and section=".$_REQUEST['dept']." and reason=1")->queryAll();

			if($w2[0][am] <> $budgt[0][a]) {
				$addition=$w2[0][am]-$budgt[0][a];
				app()->db->createCommand("insert into bc_itembudgets (item,section,amount,budget,reason,status,dateadded,addedby,updated_at,updated_by) values('".$_REQUEST['item']."','".$_REQUEST['dept']."','".$addition."','".budget()."','1','COMMITED',NOW(),'".user()->id."',now(),".user()->id.")")->execute();

				//echo "insert into bc_itembudgets (item,section,amount,budget,reason,status,dateadded,addedby) values('".$_REQUEST['item']."','".$_REQUEST['dept']."','".$addition."','".budget()."','1','COMMITTED',NOW(),'".user()->id."')";
				//exit;
			}
		}
		$this->render('budgetaddition');
	}
	public function actionMove1()
	{
	//	die(user()->id);
	//	exit;
		if($_POST['acccode']) {
			$c=app()->db->createCommand("SELECT sum(amount) a,section,sectionname,accountitem from v_bc_itembudgets where budget=".budget()." and reason=1 and accountid=".$_POST['acccode']." group by section")->queryAll();
			foreach($c as $cc) {
				$atts=array('accountcode'=>$_POST['acccode'],'name'=>$cc['accountitem']." for ".$cc['sectionname']);
				$item=Items::model()->findByAttributes($atts);
				if(!$item) {
					$item=new Items;
					$item->attributes=$atts;
					if(!$item->save()) die("Could not save item!!");
					$item=Items::model()->findByAttributes($atts);
				} else
					print("Account already consolindated!! ");

				$c2=app()->db->createCommand("delete from bc_itembudgets where budget=".budget()." and reason=1 and item in (select id from items where accountcode=".$_POST['acccode'].") and section=".$cc['section'])->execute();
				$c3=app()->db->createCommand("INSERT INTO bc_itembudgets (item,amount,section,budget,reason,dateadded,addedby,updated_by,updated_at) values('".$item->id."','".$cc['a']."','".$cc['section']."','".budget()."','1',now(),'".user()->id."','".user()->id."',now())")->execute();
				$moved=1;
			}
		}
		$this->render('move1',array('moved'=>$moved));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Settings;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Settings']))
		{
			$model->attributes=$_POST['Settings'];
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
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Settings']))
		{
			$model->attributes=$_POST['Settings'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		//Update salary index
//		$c=app()->db->createCommand("select * from items_prices_view ")->queryAll();

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
		//$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Settings');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Settings('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Settings']))
			$model->attributes=$_GET['Settings'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Settings the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Settings::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Settings $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='settings-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
