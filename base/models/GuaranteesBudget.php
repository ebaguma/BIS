<?php

/**
 * This is the model class for table "guarantees_budget".
 *
 * The followings are the available columns in table 'guarantees_budget':
 * @property integer $id
 * @property integer $guarantee
 * @property double $arrangement
 * @property double $establishment
 * @property double $quarterly
 * @property double $annualrenewal
 * @property integer $budget
 *
 * The followings are the available model relations:
 * @property GuaranteesBudget $guarantee0
 * @property GuaranteesBudget[] $guaranteesBudgets
 */
class GuaranteesBudget extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'guarantees_budget';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('guarantee', 'required'),
			array('guarantee, budget', 'numerical', 'integerOnly'=>true),
			array('arrangement, establishment, quarterly, annualrenewal', 'numerical'),
			array('budget','default','value'=>user()->budget['id']),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, guarantee, arrangement, establishment, quarterly, annualrenewal, budget', 'safe', 'on'=>'search'),
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
			'guarantee0' => array(self::BELONGS_TO, 'Guarantees', 'guarantee'),
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
			'guarantee' => 'Bank Guarantee',
			'arrangement' => 'Arrangement Fees (%)',
			'establishment' => 'Establishment Fees (%)',
			'quarterly' => 'Quarterly Fees (%)',
			'annualrenewal' => 'Annual Renewal Fees (%)',
			'budget' => 'Budget (%)',
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
		$criteria->compare('guarantee',$this->guarantee);
		$criteria->compare('arrangement',$this->arrangement);
		$criteria->compare('establishment',$this->establishment);
		$criteria->compare('quarterly',$this->quarterly);
		$criteria->compare('annualrenewal',$this->annualrenewal);
		$criteria->compare('budget',$this->budget);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return GuaranteesBudget the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
