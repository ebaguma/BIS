<?php
/**
 * This is the shortcut to DIRECTORY_SEPARATOR
 */
defined('DS') or define('DS',DIRECTORY_SEPARATOR);
function dump($r,$e=true) {
	echo "<pre>";print_r($r);echo "</pre>";
	if($e==true) exit;
}
function sectionmates() {
	$ar=array();
	$sec=Users::model()->findAll('dept='.user()->dept['id']);
	foreach($sec as $s) $ar[]=$s[id];
	return $ar;
}
function cancomment($rec,$cn='request') {
//	echo "SELECT * from v_bc_approvals where request=".$rec." AND (nextapprover_id ='".user()->id."'  or nextapprover_rolealias in ('".implode(myroles(),"','")."')) and nextapprover_done is null";
//	exit;
	$c=app()->db->createCommand("SELECT * from v_bc_approvals where ".$cn."='".$rec."' AND (nextapprover_id ='".user()->id."'  or nextapprover_rolealias in ('".implode(myroles(),"','")."')) and nextapprover_done is null")->queryAll();
		if( 	count($c)==1 and (
			($c[0]['nextapprover_rolealias']=="HOS" && $c[0]['section_id']==section()) or
			($c[0]['nextapprover_rolealias']=="HOD" && $c[0]['dept_id']==user()->dept['department']) or
			$c[0]['nextapprover_id']==user()->id or
			in_array($c[0]['nextapprover_rolealias'],myotherroles())
		) )  return true;
			return false;
}
function canapprove($rec,$cn='request',$rolealias='') {

	$c=app()->db->createCommand("SELECT * from v_bc_approvals where
		".$cn."=".$rec." AND
			(nextapprover_role='APPROVE' or
			nextapprover_role='RE-ASSIGN' or
			 nextapprover_role is null ) AND
			 
			 (decision='APPROVE' or
			 decision='RE-ASSIGN' or
			 decision='QUERY' or
			 (decision='REJECT' and approver_id=".user()->id.") or
			 (decision='CREATE' and approver_level=1)) AND

			 (nextapprover_id ='".user()->id."'  or
			 nextapprover_rolealias in ('".implode(myroles(),"','")."')) and
	nextapprover_done is null")->queryAll();
	
		if( 	count($c)==1 and (
			($c[0]['nextapprover_rolealias']=="HOS" && $c[0]['section_id']==section()) or
			($c[0]['nextapprover_rolealias']=="HOD" && $c[0]['dept_id']==user()->dept['department']) or
			$c[0]['nextapprover_id']==user()->id or
			in_array($c[0]['nextapprover_rolealias'],myotherroles())
		) )  return true; 

	$c=app()->db->createCommand("SELECT * from v_bc_approvals where
		".$cn."=".$rec." AND
			(approver_role='APPROVE' or
			approver_role='RE-ASSIGN') AND

			 approver_id ='".user()->id."'  and
	nextapprover_done is null")->queryAll();
		if(count($c)==1)  return true; 
		
		$c=app()->db->createCommand("SELECT * from v_bc_approvals where nextapprover_done is null and nextapprover_role='QUERY' && approver_role='QUERY' and ".$cn."=".$rec)->queryAll();
		
		if(count($c) ==1) {

			$c2=app()->db->createCommand("SELECT * from v_bc_approvals where  ".$cn."=".$rec." and
		 (decision='APPROVE' or
		 decision='RE-ASSIGN' or
		 decision='QUERY' or
		 (decision='REJECT' and approver_id=".user()->id.") or
		 (decision='CREATE' and approver_level=1)) AND
			approver_rolealias='".$rolealias."'  and nextapprover_rolealias='".$rolealias."' order by id desc")->queryAll();
			
			if(count($c2) ==1) return true;
		}
		
		$c=app()->db->createCommand("SELECT count(*) from v_bc_approvals where nextapprover_done is null and nextapprover_role='QUERY' and ".$cn."=".$rec ." AND approver_rolealias in ('".implode(myotherroles(),"','")."')  and nextapprover_rolealias in ('".implode(myotherroles(),"','")."')")->queryScalar();
		
		if($c ==1) return true;
		 
		return false;
}

function strip($ss) {
	$str = preg_replace('/\'/', '', $ss);
	$str = preg_replace('/\"/', '', $str);
	$str = preg_replace('/\n/', '', $str);
	$str = preg_replace('/\>/', '', $str);
	$str = preg_replace('/\</', '', $str);
	return trim($str);
}
function myotherroles() {
	$rr=array();
	if(count(Yii::app()->user->roles)) {
		foreach(Yii::app()->user->roles as $r)
			if($r[alias] !="HOS" && $r[alias]!="HOD") $rr[]=$r[alias];
	}
	return $rr;
}
function myroles() {
	$rr=array();
	if(count(Yii::app()->user->roles)) {
		foreach(Yii::app()->user->roles as $r)
			$rr[]=$r[alias];
	}
	return $rr;
}
function budget($name='id') {
	return Yii::app()->user->budget[$name];
}
function section() {
	return Yii::app()->user->dept['id'];
}
function dept() {
	return Yii::app()->user->dept['department'];
}
function budget_locked() {
	return isset(Yii::app()->user->settings['BUDGET_LOCK_'.budget('name')]) && Yii::app()->user->settings['BUDGET_LOCK_'.budget('name')]=='YES';
}
// Permission functions
function corporate_report() {
	return is_finance_officer() ||  is_sys_admin()  || is_manager_finance();
}
function is_hr() {
//	dump
	return isset(Yii::app()->user->roles) && array_key_exists(HR,Yii::app()->user->roles);
}
function is_sys_admin() {
	return isset(Yii::app()->user->roles) && array_key_exists(SA,Yii::app()->user->roles);
}
function is_finance_officer() {
	return (is_auditor()|| is_manager_finance() || is_sat() || is_pbfo() || is_sys_admin());
	//return isset(Yii::app()->user->roles) && array_key_exists(FO,Yii::app()->user->roles);
}
function is_manager_finance() {
	return isset(Yii::app()->user->roles) && array_key_exists(MFAS,Yii::app()->user->roles);
}
function is_auditor() {
	return isset(Yii::app()->user->roles) && array_key_exists(AUD,Yii::app()->user->roles);
}

function is_budget_officer() {
	return isset(Yii::app()->user->roles) && array_key_exists(BO,Yii::app()->user->roles);
}
function is_legal_officer() {
	return (is_finance_officer() || (isset(Yii::app()->user->roles) && array_key_exists(LO,Yii::app()->user->roles)));
}

function is_dept_head() {
	return isset(Yii::app()->user->roles) && array_key_exists(HOD,Yii::app()->user->roles);
}
function is_section_head() {
	return isset(Yii::app()->user->roles) && array_key_exists(HOS,Yii::app()->user->roles);
}
function is_proc_officer() {
	return isset(Yii::app()->user->roles) && array_key_exists(PO,Yii::app()->user->roles);
}
function is_transport_officer() {
	return isset(Yii::app()->user->roles) && array_key_exists(TO,Yii::app()->user->roles);
}
function is_sat() {
	return isset(Yii::app()->user->roles) && array_key_exists(SAT,Yii::app()->user->roles);
}
function is_pbfo() {
	return isset(Yii::app()->user->roles) && array_key_exists(PBFO,Yii::app()->user->roles);
}



/**
 * This is the shortcut to Yii::app()
 */
function app()
{
    return Yii::app();
}

/**
 * This is the shortcut to Yii::app()->clientScript
 */
function cs()
{
    // You could also call the client script instance via Yii::app()->clientScript
    // But this is faster
    return Yii::app()->getClientScript();
}

/**
 * This is the shortcut to Yii::app()->user.
 */
function user()
{
    return Yii::app()->getUser();
}

/**
 * This is the shortcut to Yii::app()->createUrl()
 */
function url($route,$params=array(),$ampersand='&')
{
    return Yii::app()->createUrl($route,$params,$ampersand);
}

/**
 * This is the shortcut to CHtml::encode
 */
function h($text)
{
    return htmlspecialchars($text,ENT_QUOTES,Yii::app()->charset);
}

/**
 * This is the shortcut to CHtml::link()
 */
function l($text, $url = '#', $htmlOptions = array())
{
    return CHtml::link($text, $url, $htmlOptions);
}

/**
 * This is the shortcut to Yii::t() with default category = 'stay'
 */
function t($message, $category = 'stay', $params = array(), $source = null, $language = null)
{
    return Yii::t($category, $message, $params, $source, $language);
}

/**
 * This is the shortcut to Yii::app()->request->baseUrl
 * If the parameter is given, it will be returned and prefixed with the app baseUrl.
 */
function bu($url=null)
{
    static $baseUrl;
    if ($baseUrl===null)
        $baseUrl=Yii::app()->getRequest()->getBaseUrl();
    return $url===null ? $baseUrl : $baseUrl.'/'.ltrim($url,'/');
}

/**
 * Returns the named application parameter.
 * This is the shortcut to Yii::app()->params[$name].
 */
function param($name)
{
    return Yii::app()->params[$name];
}

?>
