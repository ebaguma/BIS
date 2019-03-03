<?php

/**
 * This is the model class for table "reallocation".
 *
 * The followings are the available columns in table 'reallocation':
 * @property integer $id
 * @property integer $acfrom
 * @property integer $acto
 * @property integer $requestor
 * @property integer $approval1
 * @property integer $approval1_by
 * @property integer $approval2
 * @property integer $approval2_by
 * @property integer $approval3
 * @property integer $approval3_by
 * @property integer $approval4
 * @property integer $approval4_by
 * @property integer $disbursed
 * @property integer $amount
 * @property integer $budget
 *
 * The followings are the available model relations:
 * @property Accountcodes $acfrom0
 * @property Accountcodes $acto0
 * @property Staff $requestor0
 * @property Staff $approval1By
 * @property Staff $approval2By
 * @property Staff $approval3By
 * @property Staff $approval4By
 */
class Reallocation extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'reallocation';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('acfrom, amount,acto, requestor, approval1, approval1_by, approval2, approval2_by, approval3, approval3_by, approval4, approval4_by, disbursed', 'numerical', 'integerOnly'=>true),
			//array('budget', 'default', 'value'=>Yii::app()->user->budget['id']),			
			array('requestor', 'default', 'value'=>Yii::app()->user->id),			
			
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, acfrom, acto, requestor, approval1, approval1_by, approval2, approval2_by, approval3, approval3_by, approval4, approval4_by, disbursed', 'safe', 'on'=>'search'),
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
			'acfrom0' => array(self::BELONGS_TO, 'Accountcodes', 'acfrom'),
			'acto0' => array(self::BELONGS_TO, 'Accountcodes', 'acto'),
			'requestor0' => array(self::BELONGS_TO, 'Staff', 'requestor'),
			'approval1By' => array(self::BELONGS_TO, 'Staff', 'approval1_by'),
			'approval2By' => array(self::BELONGS_TO, 'Staff', 'approval2_by'),
			'approval3By' => array(self::BELONGS_TO, 'Staff', 'approval3_by'),
			'approval4By' => array(self::BELONGS_TO, 'Staff', 'approval4_by'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'acfrom' => 'Acfrom',
			'acto' => 'Acto',
			'amount' => 'amount',
			'requestor' => 'Requestor',
			'approval1' => 'Approval1',
			'approval1_by' => 'Approval1 By',
			'approval2' => 'Approval2',
			'approval2_by' => 'Approval2 By',
			'approval3' => 'Approval3',
			'approval3_by' => 'Approval3 By',
			'approval4' => 'Approval4',
			'approval4_by' => 'Approval4 By',
			'disbursed' => 'Disbursed',
			'budget'	=>	'Budget',
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
		$criteria->compare('amount',$this->id);
		$criteria->compare('acfrom',$this->acfrom);
		$criteria->compare('acto',$this->acto);
		$criteria->compare('requestor',$this->requestor);
		$criteria->compare('approval1',$this->approval1);
		$criteria->compare('approval1_by',$this->approval1_by);
		$criteria->compare('approval2',$this->approval2);
		$criteria->compare('approval2_by',$this->approval2_by);
		$criteria->compare('approval3',$this->approval3);
		$criteria->compare('approval3_by',$this->approval3_by);
		$criteria->compare('approval4',$this->approval4);
		$criteria->compare('approval4_by',$this->approval4_by);
		$criteria->compare('disbursed',$this->disbursed);
		$criteria->compare('budget',$this->budget);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Reallocation the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
