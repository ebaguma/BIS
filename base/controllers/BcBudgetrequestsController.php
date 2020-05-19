<?php

class BcBudgetrequestsController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/column2';

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
		$a = ['admin'];
		if (is_sat() or is_pbfo()) $a[] = user()->details['username'];
		return array(
			array(
				'allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions' => array('index', 'view', 'admin', 'create', 'print', 'email'),
				'users' => array('@'),
			),
			array(
				'allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions' => array('capture', 'reverse', 'rejected'),
				'users' => $a,
			),
			array(
				'deny',  // deny all users
				'users' => array('*'),
			),
		);
	}

	protected function gridDataColumn($data, $row)
	{
		$mm = app()->db->createCommand("select * from v_bc_approvals where request='" . $data->id . "' order by approverdate desc limit 1")->queryAll();
		$st = array(
			"REJECT"		=> "Rejected",
			"CREATE"		=> "Created",
			"APPROVE"	=> "Approved",
			"RE-ASSIGN"	=> "Re-Assigned",
			"QUERY"		=> "Queried"
		);
		if ($mm['0']['decision'])
			return $st[$mm['0']['decision']] . " by " . $mm['0']['approver_rolealias'];
		return "Status Not Found";
	}

	public function actionReverse()
	{
		if ($_REQUEST['item'] && $_REQUEST['requestid']) {
			$commited_funding = app()->db->createCommand("SELECT count(*) from bc_itembudgets where reasonid='" . $_REQUEST['requestid'] . "' and item='" . $_REQUEST['item'] . "' and status='COMMITED'")->queryScalar();
			if ($commited_funding)
				$reversed = app()->db->createCommand("SELECT count(*) from bc_itembudgets where reasonid='" . $_REQUEST['id'] . "' and item='" . $_REQUEST['item'] . "'  and reason=7")->queryScalar();
			if ($reversed) $commited_funding = 0;

			if ($commited_funding && !$reversed) {
				if ($_POST['reverse'] && $_POST['section']) {
					$maxrev = app()->db->createCommand("SELECT * from bc_itembudgets where reasonid='" . $_REQUEST['requestid'] . "' and item='" . $_REQUEST['item'] . "' and section='" . $_REQUEST['section'] . "' and status='COMMITED'")->queryAll();
					if ($_POST['reverse'] > 0 && $_POST['reverse'] <= ($maxrev[0]['amount'] * -1)) {
						$spend[] = array(
							'item' 		=> $_REQUEST['item'],
							'section' 	=> $_POST['section'],
							'amount'	=> $_REQUEST['reverse'],
							'budget'	=> budget(),
							'reason'	=> 7,
							'status'	=> 'COMMITED',
							'reasonid'	=> $_REQUEST['requestid'],
							'dateadded' => date('Y-m-d H:i:s'),
							'updated_at' => date('Y-m-d H:i:s'),
							'addedby'	=> user()->id,
							'updated_by'	=> user()->id,
						);
					}
					if (count($spend)) GeneralRepository::insertSeveral('bc_itembudgets', $spend);
				}
				$this->render('reverse', array('model' => $this->loadModel($_REQUEST['requestid'])));
			}
		}
	}
	public function actionCapture()
	{

		if ($_POST) { //dump($_POST);
			$m = new BcBudgetrequests;
			$m->attributes = array(
				'accountcode' => $_POST['accountcode'],
				'section'		=> $_POST['section'],
				'ppform'		=> '100',
				'subject'		=> $_POST['subject'],
				'justification'	=> $_POST['justification'],
			);
			if (!$m->validate())  dump($m);
			if ($m->validate() && $m->save()) {
				foreach ($_POST['ProcurementItems']['item'] as $i => $v) {
					if ($_POST['ProcurementItems']['price'][$i] > 0 && $_POST['ProcurementItems']['quantity'][$i] > 0) {
						$values[] = array(
							"request"	=> $m->id,
							"item" 	=> $v,
							//						'dateadded'=>date('Y-m-d H:i:s'),
							"quantity" => $_POST['ProcurementItems']['quantity'][$i],
							"price"	=> $_POST['ProcurementItems']['price'][$i]
						);
						$spend[] = array(
							'item' 		=> $v,
							'section' 	=> $_POST['section'],
							'amount'	=> ((int) $_POST['ProcurementItems']['quantity'][$i] * (int) $_POST['ProcurementItems']['price'][$i] * -1),
							'budget'	=> budget(),
							'reason'	=> 6,
							'status'	=> 'COMMITED',
							'reasonid'	=> $m->id,
							'dateadded' => date('Y-m-d H:i:s'),
							'addedby'	=> user()->id,
						);
					} //else $msg="Zeros not allowed!";
				}
				if (count($values)) GeneralRepository::insertSeveral('bc_budgetrequest_items', $values);
				if (count($spend)) GeneralRepository::insertSeveral('bc_itembudgets', $spend);
				$msg = "The Budget has been updated accordingly. Please access the reports to see the new figures";
			} else {
				echo $m->getErrors();
			}
		}
		$this->render('capture', array('message' => $msg, 'model' => $model));
	}

	public function actionPrint($id)
	{
		$this->layout = '//layouts/print';
		$this->render('viewprint', array('model' => $this->loadModel($id)));
	}
	public function actionView($id = 0)
	{
		if ($_POST['c'] && is_array($_POST['c']) && $_POST['decision']) {
			$decs = ['REJECT' => 'Rejected', 'APPROVE' => 'Approved'];
			foreach ($_POST['c'] as $cc) {
				$this->approve($decs[$_POST['decision']] . ' by Mass Action', $_POST['decision'], $cc);
			}
			$this->redirect('index.php?r=bcBudgetapprovals/admin&msg=The items have been ' . $decs[$_POST['decision']]);
		}
		$this->approve($_POST['comments'], $_POST['decision'], $_POST['id'], $_POST['emp']);
		$this->render('view', array('model' => $this->loadModel($id)));
	}

	private function approve($comments, $decision, $id, $emp = 0)
	{
		//		echo "NO!";exit;
		$validdecisions = array('RE-ASSIGN', 'APPROVE', 'REJECT', 'QUERY', 'REPLY');
		if (!empty($comments) && in_array($decision, $validdecisions) && $id) {
			$fwded = array();
			if (!cancomment($id)) {
				throw new CHttpException(403, 'Permission Denied');
				exit;
			}
			if (($decision == 'RE-ASSIGN' or $decision == 'APPROVE' or $decision == 'REJECT') and !canapprove($id)) {
				throw new CHttpException(403, 'Forbidden!');
				exit;
			}
			$m = BcBudgetapprovals::model()->findByAttributes(array('request' => $id, 'nextapprover_done' => NULL));
			$m->nextapprover_done = 1;
			if (!$m->save()) {
				echo "Failed to Save! Please report this error to the administrator";
				dump($m->getErrors());
			}
			$decsn = $decision == "REPLY" ? "QUERY" : $decision;
			$m2 = new BcBudgetapprovals;
			$newApproval = array(
				'request'			=> $id,
				'approver_id'		=> user()->id,
				'decision'			=> $decsn,
				'comments'		=> $comments,
				'approver_level'	=> $m->nextapprover_level,
				'approver_role'	=> $m->nextapprover_role
			);
			$mail = new YiiMailer();
			$mail->setFrom(user()->details['email'], user()->details['names']);

			switch ($decision) {
				case "APPROVE":
					$nxtLevel = $m->nextapprover_level + 1;
					$mm = app()->db->createCommand("select * from bc_workflow_stages where workflow=(select workflow from v_bc_approvals where request='" . $id . "' limit 1) and stage='" . $nxtLevel . "'")->queryAll();
					if ($mm[0]) {
						$newApproval['nextapprover_role'] = "APPROVE";
						$newApproval['nextapprover_level'] = $nxtLevel;

						$nextapprover_actual = app()->db->createCommand("select * from v_users_roles_active where role=(select approver from v_workflow_stages where workflow=(select workflow from v_bc_approvals where request='" . $id . "' limit 1) and stage=" . $nxtLevel . ")")->queryAll();
						foreach ($nextapprover_actual as $a) {
							$okay = preg_match(
								'/^[A-z0-9_\-\.]+[@][A-z0-9_\-]+([.][A-z0-9_\-]+)+[A-z.]{2,4}$/',
								$a['email']
							);
							if ((
								(
									($a['alias'] === 'HOS' &&  $a['sectionid'] === section()) ||
									($a['alias'] === 'HOD' &&  $a['deptid'] === dept())) ||
								($a['alias'] != 'HOS' && $a['alias'] != 'HOD')) && $okay) {
								$fwded[] = $a['names'];
								// echo "sending to ".$a['email']."<br/>";
								$aa = "
								Dear $a[names],<br/>

								<p>In your capacity has the $a[rolename] ($a[alias]), you are requested to take action on the budget check request below. Kindly click the link below access the request.</p>
								<p>" . CHtml::link('View Budget Check Request', $this->createAbsoluteUrl('bcBudgetrequests/view', array('id' => $id))) . "</p>

								<p>Regards,<br/>
								BIS Admin	</p>
								";
								$mailtitle = 'Request for Approval';
								$mail->setData(array('message' => $aa, 'description' => 'BIS Budget Check: ' . $mailtitle));
								$mail->setTo($a['email']);
								$mail->setSubject('BIS Budget Check: ' . $mailtitle);
								// if(!$mail->send()) print ($mail->getError());
							}
						}
					} else {
						app()->db->createCommand("update bc_itembudgets set status='COMMITED',updated_at=now(),updated_by=" . user()->id . " where reasonid=$id and status='PENDING' and reason='3'")->execute();
						//echo "update bc_itembudgets set status='COMMITED',updated_at=now(),updated_by=".user()->id." where reasonid=$id and status='PENDING' and reason='3'";
					}
					// get email recipients

					break;
				case "QUERY":
					if (!$emp) {
						throw new CHttpException(403, "You did not select an employeee to assign to. Please go back and try again");
						exit;
					}
					$newApproval['nextapprover_role']	= "QUERY";
					$newApproval['nextapprover_id']		= $emp;
					$newApproval['nextapprover_level']	= $m->nextapprover_level;
					$mailtitle = 'Query';


					break;
				case "REPLY":
					$newApproval['nextapprover_role']	= $m->approver_role;
					$newApproval['nextapprover_id']		= $m->approver_id;
					$newApproval['nextapprover_level']	= $m->approver_level;
					$mailtitle = 'Reply';


					break;
				case "RE-ASSIGN":
					if (!$emp) {
						throw new CHttpException(403, "You did not select an employeee to assign to. Please go back and try again");
						exit;
					}
					$newApproval['nextapprover_role']	= "RE-ASSIGN";
					$newApproval['nextapprover_id']		= $emp;
					$newApproval['nextapprover_level']	= $m->nextapprover_level;
					$mailtitle = 'Re-Assignment';


					break;
				case "REJECT":
					app()->db->createCommand("delete from bc_itembudgets where  reasonid=$id and status='PENDING' and reason='3'")->execute();
					$mailtitle = "Rejection";
					break;
			}
			$m2->attributes = $newApproval;
			if (!$m2->save()) {
				echo "failed to save! the next approver will NOT be able to approve. Please send this error to the administrator";
				dump($m2->getErrors());
			}

			if ($newApproval['nextapprover_id']) {
				$nextapprover_actual = app()->db->createCommand("select * from users where id=" . $newApproval['nextapprover_id'])->queryAll();
				foreach ($nextapprover_actual as $a) {
					$okay = preg_match('/^[A-z0-9_\-\.]+[@][A-z0-9_\-]+([.][A-z0-9_\-]+)+[A-z.]{2,4}$/', $a['email']);
					if ($okay) {
						$fwded[] = $a['names'];
						$aa = "
						Dear $a[names],<br/>

						<p>You are requested to take action on the budget check request below. Kindly click the link below to access the request.</p>
						<p>" . CHtml::link('View Budget Check Request', $this->createAbsoluteUrl('bcBudgetrequests/view', array('id' => $id))) . "</p>
						<p>Regards,<br/>
						BIS Admin	</p>
						";
						$mail->setData(array('message' => $aa, 'description' => 'BIS Budget Check: ' . $mailtitle));
						$mail->setTo($a['email']);
						$mail->setSubject('BIS Budget Check: ' . $mailtitle);
						// if(!$mail->send()) print($mail->getError());

						// EDWIN: 18/05/2020 Redirect to Approvals
						$this->redirect('index.php?r=bcBudgetapprovals/admin');
					}
				}
			}

			$okay = preg_match('/^[A-z0-9_\-\.]+[@][A-z0-9_\-]+([.][A-z0-9_\-]+)+[A-z.]{2,4}$/', $m->request0->requestor0->email);
			if ($okay) {
				$aa = "
					Dear " . $m->request0->requestor0->names . ",<br/>

					<p>Your budget check request has been forwarded to the following:</p>" . implode($fwded, "; ") . "<p> Kindly click the link below to view the current status.</p>
					<p>" . CHtml::link('View Budget Check Request', $this->createAbsoluteUrl('bcBudgetrequests/view', array('id' => $id))) . "</p>
					<p>Regards,<br/>
					BIS Admin	</p>
					";
				$mail->setData(array('message' => $aa, 'description' => 'BIS Budget Check: ' . $mailtitle));
				$mail->setTo($m->request0->requestor0->email);
				$mail->setSubject('BIS Budget Check: ' . $mailtitle);
				// if(!$mail->send()) print($mail->getError());
			}
		}

		$model = BcBudgetrequests::model()->findByPk($id);
		$images = CUploadedFile::getInstancesByName('appendix');
		if (isset($images) && count($images) > 0) {
			foreach ($images as $image => $pic) {
				if (!$pic->saveAs(Yii::getPathOfAlias('webroot') . '/appendix/bc' . Yii::app()->user->budget['id'] . '/' . Yii::app()->user->id . '-' . $model->id . '-' . $m2->id . '-' . $pic->name)) {
					die("Could not save " . $pic->name . ". Please contact the administrator<br>");
				}
			}
		}
	}
	public function actionEmail()
	{
		$mail = new YiiMailer();
		$mail->setData(array('message' => 'testt', 'description' => 'BIS Budget Check: Request for Approval'));
		$mail->setFrom(user()->details['email'], user()->details['names']);
		$mail->setTo('bisadmin@uetcl.com');
		$mail->setSubject('BIS Budget Check: Request for Approval');
		// if(!$mail->send()) print($mail->getError());

	}
	public function actionCreate()
	{
		$model = new BcBudgetrequests;
		//	echo "<pre>";print_r($_POST);

		if (isset($_POST['BcBudgetrequests'])) {
			$items_submitted = [];
			foreach ($_POST['ProcurementItems']['item'] as $i => $v) {

				if (in_array($v, $items_submitted))
					throw new CHttpException(403, "Duplicate items not allowed.");
				$items_submitted[] = $v;

				$requested = $_POST['ProcurementItems']['price'][$i] * $_POST['ProcurementItems']['quantity'][$i];
				if ($requested < 1) {
					throw new CHttpException(403, "Requested Amount is below the minimum");
					die("Requested Amount for <b>" . $budget[0]['itemname'] . "</b> is greater than available budget.");
				}

				$budget = app()->db->createCommand("select sum(amount) a,itemname from v_bc_itembudgets where item='" . $v . "' and budget=" . budget())->queryAll();
				//echo $budget[0]['a'].$budget[0]['itemname'];
				$requested = $_POST['ProcurementItems']['price'][$i] * $_POST['ProcurementItems']['quantity'][$i];
				if ($requested > $budget[0]['a']) {
					throw new CHttpException(403, "Requested Amount for " . $budget[0]['itemname'] . " (UGX " . number_format($requested) . "/=) is greater than available budget (UGX " . number_format($budget[0]['a']) . "/=)");
					die("Requested Amount for <b>" . $budget[0]['itemname'] . "</b> is greater than available budget.");
				}
			}

			$_POST['BcBudgetrequests']['accountcode'] = $_POST['accountcode'];
			$this->performAjaxValidation($model);
			$model->attributes = $_POST['BcBudgetrequests'];
			// /			$model->accountcode=$_POST['accountcode'];
			if ($model->save()) {
				foreach ($_POST['ProcurementItems']['item'] as $i => $v) {
					if ($_POST['ProcurementItems']['quantity'][$i] > 0 && $_POST['ProcurementItems']['price'][$i] > 0) {
						$values[] = array(
							"request"		=> $model->id,
							"item" 		=> $v,
							"quantity"	=> $_POST['ProcurementItems']['quantity'][$i],
							"price"		=> $_POST['ProcurementItems']['price'][$i]
						);
						$spend[] = array(
							'item' 		=> $v,
							'section' 	=> section(),
							'amount'	=> ((int) $_POST['ProcurementItems']['quantity'][$i] * (int) $_POST['ProcurementItems']['price'][$i] * -1),
							'budget'	=> budget(),
							'reason'	=> 3,
							'reasonid'	=> $model->id,
							'status'	=> 'PENDING',
							'addedby'	=> user()->id,
							'dateadded' => date('Y-m-d H:i:s'),
							'updated_by'	=> user()->id,
							'updated_at' => date('Y-m-d H:i:s'),

						);
					}
				}
				if (count($values)) GeneralRepository::insertSeveral('bc_budgetrequest_items', $values);
				if (count($spend)) GeneralRepository::insertSeveral('bc_itembudgets', $spend);

				//Get the correct workflow and see who is the first approver
				if (!count($values)) die("not a valid request.");
				$nextapprover_actual = app()->db->createCommand("select * from v_users_roles_active where role=(select approver from v_workflow_stages where workflow=(select workflow from bc_workflows_accountcodes where accountcode='" . $_POST['accountcode'] . "' and budget='" . user()->budget['id'] . "') and stage=2)")->queryAll();
				//echo "select * from v_users_roles_active where role=(select approver from v_workflow_stages where workflow=(select workflow from bc_workflows_accountcodes where accountcode='".$_POST['accountcode']."' and budget='".user()->budget['id']."') and stage=2)";
				//	echo $nextapprover_title[0][approver];
				foreach ($nextapprover_actual as $a) {
					//dump($a,false);
					$okay = preg_match(
						'/^[A-z0-9_\-\.]+[@][A-z0-9_\-]+([.][A-z0-9_\-]+)+[A-z.]{2,4}$/',
						$a['email']
					);
					if ((
						(
							($a['alias'] === 'HOS' &&  $a['sectionid'] === section()) ||
							($a['alias'] === 'HOD' &&  $a['deptid'] === dept())) ||
						($a['alias'] != 'HOS' && $a['alias'] != 'HOD')) && $okay) {
						//dump($a,false);
						$aa = "
						Dear $a[names],<br/>

						<p>In your capacity as the $a[rolename] ($a[alias]), you are requested to take action on the budget check request below. Kindly click the link below to access the request.</p>

						<p>" . CHtml::link('View Budget Check Request', $this->createAbsoluteUrl('bcBudgetrequests/view', array('id' => $model->id))) . "</p>

						<p>Regards,<br/>
						BIS Admin	</p>
						";
						$mail = new YiiMailer();
						$mail->setData(array('message' => $aa, 'description' => 'BIS Budget Check: Request for Approval'));
						$mail->setFrom(user()->details['email'], user()->details['names']);
						$mail->setTo($a['email']);
						$mail->setSubject('BIS Budget Check: Request for Approval');
						// if(!$mail->send()) print($mail->getError());
					}
				}
				//}
				$as = array(
					'request'					=> $model->id,
					'approver_id'				=> user()->id,
					'approver_role'			=> 'CREATE',
					'decision'					=> 'CREATE',
					'comments'				=> $_POST['BcBudgetrequests']['justification'],
					'approver_level'			=> 1,
					'nextapprover_role'		=> "APPROVE",
					'nextapprover_level'		=> 2
				);
				$m2 = new BcBudgetapprovals;
				$m2->attributes = $as;
				if (!$m2->save()) 	 dump($m2->getErrors());

				$images = CUploadedFile::getInstancesByName('appendix');
				if (isset($images) && count($images) > 0) {
					foreach ($images as $image => $pic) {
						if (!$pic->saveAs(Yii::getPathOfAlias('webroot') . '/appendix/bc' . Yii::app()->user->budget['id'] . '/' . Yii::app()->user->id . '-' . $model->id . '-' . $m2->id . '-' . $pic->name)) {
							die("Could not save " . $pic->name . ". Please contact the administrator<br>");
						}
					}
				}

				$this->redirect(array('view', 'id' => $model->id));
			}
		}
		$this->render('create', array('model' => $model));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */

	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if (isset($_POST['BcBudgetrequests'])) {
			$model->attributes = $_POST['BcBudgetrequests'];
			if ($model->save())
				$this->redirect(array('view', 'id' => $model->id));
			//$this->redirect('index.php?r=bcBudgetapprovals/admin');
		}

		//		$this->render('update',array('model'=>$model));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		//		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if (!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider = new CActiveDataProvider('BcBudgetrequests');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model = new BcBudgetrequests('search');
		$model->unsetAttributes();  // clear any default values
		if (isset($_GET['BcBudgetrequests']))
			$model->attributes = $_GET['BcBudgetrequests'];
		$this->render('admin', array('model' => $model));
	}

	public function actionRejected()
	{
		$this->render('rejected', array('model' => new BcBudgetrequests()));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return BcBudgetrequests the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model = BcBudgetrequests::model()->findByPk($id);
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param BcBudgetrequests $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if (isset($_POST['ajax']) && $_POST['ajax'] === 'bc-budgetrequests-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
