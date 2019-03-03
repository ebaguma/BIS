<?php

/**
 * This is the model class for table "emolumentrates".
 *
 * The followings are the available columns in table 'emolumentrates':
 * @property integer $id
 * @property integer $employee
 * @property integer $travel_in_ug_op
 * @property integer $travel_in_ug_cap
 * @property integer $weekend_lunch
 * @property integer $weekend_transport
 * @property integer $out_of_station
 * @property integer $acting_allowance
 * @property integer $mobile_phone_allowance
 * @property integer $risk_allowance
 * @property integer $responsibility_allowance
 * @property integer $driving_allowance
 * @property integer $mileage
 * @property integer $soap
 * @property integer $shift
 * @property integer $milk
 * @property integer $leave_in_lieu
 * @property integer $overtime_weekdayhrs
 * @property integer $overtime_weekdaydays
 * @property integer $overtime_weekend_hrs
 * @property integer $overtime_weekend_days
 * @property integer $shift_hours
 * @property integer $shift_days
 * @property string $leave_start
 * @property string $leave_end
 * @property string $budget
 *
 * The followings are the available model relations:
 * @property Employees $employee0
 */
class Emolumentrates extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'emolumentrates';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('employee','required'),
			array('budget, employee, travel_in_ug_op, travel_in_ug_cap, weekend_lunch, weekend_transport, out_of_station, acting_allowance, mobile_phone_allowance, risk_allowance, responsibility_allowance, driving_allowance, mileage, soap, shift, milk, leave_in_lieu, overtime_weekdayhrs, overtime_weekdaydays, overtime_weekend_hrs, overtime_weekend_days, shift_hours, shift_days', 'numerical', 'integerOnly'=>true),
			array('budget','default','value'=>Yii::app()->user->budget['id']),
			//array('budget,employee', 'unique', 'on' => 'insert', 'message' => '{attribute}:{value} already exists!'),
			array('leave_start, leave_end,removal_allowance', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, employee, travel_in_ug_op, travel_in_ug_cap, weekend_lunch, weekend_transport, out_of_station, acting_allowance, mobile_phone_allowance, risk_allowance, responsibility_allowance, driving_allowance, mileage, soap, shift, milk, leave_in_lieu, overtime_weekdayhrs, overtime_weekdaydays, removal_allowance,overtime_weekend_hrs, overtime_weekend_days, shift_hours, shift_days, leave_start, leave_end', 'safe', 'on'=>'search'),
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
			'employee0' => array(self::BELONGS_TO, 'Employees', 'employee'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'employee' => 'Employee',
			'travel_in_ug_op' => 'Administrative Subsistence (Days)',
			'travel_in_ug_cap' => 'Travel In Ug (Capital/Projects)',
			'weekend_lunch' => 'Weekend Lunch (Days)',
			'weekend_transport' => 'Weekend Transport (Days)',
			'out_of_station' => 'Out Of Station (Days)',
			'acting_allowance' => 'Acting  (Days)',
			'mobile_phone_allowance' => 'Mobile Phone ',
			'risk_allowance' => 'Risk Allowance',
			'responsibility_allowance' => 'Responsibility  (Days)',
			'driving_allowance' => 'Driving',
			'mileage' => 'Mileage',
			'soap' => 'Soap ()',
			'shift' => 'Shift',
			'milk' => 'Milk',
			'leave_in_lieu' => 'Leave In Lieu (Days)',
			'overtime_weekdayhrs' => 'Overtime WeekDay (Hours)',
			'overtime_weekdaydays' => 'Overtime WeekDay (Days)',
			'overtime_weekend_hrs' => 'Overtime Weekend (Hours)',
			'overtime_weekend_days' => 'Overtime Weekend (Days)',
			'shift_hours' => 'Shift Hours',
			'shift_days' => 'Shift Days',
			'leave_start' => 'Leave Start',
			'terminal_benefits' => 'Terminal Benefits',
			'removal_allowance' => 'Removal Allowance',
			'leave_end' => 'Leave End',
			'budget' => 'Budget'
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
		//if($_REQUEST['r']=='emolumentrates/admin') {
		$criteria->compare('id',$this->id);
		$criteria->compare('employee',$this->employee); //array(1,2,3,50,103)
		$criteria->compare('travel_in_ug_op',$this->travel_in_ug_op);
		$criteria->compare('travel_in_ug_cap',$this->travel_in_ug_cap);
		$criteria->compare('weekend_lunch',$this->weekend_lunch);
		$criteria->compare('weekend_transport',$this->weekend_transport);
		$criteria->compare('out_of_station',$this->out_of_station);
		$criteria->compare('acting_allowance',$this->acting_allowance);
		$criteria->compare('mobile_phone_allowance',$this->mobile_phone_allowance);
		$criteria->compare('risk_allowance',$this->risk_allowance);
		$criteria->compare('responsibility_allowance',$this->responsibility_allowance);
		$criteria->compare('driving_allowance',$this->driving_allowance);
		$criteria->compare('mileage',$this->mileage);
		$criteria->compare('soap',$this->soap);
		$criteria->compare('shift',$this->shift);
		$criteria->compare('milk',$this->milk);
		$criteria->compare('leave_in_lieu',$this->leave_in_lieu);
		$criteria->compare('overtime_weekdayhrs',$this->overtime_weekdayhrs);
		$criteria->compare('overtime_weekdaydays',$this->overtime_weekdaydays);
		$criteria->compare('overtime_weekend_hrs',$this->overtime_weekend_hrs);
		$criteria->compare('overtime_weekend_days',$this->overtime_weekend_days);
		$criteria->compare('shift_hours',$this->shift_hours);
		$criteria->compare('shift_days',$this->shift_days);
		$criteria->compare('leave_start',$this->leave_start,true);
		$criteria->compare('leave_end',$this->leave_end,true);
//		$criteria->compare('budget',budget());
		//$criteria->addInCondition('','AND');
		$criteria->condition ="budget = '".user()->budget['id']."' and employee in (select id from employees where section='".user()->dept['id']."' and budget='".budget()."')"; 
//	}
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Emolumentrates the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
