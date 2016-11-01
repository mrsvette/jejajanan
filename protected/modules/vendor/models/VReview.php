<?php

/**
 * This is the model class for table "{{review}}".
 *
 * The followings are the available columns in table '{{review}}':
 * @property integer $id
 * @property integer $product_id
 * @property integer $customer_id
 * @property string $author
 * @property string $text
 * @property integer $rating
 * @property integer $status
 * @property string $date_entry
 * @property string $date_update
 */
class VReview extends CActiveRecord
{
	const STATUS_ENABLED = "Enabled";
	const STATUS_DISABLED = "Disabled";

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{review}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('product_id, customer_id, author, text, rating, date_entry', 'required'),
			array('product_id, customer_id, rating, status', 'numerical', 'integerOnly'=>true),
			array('author', 'length', 'max'=>64),
			array('date_update', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, product_id, customer_id, author, text, rating, status, date_entry, date_update', 'safe', 'on'=>'search'),
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
			'product_rel' => array(self::BELONGS_TO, 'VProduct', 'product_id'),
			'customer_rel' => array(self::BELONGS_TO, 'VCustomer', 'customer_id'),
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
			'customer_id' => 'Customer',
			'author' => 'Author',
			'text' => 'Text',
			'rating' => 'Rating',
			'status' => 'Status',
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
		$criteria->compare('customer_id',$this->customer_id);
		$criteria->compare('author',$this->author,true);
		$criteria->compare('text',$this->text,true);
		$criteria->compare('rating',$this->rating);
		$criteria->compare('status',$this->status);
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
	 * @return VReview the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}	

	/**
	 * @param string $type : list, item but default to item
	 * fill the value of $title to add title on dropDownList
	 * set $status if need to get the status, ex: VReview::getTextStatus('item',null,1)
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
				if(($this instanceof VReview) && !$this->isNewRecord)
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
}
