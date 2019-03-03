<?php

/**
 * This is the model class for table "revenue".
 *
 * The followings are the available columns in table 'revenue':
 * @property integer $id
 * @property integer $budget
 * @property integer $accountcode
 * @property string $amount1
 * @property integer $createdby
 * @property string $createdon
 * @property integer $updatedby
 * @property string $updatedon
 *
 * The followings are the available model relations:
 * @property Budgets $budget0
 * @property Accountcodes $accountcode0
 * @property Users $createdby0
 * @property Users $updatedby0
 */
class Revenue extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'revenue';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('accountcode, createdby, createdon', 'required'),
			array('amount1, amount2, amount3, amount4, budget, accountcode, createdby, updatedby', 'numerical', 'integerOnly'=>true),
			array('amount1', 'length', 'max'=>200),
			array('updatedon', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, budget, accountcode, amount1, amount3, amount2, amount4,createdby, createdon, updatedby, updatedon', 'safe', 'on'=>'search'),
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
			'budget0' => array(self::BELONGS_TO, 'Budgets', 'budget'),
			'accountcode0' => array(self::BELONGS_TO, 'Accountcodes', 'accountcode'),
			'createdby0' => array(self::BELONGS_TO, 'Users', 'createdby'),
			'updatedby0' => array(self::BELONGS_TO, 'Users', 'updatedby'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'budget' => 'Budget',
			'accountcode' => 'Accountcode',
			'amount1' => 'Q1 (Kwh)',
			'amount2' => 'Q2 (Kwh)',
			'amount3' => 'Q3 (Kwh)',
			'amount4' => 'Q4 (Kwh)',
			'createdby' => 'Createdby',
			'createdon' => 'Createdon',
			'updatedby' => 'Updatedby',
			'updatedon' => 'Updatedon',
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
		$criteria->compare('budget',user()->budget['id']);
		$criteria->compare('accountcode',$this->accountcode);
		$criteria->compare('amount1',$this->amount1,true);
		$criteria->compare('createdby',$this->createdby);
		$criteria->compare('createdon',$this->createdon,true);
		$criteria->compare('updatedby',$this->updatedby);
		$criteria->compare('updatedon',$this->updatedon,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Revenue the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
