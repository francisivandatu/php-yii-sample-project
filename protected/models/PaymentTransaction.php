<?php

/**
 * This is the model class for table "{{payment_transaction}}".
 *
 * The followings are the available columns in table '{{payment_transaction}}':
 * @property integer $id
 * @property integer $account_id
 * @property string $first_name
 * @property string $last_name
 * @property string $middle_name
 * @property string $billing_address1
 * @property string $billing_address2
 * @property string $country
 * @property string $city
 * @property string $state
 * @property string $zip
 * @property double $total
 * @property double $tax_amount
 * @property string $invoice_number
 * @property string $txn_id
 * @property string $txn_time
 * @property string $approval_code
 * @property integer $status
 * @property integer $payment_method
 * @property string $date_created
 * @property string $date_updated
 * @property string $promo_code
 */
class PaymentTransaction extends CActiveRecord
{
	
	const STATUS_COMPLETED = 1;
	const STATUS_PROCESSING = 2;
	const STATUS_DELETED = 3;
	const STATUS_DECLINED = 4;
	const STATUS_PENDING = 5;
        
        const METHOD_CREDIT_CARD = 1;
        const METHOD_PROMO_CODE = 2;
        const METHOD_PAYPAL = 3;
	
	public $card_number;
	public $card_type;
	public $card_expiration_month;
	public $card_expiration_year;
	public $card_verification_number;
        
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{payment_transaction}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('account_id, first_name, last_name, billing_address1, city, state, zip', 'required'),
                        array('card_number, card_type, card_expiration_month, card_expiration_year, card_verification_number','required', 'on' => 'credit_card'),
			array('account_id, status, payment_method', 'numerical', 'integerOnly'=>true),
			array('total, tax_amount', 'numerical'),
			array('first_name, last_name, middle_name, country, city, state', 'length', 'max'=>125),
			array('zip', 'length', 'max'=>45),
			array('invoice_number, txn_id, txn_time, approval_code', 'length', 'max'=>128),
			array('billing_address2, date_created, date_updated, remarks, promo_code, card_number, card_type, card_expiration_month, card_expiration_year, card_verification_number', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, account_id, first_name, last_name, middle_name, billing_address1, billing_address2, country, city, state, zip, total, tax_amount, invoice_number, txn_id, txn_time, approval_code, status, payment_method, date_created, date_updated, promo_code', 'safe', 'on'=>'search'),
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
			'account_id' => 'Account',
			'first_name' => 'First Name',
			'last_name' => 'Last Name',
			'middle_name' => 'Middle Name',
			'billing_address1' => 'Billing Address1',
			'billing_address2' => 'Billing Address2',
			'country' => 'Country',
			'city' => 'City',
			'state' => 'State',
			'zip' => 'Zip',
			'total' => 'Total',
			'tax_amount' => 'Tax Amount',
			'invoice_number' => 'Invoice Number',
			'txn_id' => 'Txn',
			'txn_time' => 'Txn Time',
			'approval_code' => 'Approval Code',
			'status' => 'Status',
			'payment_method' => 'Payment Method',
			'date_created' => 'Date Created',
			'date_updated' => 'Date Updated',
			'card_verification_number' => 'Card Verification Number (CVV)',
                        'promo_code' => 'Promo Code'
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
		$criteria->compare('account_id',$this->account_id);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('middle_name',$this->middle_name,true);
		$criteria->compare('billing_address1',$this->billing_address1,true);
		$criteria->compare('billing_address2',$this->billing_address2,true);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('state',$this->state,true);
		$criteria->compare('zip',$this->zip,true);
		$criteria->compare('total',$this->total);
		$criteria->compare('tax_amount',$this->tax_amount);
		$criteria->compare('invoice_number',$this->invoice_number,true);
		$criteria->compare('txn_id',$this->txn_id,true);
		$criteria->compare('txn_time',$this->txn_time,true);
		$criteria->compare('approval_code',$this->approval_code,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('payment_method',$this->payment_method);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
                $criteria->compare('promo_code',$this->promo_code,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return PaymentTransaction the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function generateInvoiceId($processId)
	{
		$str = substr(str_shuffle(str_repeat("abcdefghijklmnopqrstuvwxyz", 5)), 0, 2);
		$str .= rand(1000, 999999);
		$str .= $processId;
			
		return $str;
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
	
	public function scopes()
	{
		return array(
			'paymentComplete' => array(
				'condition' => $this->tableAlias.'.status = '.self::STATUS_COMPLETED,
			),
		);
	}
        
        public static function promos()
        {
            return array(
                'j5yhr8' => array(
                    'code' => 'j5yhr8',
                    'price' => 0
                ),
				'bp123' => array(
                    'code' => 'bp123',
                    'price' => 0
                ),
				'rof123' => array(
                    'code' => 'rof123',
                    'price' => 0
                ),
				'cs123' => array(
                    'code' => 'cs123',
                    'price' => 0
                ),
				'ofr123' => array(
                    'code' => 'ofr123',
                    'price' => 0
                ),
				'zen123' => array(
                    'code' => 'zen123',
                    'price' => 0
                )
            );
        }
}
