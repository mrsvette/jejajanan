<?php

/**
 * This is the model class for table "{{invoice}}".
 *
 * The followings are the available columns in table '{{invoice}}':
 * @property integer $id
 * @property integer $vendor_id
 * @property integer $customer_id
 * @property string $serie
 * @property string $nr
 * @property string $hash
 * @property string $currency
 * @property string $currency_rate
 * @property double $credit
 * @property double $base_income
 * @property double $base_refund
 * @property double $refund
 * @property string $notes
 * @property string $text_1
 * @property string $text_2
 * @property string $status
 * @property string $seller_company
 * @property string $seller_company_vat
 * @property string $seller_company_number
 * @property string $seller_address
 * @property string $seller_phone
 * @property string $seller_email
 * @property string $buyer_first_name
 * @property string $buyer_last_name
 * @property string $buyer_company
 * @property string $buyer_company_vat
 * @property string $buyer_company_number
 * @property string $buyer_address
 * @property string $buyer_city
 * @property string $buyer_state
 * @property string $buyer_country
 * @property string $buyer_zip
 * @property string $buyer_phone
 * @property string $buyer_phone_cc
 * @property string $buyer_email
 * @property integer $gateway_id
 * @property integer $approved
 * @property string $taxname
 * @property string $taxrate
 * @property string $due_at
 * @property string $reminded_at
 * @property string $paid_at
 * @property string $date_entry
 * @property string $date_update
 *
 * The followings are the available model relations:
 * @property Customer $customer
 */
