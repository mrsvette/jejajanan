<?php

/**
 * This is the model class for table "{{customer_group}}".
 *
 * The followings are the available columns in table '{{customer_group}}':
 * @property integer $id
 * @property integer $vendor_id
 * @property string $name
 * @property string $description
 * @property integer $taxed
 * @property string $config
 * @property string $date_entry
 * @property string $date_update
 */
class VCustomerGroup extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{customer_group}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, taxed, date_entry', 'required'),
			array('vendor_id, taxed', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>128),
			array('description, config, date_update', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, vendor_id, name, description, taxed, config, date_entry, date_update', 'safe', 'on'=>'search'),
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
			'vendor_id' => 'Vendor',
			'name' => 'Name',
			'description' => 'Description',
			'taxed' => 'Taxed',
			'config' => 'Config',
			'date_entry' => 'Date Entry',
			'date_update' => 'Date Update',
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
		$criteria->compare('vendor_id',$this->vendor_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('taxed',$this->taxed);
		$criteria->compare('config',$this->config,true);
		$criteria->compare('date_entry',$this->date_entry,true);
		$criteria->compare('date_update',$this->date_update,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * @return CDbConnection the database connection used for this class
	 */
	public function getDbConnection()
	{
		return Yii::app()->db2;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return VCustomerGroup the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @param string $title 
	 * @return array of group name
	 */
	public function getItems($title = null)
	{
		$items = array();
		if(isset($title))
			$items[''] = $title;
		$criteria = new CDbCriteria;
		$criteria->compare('vendor_id',Yii::app()->user->id);
		$criteria->order = 'id ASC';
		$count = self::model()->count($criteria);
		if($count<=0){
			$criteria2 = new CDbCriteria;
			$criteria2->compare('vendor_id',0);
			$criteria2->order = 'id ASC';
			$criteria = $criteria2;
		}

		$models = self::model()->findAll($criteria);
		foreach($models as $model){
			$items[$model->id] = $model->name;
		}
		return $items;
	}
}
