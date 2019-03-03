<?php

/**
 * This is the model class for table "budgetitems".
 *
 * The followings are the available columns in table 'budgetitems':
 * @property integer $id
 * @property integer $item
 * @property integer $quantity
 * @property integer $costcentre
 * @property integer $dept
 * @property integer $budget
 *
 * The followings are the available model relations:
 * @property Budgets $budget0
 * @property Items $item0
 * @property Costcentres $costcentre0
 * @property Dept $dept0
 */
class Budgetitems extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'budgetitems';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('item, quantity, costcentre, dept, budget', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, item, quantity, costcentre, dept, budget', 'safe', 'on'=>'search'),
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
			'item0' => array(self::BELONGS_TO, 'Items', 'item'),
			'costcentre0' => array(self::BELONGS_TO, 'Costcentres', 'costcentre'),
			'dept0' => array(self::BELONGS_TO, 'Dept', 'dept'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'item' => 'Item',
			'quantity' => 'Quantity',
			'costcentre' => 'Costcentre',
			'dept' => 'Dept',
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

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('item',$this->item);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('costcentre',$this->costcentre);
		$criteria->compare('dept',$this->dept);
		$criteria->compare('budget',$this->budget);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Budgetitems the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
