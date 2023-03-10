<?php

/**
 * This is the model class for table "{{user_billing_info}}".
 *
 * The followings are the available columns in table '{{user_billing_info}}':
 * @property integer $account_id
 * @property string $first_name
 * @property string $last_name
 * @property string $billing_address1
 * @property string $billing_address2
 * @property string $country
 * @property string $city
 * @property string $state
 * @property string $zip
 *
 * The followings are the available model relations:
 * @property Account $account
 */
class UserBillingInfo extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{user_billing_info}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('first_name, last_name, billing_address1, country, city, state, zip', 'required', 'on' => 'paymentProcess'),
			array('account_id', 'numerical', 'integerOnly'=>true),
			array('first_name, last_name', 'length', 'max'=>128),
                        array('billing_address1, billing_address2', 'length', 'max'=>255),
			array('country, city, state', 'length', 'max'=>125),
			array('zip', 'length', 'max'=>45),
			array('billing_address2', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('account_id, first_name, last_name, billing_address1, billing_address2, country, city, state, zip', 'safe', 'on'=>'search'),
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
			'account' => array(self::BELONGS_TO, 'Account', 'account_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'account_id' => 'Account',
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'billing_address1' => 'Billing Address1',
			'billing_address2' => 'Billing Address2',
			'country' => 'Country',
			'city' => 'City',
			'state' => 'State',
			'zip' => 'Zip',
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

		$criteria->compare('account_id',$this->account_id);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('billing_address1',$this->billing_address1,true);
		$criteria->compare('billing_address2',$this->billing_address2,true);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('state',$this->state,true);
		$criteria->compare('zip',$this->zip,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return UserBillingInfo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public static function cardTypes()
	{
		return array(
			'Visa' => 'Visa',
			'MasterCard' => 'MasterCard',
			'Discover' => 'Discover',
			'Amex' => 'American Express',
		);
	}
	
	public static function cardExpirationMonths()
	{
		$cardExpirationMonths = array();
		
		foreach (range(1, 12) as $month)
		{
			$cardExpirationMonths[date('m', strtotime('2013-' . $month . '-1'))] = date('F', strtotime('2013-' . $month . '-1'));
		}
		
		return $cardExpirationMonths;
	}
	
	public static function cardExpirationYears()
	{
		$cardExpirationYears = array();
		
		foreach (range(date('Y'), (date('Y') + 10)) as $year)
		{
			$cardExpirationYears[$year] = $year;
		}
		
		return $cardExpirationYears;
	}
}
