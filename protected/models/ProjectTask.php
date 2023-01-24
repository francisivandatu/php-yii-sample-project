<?php

/**
 * This is the model class for table "{{project_task}}".
 *
 * The followings are the available columns in table '{{project_task}}':
 * @property integer $id
 * @property integer $account_id
 * @property integer $assigned_by_account_id
 * @property integer $project_id
 * @property string $title
 * @property string $notes
 * @property integer $status
 * @property integer $type
 * @property double $estimated_hours
 * @property string $date_created
 * @property string $date_updated
 */
class ProjectTask extends CActiveRecord
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
	
	CONST TYPE_WEB_DEV = 'Module / Web Development';
	CONST TYPE_SEO = 'SEO';
	CONST TYPE_GRAPHICS = 'Graphics';
	CONST TYPE_QA_FIX = 'QA Bug Fix';
	CONST TYPE_QA_TESTING = 'QA Testing / Issues';
	CONST TYPE_CLIENT_MOD = 'Client Modifications';
	CONST TYPE_CLIENT_COMM = 'Client Communications';
	CONST TYPE_SALES = 'Sales';
	CONST TYPE_PHONE = 'Phone';
	CONST TYPE_DATA_ENCODING = 'Data Encoding';
	CONST TYPE_ZOE_SESSION = 'ZOE Sessions';
	CONST TYPE_ADMIN_GENERAL = 'Admin General Task';
	CONST TYPE_ADMIN_REPORTS = 'Admin Reports';
	CONST TYPE_APPLICANT_INTERVIEW = 'Applicant Interview';
	CONST TYPE_OFFICE_MAINTENANCE = 'Office Maintenance';
	CONST TYPE_IT_MAINTENANCE = 'IT Maintenance';
	CONST TYPE_IT_NETWORKING = 'IT Networking';
	CONST TYPE_OTHERS = 'Others';
	CONST TYPE_TASK_MANAGEMENT = 'Task Management';
	CONST TYPE_MARKETING = 'Marketing';
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{project_task}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('account_id, assigned_by_account_id, project_id, title, notes, status, type', 'required'),
			array('account_id, assigned_by_account_id, project_id, status, type', 'numerical', 'integerOnly'=>true),
			array('estimated_hours', 'numerical'),
			array('title', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, account_id, assigned_by_account_id, project_id, title, notes, status, type, estimated_hours, date_created, date_updated', 'safe', 'on'=>'search'),
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
			'assigned_by_account_id' => 'Assigned By Account',
			'project_id' => 'Project',
			'title' => 'Title',
			'notes' => 'Notes',
			'status' => 'Status',
			'type' => 'Status Report Types',
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
		$criteria->compare('account_id',$this->account_id);
		$criteria->compare('assigned_by_account_id',$this->assigned_by_account_id);
		$criteria->compare('project_id',$this->project_id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('notes',$this->notes,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('type',$this->type);
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
	 * @return ProjectTask the static model class
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
	
	public function getTypeList ()
	{
		return array (
			'Web And Tech' => array(
				self::TYPE_WEB_DEV => 'Module / Web Development',
				self::TYPE_SEO => 'SEO',
				self::TYPE_DATA_ENCODING => 'Data Encoding',			
				self::TYPE_GRAPHICS => 'Graphics',
			),
			'QA' => array(
				self::TYPE_QA_FIX => 'QA Bug Fix',
				self::TYPE_QA_TESTING => 'QA Testing / Issues',
				self::TYPE_ZOE_SESSION => 'ZOE Sessions',
			),
			'Sales And Communications' => array(
				self::TYPE_PHONE => 'Phone',
				self::TYPE_CLIENT_COMM => 'Client Communications',
				self::TYPE_CLIENT_MOD => 'Client Modifications',
				self::TYPE_SALES => 'Sales',
			),
			'Admin' => array(
				self::TYPE_TASK_MANAGEMENT => 'Task Management',
				self::TYPE_ADMIN_REPORTS => 'Admin Reports',
				self::TYPE_ADMIN_GENERAL => 'Admin General Task',
				self::TYPE_MARKETING => 'Marketing',
			),
			'Office' => array(
				self::TYPE_APPLICANT_INTERVIEW => 'Applicant Interview',
				self::TYPE_OFFICE_MAINTENANCE => 'Office Maintenance',
				self::TYPE_IT_MAINTENANCE => 'IT Maintenance',
				self::TYPE_IT_NETWORKING => 'IT Networking',
			),
			self::TYPE_OTHERS => 'Others',
		);
	}
	
	public function getTypeLabel ( $type )
	{
		$statusList = $this->getTypeList();
		return $statusList[$type];
	}
}
