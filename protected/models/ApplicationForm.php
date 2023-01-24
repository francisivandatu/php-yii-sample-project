<?php

/**
 * This is the model class for table "{{application_form}}".
 *
 * The followings are the available columns in table '{{application_form}}':
 * @property integer $id
 * @property string $legal_name
 * @property string $dba_name
 * @property string $address
 * @property string $city
 * @property string $state
 * @property integer $zip
 * @property string $phone
 * @property string $fax
 * @property string $mobile
 * @property string $email
 * @property string $tax_exempt
 * @property string $fed_tax_id
 * @property string $exempt_certificate_path
 * @property string $mailing_address
 * @property string $contact_name_title
 * @property string $business_start
 * @property string $business_state
 * @property string $business_incorporate
 * @property string $business_description
 * @property string $business_structure
 * @property string $business_check_account
 * @property string $business_loan_types
 * @property string $other_banking_name
 * @property string $other_banking_contact
 * @property string $other_banking_phone
 * @property string $other_banking_account_number
 * @property string $date_submitted
 * @property string $promo_code
 * @property integer $approved
 */
class ApplicationForm extends CActiveRecord
{
	
	CONST TYPE_SAVED = 2;
	CONST TYPE_PAID = 1;
	CONST TYPE_PENDING = 0;
	
	public $certificate_path_validator = '';
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ApplicationForm the static model class
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
		return '{{application_form}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			// array('legal_name, address, state, zip, phone, email, tax_exempt, fed_tax_id, mailing_address, contact_name_title, business_start, business_incorporate, business_description, business_structure, business_check_account, business_loan_types, other_banking_name, other_banking_contact, other_banking_phone, other_banking_account_number', 'required'),
			 
			array('approved', 'numerical', 'integerOnly'=>true),
			array('legal_name, dba_name, exempt_certificate_path, promo_code', 'length', 'max'=>255),
			array('address, fed_tax_id', 'length', 'max'=>150),
			array('city, country, state, tax_exempt, business_structure, business_check_account, other_banking_account_number', 'length', 'max'=>255),
			
			array('business_check_account, other_banking_account_number, phone, other_banking_phone', 'validateBankAccountNumber'),
			
			array('phone, fax, mobile, other_banking_contact, other_banking_phone', 'length', 'max'=>25),
			array('email', 'length', 'max'=>50),
			array('contact_name_title, other_banking_name', 'length', 'max'=>200),
			array('business_state', 'length', 'max'=>10),
			
			array('zip, date_submitted, mailing_address, contact_name_title, business_description, business_loan_types, business_incorporate, business_start, certificate_path_validator, country, other_state', 'safe'),
			
