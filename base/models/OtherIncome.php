<?php

/**
 * This is the model class for table "other_income".
 *
 * The followings are the available columns in table 'other_income':
 * @property integer $id
 * @property integer $budget
 * @property integer $accountcode
 * @property double $amount1
 * @property double $amount2
 * @property double $amount3
 * @property double $amount4
 * @property integer $createdby
 * @property string $createdon
 * @property integer $updatedby
 * @property string $updatedon
 */
class OtherIncome extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'other_income';
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
			array('budget, accountcode, createdby, updatedby', 'numerical', 'integerOnly'=>true),
			array('amount1, amount2, amount3, amount4', 'numerical'),
			array('updatedon', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, budget, accountcode, amount1, amount2, amount3, amount4, createdby, createdon, updatedby, updatedon', 'safe', 'on'=>'search'),
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
			'amount1' => 'Amount1',
			'amount2' => 'Amount2',
			'amount3' => 'Amount3',
			'amount4' => 'Amount4',
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
		$criteria->compare('budget',$this->budget);
		$criteria->compare('accountcode',$this->accountcode);
		$criteria->compare('amount1',$this->amount1);
		$criteria->compare('amount2',$this->amount2);
		$criteria->compare('amount3',$this->amount3);
		$criteria->compare('amount4',$this->amount4);
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
	 * @return OtherIncome the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
