<?php

/**
 * This is the model class for table "{{mod_currency}}".
 *
 * The followings are the available columns in table '{{mod_currency}}':
 * @property string $id
 * @property string $title
 * @property string $code
 * @property integer $is_default
 * @property string $conversion_rate
 * @property string $format
 * @property string $price_format
 * @property string $date_entry
 * @property integer $user_entry
 * @property string $date_update
 * @property integer $user_update
 */
class ModCurrency extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{mod_currency}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('date_entry, user_entry', 'required'),
			array('is_default, user_entry, user_update', 'numerical', 'integerOnly'=>true),
			array('title, price_format', 'length', 'max'=>50),
			array('code', 'length', 'max'=>3),
			array('conversion_rate', 'length', 'max'=>13),
			array('format', 'length', 'max'=>30),
			array('date_update', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, code, is_default, conversion_rate, format, price_format, date_entry, user_entry, date_update, user_update', 'safe', 'on'=>'search'),
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
			'title' => 'Title',
			'code' => 'Code',
			'is_default' => 'Is Default',
			'conversion_rate' => 'Conversion Rate',
			'format' => 'Format',
			'price_format' => 'Price Format',
			'date_entry' => 'Date Entry',
			'user_entry' => 'User Entry',
			'date_update' => 'Date Update',
			'user_update' => 'User Update',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('is_default',$this->is_default);
		$criteria->compare('conversion_rate',$this->conversion_rate,true);
		$criteria->compare('format',$this->format,true);
		$criteria->compare('price_format',$this->price_format,true);
		$criteria->compare('date_entry',$this->date_entry,true);
		$criteria->compare('user_entry',$this->user_entry);
		$criteria->compare('date_update',$this->date_update,true);
		$criteria->compare('user_update',$this->user_update);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ModCurrency the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getDefault()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('is_default',1);
		$model = self::model()->find($criteria);
		if(!$model instanceof ModCurrency){
			$criteria2 = new CDbCriteria;
			$criteria2->order = 't.id ASC';
			$criteria2->limit = 1;
			$model = self::model()->find($criteria2);
		}
		return $model;
	}
	
	public function listData()
	{
		return CHtml::listData(self::model()->findAll(), 'code', 'title');
	}
}
