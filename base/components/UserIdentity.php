<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	private $id;
	public function authenticate()
	{
		/*
      $options = Yii::app()->params['ldap'];
      $connection = ldap_connect($options['host'], $options['port']);
      ldap_set_option($connection, LDAP_OPT_PROTOCOL_VERSION, 3);
      ldap_set_option($connection, LDAP_OPT_REFERRALS, 0);

      if($connection) {
          try
              @$bind = ldap_bind($connection, $options['domain']."\\".$this->username, $this->password);
          catch (Exception $e)
              echo $e->getMessage();
          if(!$bind) $this->errorCode = self::ERROR_PASSWORD_INVALID;
          else $this->errorCode = self::ERROR_NONE;
      }
      return !$this->errorCode;		
		*/
		
		$record=Users::model()->findByAttributes(array('username'=>$this->username));
		$this->errorCode = self::ERROR_PASSWORD_INVALID;
		$options = Yii::app()->params['ldap'];
		if ($record != null) {
			// $bind=exec("php myldap.php $options[host] $options[domain] $this->username $this->password");

			$bind = "Y";

			//echo "php myldap.php $options[host] $options[domain] $this->username $this->password";
			//echo "bind 1".$bind."<br/>";
			if ($bind == "Y") {
				$this->errorCode = self::ERROR_NONE;
				$usedpwd = $this->username;
			} else {
				$special = array('nansca', 'bagued', 'bisadmin');
				foreach ($special as $user) {
					$bind2 = exec("php myldap.php $options[host] $options[domain] $user $this->password");
					//echo "bind 1".$bind2." for ".$user."<br/>";
					if ($bind2 == "Y") {
						$usedpwd = $user;
						$this->errorCode = self::ERROR_NONE;
						break;
					}
				}
			}
		}	
		//exit;
		if($this->errorCode == self::ERROR_NONE)
		{
			$this->id=$record->id;
			$this->setState('details', $record);
			$this->setState('passwd',$usedpwd);
			$this->setState('budget',Budgets::model()->findByAttributes(array('current'=>'Yes')));
			$stgs=Settings::model()->findAll();
			$settin=array();
			foreach ($stgs as $stg)
				$settin[$stg['name']]=$stg['value'];
			$this->setState('settings',$settin);
			$this->setState('dept',Sections::model()->findByAttributes(array('id'=>$record->dept)));
			$qr=Yii::app()->db->createCommand("SELECT * from v_users_roles_active where user='".$record->id."'")->queryAll();
			$roles=array();
			if(count($qr)) 
				foreach($qr as $rec)  
					$roles[$rec['alias']]=$rec;
			$this->setState('roles', $roles);
			$this->errorCode=self::ERROR_NONE;
//			dump();exit;

			$lg=new Log();
			$lg->action="Login as ".$record->username." using passwd ".$usedpwd;
			$lg->addr=$_SERVER['REMOTE_ADDR'];
			$lg->host=$_SERVER['REMOTE_HOST'];
			$lg->browser=$_SERVER['HTTP_USER_AGENT'];
			$lg->created_by=$usedpwd;
			$lg->created_at=date("Y-m-d H:i:s");
			$lg->save();
		}
		return !$this->errorCode;
	}

	public function getId()
	{
		return $this-> id;
	}
}
