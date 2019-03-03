<?php

/**
 * This is the model class for table "v_ba1".
 *
 * The followings are the available columns in table 'v_ba1':
 * @property string $subject
 * @property integer $requestid
 * @property string $justification
 * @property string $requestdate
 * @property string $requireddate
 * @property integer $requestorid
 * @property string $requestorusername
 * @property string $requestornames
 * @property integer $budget
 * @property integer $approverid
 * @property string $approverusername
 * @property string $approvernames
 * @property integer $decision
 * @property string $comments
 * @property string $approverdate
 */
class VBa1 extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'v_ba1';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('justification, requestdate, requestorid, budget', 'required'),
			array('requestid, requestorid, budget, approverid, decision', 'numerical', 'integerOnly'=>true),
			array('subject', 'length', 'max'=>200),
			array('justification, requestornames, approvernames', 'length', 'max'=>255),
			array('requestorusername, approverusername', 'length', 'max'=>50),
			array('requireddate, comments, approverdate', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('subject, requestid, justification, requestdate, requireddate, requestorid, requestorusername, requestornames, budget, approverid, approverusername, approvernames, decision, comments, approverdate', 'safe', 'on'=>'search'),
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
			'subject' => 'Subject',
			'requestid' => 'Requestid',
			'justification' => 'Justification',
			'requestdate' => 'Requestdate',
			'requireddate' => 'Requireddate',
			'requestorid' => 'Requestorid',
			'requestorusername' => 'Requestorusername',
			'requestornames' => 'Requestornames',
			'budget' => 'Budget',
			'approverid' => 'Approverid',
			'approverusername' => 'Approverusername',
			'approvernames' => 'Approvernames',
			'decision' => 'Decision',
			'comments' => 'Comments',
			'approverdate' => 'Approverdate',
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
	public function q() {
		$count=Yii::app()->db->createCommand('SELECT COUNT(*) FROM v_ba1 where decision is null and (approverid='.user()->id.' or requestorsectionid='.user()->dept[id].")")->queryScalar();
		$sql='SELECT * FROM v_ba1 where decision is null and (approverid='.user()->id.' or requestorsectionid='.user()->dept[id].")";
		$dataProvider=new CSqlDataProvider($sql, array(
		    'totalItemCount'=>$count,
		    'sort'=>array(
		        'attributes'=>array(
		             'requestid', 'requestdate', 'requireddate',
		        ),
		    ),
		    'pagination'=>array(
		        'pageSize'=>10,
		    ),
		));
		return $dataProvider;
	}
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('subject',$this->subject,true);
		$criteria->compare('requestid',$this->requestid);
		$criteria->compare('justification',$this->justification,true);
		$criteria->compare('requestdate',$this->requestdate,true);
		$criteria->compare('requireddate',$this->requireddate,true);
		$criteria->compare('requestorid',$this->requestorid);
		$criteria->compare('requestorusername',$this->requestorusername,true);
		$criteria->compare('requestornames',$this->requestornames,true);
		$criteria->compare('budget',$this->budget);
		$criteria->compare('approverid',$this->approverid);
		$criteria->compare('approverusername',$this->approverusername,true);
		$criteria->compare('approvernames',$this->approvernames,true);
		$criteria->compare('decision',$this->decision);
		$criteria->compare('comments',$this->comments,true);
		$criteria->compare('approverdate',$this->approverdate,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VBa1 the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
