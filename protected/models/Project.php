<?php

/**
 * This is the model class for table "{{project}}".
 *
 * The followings are the available columns in table '{{project}}':
 * @property integer $id
 * @property integer $client_id
 * @property string $title
 * @property string $description
 * @property integer $status
 * @property integer $type
 * @property integer $added_by_account_id
 * @property double $estimated_hours
 * @property string $date_created
 * @property string $date_updated
 */
class Project extends CActiveRecord
{
	CONST STATUS_PRIORITY = 1;
	CONST STATUS_INPROGRESS = 2;
	CONST STATUS_WAITING_FEEDBACK = 3;
	CONST STATUS_PENDING = 4;
	CONST STATUS_ONHOLD = 5;
	CONST STATUS_DONE = 6;
	CONST STATUS_CLOSED = 7;
	
	//to avoid additional status and to maximized the sort order
	CONST STATUS_DELETED = 30;	
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{project}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('client_id, title, status, added_by_account_id', 'required'),
			array('client_id, status, type, added_by_account_id', 'numerical', 'integerOnly'=>true),
			array('estimated_hours', 'numerical'),
			array('title', 'length', 'max'=>255),
			array('description', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, client_id, title, description, status, type, added_by_account_id, estimated_hours, date_created, date_updated', 'safe', 'on'=>'search'),
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
			'client' => array(self::BELONGS_TO, 'Client', 'client_id'),
			'createdByAccount' => array(self::BELONGS_TO, 'Account', 'added_by_account_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'client_id' => 'Client',
			'title' => 'Project Title',
			'description' => 'Description',
			'status' => 'Status',
			'type' => 'Type',
			'added_by_account_id' => 'Added By Account',
			'estimated_hours' => 'Estimated Hours',
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
		$criteria->compare('client_id',$this->client_id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('type',$this->type);
		$criteria->compare('added_by_account_id',$this->added_by_account_id);
		$criteria->compare('estimated_hours',$this->estimated_hours);
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
	 * @return Project the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function scopes()
	{
		return array(
			'existing' => array(
				'condition' => $this->tableAlias.'.status <> '.self::STATUS_DELETED,
			),
			'orderByStatus' => array(
				'order' => $this->tableAlias.'.status ASC',
			),
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
	
	public function getStatusList()
	{
		return array(
			self::STATUS_PRIORITY => 'Priority',
			self::STATUS_INPROGRESS => 'In-progress',
			self::STATUS_WAITING_FEEDBACK => 'Waiting for feedback',
			self::STATUS_PENDING => 'Pending',
			self::STATUS_ONHOLD => 'On-hold',
			self::STATUS_DONE => 'Done',
			self::STATUS_CLOSED => 'Closed',
			self::STATUS_DELETED => 'Deleted',
		);
	}
	
	public function getStatusLabel ( $status )
	{
		$statusList = $this->getStatusList();
		return $statusList[$status];
	}
}
