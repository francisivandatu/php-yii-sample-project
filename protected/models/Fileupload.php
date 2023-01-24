<?php

/**
 * This is the model class for table "{{fileupload}}".
 *
 * The followings are the available columns in table '{{fileupload}}':
 * @property integer $id
 * @property string $original_filename
 * @property string $name
 * @property string $extension
 * @property integer $status
 * @property string $date_created
 *
 * The followings are the available model relations:
 * @property NewsEvent[] $newsEvents
 */
class Fileupload extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Fileupload the static model class
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
		return '{{fileupload}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('original_filename, name, extension, status, date_created', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('original_filename', 'length', 'max'=>256),
			array('name, extension', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, original_filename, name, extension, status, date_created', 'safe', 'on'=>'search'),
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
			'newsEvents' => array(self::BELONGS_TO, 'NewsEvent', 'preview_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'original_filename' => 'Original Filename',
			'name' => 'Name',
			'extension' => 'Extension',
			'status' => 'Status',
			'date_created' => 'Date Created',
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
		$criteria->compare('original_filename',$this->original_filename,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('extension',$this->extension,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('date_created',$this->date_created,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	
	public function getFile($size = null)
	{
		switch($size)
		{
			case "large":
				$filename = $this->name . "_l";
				break;
			case "medium":
				$filename = $this->name . "_m";
				break;
			case "small":
				$filename = $this->name . "_s";
				break;
			case "thumb":
				$filename = $this->name . "_th";
				break;
			default:
				$filename = $this->name;
				break;
		}
		$return = $filename . "." . $this->extension;
		return $return;
	}
	
	public function getFilePath($size = null)
	{
		return Yii::app()->request->baseUrl . "/uploads/" . $this->getFile($size);
	}
	
	public function getAbsPath()
	{
		return Yii::app()->getBasePath() . '/../uploads/' . $this->getFile();
	}
	
}
