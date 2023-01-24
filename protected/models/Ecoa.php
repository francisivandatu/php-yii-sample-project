<?php

/**
 * This is the model class for table "{{ecoa}}".
 *
 * The followings are the available columns in table '{{ecoa}}':
 * @property integer $id
 * @property integer $form_id
 * @property string $name
 * @property string $banker_id
 * @property string $phone
 * @property string $fax
 */
class Ecoa extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Ecoa the static model class
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
		return '{{ecoa}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			// array('name, banker_id, phone, fax', 'required'),
			
			array('form_id, banker_id, phone, fax', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>100),
			array('banker_id, phone, fax', 'length', 'max'=>25),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, form_id, name, banker_id, phone, fax', 'safe', 'on'=>'search'),
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
			'form_id' => 'Form',
			'name' => 'Banker Name',
			'banker_id' => 'Banker ID',
			'phone' => 'Phone No.',
			'fax' => 'Fax No.',
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
		$criteria->compare('form_id',$this->form_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('banker_id',$this->banker_id,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('fax',$this->fax,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}