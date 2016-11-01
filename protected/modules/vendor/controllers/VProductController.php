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
				'actions'=>array('updateDiscount','deleteDiscount','addDiscount'),
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

		$model = new VProduct;
		$model2 = new VProductDescription;
		$model3 = new VProductToCategory;
		$model4 = new VProductRelated;
		
		$criteria = new CDbCriteria;
		$criteria->compare('vendor_id',Yii::app()->user->profile->id);
		$criteria->order = 'date_entry DESC';
		
		$dataProvider = new CActiveDataProvider('VProduct',array('criteria'=>$criteria,'pagination'=>false));

		$this->render(
			'index',
			array(
				'model'=>$model,
				'model2'=>$model2,
				'dataProvider'=>$dataProvider,
				'model3'=>$model3,
				'model4'=>$model4,
			));
	}

	public function actionCreate()
	{
		
		$model = new VProduct;
		$model2 = new VProductDescription;
		$model3 = new VProductToCategory;
		$model4 = new VProductRelated;
		if(Yii::app()->request->isPostRequest)
		{
			if(isset($_POST['VProduct']) && isset($_POST['VProductDescription'])){
				$model->attributes = $_POST['VProduct'];
				$model2->attributes = $_POST['VProductDescription'];
				$model3->attributes = $_POST['VProductToCategory'];
				$model4->attributes = $_POST['VProductRelated'];
				
				$model->vendor_id = Yii::app()->user->profile->id;
				$model->stock_status_id = 1;
				$model->manufacturer_id = 1;
				if(empty($model->date_available))
					$model->date_available = date("Y-m-d");
				$model->date_entry = date(c);
				//model2 default
				$model2->product_id = 1; //just default
				$model2->language_id = Yii::app()->user->getState('vlanguage')->id;
				if($model->validate() && $model2->validate()){
					if($model->save()){
						$model2->product_id = $model->id; //give the real id
						$model2->save();
						//product category
						if(is_array($model3->category_id)){
							foreach($model3->category_id as $i=>$category_id){
								$model3->create(array('product_id'=>$model->id,'category_id'=>$category_id));
							}
						}
						//product related
						if(is_array($model4->related_id)){
							foreach($model4->related_id as $i=>$related_id){
								$model4->create(array('product_id'=>$model->id,'related_id'=>$related_id));
							}
						}
						echo CJSON::encode(array(
							'status'=>'success',
							'div'=>Yii::t('global','Your data is successfully saved.')
						));
					}
				}else{
					echo CJSON::encode(array(
						'status'=>'failed',
						'div'=>$this->renderPartial('_form',array('model'=>$model,'model2'=>$model2,'model3'=>$model3,'model4'=>$model4),true,true),
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
		$model3 = new VProductToCategory;
		$model3->category_id = $model->categories;
		$model4 = new VProductRelated;
		$model4->related_id = $model->relateds;
		$model5 = new VProductImages;
		
		if(Yii::app()->request->isPostRequest)
		{
			if(isset($_POST['VProduct'])){
				$model->attributes = $_POST['VProduct'];
				$model2->attributes = $_POST['VProductDescription'];
				$model3->attributes = $_POST['VProductToCategory'];
				$model4->attributes = $_POST['VProductRelated'];
				$model->vendor_id = Yii::app()->user->profile->id;
				if(empty($model->date_available))
					$model->date_available = date("Y-m-d");
				$model->date_update = date(c);
				if($model->save() && $model2->save()){
					if(is_array($model3->category_id)){
						foreach($model3->category_id as $i=>$category_id){
							$model3->create(array('product_id'=>$model->id,'category_id'=>$category_id));
						}
					}
					if(is_array($model4->related_id)){
						foreach($model4->related_id as $i=>$related_id){
							$model4->create(array('product_id'=>$model->id,'related_id'=>$related_id));
						}
					}
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
			'model3'=>$model3,
			'model4'=>$model4,
			'model5'=>$model5,
		));
	}


	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			$model = $this->loadModel($id);
			$del1 = VProductDescription::model()->deleteAllByAttributes(array('product_id'=>$model->id));
			$del2 = VProductToCategory::model()->deleteAllByAttributes(array('product_id'=>$model->id));
			$del3 = VProductRelated::model()->deleteAllByAttributes(array('product_id'=>$model->id));
			$model->delete();
		}
	}

	public function actionUploadImage($id)
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
			if(isset($_GET['id'])){
				$product = VProduct::model()->findByPk($id);
				$model->product_id = $product->id;
			}
			$model->date_entry=date(c);
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

					$fname = Tools::slug($product->description_one_rel->name).'-'.time().'.'.$extension;
					
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
					'image'=>(!empty($model->image))? CHtml::image(Yii::app()->request->baseUrl.'/'.$model->thumb.$model->image) : false,
				));
			}else{
				$errors = '';
				if(is_array($model->errors['image'])){
					$errors = implode("<br/>",$model->errors['image']);
				}
				echo CJSON::encode(array(
					'status'=>'failed',
					'div'=>'<div class="alert alert-warning">'.$errors.'</div>',
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
			if(!empty($_POST['id'])){
				$model->type = $_POST['value'];
				if($model->update('type'))
					echo CJSON::encode(array('status'=>'success'));
				else
					echo CJSON::encode(array('status'=>'failed','errors'=>$model->errors));
			}
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

	public function actionUpdateDiscount($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			$model = VProductDiscount::model()->findByPk($id);
			if($model===null)
				throw new CHttpException(404,'The requested page does not exist.');
			foreach($_POST as $attr=>$val){
				$model->{$attr} = $val;
			}
			if(!empty($model->date_range)){
				$range = explode(" - ",$model->date_range);
				$model->date_start = date("Y-m-d",strtotime($range[0]));
				$model->date_end = date("Y-m-d",strtotime($range[1]));
			}
			if($model->save())
				return true;
		}
	}

	public function actionDeleteDiscount($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			$model = VProductDiscount::model()->findByPk($id);
			if($model===null)
				throw new CHttpException(404,'The requested page does not exist.');
			$model->delete();
		}
	}

	public function actionAddDiscount($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			$model = new VProductDiscount;
			$model->product_id = $id;
			$model->price = 0;
			$model->date_entry = date(c);
			if($model->save())
				echo CJSON::encode(array('status'=>'success'));
			else
				var_dump($model->errors);
			exit;
		}
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
