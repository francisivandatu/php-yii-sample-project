<?php

/**
 * This is the model class for table "client".
 *
 * The followings are the available columns in table 'client':
 * @property integer $id
 * @property integer $client_name
 * @property string $email_address
 * @property string $description
 * @property integer $status
 * @property integer $type
 * @property string $date_created
 * @property string $date_updated
 */
class Client extends CActiveRecord
{
	CONST STATUS_ACTIVE = 1;
	CONST STATUS_INACTIVE = 2;
	CONST STATUS_DELETED = 3;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'client';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('client_name, email_address, status, type', 'required'),
			array('status, type', 'numerical', 'integerOnly'=>true),
			array('email_address', 'length', 'max'=>255),
			array('description', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, client_name, email_address, description, status, type, date_created, date_updated', 'safe', 'on'=>'search'),
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
			'client_name' => 'Client Name',
			'email_address' => 'Email Address',
			'description' => 'Description',
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
		$criteria->compare('client_name',$this->client_name);
		$criteria->compare('email_address',$this->email_address,true);
		$criteria->compare('description',$this->description,true);
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
	 * @return Client the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
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
		);
	}
	
	protected function beforeSave(){
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
	
	public function getStatusList()
	{
		return array(
			self::STATUS_ACTIVE => 'Active',
			self::STATUS_INACTIVE => 'Inactive',
			self::STATUS_DELETED => 'Deleted',
		);
	}
	
	public function getStatusLabel ( $status )
	{
		$statusList = $this->getStatusList();
		return $statusList[$status];
	}
	
	public function getClientList()
	{
		return self::model()->existing()->findAll();
	}
}
