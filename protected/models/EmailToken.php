<?php

/**
 * This is the model class for table "{{email_token}}".
 *
 * The followings are the available columns in table '{{email_token}}':
 * @property integer $id
 * @property integer $account_id
 * @property string $token
 * @property integer $status
 * @property integer $type
 * @property string $date_created
 * @property string $date_updated
 */
class EmailToken extends CActiveRecord
{
	
	const STATUS_ACTIVE = 1;
	const STATUS_INACTIVE = 2;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{email_token}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('account_id, token, date_created, date_updated', 'required'),
			array('account_id, status, type', 'numerical', 'integerOnly'=>true),
			array('token', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, account_id, token, status, type, date_created, date_updated', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'account_id' => 'Account',
			'token' => 'Token',
			'status' => 'Status',
			'type' => 'Type',
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
		$criteria->compare('account_id',$this->account_id);
		$criteria->compare('token',$this->token,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('type',$this->type);
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
	 * @return EmailToken the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function scopes()
	{
		return array(
			'active' => array(
				'condition' => "status = :status",
				'params' => array(
					':status' => self::STATUS_ACTIVE
				)
			),
			'inActive' => array(
				'condition' => "status = :status",
				'params' => array(
					':status' => self::STATUS_INACTIVE
				)
			)
		);
	}
	
	protected function beforeSave()
	{
		if (parent::beforeSave())
		{
			if ($this->isNewRecord)
			{
				$this->date_created = $this->date_updated = date('Y-m-d H:i:s');

			}
			else{

				$this->date_updated = date('Y-m-d H:i:s');

			}
			return true;
		}
	}
	
	public function getToken($token)
	{
		$accountToken = $this->active()->find(array(
			'condition' => 'token = :token',
			'params' => array(
				':token' => $token
			)
		));
	
		if ( $accountToken )
		{
			// check token if not expired (expiry 24 hours)
			if(strtotime("+24 hours", strtotime($accountToken->date_created)) > time())
				return $accountToken;
			else
				return null;
		}
		else
		{
			return null;
		}
	}
}
