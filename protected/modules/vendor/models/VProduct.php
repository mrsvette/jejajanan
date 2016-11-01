<?php

/**
 * This is the model class for table "{{product}}".
 *
 * The followings are the available columns in table '{{product}}':
 * @property integer $id
 * @property integer $vendor_id
 * @property string $model
 * @property string $sku
 * @property string $upc
 * @property string $ean
 * @property string $jan
 * @property string $isbn
 * @property string $mpn
 * @property string $location
 * @property integer $quantity
 * @property integer $stock_status_id
 * @property integer $manufacturer_id
 * @property integer $shipping
 * @property string $price
 * @property integer $points
 * @property integer $tax_class_id
 * @property string $date_available
 * @property string $weight
 * @property integer $weight_class_id
 * @property string $length
 * @property string $width
 * @property string $height
 * @property integer $length_class_id
 * @property integer $subtract
 * @property integer $minimum
 * @property integer $sort_order
 * @property integer $status
 * @property integer $viewed
 * @property string $date_entry
 * @property integer $user_entry
 * @property string $date_update
 * @property integer $user_update
 */
class VProduct extends CActiveRecord
{
	const STATUS_ENABLED = "Enabled";
	const STATUS_DISABLED = "Disabled";
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{product}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('vendor_id, model, stock_status_id, manufacturer_id, tax_class_id, price, date_entry', 'required'),
			array('vendor_id, quantity, stock_status_id, manufacturer_id, shipping, points, tax_class_id, weight_class_id, length_class_id, subtract, minimum, sort_order, status, viewed', 'numerical', 'integerOnly'=>true),
			array('sku, upc, ean, jan, isbn, mpn, location', 'safe'),
			array('model, sku, mpn', 'length', 'max'=>64),
			array('upc', 'length', 'max'=>12),
			array('ean', 'length', 'max'=>14),
			array('jan', 'length', 'max'=>13),
			array('isbn', 'length', 'max'=>17),
			array('location', 'length', 'max'=>128),
			array('price, weight, length, width, height', 'length', 'max'=>15),
			array('date_available, date_update', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, vendor_id, model, sku, upc, ean, jan, isbn, mpn, location, quantity, stock_status_id, manufacturer_id, shipping, price, points, tax_class_id, date_available, weight, weight_class_id, length, width, height, length_class_id, subtract, minimum, sort_order, status, viewed, date_entry, date_update', 'safe', 'on'=>'search'),
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
			'description_rel' => array(self::HAS_MANY, 'VProductDescription', 'product_id'),
			'description_one_rel' => array(self::HAS_ONE, 'VProductDescription', 'product_id', 'condition'=>'description_one_rel.language_id="'.Yii::app()->user->getState('vlanguage')->id.'"'),
			'description_one_client_rel' => array(self::HAS_ONE, 'VProductDescription', 'product_id', 'condition'=>'description_one_client_rel.language_id="'.Yii::app()->user->getState('language')->id.'"'),
			'category_rel' => array(self::HAS_MANY, 'VProductToCategory', 'product_id'),
			'category_count' => array(self::STAT, 'VProductToCategory', 'product_id'),
			'related_rel' => array(self::HAS_MANY, 'VProductRelated', 'product_id'),
			'related_count' => array(self::STAT, 'VProductRelated', 'product_id'),
			'image_one_rel' => array(self::HAS_ONE, 'VProductImages', 'product_id'),
			'review_count' => array(self::STAT, 'VReview', 'product_id'),
			'vendor_rel' => array(self::BELONGS_TO, 'ModClient', 'vendor_id'),
			'currency_rel' => array(self::BELONGS_TO, 'ModCurrency', 'currency_id'),
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
			'model' => 'Model',
			'sku' => 'Sku',
			'upc' => 'Upc',
			'ean' => 'Ean',
			'jan' => 'Jan',
			'isbn' => 'Isbn',
			'mpn' => 'Mpn',
			'location' => 'Location',
			'quantity' => 'Quantity',
			'stock_status_id' => 'Stock Status',
			'manufacturer_id' => 'Manufacturer',
			'shipping' => 'Shipping',
			'price' => 'Price',
			'points' => 'Points',
			'tax_class_id' => 'Tax Class',
			'date_available' => 'Date Available',
			'weight' => 'Weight',
			'weight_class_id' => 'Weight Class',
			'length' => 'Length',
			'width' => 'Width',
			'height' => 'Height',
			'length_class_id' => 'Length Class',
			'subtract' => 'Subtract',
			'minimum' => 'Minimum',
			'sort_order' => 'Sort Order',
			'status' => 'Status',
			'viewed' => 'Viewed',
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
		$criteria->compare('model',$this->model,true);
		$criteria->compare('sku',$this->sku,true);
		$criteria->compare('upc',$this->upc,true);
		$criteria->compare('ean',$this->ean,true);
		$criteria->compare('jan',$this->jan,true);
		$criteria->compare('isbn',$this->isbn,true);
		$criteria->compare('mpn',$this->mpn,true);
		$criteria->compare('location',$this->location,true);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('stock_status_id',$this->stock_status_id);
		$criteria->compare('manufacturer_id',$this->manufacturer_id);
		$criteria->compare('shipping',$this->shipping);
		$criteria->compare('price',$this->price,true);
		$criteria->compare('points',$this->points);
		$criteria->compare('tax_class_id',$this->tax_class_id);
		$criteria->compare('date_available',$this->date_available,true);
		$criteria->compare('weight',$this->weight,true);
		$criteria->compare('weight_class_id',$this->weight_class_id);
		$criteria->compare('length',$this->length,true);
		$criteria->compare('width',$this->width,true);
		$criteria->compare('height',$this->height,true);
		$criteria->compare('length_class_id',$this->length_class_id);
		$criteria->compare('subtract',$this->subtract);
		$criteria->compare('minimum',$this->minimum);
		$criteria->compare('sort_order',$this->sort_order);
		$criteria->compare('status',$this->status);
		$criteria->compare('viewed',$this->viewed);
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
	 * @return VProduct the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @param string $type : list, item but default to item
	 * fill the value of $title to add title on dropDownList
	 * set $status if need to get the status, ex: VProduct::getTextStatus('item',null,1)
	 * or $model->textStatus should be return text status if $model is not new record
	 * @return array status or text status
	 */
	public function getTextStatus($type = 'item',$title = null,$status = 0)
	{
		$items = array(
				0 => self::STATUS_DISABLED,
				1 => self::STATUS_ENABLED,
			);
		if(!empty($title)){
			$items[''] = $title;
		}
		switch($type){
			case 'list':
				$response = $items;
				break;
			case 'item':
				if(($this instanceof VProduct) && !$this->isNewRecord)
					$response = $items[$this->status];
				else
					$response = $items[$status];
				break;
			default:
				$response = $items;
				break;
		}
		return $response;
	}

	/**
	 * @param string $title, $exceptions 
	 * @return array of product
	 */
	public function getItems($title = null,$exceptions = array())
	{
		$items = array();
		if(isset($title))
			$items[''] = $title;
		$criteria = new CDbCriteria;
		$criteria->compare('vendor_id',Yii::app()->user->id);
		$criteria->compare('status',1);
		$criteria->order = 'id ASC';

		$models = self::model()->findAll($criteria);
		foreach($models as $model){
			if(!in_array($model->id,$exceptions))
				$items[$model->id] = $model->description_one_rel->name;
		}
		return $items;
	}

	/**
	 * @param string $id 
	 * @return array of product id
	 */
	public function getCategories($id = 0)
	{
		if($id == 0)
			$model = $this;
		else
			$model = self::model()->findByPk($id);
		$items = array();
		if($model->category_count>0){
			foreach($model->category_rel as $category){
				$items[] = (int)$category->id;
			}
		}
		return $items;
	}

	/**
	 * @param string $id 
	 * @return array of product id
	 */
	public function getRelateds($id = 0)
	{
		if($id == 0)
			$model = $this;
		else
			$model = self::model()->findByPk($id);
		$items = array();
		if($model->related_count>0){
			foreach($model->related_rel as $related){
				$items[] = (int)$related->id;
			}
		}
		return $items;
	}

	/**
	 * @param string $id 
	 * @return dataProvider instanceof CActiveDataProvider
	 */
	public function getImageProvider($id = 0)
	{
		if($id == 0)
			$id = $this->id;
		
		$criteria = new CDbCriteria;
		$criteria->compare('product_id',$id);
		$criteria->order = 'id DESC';

		$dataProvider = new CActiveDataProvider('VProductImages',array('criteria'=>$criteria,'pagination'=>array('pageSize'=>5)));
		return $dataProvider;
	}

	/**
	 * @param string $id 
	 * @return dataProvider instanceof CActiveDataProvider
	 */
	public function getDiscountProvider($id = 0)
	{
		if($id == 0)
			$id = $this->id;
		
		$criteria = new CDbCriteria;
		$criteria->compare('product_id',$id);
		$criteria->order = 'id DESC';

		$dataProvider = new CActiveDataProvider('VProductDiscount',array('criteria'=>$criteria,'pagination'=>false));
		return $dataProvider;
	}

	/**
	 * @param string $id 
	 * @return object of VProductDescription
	 */
	public function getProductDescription($id = 0, $lang = 0)
	{
		if($id == 0){
			$id = $this->id;
			$model = $this;
		}else
			$model = self::model()->findByPk($id);
		//description
		$criteria = new CDbCriteria;
		$criteria->compare('product_id', $id);
		if($lang == 0)
			$lang = Yii::app()->user->getState('language')->id;
		$criteria->compare('language_id', $lang);

		$description = VProductDescription::model()->find($criteria);

		return $description;
	}

	/**
	 * @param string $id 
	 * @return object of VProductImages
	 */
	public function getProductImage($id = 0, $type = 1)
	{
		if($id == 0){
			$id = $this->id;
			$model = $this;
		}else
			$model = self::model()->findByPk($id);
		//image
		$criteria = new CDbCriteria;
		$criteria->compare('product_id', $id);
		$criteria->compare('type', $type);

		$image = VProductImages::model()->find($criteria);
		if(!$image instanceof VProductImages)
			$image = $model->image_one_rel;

		return $image;
	}

	/**
	 * @param string $id 
	 * @return integer price
	 */
	public function getProductPrice($id = 0)
	{
		if($id == 0){
			$id = $this->id;
			$model = $this;
		}else
			$model = self::model()->findByPk($id);
		//discount
		$criteria = new CDbCriteria;
		$criteria->compare('product_id', $id);
		$criteria->compare('quantity', 1);
		$criteria->compare('date_start', '<='.date('Y-m-d H:i:s'));
		$criteria->compare('date_end', '>='.date('Y-m-d H:i:s'));

		$discount = VProductDiscount::model()->find($criteria);
		if($discount instanceof VProductDiscount){
			$price = $discount->price;
			$discount = $model->price - $price;
		}else{
			$price = $model->price;
			$discount = 0;
		}
		$pricing = array(
				'base_price' => $model->price,
				'price' => $price,
				'discount' => $discount,
				'currency' => $model->vendor_rel->currency_rel,
			);

		return json_decode(json_encode($pricing));
	}
}
