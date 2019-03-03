<?php

/**
 * This is the model class for table "bc_comments".
 *
 * The followings are the available columns in table 'bc_comments':
 * @property integer $id
 * @property integer $request
 * @property integer $initiator
 * @property integer $owner
 * @property string $comments
 * @property string $requestdate
 *
 * The followings are the available model relations:
 * @property BcBudgetrequests $request0
 * @property Users $initiator0
 * @property Users $owner0
 */
class BcComments extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'bc_comments';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('request, initiator, owner, comments, requestdate', 'required'),
			array('request, initiator, owner', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, request, initiator, owner, comments, requestdate', 'safe', 'on'=>'search'),
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
			'request0' => array(self::BELONGS_TO, 'BcBudgetrequests', 'request'),
			'initiator0' => array(self::BELONGS_TO, 'Users', 'initiator'),
			'owner0' => array(self::BELONGS_TO, 'Users', 'owner'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'request' => 'Request',
			'initiator' => 'Initiator',
			'owner' => 'Owner',
			'comments' => 'Comments',
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
		$criteria->compare('request',$this->request);
		$criteria->compare('initiator',$this->initiator);
		$criteria->compare('owner',$this->owner);
		$criteria->compare('comments',$this->comments,true);
		$criteria->compare('requestdate',$this->requestdate,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BcComments the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
