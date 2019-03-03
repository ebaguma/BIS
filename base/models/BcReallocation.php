<?php

/**
 * This is the model class for table "bc_reallocation".
 *
 * The followings are the available columns in table 'bc_reallocation':
 * @property integer $id
 * @property integer $fromitem
 * @property integer $toitem
 * @property double $amount
 * @property integer $budget
 * @property integer $requestor
 * @property string $requestdate
 *
 * The followings are the available model relations:
 * @property Items $fromitem0
 * @property Items $toitem0
 * @property Users $requestor0
 * @property Budgets $budget0
 */
class BcReallocation extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'bc_reallocation';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fromitem, toitem,amount', 'required'),
			array('fromitem, toitem, fromsection,tosection,budget, requestor', 'numerical', 'integerOnly'=>true),
			array('amount', 'numerical'),
			array('justification', 'length', 'max'=>1255),
			array('requestor','default','value'=>user()->id),	
			array('fromsection','default','value'=>section()),	
			array('tosection','default','value'=>section()),	
			array('budget','default','value'=>budget()),	
			array('requestdate','default', 'value'=>new CDbExpression('NOW()')),								
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, fromitem, toitem, fromsection,tosection,justification,amount, budget, requestor, requestdate', 'safe', 'on'=>'search'),
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
			'fromitem0' => array(self::BELONGS_TO, 'Items', 'fromitem'),
			'toitem0' => array(self::BELONGS_TO, 'Items', 'toitem'),
			'requestor0' => array(self::BELONGS_TO, 'Users', 'requestor'),
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
			'fromitem' => 'From Item',
			'toitem' => 'To Item',
			'justification' => 'Justification',
			'amount' => 'Amount',
			'fromsection'=>'From Section',
			'tosection'=>'To Section',
			'budget' => 'Budget',
			'requestor' => 'Requestor',
			'requestdate' => 'Requestdate',
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
		$criteria->compare('fromitem',$this->fromitem);
		$criteria->compare('toitem',$this->toitem);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('fromsection',$this->fromsection);
		$criteria->compare('tosection',$this->tosection);
		$criteria->compare('budget',$this->budget);
		$criteria->compare('requestor',user()->id);
		$criteria->compare('requestdate',$this->requestdate,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BcReallocation the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
