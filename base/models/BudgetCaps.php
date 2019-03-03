<?php

/**
 * This is the model class for table "budget_caps".
 *
 * The followings are the available columns in table 'budget_caps':
 * @property integer $id
 * @property integer $dept
 * @property integer $accountcode
 * @property string $cap
 * @property integer $budget
 * @property integer $updatedby
 * @property string $updatedate
 *
 * The followings are the available model relations:
 * @property Dept $dept0
 * @property Users $updatedby0
 * @property Budgets $budget0
 */
class BudgetCaps extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'budget_caps';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('dept, accountcode, budget, updatedby', 'required'),
			array('dept, accountcode, budget, updatedby', 'numerical', 'integerOnly'=>true),
			array('cap', 'length', 'max'=>20),
			array('updatedate', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, dept, accountcode, cap, budget, updatedby, updatedate', 'safe', 'on'=>'search'),
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
			'dept0' => array(self::BELONGS_TO, 'Dept', 'dept'),
			'updatedby0' => array(self::BELONGS_TO, 'Users', 'updatedby'),
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
			'dept' => 'Dept',
			'accountcode' => 'Accountcode',
			'cap' => 'Cap',
			'budget' => 'Budget',
			'updatedby' => 'Updatedby',
			'updatedate' => 'Updatedate',
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
		$criteria->compare('dept',$this->dept);
		$criteria->compare('accountcode',$this->accountcode);
		$criteria->compare('cap',$this->cap,true);
		$criteria->compare('budget',$this->budget);
		$criteria->compare('updatedby',$this->updatedby);
		$criteria->compare('updatedate',$this->updatedate,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BudgetCaps the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
