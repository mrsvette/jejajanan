<?php

/**
 * This is the model class for table "{{mod_banner}}".
 *
 * The followings are the available columns in table '{{mod_banner}}':
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $slug
 * @property string $image
 * @property string $thumb
 * @property string $src
 * @property string $url
 * @property string $start_date
 * @property string $end_date
 * @property string $config
 * @property integer $status
 * @property string $date_entry
 * @property integer $user_entry
 * @property string $date_update
 * @property integer $user_update
 */
class ModBanner extends CActiveRecord
{

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{mod_banner}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, slug, date_entry, user_entry', 'required'),
			array('status, user_entry, user_update', 'numerical', 'integerOnly'=>true),
			array('name, image, thumb, src', 'length', 'max'=>128),
			array('slug, url', 'length', 'max'=>256),
			array('description, start_date, end_date, config, date_update', 'safe'),
			array('image', 'file', 'safe'=>true, 'allowEmpty' => false, 'types'=>self::getAllowedTypes(), 'maxSize'=>self::getMaxSize(), 'on'=>'create'),
			array('image', 'file', 'safe'=>true, 'allowEmpty' => true, 'types'=>self::getAllowedTypes(), 'maxSize'=>self::getMaxSize(), 'on'=>'update'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, description, slug, image, thumb, src, url, start_date, end_date, config, status, date_entry, user_entry, date_update, user_update', 'safe', 'on'=>'search'),
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
			'name' => 'Name',
			'description' => 'Description',
			'slug' => 'Slug',
			'image' => 'Image',
			'thumb' => 'Thumb',
			'src' => 'Src',
			'url' => 'Url',
			'start_date' => 'Start Date',
			'end_date' => 'End Date',
			'config' => 'Config',
			'status' => 'Status',
			'date_entry' => 'Date Entry',
			'user_entry' => 'User Entry',
			'date_update' => 'Date Update',
			'user_update' => 'User Update',
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
		$criteria->compare('description',$this->description,true);
		$criteria->compare('slug',$this->slug,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('thumb',$this->thumb,true);
		$criteria->compare('src',$this->src,true);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('start_date',$this->start_date,true);
		$criteria->compare('end_date',$this->end_date,true);
		$criteria->compare('config',$this->config,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('date_entry',$this->date_entry,true);
		$criteria->compare('user_entry',$this->user_entry);
		$criteria->compare('date_update',$this->date_update,true);
		$criteria->compare('user_update',$this->user_update);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ModBanner the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getAllowedTypes()
	{
		$default = 'jpg, jpeg, png';
		$allowed = Extension::getConfigByModule('banner','banner_allowed_file_type');
		if(empty($allowed))
			$allowed = $default;
		return $allowed;
	}

	public function getMaxSize()
	{
		$default = 3000000; //3MB
		$allowed = Extension::getConfigByModule('banner','banner_max_file_size');
		if(empty($allowed))
			$allowed = $default;
		return (int)$allowed;
	}

	public function getStatuses($status=0,$list=false)
	{
		$items = array('Disabled','Enabled');
		return (!$list)? $items[$status] : $items;
	}

	public function getUsage($id=0)
	{
		if($id==0)
			$model = $this;
		else
			$model = self::model()->findByPk($id);
		return "{% do this.widget('application.modules.banner.components.BannerWidget',{'id':'".$model->slug."'}) %}";
	}
}
