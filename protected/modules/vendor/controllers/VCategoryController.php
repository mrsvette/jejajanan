<?php

class VCategoryController extends DController
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
			array('allow',
				'actions'=>array('uploadImage'),
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
//echo '<pre>';
//var_dump(VCategory::getItems(5));
//var_dump(Yii::app()->user->profile->lang);
//echo '</pre>';exit;
		$model = new VCategory;
		$model2 = new VCategoryDescription;
		
		$criteria = new CDbCriteria;
		$criteria->compare('vendor_id',Yii::app()->user->profile->id);
		$criteria->order = 'date_entry DESC';
		
		$dataProvider = new CActiveDataProvider('VCategory',array('criteria'=>$criteria,'pagination'=>false));

		$this->render(
			'index',
			array(
				'model'=>$model,
				'model2'=>$model2,
				'dataProvider'=>$dataProvider,
			));
	}

	public function actionCreate()
	{
		$model = new VCategory;
		$model2 = new VCategoryDescription;
		if(Yii::app()->request->isPostRequest)
		{
			if(isset($_POST['VCategory']) && isset($_POST['VCategoryDescription'])){
				$model->attributes = $_POST['VCategory'];
				$model2->attributes = $_POST['VCategoryDescription'];
				
				$model->vendor_id = Yii::app()->user->profile->id;
				$model->column = 1;
				$model->top = 1;
				if($model->parent_id>0){
					$model->top = 0;
					$parent = $this->loadModel($model->parent_id);
					//build sort order
					$criteria = new CDbCriteria;
					$criteria->compare('parent_id',$model->parent_id);
					$criteria->order = 'sort_order DESC';
					$criteria->limit = 1;
					$sort = VCategory::model()->find($criteria);
					$model->sort_order = ($sort instanceof VCategory)? $sort->sort_order+1 : 1;
					$model->column = $parent->column + 1;
				}
				$model->status = 1;
				$model->date_entry = date(c);
				//model2 default
				$model2->category_id = 1; //just default
				$model2->language_id = Yii::app()->user->getState('vlanguage')->id;
				if($model->validate() && $model2->validate()){
					if($model->save()){
						$model2->category_id = $model->id; //give the real id
						$model2->save();
						echo CJSON::encode(array(
							'status'=>'success',
							'div'=>Yii::t('global','Your data is successfully saved.')
						));
					}
				}else{
					echo CJSON::encode(array(
						'status'=>'failed',
						'div'=>$this->renderPartial('_form',array('model'=>$model,'model2'=>$model2),true,true),
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
		$model2 = $model->description_one_rel;
		
		if(Yii::app()->request->isPostRequest)
		{
			if(isset($_POST['VCategory'])){
				$model->attributes = $_POST['VCategory'];
				$model2->attributes = $_POST['VCategoryDescription'];
				$model->vendor_id = Yii::app()->user->profile->id;
				$model->date_update = date(c);
				if($model->save() && $model2->save()){
					echo CJSON::encode(array(
						'status'=>'success',
						'div'=>Yii::t('global','Your data is successfully saved.')
					));
				}else{
					echo CJSON::encode(array(
						'status'=>'failed',
						'div'=>$this->renderPartial('_form',array('model'=>$model,'model2'=>$model2),true,true),
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
				$del = VCategoryDescription::model()->deleteAllByAttributes(array('category_id'=>$model->id));
				//delete old image if any
				if(isset($image)){
					if(file_exists($image))
						unlink($image);
				}
			}
		}
	}

	public function actionUploadImage($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			Yii::app()->clientScript->scriptMap['jquery.js'] = false;
			$model = $this->loadModel($id);
			$old_image = $model->image;
			$model->attributes = $_POST['VCategory'];

			//default path uploads/images/vendor
			$path = Extension::getConfigByModule('vendor','vendor_upload_path').'/'.Yii::app()->user->profile->id.'/product';
			$src = $path.'/';

			$file = CUploadedFile::getInstance($model,'image');
			$extension = pathinfo($file->name, PATHINFO_EXTENSION);
			if(!empty($file)){
				list($CurWidth,$CurHeight) = getimagesize($file->tempName);
				$basePath = Yii::getPathOfAlias('webroot').'/';
				if(!is_dir($basePath.$path))
					Yii::app()->file->createDir($permissions=0755, $path);
				if(!is_dir($basePath.$path_thumbs))
					Yii::app()->file->createDir($permissions=0755, $path_thumbs);

				$fname = Tools::slug($model->description_one_rel->name).'-'.time().'.'.$extension;
					
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
				echo CJSON::encode(array(
					'status'=>'success',
					'div'=>'Data berhasil disimpan',
					'image'=>(!empty($model->image))? CHtml::image(Yii::app()->request->baseUrl.'/'.$model->image) : false,
				));
			}
			exit;
		}
	}

	public function loadModel($id)
	{
		$model = VCategory::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		if($model->vendor_id!=Yii::app()->user->profile->id) //owner of the product
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
