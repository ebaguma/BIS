<?php

/**
 * This is the model class for table "bc_itembudgets".
 *
 * The followings are the available columns in table 'bc_itembudgets':
 * @property integer $id
 * @property integer $item
 * @property integer $section
 * @property double $amount
 * @property integer $budget
 * @property integer $reason
 * @property integer $reasonid
 * @property string $status
 * @property string $dateadded
 * @property integer $addedby
 */
class BcItembudgets extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'bc_itembudgets';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('item,section', 'required'),
			array('item, section, budget, reason, reasonid, addedby', 'numerical', 'integerOnly'=>true),
			array('amount', 'numerical'),
			array('budget','default','value'=>budget()),
			array('addedby','default','value'=>user()->id),
			array('section','default','value'=>user()->dept['id']),
			array('amount','default','value'=>0),
			array('reason','default','value'=>1),
			array('status','default','value'=>'COMMITED'),
			array('dateadded','default', 'value'=>new CDbExpression('NOW()')),
			array('updated_at','default', 'value'=>new CDbExpression('NOW()')),
			array('updated_by','default', 'value'=>user()->id),
			array('status', 'length', 'max'=>8),
			array('dateadded', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, item, updated_by,updated_at,section, dateadded,amount, budget, reason, reasonid, status, dateadded, addedby', 'safe', 'on'=>'search'),
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
			'item0' 		=> array(self::BELONGS_TO, 'Items', 'item'),
			'section0'		=> array(self::BELONGS_TO, 'Sections', 'section'),
			'budget0' 	=> array(self::BELONGS_TO, 'Budgets', 'budget'),
			'addedby0' 	=> array(self::BELONGS_TO, 'Users', 'addedby'),
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
			'section' => 'Section',
			'amount' => 'Amount',
			'budget' => 'Budget',
			'reason' => 'Reason',
			'reasonid' => 'Reasonid',
			'status' => 'Status',
			'dateadded' => 'Date Added',
			'addedby' => 'Addedby',
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
	public function q()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('item',$this->item);
		$criteria->compare('section',$this->section);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('budget',$this->budget);
		$criteria->compare('reason',$this->reason);
		$criteria->compare('reasonid',$this->reasonid);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('dateadded',$this->dateadded,true);
		$criteria->compare('addedby',$this->addedby);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria, 'pagination'=>array('pageSize'=>50)
		));
	}
	
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('item',$this->item);
		$criteria->compare('section',$this->section);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('budget',$this->budget);
		$criteria->compare('reason',$this->reason);
		$criteria->compare('reasonid',$this->reasonid);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('dateadded',$this->dateadded,true);
		$criteria->compare('addedby',$this->addedby);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria, 'pagination'=>array('pageSize'=>50)
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BcItembudgets the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
