<?php

/**
 * This is the model class for table "{{mod_product_viewed}}".
 *
 * The followings are the available columns in table '{{mod_product_viewed}}':
 * @property integer $id
 * @property integer $product_id
 * @property string $ip_address
 * @property string $url_referrer
 * @property string $date_entry
 * @property integer $user_entry
 */
class ModProductViewed extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{mod_product_viewed}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('product_id, ip_address, date_entry', 'required'),
			array('product_id, user_entry', 'numerical', 'integerOnly'=>true),
			array('ip_address', 'length', 'max'=>39),
			array('url_referrer', 'length', 'max'=>128),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, product_id, ip_address, url_referrer, date_entry, user_entry', 'safe', 'on'=>'search'),
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
			'product_rel'=>array(self::BELONGS_TO,'ModProduct','product_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'product_id' => 'Product',
			'ip_address' => 'Ip Address',
			'url_referrer' => 'Url Referrer',
			'date_entry' => 'Date Entry',
			'user_entry' => 'User Entry',
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
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('ip_address',$this->ip_address,true);
		$criteria->compare('url_referrer',$this->url_referrer,true);
		$criteria->compare('date_entry',$this->date_entry,true);
		$criteria->compare('user_entry',$this->user_entry);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ModProductViewed the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
