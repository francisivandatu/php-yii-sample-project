<?php

/**
 * This is the model class for table "{{trade_reference}}".
 *
 * The followings are the available columns in table '{{trade_reference}}':
 * @property integer $id
 * @property integer $form_id
 * @property string $trade_name
 * @property string $trade_location
 * @property string $trade_phone
 * @property string $trade_contact
 * @property string $trade_account_number
 */
class TradeReference extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TradeReference the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{trade_reference}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			// array('trade_name, trade_location, trade_phone, trade_contact, trade_account_number', 'required'),
			array('form_id', 'numerical', 'integerOnly'=>true),
			array('trade_name', 'length', 'max'=>200),
			array('trade_location, trade_contact', 'length', 'max'=>100),
			array('trade_phone, trade_account_number', 'length', 'max'=>25),
			array('trade_phone, trade_account_number','validateBankAccountNumber'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, form_id, trade_name, trade_location, trade_phone, trade_contact, trade_account_number', 'safe', 'on'=>'search'),
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
			'form_id' => 'Form',
			'trade_name' => 'Name of Reference',
			'trade_location' => 'City/State',
			'trade_phone' => 'Phone',
			'trade_contact' => 'Contact',
			'trade_account_number' => 'Account No.',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('form_id',$this->form_id);
		$criteria->compare('trade_name',$this->trade_name,true);
		$criteria->compare('trade_location',$this->trade_location,true);
		$criteria->compare('trade_phone',$this->trade_phone,true);
		$criteria->compare('trade_contact',$this->trade_contact,true);
		$criteria->compare('trade_account_number',$this->trade_account_number,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function validateBankAccountNumber ( $attribute, $params )
	{
		if ( !empty($this->$attribute) AND $this->$attribute != "")
		{
			$_tempVal = str_replace(array(',',' ', '-'), array('','',''), trim($this->$attribute));
			if ( strpos($_tempVal, '.') !== false OR !is_numeric($_tempVal) )
			{
				$this->addError($attribute, $this->getAttributeLabel($attribute).' must be a numeric value.');
				return false;
			}
		}
	}
}