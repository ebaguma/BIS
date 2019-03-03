<?php

/**
 * This is the model class for table "v_travel".
 *
 * The followings are the available columns in table 'v_travel':
 * @property string $budgetname
 * @property integer $itemid
 * @property string $item
 * @property integer $amount
 * @property integer $training
 * @property integer $id
 * @property integer $employee
 * @property string $course
 * @property string $purpose
 * @property string $centre
 * @property string $mission
 * @property integer $budget
 * @property string $traveldate
 * @property integer $createdby
 * @property string $createdon
 * @property integer $updatedby
 * @property string $updatedon
 * @property string $foreigntravel
 * @property string $trainingtravel
 */
class VTravel extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'v_travel';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('foreigntravel, trainingtravel', 'required'),
			array('itemid, amount, training, id, employee, budget, createdby, updatedby', 'numerical', 'integerOnly'=>true),
			array('budgetname, item, course, centre', 'length', 'max'=>100),
			array('mission', 'length', 'max'=>13),
			array('foreigntravel, trainingtravel', 'length', 'max'=>3),
			array('purpose, traveldate, createdon, updatedon', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('budgetname, itemid, item, amount, training, id, employee, course, purpose, centre, mission, budget, traveldate, createdby, createdon, updatedby, updatedon, foreigntravel, trainingtravel', 'safe', 'on'=>'search'),
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
			'budgetname' => 'Budgetname',
			'itemid' => 'Itemid',
			'item' => 'Item',
			'amount' => 'Amount',
			'training' => 'Training',
			'id' => 'ID',
			'employee' => 'Employee',
			'course' => 'Course',
			'purpose' => 'Purpose',
			'centre' => 'Centre',
			'mission' => 'Mission',
			'budget' => 'Budget',
			'traveldate' => 'Traveldate',
			'createdby' => 'Createdby',
			'createdon' => 'Createdon',
			'updatedby' => 'Updatedby',
			'updatedon' => 'Updatedon',
			'foreigntravel' => 'Foreigntravel',
			'trainingtravel' => 'Trainingtravel',
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

		$criteria->compare('budgetname',$this->budgetname,true);
		$criteria->compare('itemid',$this->itemid);
		$criteria->compare('item',$this->item,true);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('training',$this->training);
		$criteria->compare('id',$this->id);
		$criteria->compare('employee',$this->employee);
		$criteria->compare('course',$this->course,true);
		$criteria->compare('purpose',$this->purpose,true);
		$criteria->compare('centre',$this->centre,true);
		$criteria->compare('mission',$this->mission,true);
		$criteria->compare('budget',$this->budget);
		$criteria->compare('traveldate',$this->traveldate,true);
		$criteria->compare('createdby',$this->createdby);
		$criteria->compare('createdon',$this->createdon,true);
		$criteria->compare('updatedby',$this->updatedby);
		$criteria->compare('updatedon',$this->updatedon,true);
		$criteria->compare('foreigntravel',$this->foreigntravel,true);
		$criteria->compare('trainingtravel',$this->trainingtravel,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VTravel the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
