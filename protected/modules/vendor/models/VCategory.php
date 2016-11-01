<?php

/**
 * This is the model class for table "{{category}}".
 *
 * The followings are the available columns in table '{{category}}':
 * @property integer $id
 * @property integer $vendor_id
 * @property string $image
 * @property integer $parent_id
 * @property integer $top
 * @property integer $column
 * @property integer $sort_order
 * @property integer $status
 * @property string $date_entry
 * @property string $date_update
 *
 * The followings are the available model relations:
 * @property CategoryDescription[] $categoryDescriptions
 */
class VCategory extends CActiveRecord
{
	const STATUS_ENABLED = "Enabled";
	const STATUS_DISABLED = "Disabled";

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{category}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('vendor_id, top, column, status, date_entry', 'required'),
			array('vendor_id, parent_id, top, column, sort_order, status', 'numerical', 'integerOnly'=>true),
			array('image', 'length', 'max'=>255),
			array('date_update', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, vendor_id, image, parent_id, top, column, sort_order, status, date_entry, date_update', 'safe', 'on'=>'search'),
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
			'description_rel' => array(self::HAS_MANY, 'VCategoryDescription', 'category_id'),
			'description_one_rel' => array(self::HAS_ONE, 'VCategoryDescription', 'category_id', 'condition'=>'description_one_rel.language_id="'.Yii::app()->user->getState('vlanguage')->id.'"'),
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
			'image' => 'Image',
			'parent_id' => 'Parent',
			'top' => 'Top',
			'column' => 'Column',
			'sort_order' => 'Sort Order',
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
		$criteria->compare('vendor_id',$this->vendor_id);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('parent_id',$this->parent_id);
		$criteria->compare('top',$this->top);
		$criteria->compare('column',$this->column);
		$criteria->compare('sort_order',$this->sort_order);
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
	 * @return VCategory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @param text $title
	 * @return array
	 */
	public function getItems($title = null)
	{
		$criteria = new CDbCriteria;
		$criteria->compare('vendor_id',Yii::app()->user->id);
		$criteria->compare('status',1);
		$criteria->order = 'id ASC';
		
		$models = self::model()->findAll($criteria);
		$list = array();
		if(!empty($title))
			$list[''] = $title;
		foreach($models as $model){
			$name = ucfirst(strtolower($model->description_one_rel->name));
			if(!in_array($model->id,array_keys($list))){
				$list[$model->id] = $name;
				if(self::hasChild($model->id)){
					self::child($model,$name, $list);
				}
			}
		}

		return $list;
	}

	/**
	 * @param integer $parent, text $name, array $list
	 */
	private function child($parent, $name = null, &$list)
	{
		$criteria = new CDbCriteria;
		$criteria->compare('status',1);
		$criteria->compare('parent_id',$parent->id);
		$criteria->order = 'sort_order ASC';
		
		$models = self::model()->findAll($criteria);
		foreach($models as $model){
			$cname = $name.' > '.ucfirst(strtolower($model->description_one_rel->name));
			$list[$model->id] = $cname;
			if(self::hasChild($model->id)){
				self::child($model,$cname, $list);
			}
		}
	}
	
	/**
	 * @param integer $id, check whether the record has child
	 * @return boolean
	 */
	private function hasChild($id)
	{
		$criteria = new CDbCriteria;
		$criteria->compare('status',1);
		$criteria->compare('parent_id',$id);
		
		$count = self::model()->count($criteria);
		return ($count>0)? true : false;
	}

	/**
	 * @param integer $id, leave it empty if we have $model which is not new record
	 * ex : $model->title should be return title
	 * @return title
	 */
	public function getTitle($id = 0)
	{
		if($id > 0)
			$id = self::model()->findByPk($id);
		else
			$model = $this;
		$title = ucfirst(strtolower($model->description_one_rel->name));
		if($model->parent_id > 0){
			self::getParentTitle($model,$title);
		}
		return $title;
	}

	/**
	 * @param string $model instanceof VCategory
	 * $title rebuild the title from current title given
	 */
	private function getParentTitle($model,&$title)
	{
		$parent = self::model()->findByPk($model->parent_id);
		$title = ucfirst(strtolower($parent->description_one_rel->name)).' > '.$title;
		if($parent->parent_id > 0){
			self::getParentTitle($parent,$title);
		}
	}

	/**
	 * @param string $type : list, item but default to list
	 * fill the value of $title to add title on dropDownList
	 * set $status if need to get the status, ex: VCategory::getTextStatus('item',null,1)
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
				if(($this instanceof VCategory) && !$this->isNewRecord)
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
