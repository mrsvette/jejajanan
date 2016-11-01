<?php

/**
 * This is the model class for table "{{customer_order}}".
 *
 * The followings are the available columns in table '{{customer_order}}':
 * @property integer $id
 * @property integer $vendor_id
 * @property string $customer_id
 * @property string $product_id
 * @property string $promo_id
 * @property integer $promo_recurring
 * @property string $promo_used
 * @property string $group_id
 * @property integer $group_master
 * @property string $invoice_option
 * @property string $title
 * @property string $currency
 * @property string $unpaid_invoice_id
 * @property string $quantity
 * @property string $unit
 * @property double $price
 * @property double $discount
 * @property string $status
 * @property string $reason
 * @property string $notes
 * @property string $config
 * @property string $date_entry
 * @property string $date_update
 */
class VCustomerOrder extends CActiveRecord
{
    const ACTIVE                    = 'active';
    const SUSPENDED                 = 'suspended';
    const CANCELED                  = 'canceled';
	const PENDING_SETUP 			= 'pending_setup';
	const FAILED_SETUP 				= 'failed_setup';

	const ISSUE_INVOICE				= 'issue-invoice';
	const NO_INVOICE				= 'no-invoice';

	public $company_search;
	public $customer_search;
	public $product_search;
	public $product_category_id;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{customer_order}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('vendor_id, date_entry', 'required'),
			array('vendor_id, promo_recurring, group_master', 'numerical', 'integerOnly'=>true),
			array('price, discount', 'numerical'),
			array('customer_id, product_id, promo_id, promo_used, currency, unpaid_invoice_id, quantity', 'length', 'max'=>20),
			array('group_id, invoice_option, title, reason', 'length', 'max'=>255),
			array('unit', 'length', 'max'=>100),
			array('status', 'length', 'max'=>50),
			array('notes, config, date_update', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, vendor_id, customer_id, product_id, promo_id, promo_recurring, promo_used, group_id, group_master, invoice_option, title, currency, unpaid_invoice_id, quantity, unit, price, discount, status, reason, notes, config, date_entry, date_update', 'safe', 'on'=>'search'),
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
			'customer_rel' => array(self::BELONGS_TO, 'VCustomer', 'customer_id'),
			'product_rel' => array(self::BELONGS_TO, 'VProduct', 'product_id'),
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
			'customer_id' => 'Customer',
			'product_id' => 'Product',
			'promo_id' => 'Promo',
			'promo_recurring' => 'Promo Recurring',
			'promo_used' => 'Promo Used',
			'group_id' => 'Group',
			'group_master' => 'Group Master',
			'invoice_option' => 'Invoice Option',
			'title' => 'Title',
			'currency' => 'Currency',
			'unpaid_invoice_id' => 'Unpaid Invoice',
			'quantity' => 'Quantity',
			'unit' => 'Unit',
			'price' => 'Price',
			'discount' => 'Discount',
			'status' => 'Status',
			'reason' => 'Reason',
			'notes' => 'Notes',
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
		$criteria->compare('customer_id',$this->customer_id,true);
		$criteria->compare('product_id',$this->product_id,true);
		$criteria->compare('promo_id',$this->promo_id,true);
		$criteria->compare('promo_recurring',$this->promo_recurring);
		$criteria->compare('promo_used',$this->promo_used,true);
		$criteria->compare('group_id',$this->group_id,true);
		$criteria->compare('group_master',$this->group_master);
		$criteria->compare('invoice_option',$this->invoice_option,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('currency',$this->currency,true);
		$criteria->compare('unpaid_invoice_id',$this->unpaid_invoice_id,true);
		$criteria->compare('quantity',$this->quantity,true);
		$criteria->compare('unit',$this->unit,true);
		$criteria->compare('price',$this->price);
		$criteria->compare('discount',$this->discount);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('reason',$this->reason,true);
		$criteria->compare('notes',$this->notes,true);
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
	 * @return VCustomerOrder the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getStatuses($status = null)
	{
		$types = array(
				self::ACTIVE=>Yii::t('VendorModule.order','Active'),
				self::SUSPENDED=>Yii::t('VendorModule.order','Suspended'),
				self::CANCELED=>Yii::t('VendorModule.order','Canceled'),
				self::PENDING_SETUP=>Yii::t('VendorModule.order','Pending Setup'),
				self::FAILED_SETUP=>Yii::t('VendorModule.order','Failed Setup'),
			);
		if(empty($status))
			return $types;
		else
			return $types[$status];
	}

	public function getCountOrder($status=null)
	{
		$criteria = new CDbCriteria;
		$criteria->compare('vendor_id', Yii::app()->user->profile->id);
		if(!empty($status))
			$criteria->compare('status',$status);
		$count = self::model()->count($criteria);
		return $count;
	}

	public function getInvoiceOptions($option=null)
	{
		$types = array(
				self::ISSUE_INVOICE=>Yii::t('VendorModule.order','Automatically issue renewal invoices'),
				self::NO_INVOICE=>Yii::t('VendorModule.order','Issue invoices manually'),
			);
		if(empty($status))
			return $types;
		else
			return $types[$option];
	}

	public function getDataProvider($data=array())
	{
		$criteria=new CDbCriteria;
		$criteria->compare('t.product_id',$data['product_id']);
		if(isset($data['status']))
			$criteria->compare('t.status',$data['status']);
		$criteria->order='t.id ASC';

		return new CActiveDataProvider(__CLASS__,
			array(
				'criteria'=>$criteria,
				'pagination'=>array(
					'pageSize'=>(isset($data['pageSize']))? $data['pageSize']:10,
				)
			));
	}

	public function createOrderFromCart($data)
	{
		if(isset($data['carts']) && isset($data['customer'])){
			if(count($data['carts'])>0){
				$customer = $data['customer'];
				$group_id = time(); $orders = array();
				foreach(array_values($data['carts']) as $i=>$cart){
					$model = new VCustomerOrder;
					$model->customer_id = $customer['id'];
					$model->product_id = $cart['product']['id'];
					$model->group_id = $group_id;
					$model->group_master = ($i==0)? 1 : 0;
					$model->invoice_option = VCustomerOrder::ISSUE_INVOICE;
					$model->price = $cart['pricing'];
					$model->discount = $cart['discount'];
					$model->title = ucfirst(strtolower($cart['product']['title']));
					$model->currency = $cart['currency']['code'];
					$model->quantity = $cart['qty'];
					$model->unit = 'product';
					$model->status = VCustomerOrder::PENDING_SETUP;
					$model->notes = $data['notes'];
					$model->config = CJSON::encode($cart);
					$model->date_entry = date(c);
					if($model->save())
						$orders[] = $model->id;
				}
				//issued invoice
				$invoice = ModInvoice::createFromOrder(array('id'=>$orders[0]));
				return $invoice;
			}
		}
		return false;
	}
}