class VInvoice extends CActiveRecord
{
	const STATUS_PAID   = 'paid';
    const STATUS_UNPAID = 'unpaid';
    const STATUS_REFUNDED = 'refunded';
    const STATUS_CANCELED = 'canceled';

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{invoice}}';
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
			array('vendor_id, customer_id, gateway_id, approved', 'numerical', 'integerOnly'=>true),
			array('credit, base_income, base_refund, refund', 'numerical'),
			array('serie, status', 'length', 'max'=>50),
			array('nr, hash, seller_company, seller_company_vat, seller_company_number, seller_address, seller_phone, seller_email, buyer_first_name, buyer_last_name, buyer_company, buyer_company_vat, buyer_company_number, buyer_address, buyer_city, buyer_state, buyer_country, buyer_zip, buyer_phone, buyer_phone_cc, buyer_email, taxname', 'length', 'max'=>255),
			array('currency', 'length', 'max'=>25),
			array('currency_rate', 'length', 'max'=>13),
			array('taxrate', 'length', 'max'=>35),
			array('notes, text_1, text_2, due_at, reminded_at, paid_at, date_update', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, vendor_id, customer_id, serie, nr, hash, currency, currency_rate, credit, base_income, base_refund, refund, notes, text_1, text_2, status, seller_company, seller_company_vat, seller_company_number, seller_address, seller_phone, seller_email, buyer_first_name, buyer_last_name, buyer_company, buyer_company_vat, buyer_company_number, buyer_address, buyer_city, buyer_state, buyer_country, buyer_zip, buyer_phone, buyer_phone_cc, buyer_email, gateway_id, approved, taxname, taxrate, due_at, reminded_at, paid_at, date_entry, date_update', 'safe', 'on'=>'search'),
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
			'item_rel'=>array(self::HAS_MANY,'VInvoiceItem','invoice_id'),
			'item_count'=>array(self::STAT,'VInvoiceItem','invoice_id'),
			//'gateway_rel'=>array(self::BELONGS_TO,'VPayGateway','gateway_id'),
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
			'serie' => 'Serie',
			'nr' => 'Nr',
			'hash' => 'Hash',
			'currency' => 'Currency',
			'currency_rate' => 'Currency Rate',
			'credit' => 'Credit',
			'base_income' => 'Base Income',
			'base_refund' => 'Base Refund',
			'refund' => 'Refund',
			'notes' => 'Notes',
			'text_1' => 'Text 1',
			'text_2' => 'Text 2',
			'status' => 'Status',
			'seller_company' => 'Seller Company',
			'seller_company_vat' => 'Seller Company Vat',
			'seller_company_number' => 'Seller Company Number',
			'seller_address' => 'Seller Address',
			'seller_phone' => 'Seller Phone',
			'seller_email' => 'Seller Email',
			'buyer_first_name' => 'Buyer First Name',
			'buyer_last_name' => 'Buyer Last Name',
			'buyer_company' => 'Buyer Company',
			'buyer_company_vat' => 'Buyer Company Vat',
			'buyer_company_number' => 'Buyer Company Number',
			'buyer_address' => 'Buyer Address',
			'buyer_city' => 'Buyer City',
			'buyer_state' => 'Buyer State',
			'buyer_country' => 'Buyer Country',
			'buyer_zip' => 'Buyer Zip',
			'buyer_phone' => 'Buyer Phone',
			'buyer_phone_cc' => 'Buyer Phone Cc',
			'buyer_email' => 'Buyer Email',
			'gateway_id' => 'Gateway',
			'approved' => 'Approved',
			'taxname' => 'Taxname',
			'taxrate' => 'Taxrate',
			'due_at' => 'Due At',
			'reminded_at' => 'Reminded At',
			'paid_at' => 'Paid At',
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
		$criteria->compare('customer_id',$this->customer_id);
		$criteria->compare('serie',$this->serie,true);
		$criteria->compare('nr',$this->nr,true);
		$criteria->compare('hash',$this->hash,true);
		$criteria->compare('currency',$this->currency,true);
		$criteria->compare('currency_rate',$this->currency_rate,true);
		$criteria->compare('credit',$this->credit);
		$criteria->compare('base_income',$this->base_income);
		$criteria->compare('base_refund',$this->base_refund);
		$criteria->compare('refund',$this->refund);
		$criteria->compare('notes',$this->notes,true);
		$criteria->compare('text_1',$this->text_1,true);
		$criteria->compare('text_2',$this->text_2,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('seller_company',$this->seller_company,true);
		$criteria->compare('seller_company_vat',$this->seller_company_vat,true);
		$criteria->compare('seller_company_number',$this->seller_company_number,true);
		$criteria->compare('seller_address',$this->seller_address,true);
		$criteria->compare('seller_phone',$this->seller_phone,true);
		$criteria->compare('seller_email',$this->seller_email,true);
		$criteria->compare('buyer_first_name',$this->buyer_first_name,true);
		$criteria->compare('buyer_last_name',$this->buyer_last_name,true);
		$criteria->compare('buyer_company',$this->buyer_company,true);
		$criteria->compare('buyer_company_vat',$this->buyer_company_vat,true);
		$criteria->compare('buyer_company_number',$this->buyer_company_number,true);
		$criteria->compare('buyer_address',$this->buyer_address,true);
		$criteria->compare('buyer_city',$this->buyer_city,true);
		$criteria->compare('buyer_state',$this->buyer_state,true);
		$criteria->compare('buyer_country',$this->buyer_country,true);
		$criteria->compare('buyer_zip',$this->buyer_zip,true);
		$criteria->compare('buyer_phone',$this->buyer_phone,true);
		$criteria->compare('buyer_phone_cc',$this->buyer_phone_cc,true);
		$criteria->compare('buyer_email',$this->buyer_email,true);
		$criteria->compare('gateway_id',$this->gateway_id);
		$criteria->compare('approved',$this->approved);
		$criteria->compare('taxname',$this->taxname,true);
		$criteria->compare('taxrate',$this->taxrate,true);
		$criteria->compare('due_at',$this->due_at,true);
		$criteria->compare('reminded_at',$this->reminded_at,true);
		$criteria->compare('paid_at',$this->paid_at,true);
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
	 * @return VInvoice the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getStatuses($status=null)
	{
		$types = array(
				self::STATUS_PAID=>Yii::t('VendorModule.invoice','Paid'),
				self::STATUS_UNPAID=>Yii::t('VendorModule.invoice','Unpaid'),
				self::STATUS_REFUNDED=>Yii::t('VendorModule.invoice','Refunded'),
				self::STATUS_CANCELED=>Yii::t('VendorModule.invoice','Canceled'),
			);
		if(empty($status))
			return $types;
		else
			return $types[$status];
	}

	public function createFromOrder($data)
	{
		$order = VCustomerOrder::model()->findByPk($data['id']);
		if(!$order instanceof VCustomerOrder)
			return false;
		if($order->unpaid_invoice_id>0)
			return VInvoice::model()->findByPk($order->unpaid_invoice_id);
		$model = new VInvoice;
		$model->vendor_id = Yii::app()->user->profile->id;
		$model->customer_id = $order->customer_id;
		$model->serie = Extension::getConfigByModule('ecommerce','invoice_series');
		$model->currency = $order->customer_rel->currency;
		$model->currency_rate = 1;
		$model->credit = 0;
		//$model->base_income = 0;
		$model->base_refund = 0;
		$model->refund = 0;
		$model->notes = '';
		$model->status = self::STATUS_UNPAID;
		$model->seller_company = Extension::getConfigByModule('ecommerce','invoice_company_name');
		$model->seller_company_vat = Extension::getConfigByModule('ecommerce','invoice_company_vat');
		$model->seller_company_number = Extension::getConfigByModule('ecommerce','invoice_company_number');
		$model->seller_address = Extension::getConfigByModule('ecommerce','invoice_company_address');
		$model->seller_phone = Extension::getConfigByModule('ecommerce','invoice_company_phone');
		$model->seller_email = Extension::getConfigByModule('ecommerce','invoice_company_email');
		//get the buyer information
		$pos = strpos($order->customer_rel->name," ");
		$first_name = substr($order->customer_rel->name, 0, -1*($pos+2));
		$last_name = substr($order->customer_rel->name, $pos+1, strlen($order->customer_rel->name));
		$model->buyer_first_name = $first_name;
		$model->buyer_last_name = $last_name;
		$model->buyer_company = 'na';
		$model->buyer_company_vat = 'na';
		$model->buyer_company_number = 'na';
		$model->buyer_address = $order->customer_rel->address;
		$model->buyer_city = $order->customer_rel->city;
		$model->buyer_state = $order->customer_rel->state;
		$model->buyer_country = $order->customer_rel->country;
		$model->buyer_zip = $order->customer_rel->postcode;
		$model->buyer_phone = $order->customer_rel->phone;
		$model->buyer_phone_cc = '-';
		$model->buyer_email = $order->customer_rel->email;
		$model->gateway_id = 1;
		$model->approved = 1;
		$model->taxname = '';
		$model->taxrate = '';
		$model->due_at = date("Y-m-d H:i:s",strtotime("+1 Month")); //perlu tambahan config due
		$model->reminded_at = null;
		$model->paid_at = null;
		$model->date_entry = date(c);
		if($model->save()){
			//create the items
			$criteria = new CDbCriteria;
			$criteria->compare('group_id',$order->group_id);
			$orders = VCustomerOrder::model()->findAll($criteria);
			$income = 0;
			foreach($orders as $corder){
				$model2 = new VInvoiceItem;
				$model2->invoice_id = $model->id;
				$model2->rel_id = $corder->id;
				$model2->title = $corder->title;
				$model2->quantity = $corder->quantity;
				$model2->price = $corder->price - $corder->discount;
				$model2->date_entry = date(c);
				if($model2->save())
					$income = $income + ($model2->price * $model2->quantity);
			}
			//update the invoice
			$model->nr = $model->id;
			$model->hash = md5($model->id);
			$model->base_income = $income;
			$model->update(array('nr','hash','base_income'));
			//save the order
			$order->unpaid_invoice_id = $model->id;
			$order->date_update = date(c);
			$order->save();
		}else{var_dump($model->errors);exit;}
		return $model;
	}

	public function money_format($price,$currency='IDR')
	{
		if($currency=='IDR'){
			$prefix = 'Rp';
			$formated = number_format($price,2,',','.');
			$fprice = $prefix.' '.$formated;
		}
		return $fprice;
	}

	public function markAsPaid($id=0)
	{
		if($id==0)
			$model = $this;
		else
			$model = self::model()->findByPk($id);
		$model->status = VInvoice::STATUS_PAID;
		//set new serie nr
		$model->serie = Extension::getConfigByModule('ecommerce','invoice_series_paid');
		$model->nr = Extension::getConfigByModule('ecommerce','invoice_starting_number');
		$model->paid_at = date(c);
		$model->date_update = date(c);
		if($model->save()){
			//update new starting number
			$criteria_p = new CDbCriteria;
			$criteria_p->compare('t.key','invoice_starting_number');
			$params = Params::model()->find($criteria_p);
			$params->value = serialize($model->nr+1);
			$params->date_update = date(c);
			$params->user_update = Yii::app()->user->id;
			$params->update(array('value','date_update','user_update'));

			if($model->item_count>0){
				foreach($model->item_rel as $item){
					$order = $item->order_rel;
					if($order instanceof VClientOrder){ //hanya jika ordernya valid
						//jika new order
						if($item->task == VInvoiceItem::TASK_ACTIVATE){
							if($order->product_rel->setup == ModProduct::SETUP_AFTER_PAYMENT){
								$activate = $order->activate();
								if($activate){
									$order->unpaid_invoice_id = null;
									$order->update(array('unpaid_invoice_id'));
								}
							}
						}
						//jika renewal order
						if($item->task == VInvoiceItem::TASK_RENEW){
							if($order->product_rel->setup == ModProduct::SETUP_AFTER_PAYMENT){
								$order->renew();
								if($activate){
									$order->unpaid_invoice_id = null;
									$order->update(array('unpaid_invoice_id'));
								}
							}
						}
					}
				}
			}
		}
		return true;
	}

	public function getCount($status=null)
	{
		$criteria = new CDbCriteria;
		$criteria->compare('vendor_id', Yii::app()->user->profile->id);
		if(!empty($status))
			$criteria->compare('status',$status);
		$count = self::model()->count($criteria);
		return $count;
	}

	public function getFormatedNumber($id=0)
	{
		if($id==0)
			$model = $this;
		else
			$model = self::model()->findByPk($id);

		$nr = str_pad($model->nr, 5, '0', STR_PAD_LEFT);
		return ($model->status == self::STATUS_UNPAID)? $model->serie.$nr : $model->serie.'-'.$nr;
	}

	public function refund($id=0)
	{
		if($id==0)
			$model = $this;
		else
			$model = self::model()->findByPk($id);

		$rmodel = new VInvoice;
		$rmodel->attributes = $model->attributes;
		$rmodel->status = self::STATUS_REFUNDED;
		$rmodel->serie = 'CN';
		$rmodel->nr = Extension::getConfigByModule('ecommerce','invoice_cn_starting_number');
		$rmodel->hash = md5(time());
		$rmodel->base_income = -1*$model->base_income;
		$rmodel->notes = date(c).': Refund for #'.$model->id;
		$rmodel->due_at = null;
		$rmodel->date_entry = date(c);
		if($rmodel->save()){
			//update new cn starting number
			$criteria_p = new CDbCriteria;
			$criteria_p->compare('t.key','invoice_cn_starting_number');
			$params = Params::model()->find($criteria_p);
			$params->value = serialize($rmodel->nr+1);
			$params->date_update = date(c);
			$params->user_update = Yii::app()->user->id;
			$params->update(array('value','date_update','user_update'));
			if($model->item_count>0){
				foreach($model->item_rel as $item){
					$imodel = new VInvoiceItem;
					$imodel->attributes = $item->attributes;
					$imodel->invoice_id = $rmodel->id;
					$imodel->price = -1*$item->price;
					$imodel->type = 'order';
					$imodel->status = VInvoiceItem::STATUS_EXECUTED;
					$imodel->date_entry = date(c);
					$imodel->date_update = date(c);
					$imodel->save();
				}
			}
			//update information for the old invoice
			$model->notes = date(c).': Refund invoice #'.$rmodel->id.' generated';
			$model->date_update = date(c);
			$model->update(array('notes','date_update'));
		}
		return $rmodel;
	}
}
