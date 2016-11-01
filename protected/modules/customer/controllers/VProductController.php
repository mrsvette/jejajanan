<?php

class VProductController extends DController
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
				'actions'=>array('createCategory','updateCategory','deleteCategory','createSlug'),
				'users'=>array('@'),
			),
			array('allow',
				'actions'=>array('uploadImage','deleteImage','updateImageType'),
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

		$model = Yii::app()->user->profile;
		if(!$model instanceof ModClient)
			$model = $this->loadModel(Yii::app()->user->id);
		if(isset($_POST['ModClient'])){
			$model->attributes = $_POST['ModClient'];
			$model->date_update = date(c);
			if($model->save()){
				Yii::app()->user->setFlash('update',Yii::t('global','Your data is successfully updated.'));
				$this->refresh();
			}
		}

		$this->render('index',array('model'=>$model));
	}

	public function actionCreate()
	{
		$this->layout = 'column2';
		$model = new VProduct;
		if(Yii::app()->request->isPostRequest)
		{
			if(isset($_POST['VProduct'])){
				$model->attributes = $_POST['VProduct'];
				$model->vendor_id = Yii::app()->user->profile->id;
				$model->slug = Tools::slug($model->title);
				$model->date_entry = date(c);
				$model->user_entry = Yii::app()->user->profile->id;
				if($model->save()){
					echo CJSON::encode(array(
						'status'=>'success',
						'div'=>Yii::t('global','Your data is successfully saved.')
					));
					exit;
				}
			}
		}

		$criteria = new CDbCriteria;
		$criteria->compare('vendor_id',Yii::app()->user->profile->id);
		
		$dataProvider = new CActiveDataProvider('VProductCategory',array('criteria'=>$criteria));

		$criteria2 = new CDbCriteria;
		$criteria2->compare('vendor_id',Yii::app()->user->profile->id);
		
		$productProvider = new CActiveDataProvider('VProduct',array('criteria'=>$criteria2));

		$model2 = new VProductCategory;

		$this->render(
			'create',
			array(
				'model'=>$model,
				'dataProvider'=>$dataProvider,
				'model2'=>$model2,
				'productProvider'=>$productProvider
			)
		);
	}

	public function actionUpdate($id)
	{
		$this->layout = 'column2';

		$model = $this->loadModel($id);
		
		if(Yii::app()->request->isPostRequest)
		{
			if(isset($_POST['VProduct'])){
				$model->attributes = $_POST['VProduct'];
				$model->vendor_id = Yii::app()->user->profile->id;
				$model->date_update = date(c);
				$model->user_update = Yii::app()->user->profile->id;
				if($model->save()){
					echo CJSON::encode(array(
						'status'=>'success',
						'div'=>Yii::t('global','Your data is successfully saved.')
					));
					exit;
				}
			}
		}

		if($model->payment_rel instanceof VProductPayment){
			$model2 = $model->payment_rel;
			if($model2->type=='once')
				$model2->total = $model2->once_price + $model2->once_setup_price;
		}else{
			$model2 = new VProductPayment;
			$model2->type = 'once';
		}

		$criteria = new CDbCriteria;
		$criteria->compare('product_id',$id);
		$imageProvider = new CActiveDataProvider('VProductImages',array('criteria'=>$criteria));

		$this->render('update',array(
			'model'=>$model,
			'model2'=>$model2,
			'imageProvider'=>$imageProvider,
		));
	}

	public function actionCreateCategory()
	{
		$model = new VProductCategory;
		if(isset($_POST['VProductCategory'])){
			$model->attributes = $_POST['VProductCategory'];
			$model->vendor_id = Yii::app()->user->profile->id;
			$model->slug = Tools::slug($model->title);
			$model->date_entry = date(c);
			$model->user_entry = Yii::app()->user->profile->id;
			if($model->save()){
				echo CJSON::encode(array(
					'status'=>'success',
					'div'=>Yii::t('global','Your data is successfully saved.')
				));
				exit;
			}
		}
		
	}

	public function actionDeleteCategory($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			$model = VProductCategory::model()->findByPk($id);
			$model->delete();
		}
	}

	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			$model = $this->loadModel($id);
			$model->delete();
		}
	}

	public function actionCreateSlug()
	{
		if(Yii::app()->request->isPostRequest)
		{
			$slug = Tools::slug($_POST['title']);
			echo CJSON::encode(array('status'=>'success','div'=>$slug));
			exit;
		}
	}

	public function actionUploadImage()
	{
		if(Yii::app()->request->isPostRequest)
		{
			Yii::app()->clientScript->scriptMap['jquery.js'] = false;
			$model = new VProductImages('create');
			$model->attributes = $_POST['VProductImages'];

			//default path uploads/images/vendor
			$path = Extension::getConfigByModule('vendor','vendor_upload_path').'/'.Yii::app()->user->profile->id.'/product';
			//default path uploads/images/vendor/_thumbs
			$path_thumbs = $path.'/_thumbs';

			$model->image = '-';
			$model->src = $path.'/';
			$model->thumb = $path_thumbs.'/';
			$model->date_entry=date(c);
			$model->user_entry=Yii::app()->user->id;
			if($model->validate()){
				$file = CUploadedFile::getInstance($model,'image');
				$extension = pathinfo($file->name, PATHINFO_EXTENSION);
				if(!empty($file)){
					list($CurWidth,$CurHeight) = getimagesize($file->tempName);
					$basePath = Yii::getPathOfAlias('webroot').'/';
					if(!is_dir($basePath.$path))
						Yii::app()->file->createDir($permissions=0755, $path);
					if(!is_dir($basePath.$path_thumbs))
						Yii::app()->file->createDir($permissions=0755, $path_thumbs);

					$fname = $model->product_rel->slug.'-'.time().'.'.$extension;
					
					$model->image = $fname;
					if($file->saveAs($model->src.$model->image)){ //upload image
						//resize image to ideal size
						$force_resize = (int)Extension::getConfigByModule('vendor','vendor_product_image_force_resize');
						if($force_resize>0){
							$ideal_width = (int)Extension::getConfigByModule('vendor','vendor_product_image_width');
							$ideal_height = (int)Extension::getConfigByModule('vendor','vendor_product_image_height');
							if(($CurWidth!=$ideal_width) || ($CurHeight!=$ideal_height)){
								$thumb2 = Yii::app()->phpThumb->create($path.'/'.$fname);
								
								if($CurWidth<=$CurHeight) //landscape picture
									$percentage = ($ideal_width/$CurWidth)*100;
								else //portrait
									$percentage = ($ideal_height/$CurHeight)*100;

								$thumb2->resizePercent($percentage);
								$thumb2->save($path.'/'.$fname);
								//force resize thumb
								$thumb3 = Yii::app()->phpThumb->create($path.'/'.$fname);
								$thumb3->adaptiveResize($ideal_width,$ideal_height);
								$thumb3->save($path.'/'.$fname);
							}
						}
						//create thumb
						$thumb = Yii::app()->phpThumb->create($path.'/'.$fname);
						$thumb->adaptiveResize(260,300);
						$thumb->save($path_thumbs.'/'.$fname);

						$model->save();
					}
				}
				echo CJSON::encode(array(
					'status'=>'success',
					'div'=>'Data berhasil disimpan',
					'image'=>(!empty($model->image))? CHtml::image(Yii::app()->request->baseUrl.'/'.$model->src.$model->image) : false,
				));
			}else{
				echo CJSON::encode(array(
					'status'=>'failed',
					'div'=>$this->renderPartial('_form_image',array('model'=>$model),true,true),
				));
			}
			exit;
		}
	}

	public function actionUpdateImageType()
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$model = VProductImages::model()->findByPk($_POST['id']);
			if(!empty($_POST['value'])){
				$model->type=$_POST['value'];
				$model->update('type');
			}
			echo CJSON::encode(array('status'=>'success'));
			exit;
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	public function actionDeleteImage($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$model = VProductImages::model()->findByPk($id);
			if($model instanceof VProductImages){
				$criteria = new CDbCriteria;
				$criteria->compare('image',$model->image);
				$count = VProductImages::model()->count($criteria);
				if($count<=1){
					if(file_exists($model->src.$model->image)){
						if(unlink($model->src.$model->image)){
							if(file_exists($model->thumb.$model->image))
								unlink($model->thumb.$model->image);
							$model->delete();
						}
					}
				}else
					$model->delete();
			}
			echo CJSON::encode(array('status'=>'success'));
			exit;
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	public function loadModel($id)
	{
		$model = VProduct::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		if($model->vendor_id!=Yii::app()->user->profile->id) //owner of the product
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
