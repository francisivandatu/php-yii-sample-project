<?php

/**
 * This is the model class for table "{{vendor_info}}".
 *
 * The followings are the available columns in table '{{vendor_info}}':
 * @property integer $id
 * @property integer $form_id
 * @property string $name
 * @property string $address
 * @property string $location
 * @property string $phone
 * @property string $contact_person
 * @property string $contact_phone
 * @property integer $new_flag
 * @property string $equipment_description
 * @property string $equipment_location
 * @property double $monthly_payment
 * @property double $total_invoice
 * @property integer $term
 * @property integer $lease_option
 * @property string $line_of_credit
 */
class VendorInfo extends CActiveRecord
{
	public $other_line_of_credit;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VendorInfo the static model class
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
		return '{{vendor_info}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			// array('name, address, location, contact_person, contact_phone, equipment_description, equipment_location, monthly_payment, total_invoice, term, lease_option', 'required'),
			
			array('form_id, new_flag, term, lease_option', 'numerical', 'integerOnly'=>true),
			array('monthly_payment, total_invoice, other_line_of_credit, phone, contact_phone', 'validateNumericValue'),
			array('name, contact_person, equipment_location', 'length', 'max'=>100),
			array('location', 'length', 'max'=>50),
			array('phone, contact_phone', 'length', 'max'=>25),
			array('line_of_credit', 'length', 'max'=>10),
			
			array('address, equipment_description','safe'),
			// array('email', 'unique', 'attributeName' => 'email', 'message'=>'This Email is already in use'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, form_id, name, address, location, phone, contact_person, contact_phone, new_flag, equipment_description, equipment_location, monthly_payment, total_invoice, term, lease_option, line_of_credit', 'safe', 'on'=>'search'),
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
			'name' => 'Vendor Name',
			'address' => 'Street Address',
			'location' => 'City, State, Zip',
			'phone' => 'Phone',
			'contact_person' => 'Contact Person',
			'contact_phone' => 'Phone Number',
			'new_flag' => 'New Flag',
			'equipment_description' => 'Equipment Description',
			'equipment_location' => 'Equipment Location',
			'monthly_payment' => 'Desired Monthly Payment',
			'total_invoice' => 'Total Invoice',
			'term' => 'Desired Term',
			'lease_option' => 'Type',
			'line_of_credit' => 'Line Of Credit',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('location',$this->location,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('contact_person',$this->contact_person,true);
		$criteria->compare('contact_phone',$this->contact_phone,true);
		$criteria->compare('new_flag',$this->new_flag);
		$criteria->compare('equipment_description',$this->equipment_description,true);
		$criteria->compare('equipment_location',$this->equipment_location,true);
		$criteria->compare('monthly_payment',$this->monthly_payment);
		$criteria->compare('total_invoice',$this->total_invoice);
		$criteria->compare('term',$this->term);
		$criteria->compare('lease_option',$this->lease_option);
		$criteria->compare('line_of_credit',$this->line_of_credit,true);
		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function validateNumericValue ( $attribute, $params )
	{
		if ( ( !empty($this->$attribute) OR $this->$attribute == 0 ) AND $this->$attribute != "")
		{
			// if ( is_numeric($this->$attribute) )
			if ( preg_match('#^([\$]?)([0-9,\s]*\.?[0-9]{0,2})$#', $this->$attribute) )
			{
				$_tempVal = str_replace(array(',',' '), array('',''), $this->$attribute);
				if ( $_tempVal <= 0 )
				{
					$this->addError($attribute, $this->getAttributeLabel($attribute).' must be greater than zero.');
					return false;
				}
				else
				{
					if ( strpos($this->$attribute, ',') )
					{
						$_tempVal = explode(',',$this->$attribute);
		
						foreach ( $_tempVal as $index => $value )
						{
							$value = trim($value);
							
							if($index == 0)	//validate the first portion of the amount
							{
								if ( empty($value) )
								{
									$this->addError($attribute, $this->getAttributeLabel($attribute).' must be a valid numeric value.');
									break;
								}
							}
							else if ( $index == (count($_tempVal) - 1) )	//validate the last portion of the amount if proper format
							{
								if ( strpos($value, '.') )	//check if the last portion and decimal place are properly formatted
								{
									$_tempVal2 = explode('.',$value);
									$_tempVal2[0] = trim($_tempVal2[0]);
									$_tempVal2[1] = trim($_tempVal2[1]);
									
									if ( strlen($_tempVal2[0]) != 3 OR strlen($_tempVal2[1]) != 2 )	
									{
										$this->addError($attribute, $this->getAttributeLabel($attribute).' must be a valid numeric value.');
										break;
									}
								}
								else	//validate last portion with no decimal
								{
									if ( strlen($value) != 3 )
									{
										$this->addError($attribute, $this->getAttributeLabel($attribute).' must be a valid numeric value.');
										break;
									}
								}
							}
							else	//validate all middle portion of the amount if proper format
							{
								if ( strlen($value) != 3 )
								{
									$this->addError($attribute, $this->getAttributeLabel($attribute).' must be a valid numeric value.');
									break;
								}
							}
						}
					}
				}
			}
			else
			{
				$this->addError($attribute, $this->getAttributeLabel($attribute).' must be a numeric value.');
				return false;
			}
		}
	}

	protected function beforeSave()
	{
		if (parent::beforeSave())
		{
			if ( !empty($this->total_invoice) )
			{
				$this->total_invoice = str_replace(array(',',' '), array('',''), $this->total_invoice);
			}
			
			if ( !empty($this->monthly_payment) )
			{
				$this->monthly_payment = str_replace(array(',',' '), array('',''), $this->monthly_payment);
			}
			
			return true;
		}
	}
}