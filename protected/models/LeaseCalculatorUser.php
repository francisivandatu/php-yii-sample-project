<?php

/**
 * This is the model class for table "{{lease_calculator_user}}".
 *
 * The followings are the available columns in table '{{lease_calculator_user}}':
 * @property integer $id
 * @property integer $lease_calculator_id
 * @property string $first_name
 * @property string $last_name
 * @property string $email_address
 * @property integer $status
 * @property string $date_created
 * @property string $date_updated
 */
class LeaseCalculatorUser extends CActiveRecord
{
	CONST STATUS_ACTIVE = 1;
	CONST STATUS_DELETED = 3;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{lease_calculator_user}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lease_calculator_id, first_name, last_name, email_address, company, status', 'required'),
			array('lease_calculator_id, status', 'numerical', 'integerOnly'=>true),
			array('first_name, email_address', 'length', 'max'=>255),
			array('last_name', 'length', 'max'=>25),
			
			array('email_address','email'),
			
			array('phone,comments','safe'),
			
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, lease_calculator_id, first_name, last_name, email_address, status, date_created, date_updated', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'lease_calculator_id' => 'Lease Calculator',
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'email_address' => 'Email Address',
			'status' => 'Status',
			'date_created' => 'Date Created',
			'date_updated' => 'Date Updated',
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
		$criteria->compare('lease_calculator_id',$this->lease_calculator_id);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('email_address',$this->email_address,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LeaseCalculatorUser the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	protected function beforeSave()
	{
		if (parent::beforeSave())
		{
			if ($this->isNewRecord)
			{
				$this->date_created = $this->date_updated = date('Y-m-d H:i:s');
			}
			else
			{
				$this->date_updated = date('Y-m-d H:i:s');
			}
			
			return true;
		}
	}
}
