<?php

/**
 * This is the model class for table "{{application_principal_info}}".
 *
 * The followings are the available columns in table '{{application_principal_info}}':
 * @property integer $id
 * @property integer $form_id
 * @property string $name_title
 * @property string $address
 * @property string $location
 * @property integer $ownership
 * @property string $security_number
 */
class PrincipalInfo extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PrincipalInfo the static model class
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
		return '{{application_principal_info}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			// array('name_title, address, location, ownership, security_number', 'required'),
			array('ownership, email_address', 'required'),
			array('form_id, ownership', 'numerical', 'integerOnly'=>true),
			array('name_title, location, address', 'length', 'max'=>100),
			array('security_number', 'length', 'max'=>50),
			array('email_address', 'email'),
			array('check_flag', 'safe'),
			array('security_number','validateBankAccountNumber'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, form_id, name_title, address, location, ownership, security_number', 'safe', 'on'=>'search'),
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
			'name_title' => 'Name Title',
			'address' => 'Address',
			'location' => 'Location',
			'ownership' => 'Ownership',
			'security_number' => 'Security Number',
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
		$criteria->compare('name_title',$this->name_title,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('location',$this->location,true);
		$criteria->compare('ownership',$this->ownership);
		$criteria->compare('security_number',$this->security_number,true);

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