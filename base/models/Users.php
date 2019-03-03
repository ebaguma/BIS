<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property integer $id
 * @property string $username
 * @property string $passwd
 * @property integer $dept
 * @property integer $role
 * @property string $names
 *
 * The followings are the available model relations:
 * @property Budget[] $budgets
 * @property Revenue[] $revenues
 * @property Revenue[] $revenues1
 * @property StaffCosts[] $staffCosts
 * @property StaffCosts[] $staffCosts1
 * @property TransportBudget[] $transportBudgets
 * @property TransportBudget[] $transportBudgets1
 * @property Travel[] $travels
 * @property Travel[] $travels1
 * @property Sections $dept0
 * @property UsersRoles[] $usersRoles
 */
class Users extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, email,passwd, dept, role, names', 'required'),
			array('dept, role', 'numerical', 'integerOnly'=>true),
			array('username', 'length', 'max'=>50),
			array('passwd, names', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, username, passwd, dept, role, names', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'budgets' => array(self::HAS_MANY, 'Budget', 'createdby'),
			'revenues' => array(self::HAS_MANY, 'Revenue', 'createdby'),
			'revenues1' => array(self::HAS_MANY, 'Revenue', 'updatedby'),
			'staffCosts' => array(self::HAS_MANY, 'StaffCosts', 'updatedby'),
			'staffCosts1' => array(self::HAS_MANY, 'StaffCosts', 'createdby'),
			'transportBudgets' => array(self::HAS_MANY, 'TransportBudget', 'updatedby'),
			'transportBudgets1' => array(self::HAS_MANY, 'TransportBudget', 'createdby'),
			'travels' => array(self::HAS_MANY, 'Travel', 'createdby'),
			'travels1' => array(self::HAS_MANY, 'Travel', 'updatedby'),
			'dept0' => array(self::BELONGS_TO, 'Sections', 'dept'),
			'usersRoles' => array(self::HAS_MANY, 'UsersRoles', 'user'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'username' => 'Username',
			'passwd' => 'Passwd',
			'dept' => 'Dept',
			'role' => 'Role',
			'email' => 'Email',
			'names' => 'Names',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('passwd',$this->passwd,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('dept',$this->dept);
		$criteria->compare('role',$this->role);
		$criteria->compare('names',$this->names,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
			    'pageSize'=>100,
			  ),			
		));
		
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Users the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
