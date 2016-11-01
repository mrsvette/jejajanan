<?php

class VManufactureController extends DController
{

	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = 'column1';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',
				'actions'=>array('index','create','update','delete'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionIndex()
	{
		$this->layout = 'column2';

		Yii::import('application.modules.vendor.models.*');
		Yii::import('application.modules.vendor.MarketModule');

		$model = new VManufacturer;
		
		$criteria = new CDbCriteria;
		$criteria->compare('vendor_id',Yii::app()->user->profile->id);
		$criteria->order = 'date_entry DESC';
		
		$dataProvider = new CActiveDataProvider('VManufacturer',array('criteria'=>$criteria,'pagination'=>false));

		$this->render(
			'index',
			array(
				'model'=>$model,
				'dataProvider'=>$dataProvider,
			));
	}

	public function actionCreate()
	{
		$model = new VManufacturer;
		if(Yii::app()->request->isPostRequest)
		{
			if(isset($_POST['VManufacturer'])){
				$model->attributes = $_POST['VManufacturer'];
				
				$model->vendor_id = Yii::app()->user->profile->id;
				//build sort order
				$criteria = new CDbCriteria;
				$criteria->compare('vendor_id',$model->vendor_id);
				$criteria->order = 'sort_order DESC';
				$criteria->limit = 1;
				$sort = VManufacturer::model()->find($criteria);
				$model->sort_order = ($sort instanceof VManufacturer)? $sort->sort_order+1 : 1;
				
				$model->date_entry = date(c);
				$file = CUploadedFile::getInstance($model,'image');
				if($model->save()){
					$this->uploadImage($model,$file);
					echo CJSON::encode(array(
						'status'=>'success',
						'div'=>Yii::t('global','Your data is successfully saved.')
					));
				}else{
					echo CJSON::encode(array(
						'status'=>'failed',
						'div'=>$this->renderPartial('_form',array('model'=>$model),true,true),
					));
				}
				exit;
			}
		}
	}

	public function actionUpdate($id)
	{
		$this->layout = 'column2';

		$model = $this->loadModel($id);
		
		if(Yii::app()->request->isPostRequest)
		{
			if(isset($_POST['VManufacturer'])){
				$model->attributes = $_POST['VManufacturer'];
				
				$model->vendor_id = Yii::app()->user->profile->id;
				$model->date_update = date(c);
				$file = CUploadedFile::getInstance($model,'image');
				if($model->save()){
					$this->uploadImage($model,$file);
					echo CJSON::encode(array(
						'status'=>'success',
						'div'=>Yii::t('global','Your data is successfully saved.')
					));
				}else{
					echo CJSON::encode(array(
						'status'=>'failed',
						'div'=>$this->renderPartial('_form',array('model'=>$model),true,true),
					));
				}
				exit;
			}
		}
		$this->render('update',array(
			'model'=>$model,
			'model2'=>$model2,
		));
	}

	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			$model = $this->loadModel($id);
			$image = $model->image;
			if($model->delete()){
				//delete old image if any
				if(isset($image)){
					if(file_exists($image))
						unlink($image);
				}
			}
		}
	}

	private function uploadImage($model,$file = null)
	{
		$old_image = $model->image;

		//default path uploads/images/vendor
		$path = Extension::getConfigByModule('vendor','vendor_upload_path').'/'.Yii::app()->user->profile->id.'/manufacture';
		$src = $path.'/';

		$extension = pathinfo($file->name, PATHINFO_EXTENSION);
		if(!empty($file)){
			list($CurWidth,$CurHeight) = getimagesize($file->tempName);
			$basePath = Yii::getPathOfAlias('webroot').'/';
			if(!is_dir($basePath.$path))
				Yii::app()->file->createDir($permissions=0755, $path);
			if(!is_dir($basePath.$path_thumbs))
				Yii::app()->file->createDir($permissions=0755, $path_thumbs);

			$fname = Tools::slug($model->name).'-'.time().'.'.$extension;
					
			$model->image = $path.'/'.$fname;
			$model->date_update = date(c);
			if($file->saveAs($model->image)){ //upload image
				//delete old image if any
				if(isset($old_image)){
					if(file_exists($old_image)){
						unlink($old_image);
					}
				}
				//resize image to ideal size
				$force_resize = (int)Extension::getConfigByModule('vendor','vendor_product_image_force_resize');
				if($force_resize>0){
					$ideal_width = 200; //(int)Extension::getConfigByModule('vendor','vendor_product_image_width');
					$ideal_height = 200; //(int)Extension::getConfigByModule('vendor','vendor_product_image_height');
					if(($CurWidth!=$ideal_width) || ($CurHeight!=$ideal_height)){
						//force resize thumb
						$thumb = Yii::app()->phpThumb->create($model->image);
						$thumb->adaptiveResize($ideal_width,$ideal_height);
						$thumb->save($model->image);
					}
				}

				$model->save();
			}
			return (!empty($model->image))? true : false;
		}
		return false;
	}

	public function loadModel($id)
	{
		$model = VManufacturer::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		if($model->vendor_id!=Yii::app()->user->profile->id) //owner of the product
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
