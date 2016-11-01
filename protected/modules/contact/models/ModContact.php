<?php

/**
 * This is the model class for table "{{mod_contact}}".
 *
 * The followings are the available columns in table '{{mod_contact}}':
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $address
 * @property string $website
 * @property string $subject
 * @property string $message
 * @property integer $status
 * @property string $date_entry
 * @property string $date_update
 */
class ModContact extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{mod_contact}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, email, phone, subject, message, date_entry', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('name, email, website', 'length', 'max'=>128),
			array('phone', 'length', 'max'=>64),
			array('subject', 'length', 'max'=>256),
			array('address, date_update', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, email, phone, address, website, subject, message, status, date_entry, date_update', 'safe', 'on'=>'search'),
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
			'name' => Yii::t('ContactModule.contact','Name'),
			'email' => Yii::t('ContactModule.contact','Email'),
			'phone' => Yii::t('ContactModule.contact','Phone'),
			'address' => Yii::t('ContactModule.contact','Address'),
			'website' => Yii::t('ContactModule.contact','Website'),
			'subject' => Yii::t('ContactModule.contact','Subject'),
			'message' => Yii::t('ContactModule.contact','Message'),
			'status' => 'Status',
			'date_entry' => Yii::t('global','Date Entry'),
			'date_update' => Yii::t('global','Date Update'),
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('website',$this->website,true);
		$criteria->compare('subject',$this->subject,true);
		$criteria->compare('message',$this->message,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('date_entry',$this->date_entry,true);
		$criteria->compare('date_update',$this->date_update,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ModContact the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function counter($status=0)
	{
		$criteria=new CDbCriteria;
		$criteria->compare('status',$status);

		return self::model()->count($criteria);
	}
}
