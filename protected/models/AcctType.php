<?php

/**
 * This is the model class for table "{{acct_type}}".
 *
 * The followings are the available columns in table '{{acct_type}}':
 * @property integer $id
 * @property string $type
 *
 * The followings are the available model relations:
 * @property Account[] $accounts
 */
class AcctType extends CActiveRecord
{
	private static $_items;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AcctType the static model class
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
		return '{{acct_type}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type', 'required'),
			array('type', 'length', 'max'=>200),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, type', 'safe', 'on'=>'search'),
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
			'accounts' => array(self::HAS_MANY, 'Account', 'type'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'type' => 'Type',
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
		$criteria->compare('type',$this->type,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	
	public static function items($options = array())
    {
        if (!isset(self::$_items))
            self::loadItems($options);
			
        return self::$_items;
    }
	
	private static function loadItems($options)
    {
        self::$_items = array();
        $models = self::model()->findAll($options);
        foreach ($models as $model)
            self::$_items[$model->id] = ucwords($model->type);
    }
	
	
}
