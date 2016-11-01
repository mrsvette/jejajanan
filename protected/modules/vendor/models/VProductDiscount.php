<?php

/**
 * This is the model class for table "{{product_discount}}".
 *
 * The followings are the available columns in table '{{product_discount}}':
 * @property integer $id
 * @property integer $product_id
 * @property integer $customer_group_id
 * @property integer $quantity
 * @property integer $priority
 * @property double $price
 * @property string $date_start
 * @property string $date_end
 * @property string $date_entry
 * @property string $date_update
 */
class VProductDiscount extends CActiveRecord
{
	public $date_range;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{product_discount}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('product_id, price, date_entry', 'required'),
			array('product_id, customer_group_id, quantity, priority', 'numerical', 'integerOnly'=>true),
			array('price', 'numerical'),
			array('date_start, date_end, date_update, date_range', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, product_id, customer_group_id, quantity, priority, price, date_start, date_end, date_entry, date_update', 'safe', 'on'=>'search'),
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
			'product_id' => 'Product',
			'customer_group_id' => 'Customer Group',
			'quantity' => 'Quantity',
			'priority' => 'Priority',
			'price' => 'Price',
			'date_start' => 'Date Start',
			'date_end' => 'Date End',
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
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('customer_group_id',$this->customer_group_id);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('priority',$this->priority);
		$criteria->compare('price',$this->price);
		$criteria->compare('date_start',$this->date_start,true);
		$criteria->compare('date_end',$this->date_end,true);
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
	 * @return VProductDiscount the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * get range dicount data
	 * @param : id
	 * return text: 13 Jun 2016 - 16 Jun 2016
	 */
	public function getDateRange($id = 0)
	{
		if($id == 0)
			$model = $this;
		else
			$model = self::model()->findByPk($id);
		if(!empty($model->date_start) && !empty($model->date_end))
			$date_range = date("d M Y",strtotime($model->date_start)).' - '.date("d M Y",strtotime($model->date_end));
		return $date_range;
	}
}
