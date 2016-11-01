<?php

/**
 * This is the model class for table "{{product_description}}".
 *
 * The followings are the available columns in table '{{product_description}}':
 * @property integer $id
 * @property integer $product_id
 * @property integer $language_id
 * @property string $name
 * @property string $description
 * @property string $tag
 * @property string $meta_title
 * @property string $meta_description
 * @property string $meta_keyword
 */
class VProductDescription extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{product_description}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('product_id, name, meta_title', 'required'),
			array('product_id, language_id', 'numerical', 'integerOnly'=>true),
			array('name, meta_title, meta_description, meta_keyword', 'length', 'max'=>255),
			array('description, tag', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, product_id, language_id, name, description, tag, meta_title, meta_description, meta_keyword', 'safe', 'on'=>'search'),
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
			'product_id' => 'Product ID',
			'language_id' => 'Language',
			'name' => 'Product Name',
			'description' => 'Product Description',
			'tag' => 'Tag',
			'meta_title' => 'Meta Tag Title',
			'meta_description' => 'Meta Tag Description',
			'meta_keyword' => 'Meta Tag Keyword',
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
		$criteria->compare('language_id',$this->language_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('tag',$this->tag,true);
		$criteria->compare('meta_title',$this->meta_title,true);
		$criteria->compare('meta_description',$this->meta_description,true);
		$criteria->compare('meta_keyword',$this->meta_keyword,true);

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
	 * @return VProductDescription the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
