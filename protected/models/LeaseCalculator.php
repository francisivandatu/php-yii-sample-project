<?php

/**
 * This is the model class for table "{{lease_calculator}}".
 *
 * The followings are the available columns in table '{{lease_calculator}}':
 * @property integer $id
 * @property string $initial_invoice_amount
 * @property string $full_invoice_amount
 * @property integer $term
 * @property integer $status
 * @property string $result_monthly_cost
 * @property string $ip_address
 * @property string $date_created
 * @property string $date_updated
 */
class LeaseCalculator extends CActiveRecord
{
	CONST STATUS_ACTIVE = 1;
	CONST STATUS_DELETED = 3;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{lease_calculator}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('term', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('initial_invoice_amount', 'length', 'max'=>20),
			
			array('initial_invoice_amount','validateAmount'),
			
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, initial_invoice_amount, full_invoice_amount, term, status, result_monthly_cost, ip_address, date_created, date_updated', 'safe', 'on'=>'search'),
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
			'leaseCalculatorUser' => array(self::HAS_ONE, 'LeaseCalculatorUser', 'lease_calculator_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'initial_invoice_amount' => 'Initial Invoice Amount',
			'full_invoice_amount' => 'Full Invoice Amount',
			'term' => 'Term',
			'status' => 'Status',
			'result_monthly_cost' => 'Result Monthly Cost',
			'ip_address' => 'Ip Address',
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
		$criteria->compare('initial_invoice_amount',$this->initial_invoice_amount,true);
		$criteria->compare('full_invoice_amount',$this->full_invoice_amount,true);
		$criteria->compare('term',$this->term);
		$criteria->compare('status',$this->status);
		$criteria->compare('result_monthly_cost',$this->result_monthly_cost,true);
		$criteria->compare('ip_address',$this->ip_address,true);
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
	 * @return LeaseCalculator the static model class
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
				$this->ip_address = self::getClientIp();
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
		$t=$this->getTableAlias(false, false); //prevent infinity loop
		return array(
			'existing'=>array(
				'condition' => $t.'.status <> '.self::STATUS_DELETED,
			),
			'active'=>array(
				'condition' => $t.'.status = '.self::STATUS_ACTIVE,
			),
			'orderDesc' => array(
				'order' => 'id DESC'
			)
		);
	}
	
	public function computeMonthlyCost()
	{
		//computation reference: http://www.efunda.com/formulae/finance/apr_calculator.cfm
		
		$essexInterestRate = 8; // 8%
		$computedInterestRate = $essexInterestRate / 1200;
		$raisedInterestRate = pow((1+$computedInterestRate), $this->term);
		
		$essexMarkup = 1.05;		// 5%
		$this->full_invoice_amount = $this->initial_invoice_amount * $essexMarkup;
		
		$_result = $this->full_invoice_amount * $computedInterestRate * $raisedInterestRate;
		$_result = $_result / ($raisedInterestRate - 1);
		
		return $this->result_monthly_cost = $_result;
	}
	
	public function getMonthlyInvoiceRange()
	{
		$result = array(
			'rangeFrom' => 0,
			'rangeTo' => 0
		);
		
		$calculationResultExtra = ($this->result_monthly_cost*0.03);
		$result['rangeFrom'] = $this->result_monthly_cost - $calculationResultExtra;
		$result['rangeTo'] = $this->result_monthly_cost + $calculationResultExtra;
		
		return $result;
	}
	
	public function validateAmount($fieldKey)
	{
		$_value = str_replace(',','', $this->$fieldKey);
		// $_value = $this->$fieldKey;
		
		if ( !is_numeric($_value) )
		{
			$this->addError($fieldKey,'Total Invoice amount must be numeric value');
			return false;
		}
		else if ( $_value > 1000000000 )
		{
			$this->addError($fieldKey,'Total Invoice amount should not be more than 900million');
			return false;
		}
		else	//make sure that the data is sanitized for database
		{
			if ( $_value <= 39.99 )
			{
				$this->addError($fieldKey,'Total Invoice amount must be greater than or equal to $40.00');
				return false;
			}
			else
			{
				$this->$fieldKey = $_value;
				return true;
			}
		}
	}
	
	// Function to get the client IP address
	private static function getClientIp() 
	{
		if( array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER) && !empty($_SERVER['HTTP_X_FORWARDED_FOR']) ) {
			if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',')>0) {
				$addr = explode(",",$_SERVER['HTTP_X_FORWARDED_FOR']);
				return trim($addr[0]);
			} else {
				return $_SERVER['HTTP_X_FORWARDED_FOR'];
			}
		}
		else {
			return $_SERVER['REMOTE_ADDR'];
		}
	}
	
	public function getPaymentTermLabel( $termSelected )
	{
		$terms = array(
			35 => '3 years',
			47 => '4 years',
			59 => '5 years'
		);
		
		if ( isset($terms[$termSelected]) )
		{
			return $terms[$termSelected];
		}
		else
			return 'n/a';
	}
}