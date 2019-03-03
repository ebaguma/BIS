<?php

/**
 * This is the model class for table "procurement_spending".
 *
 * The followings are the available columns in table 'procurement_spending':
 * @property integer $id
 * @property string $subject
 * @property integer $location
 * @property string $reference
 * @property string $date_required
 * @property integer $accountcode
 * @property integer $budget
 * 
 * The followings are the available model relations:
 * @property ProcurementItems[] $procurementItems
 * @property DeliveryLocations $location0
 * @property Accountcodes $accountcode0
 * @property Budgets $budget0
 */
class ProcurementSpending extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'procurement_spending';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('location, accountcode, budget', 'numerical', 'integerOnly'=>true),
			array('subject, reference', 'length', 'max'=>255),
			array('reference, subject,date_required', 'required'),
			array('date_required', 'safe'),
			array('budget', 'default', 'value'=>Yii::app()->user->budget['id']),
			array('requestor', 'default', 'value'=>Yii::app()->user->id),
			array('requestdate', 'default', 'value'=>new CDbExpression('NOW()'),'setOnEmpty'=>false,'on'=>'insert'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, subject, location, reference, date_required, accountcode, budget', 'safe', 'on'=>'search'),
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
			'procurementItems' => array(self::HAS_MANY, 'ProcurementItems', 'spending'),
			'location0' => array(self::BELONGS_TO, 'DeliveryLocations', 'location'),
			'accountcode0' => array(self::BELONGS_TO, 'Accountcodes', 'accountcode'),
			'budget0' => array(self::BELONGS_TO, 'Budgets', 'budget'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			//'accountcodefrom' => 'accountcodefrom',
			'subject' => 'Subject of Procurement',
			'location' => 'Delivery Location',
			'reference' => 'Procurement Reference',
			'date_required' => 'Date Required',
			'accountcode' => 'Account Code',
			'budget' => 'Budget',
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
		$dusers=array();
		$scyy=Yii::app()->db->createCommand("select id from users where dept  =".user()->dept['id'])->queryAll();				
		foreach($scyy as $sc) $dusers[]=$sc[id];

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);		
		$criteria->compare('subject',$this->subject,true);
		if(is_dept_head())
			$criteria->compare('requestor',$dusers);
		else
			$criteria->compare('requestor',user()->id);		
		$criteria->compare('location',$this->location);
		$criteria->compare('reference',$this->reference,true);
		$criteria->compare('date_required',$this->date_required,true);
		$criteria->compare('accountcode',$this->accountcode);
		$criteria->compare('budget',$this->budget);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProcurementSpending the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
