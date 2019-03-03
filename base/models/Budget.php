<?php

/**
 * This is the model class for table "budget".
 *
 * The followings are the available columns in table 'budget':
 * @property integer $id
 * @property integer $accountcode
 * @property integer $amount
 * @property integer $budget
 * @property integer $dept
 * @property integer $item
 * @property string $descr
 * @property integer $qty
 * @property string $tbl
 * @property integer $tblid
 * @property string $tblcolumn
 * @property integer $units
 * @property integer $createdby
// * @property string $createdon
 * @property string $dateneeded
 *
 * The followings are the available model relations:
 * @property Users $createdby0
 */
class Budget extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'budget';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('createdby, dateneeded', 'required'),
			array('budget, dept, item, qty, tblid, createdby', 'numerical', 'integerOnly'=>true),
			array('descr', 'length', 'max'=>255),
			array('tbl, tblcolumn', 'length', 'max'=>200),
			array('budget','default','value'=>budget()),
			//array('createdby', 'default', 'value'=>user()->id, 'setOnEmpty'=>true,'on'=>'insert'),
		   	//array('dateneeded','default', 'value'=>new CDbExpression('NOW()')),
		   	//array('dateneeded','default', 'value'=>new CDbExpression('NOW()'), 'setOnEmpty'=>true,'on'=>'update'),

		//	array('createdon', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, period,createdon,budget, dept, item, descr, qty, tbl, tblid, tblcolumn, createdby, dateneeded', 'safe'),
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
			'createdby0' => array(self::BELONGS_TO, 'Users', 'createdby'),
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
			'dept' => 'Dept',
			'item' => 'Item',
			'descr' => 'Descr',
			'qty' => 'Qty',
			'tbl' => 'Tbl',
			'tblid' => 'Tblid',
			'tblcolumn' => 'Tblcolumn',
			//'units' => 'Units',
			'createdby' => 'Createdby',
			'createdon' => 'Createdon',
			'period'		=>'Period',
			'dateneeded' => 'Dateneeded',
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
		$criteria->compare('dept',$this->dept);
		$criteria->compare('item',$this->item);
		$criteria->compare('descr',$this->descr,true);
		$criteria->compare('qty',$this->qty);
		$criteria->compare('tbl',$this->tbl,true);
		$criteria->compare('tblid',$this->tblid);
		$criteria->compare('tblcolumn',$this->tblcolumn,true);
		//$criteria->compare('units',$this->units);
		$criteria->compare('createdby',$this->createdby);
		$criteria->compare('createdon',$this->createdon,true);
		$criteria->compare('period',$this->period,true);
		$criteria->compare('dateneeded',$this->dateneeded,true);

		return new CActiveDataProvider($this, array('criteria'=>$criteria));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Budget the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