			array('exempt_certificate_path', 'checkTaxExempt'),
			// array('exempt_certificate_path', 'file', 'types' => 'png,doc,xlxs'),
			array('email', 'email', 'message'=>'Email is not valid.'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			
			// array('legal_name, address, city, state, zip, phone, email, tax_exempt, fed_tax_id, mailing_address, contact_name_title, business_start,  business_incorporate, business_description, business_structure, business_check_account, business_loan_types, other_banking_name, other_banking_contact, other_banking_phone, other_banking_account_number', 'required', 'on' => 'app_submit'),
			
			array('id, legal_name, dba_name, address, city, state, zip, phone, fax, mobile, email, tax_exempt, fed_tax_id, exempt_certificate_path, mailing_address, contact_name_title, business_start, business_state, business_incorporate, business_description, business_structure, business_check_account, business_loan_types, other_banking_name, other_banking_contact, other_banking_phone, other_banking_account_number, date_submitted, approved, promo_code', 'safe', 'on'=>'search'),
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
			'legal_name' => 'Business Legal Name',
			'dba_name' => 'DBA Name (if any)',
			'address' => 'Street Address',
			'city' => 'City',
			'state' => 'State',
			'zip' => 'Zip',
			'country' => 'Country', //added 2-20-2017
			'phone' => 'Phone',
			'fax' => 'Fax',
			'mobile' => 'Cell',
			'email' => 'Email',
			'tax_exempt' => 'Sales Tax Exempt',
			'fed_tax_id' => 'Fed Tax ID',
			'exempt_certificate_path' => 'Exemption Certificate',
			'mailing_address' => 'Mailing Address or PO Box',
			'contact_name_title' => 'Contact Name & Title',
			'business_start' => 'Date Business Started',
			'business_state' => 'Business State',
			'business_incorporate' => 'Date Business Incorporated',
			'business_description' => 'Description of Business',
			'business_structure' => 'Business Type',
			'business_check_account' => 'Business Checking Account #',
			'business_loan_types' => 'Business Loan Type(s), Account # (s)',
			'other_banking_name' => 'Bank Name',
			'other_banking_contact' => 'Contact Name',
			'other_banking_phone' => 'Phone Number',
			'other_banking_account_number' => 'Account Number',
			'date_submitted' => 'Date Submitted',
			'approved' => 'Approved',
                        'promo_code' => 'Promo Code'
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
		$criteria->compare('legal_name',$this->legal_name,true);
		$criteria->compare('dba_name',$this->dba_name,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('state',$this->state,true);
		$criteria->compare('zip',$this->zip);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('fax',$this->fax,true);
		$criteria->compare('mobile',$this->mobile,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('tax_exempt',$this->tax_exempt,true);
		$criteria->compare('fed_tax_id',$this->fed_tax_id,true);
		$criteria->compare('exempt_certificate_path',$this->exempt_certificate_path,true);
		$criteria->compare('mailing_address',$this->mailing_address,true);
		$criteria->compare('contact_name_title',$this->contact_name_title,true);
		$criteria->compare('business_start',$this->business_start,true);
		$criteria->compare('business_state',$this->business_state,true);
		$criteria->compare('business_incorporate',$this->business_incorporate,true);
		$criteria->compare('business_description',$this->business_description,true);
		$criteria->compare('business_structure',$this->business_structure,true);
		$criteria->compare('business_check_account',$this->business_check_account,true);
		$criteria->compare('business_loan_types',$this->business_loan_types,true);
		$criteria->compare('other_banking_name',$this->other_banking_name,true);
		$criteria->compare('other_banking_contact',$this->other_banking_contact,true);
		$criteria->compare('other_banking_phone',$this->other_banking_phone,true);
		$criteria->compare('other_banking_account_number',$this->other_banking_account_number,true);
		$criteria->compare('date_submitted',$this->date_submitted,true);
		$criteria->compare('approved',$this->approved);
                $criteria->compare('promo_code',$this->promo_code);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/*Developer defined validation functions*/
	public function checkTaxExempt($attributes,$params)
	{
		if($this->tax_exempt == 'Y')
		{
			if ( $this->isNewRecord )
			{
				if(empty($this->exempt_certificate_path))
				{
					 $this->addError('exempt_certificate_path','Exemption Certificate should be uploaded.');
				}
			}
			else
			{
				// Dev::pm($this);
				if ( empty($this->certificate_path_validator) AND empty($this->exempt_certificate_path) )
				{
					$this->addError('exempt_certificate_path','Exemption Certificate should be uploaded1.');
				}
			}
		}  
	}
	
	protected function beforeSave()
	{
		if (parent::beforeSave())
		{
			if ($this->isNewRecord)
			{
				$this->date_updated = date('Y-m-d H:i:s');
			}
			else
			{
				$this->date_updated = date('Y-m-d H:i:s');
			}
			
			return true;
		}
	}
	
	public function scopes()
	{
		return array(
			'forPayment' => array(
				'condition' => $this->tableAlias.'.type IN ('.self::TYPE_PENDING.', '.self::TYPE_SAVED.') ',
			),
			'savePendingForm' => array(
				'condition' => $this->tableAlias.'.type = '.self::TYPE_PENDING.'',
			),
			'savedForm' => array(
				'condition' => $this->tableAlias.'.type = '.self::TYPE_SAVED.'',
			),
		);
	}
	
	public function getTypeLabel ( $status )
	{
		$arrs = array(
			self::TYPE_SAVED => 'Save/Pending',
			self::TYPE_PAID => 'Paid',
			self::TYPE_PENDING => 'Pending Not Submitted'
		);
		
		return $arrs[$status];
	}
	
	public function getStateTextValue($abbrev)
	{
		$state = State::model()->find(array('condition' => 'abbrev = "'.$abbrev.'"' ));
		if ( $state )
			return $state->name;
		else
			return 'n/a';
	}
	
	public function getCityTextValue($cityId)
	{
		$city = Cities::model()->findByPk($cityId);
		
		if ( $city )
			return $city->city;
		else
			return 'n/a';
	}
	
	public function validateBankAccountNumber ( $attribute, $params )
	{
		if ( !empty($this->$attribute) AND $this->$attribute != "" )
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