<?php

/**
 * This is the model class for table "{{invoice_item}}".
 *
 * The followings are the available columns in table '{{invoice_item}}':
 * @property integer $id
 * @property integer $invoice_id
 * @property integer $rel_id
 * @property string $title
 * @property integer $quantity
 * @property double $price
 * @property integer $taxed
 * @property string $date_entry
 * @property string $date_update
 */
class VInvoiceItem extends CActiveRecord
{
	const STATUS_PENDING_PAYMENT = 'pending_payment';
    const STATUS_PENDING_SETUP = 'pending_setup';
    const STATUS_EXECUTED = 'executed';

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{invoice_item}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('date_entry', 'required'),
			array('invoice_id, rel_id, quantity, taxed', 'numerical', 'integerOnly'=>true),
			array('price', 'numerical'),
			array('title', 'length', 'max'=>255),
			array('date_update', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, invoice_id, rel_id, title, quantity, price, taxed, date_entry, date_update', 'safe', 'on'=>'search'),
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
			'invoice_rel'=>array(self::BELONGS_TO,'VInvoice','invoice_id'),
			'order_rel'=>array(self::BELONGS_TO,'VCustomerOrder','rel_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'invoice_id' => 'Invoice',
			'rel_id' => 'Rel',
			'title' => 'Title',
			'quantity' => 'Quantity',
			'price' => 'Price',
			'taxed' => 'Taxed',
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
		$criteria->compare('invoice_id',$this->invoice_id);
		$criteria->compare('rel_id',$this->rel_id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('price',$this->price);
		$criteria->compare('taxed',$this->taxed);
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
	 * @return VInvoiceItem the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
