<?php

/**
 * This is the model class for table "{{rbac_user_access}}".
 *
 * The followings are the available columns in table '{{rbac_user_access}}':
 * @property integer $id
 * @property integer $user_id
 * @property string $module
 * @property string $controller
 * @property string $action
 * @property integer $status
 */
class RbacUserAccess extends CActiveRecord
{
	public $access;
	public $check_list;
	public $check_all;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RbacUserAccess the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{core_rbac_user_access}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, module, controller', 'required'),
			array('user_id', 'numerical', 'integerOnly'=>true),
			array('create_p, read_p, update_p, delete_p', 'numerical', 'integerOnly'=>true),
			array('module, controller', 'length', 'max'=>30),
			array('access, check_list, check_all','safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, module, controller', 'safe', 'on'=>'search'),
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
			'user_id' => 'User',
			'module' => 'Module',
			'controller' => 'Controller',
			'create_p'=>'Create Priviledge',
			'read_p'=>'Read Priviledge',
			'update_p'=>'Update Priviledge',
			'delete_p'=>'Delete Priviledge',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('module',$this->module,true);
		$criteria->compare('controller',$this->controller,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function listAccess($user_id)
	{
		$criteria=new CDbCriteria;
		$criteria->compare('user_id',$user_id);
		
		$models=self::model()->findAll($criteria);
		$data=array();
		foreach($models as $model){
			$data[$model->module][$model->controller]=array(
						'create_p'=>($model->create_p>0)? true : false,
						'read_p'=>($model->read_p>0)? true : false,
						'update_p'=>($model->update_p>0)? true : false,
						'delete_p'=>($model->delete_p>0)? true : false,
					);
		}
		
		return $data;
	}
	
	/* public function isChecked($module,$controller,$action,$user_id)
	{
		$criteria=new CDbCriteria;
		$criteria->compare('module',strtolower($module));
		$criteria->compare('controller',strtolower($controller));
		$criteria->compare('action',strtolower($action));
		$criteria->compare('user_id',$user_id);
		$criteria->compare('status',1);
		$count=self::model()->count($criteria);
		
		//check in group
		$isCheckGroup=RbacGroupAccess::isChecked($module,$controller,$action,User::getGroup($user_id));
		if($isCheckGroup){
			if($count>0)
				$ret=true;
			else
				$ret=false;
		}else{
			if($count>0)
				$ret=true;
			else
				$ret=false;
		}
		return $ret;
	} */
	
	public function isChecked($module,$controller,$user_id,$priv)
	{
		$criteria=new CDbCriteria;
		$criteria->compare('module',strtolower($module));
		$criteria->compare('controller',strtolower($controller));
		$criteria->compare('user_id',$user_id);
		$model=self::model()->find($criteria);
		if(count($model)>0){
			if(!empty($user_id))
				return ($model->$priv>0)? true : false;
			else
				return false;
		}else{
			return false;
		}
	}
}
