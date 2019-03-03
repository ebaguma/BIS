<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}
		 public function actionBudget()
	 	{
	 		$sp=Yii::app()->db->createCommand("select id from budgets where current='Yes'")->queryAll();
	 		$budget=$sp[0]['id'];
	 		$sp=Yii::app()->db->createCommand("select sum(amount) a from v_bc_itembudgets where budget=".$budget." and  reason in (3,6) and status='COMMITED' and accountcode not regexp '^3'")->queryAll();

	 		$bspent=(float)$sp[0][a]*-1;

	 		$tbudget= Yii::app()->db->createCommand('select sum(amount) a from v_budget where  budget='.$budget."  and accountid not regexp '^3'")->queryAll();
	 		foreach($tbudget as $cds) {
	 			$btotal+=$cds[a];
	 		}
	 			echo json_encode(array('budget'=>$btotal,'spent'=>$bspent));//.'  '.$btotal;
	 	}
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionT() {
		
		$mail = new YiiMailer();
		//$mail->setView('contact');
		$mail->setData(array('message' => 'Message to send', 'description' => 'Request for Approval'));
		$mail->setFrom('wilson@uetcl.com', 'Wilson Abigaba');
		$mail->setTo('bisadmin@uetcl.com');
		$mail->setSubject('Mail subject');
		
		if ($mail->send()) {
		    echo "mail sent..";
			Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
		} else {
			die($mail->getError());
		    Yii::app()->user->setFlash('error','Error while sending email: '.$mail->getError());
		}			
		
		die("nkugambye");
		
		$message = new YiiMailMessage;
			$message->setBody('<h1>mets-blog.com</h1>','text/html');
			$message->subject = 'Service';
			$message->addTo('abigabaw@gmail.com');
			$message->from = 'your@email.com';
			Yii::app()->mail->send($message);
			echo "hahaha";
	}
	
	public function actionReports()	{	
		// test for login
		if($_REQUEST['print']==1) {
			$html2pdf = Yii::app()->ePdf->mPDF();
			$html2pdf->WriteHTML($this->renderPartial('reports', array(), true));
			// $html2pdf->Output('my_doc.pdf', 'D');
			$html2pdf->Output();
		} else
			$this->render('reports');	
	}
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		if(user()->isGuest)
			$this->redirect('?r=site/login');
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	public function actionExportDetails($c) {
		
		
		$ht="<table border=1>";
		$cs=Yii::app()->db->createCommand("select * from accountcodes where accountcode='".$c."'")->queryAll();
		$ht.="<h3> Details for ".$cs['0']['accountcode']."-".$cs['0']['item']."</h3>";		
		$codes=Yii::app()->db->createCommand("select * from v_budget where accountcode = '".$cs['0']['id']."'")->queryAll();		
		foreach($codes as $csd) {
			$ht.= "<tr><td>".$csd['descr']."</td><td>".$csd['amount']."</td></tr>";
			$tot+=$csd['amount'];
		}
		$ht.= "<tr><td><b>Total</b></td><td><b>".$tot."</b></td></tr>";
		$ht.="</table>";
		
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=report-$c.xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		print $ht;
		
	}
	
	public function actionEm()
	    {
			 
			 /*
	        # mPDF
	        $mPDF1 = Yii::app()->ePdf->mpdf();
 
	        # You can easily override default constructor's params
	     		//$mPDF1 = Yii::app()->ePdf->mpdf('', 'A5');
 
	        # render (full page)
	       //$mPDF1->WriteHTML($this->render('em', array(), true));
 
	        # Load a stylesheet
	        $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/main.css');
	        $mPDF1->WriteHTML($stylesheet, 1);
 
	        # renderPartial (only 'view' of current controller)
	        $mPDF1->WriteHTML($this->renderPartial('em', array(), true));
 
	        # Renders image
	        $mPDF1->WriteHTML(CHtml::image(Yii::getPathOfAlias('webroot.css') . '/bg.gif' ));
 
	        # Outputs ready PDF
	        $mPDF1->Output();
			 */
			 
		     $html2pdf = Yii::app()->ePdf->HTML2PDF();
		     $html2pdf->WriteHTML($this->renderPartial('', array(), true));
		    // $html2pdf->Output('my_doc.pdf', 'D');
			 $html2pdf->Output();
			 
	}
	

	public function actionExportReport($ac) {
		
		
		$ht="<table border=1>";
		$cs=Yii::app()->db->createCommand("select * from accountcodes where accountcode regexp '^".$ac."$'")->queryAll();				

		foreach($cs as $c) {
		$ht .="<tr><td><?php echo $c[accountcode]; ?></td><td colspan=2><?php echo $c[item];?></td></tr>";
		$total=0;
		$taccd=0;
		$codes=Yii::app()->db->createCommand("select * from accountcodes where accountcode regexp '^".$c[accountcode]."[0-9]{4}$'")->queryAll();				
		foreach($codes as $cd) {
			$bdgt=Yii::app()->db->createCommand("select sum(amount) a from budget where accountcode ='".$cd[id]."'")->queryAll();
			if($bdgt[0][a] > 0) { 
				$total += $bdgt[0][a];
				$taccd += $bdgt[0][a];
				$ht.= "<tr><td>".$cd[accountcode]."</td><td>".$cd[item]."</td><td>".$bdgt[0][a]."</td></tr>";
			}
		}

		$ht.="<tr><td colspan=2><b>Total</b></td><td><b>".number_format($taccd)."/=</b></td></tr>";

		}
		$ht.="</table>";
		
		header("Content-type: application/octet-stream");
		header("Content-Disposition: attachment; filename=report.xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		print $ht;
		
	}


	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-Type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		$lg=new Log();
		$lg->action="Logging out ".Yii::app()->user->details->username." had used passwd ".Yii::app()->user->passwd;
		$lg->addr=$_SERVER['REMOTE_ADDR'];
		$lg->host=$_SERVER['REMOTE_HOST'];
		$lg->browser=$_SERVER['HTTP_USER_AGENT'];
		$lg->created_by=Yii::app()->user->passwd;
		$lg->created_at=date("Y-m-d H:i:s");
		$lg->save();
		
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}
