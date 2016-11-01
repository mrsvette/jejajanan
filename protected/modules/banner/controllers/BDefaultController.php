<?php

class BDefaultController extends EController
{
	public static $_alias='Manage Banners';

	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='column2';

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
				'actions'=>array('index','view','manage'),
				'expression'=>'Rbac::ruleAccess(\'read_p\')',
			),
			array('allow',
				'actions'=>array('create','setting'),
				'expression'=>'Rbac::ruleAccess(\'create_p\')',
			),
			array('allow',
				'actions'=>array('update','uploadImage'),
				'expression'=>'Rbac::ruleAccess(\'update_p\')',
			),
			array('allow',
				'actions'=>array('delete','deleteImage'),
				'expression'=>'Rbac::ruleAccess(\'delete_p\')',
			),
			array('allow',
				'actions'=>array('detail'),
				'users'=>array('*'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionIndex()
	{
		$this->forward('view');
	}

	/**
	 * Manages all models.
	 */
	public function actionView()
	{
		$criteria = new CDbCriteria;
		$criteria->order = 't.id DESC';
		if(Yii::app()->request->isAjaxRequest && isset($_GET['ModBanner'])){
			foreach($_GET['ModBanner'] as $attr1=>$val1){
				$criteria->compare('t.'.$attr1,$val1,true);
			}
		}

		$dataProvider = new CActiveDataProvider('ModBanner',array('criteria'=>$criteria,'pagination'=>array('pageSize'=>5)));

		$criteria2 = new CDbCriteria;
		$criteria2->compare('name',Yii::app()->controller->module->id);
		$setting = Extension::model()->find($criteria2);

		$this->render('view',array(
			'dataProvider'=>$dataProvider,
			'setting'=>$setting,
		));
	}

	public function actionManage($id)
	{
		$model = $this->loadModel($id);
		$model->config = CJSON::decode($model->config);
		
		$this->render('manage',array(
			'model'=>$model,
		));
	}

		/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		if(Yii::app()->request->isPostRequest)
		{
			Yii::app()->clientScript->scriptMap['jquery.js'] = false;
			$model = new ModBanner('create');

			$model->attributes = $_POST['ModBanner'];
			$model->slug = Tools::slug($model->name);
			if(!empty($model->config)){
				$model->config = CJSON::encode($model->config);
			}
			//default path uploads/images/banner
			$path = Extension::getConfigByModule('banner','banner_upload_path');
			//$model->src = $path.'/';
			//default path uploads/images/banner/_thumbs
			$path_thumbs = $path.'/_thumbs';
			//$model->thumb = $path_thumbs.'/';
			$model->start_date = (strtotime($model->start_date)>0)? date("Y-m-d",strtotime($model->start_date)) : null;
			$model->end_date = (strtotime($model->end_date)>0)? date("Y-m-d",strtotime($model->end_date)) : null;
			$model->status = (strtotime($model->end_date)>0)? 1 : 0;
			$model->date_entry = date(c);
			$model->user_entry = Yii::app()->user->id;
			if($model->save()){
				$file = CUploadedFile::getInstance($model,'image');
				$extension = pathinfo($file->name, PATHINFO_EXTENSION);
				if(!empty($file)){
					list($CurWidth,$CurHeight) = getimagesize($file->tempName);
					$basePath = Yii::getPathOfAlias('webroot').'/'; //$exp[0];
					if(!is_dir($basePath.$path))
						Yii::app()->file->createDir($permissions=0755, $path);
					if(!is_dir($basePath.$path_thumbs))
						Yii::app()->file->createDir($permissions=0755, $path_thumbs);
					$fname = $model->slug.'-'.time().'.'.$extension;
					//$model->image = $fname;
					if($file->saveAs($path.'/'.$fname)){ //upload image
						if(!empty($model->config)){
							$config = CJSON::decode($model->config);
							$ideal_width = (int)$config['image_width'];
							$ideal_height = (int)$config['image_height'];
							if($ideal_width>0 && $ideal_height>0){
								if(($CurWidth!=$ideal_width) || ($CurHeight!=$ideal_height)){
									$thumb2 = Yii::app()->phpThumb->create($path.'/'.$fname);
									if($CurWidth<$CurHeight) //portrait
										$percentage = ($ideal_width/$CurWidth)*100+5;
									else
										$percentage = ($ideal_height/$CurHeight)*100+5;
									$thumb2->resizePercent($percentage);
									$thumb2->save($path.'/'.$fname);
									//force resize thumb
									$thumb3 = Yii::app()->phpThumb->create($path.'/'.$fname);
									$thumb3->adaptiveResize($ideal_width,$ideal_height);
									$thumb3->save($path.'/'.$fname);
								}
							}
						}
						//create thumb
						$thumb = Yii::app()->phpThumb->create($path.'/'.$fname);
						$thumb->resize(128,128);
						$thumb->save($path_thumbs.'/'.$fname);

						$model->src = $path.'/';
						$model->thumb = $path_thumbs.'/';
						$model->image = $fname;
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
					'div'=>$this->renderPartial('_form_banner',array('model'=>$model),true,true),
				));
			}
			exit;
		}
	}

	public function actionUpdate($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			Yii::app()->clientScript->scriptMap['jquery.js'] = false;
			$model = $this->loadModel($id);
			$old_image = $model->image;

			$model->attributes = $_POST['ModBanner'];
			if(!empty($model->config)){
				$model->config = CJSON::encode($model->config);
			}
			$model->slug = Tools::slug($model->name);
			//default path uploads/images/banner
			$path = Extension::getConfigByModule('banner','banner_upload_path');
			//$model->src = $path.'/';
			//default path uploads/images/banner/_thumbs
			$path_thumbs = $path.'/_thumbs';
			//$model->thumb = $path_thumbs.'/';
			$model->start_date = (strtotime($model->start_date)>0)? date("Y-m-d",strtotime($model->start_date)) : null;
			$model->end_date = (strtotime($model->end_date)>0)? date("Y-m-d",strtotime($model->end_date)) : null;
			$model->date_update = date(c);
			$model->user_update = Yii::app()->user->id;
			
			$attributes = array(
				'name',
				'description',
				'slug',
				'url',
				'config',
				'status',
				'start_date',
				'end_date',
				'status',
				'date_update',
				'user_update'
			);
			if($model->update($attributes)){
				$file = CUploadedFile::getInstance($model,'image');
				$extension = pathinfo($file->name, PATHINFO_EXTENSION);
				if(!empty($file)){
					list($CurWidth,$CurHeight) = getimagesize($file->tempName);
					$basePath = Yii::getPathOfAlias('webroot').'/';//$exp[0];
					if(!is_dir($basePath.$path))
						Yii::app()->file->createDir($permissions=0755, $path);
					if(!is_dir($basePath.$path_thumbs))
						Yii::app()->file->createDir($permissions=0755, $path_thumbs);
					$fname = $model->slug.'-'.time().'.'.$extension;
					$model->image = $fname;
					if($file->saveAs($path.'/'.$fname)){ //upload image
						if(!empty($model->config)){
							$config = CJSON::decode($model->config);
							$ideal_width = (int)$config['image_width'];
							$ideal_height = (int)$config['image_height'];
							if($ideal_width>0 && $ideal_height>0){
								if(($CurWidth!=$ideal_width) || ($CurHeight!=$ideal_height)){
									$thumb2 = Yii::app()->phpThumb->create($path.'/'.$fname);
									if($CurWidth<$CurHeight) //portrait
										$percentage = ($ideal_width/$CurWidth)*100+5;
									else
										$percentage = ($ideal_height/$CurHeight)*100+5;
									$thumb2->resizePercent($percentage);
									$thumb2->save($path.'/'.$fname);
									//force resize thumb
									$thumb3 = Yii::app()->phpThumb->create($path.'/'.$fname);
									$thumb3->adaptiveResize($ideal_width,$ideal_height);
									$thumb3->save($path.'/'.$fname);
								}
							}
						}
						//create thumb
						$thumb = Yii::app()->phpThumb->create($path.'/'.$fname);
						$thumb->resize(128,128);
						$thumb->save($path_thumbs.'/'.$fname);
						
						//delete the old image
						if($model->image != $old_image){
							if(file_exists($model->src.$old_image))
								unlink($model->src.$old_image);
							if(file_exists($model->thumb.$old_image))
								unlink($model->thumb.$old_image);
						}

						$model->update(array('image','thumb','src'));
					}
				}

				echo CJSON::encode(array(
					'status'=>'success',
					'div'=>'Data berhasil disimpan',
				));
			}else{
				echo CJSON::encode(array(
					'status'=>'failed',
					'div'=>$this->renderPartial('_form_banner',array('model'=>$model),true,true),
				));
			}
			exit;
		}
	}

	public function actionSetting()
	{
		if(Yii::app()->request->isPostRequest)
		{
			$criteria = new CDbCriteria;
			$criteria->compare('name',$_POST['name']);
			$model = Extension::model()->find($criteria);
			if(!$model instanceof Extension)
				throw new CHttpException(404,'The requested page does not exist.');
			if(Yii::app()->request->isPostRequest){
				$save_configs = $model->saveConfig($_POST);
				if($save_configs){
					echo CJSON::encode(array(
						'status'=>'success',
						'div'=>Yii::t('global','Your config has been successfully saved.')
					));
					exit;
				}
			}
		}
	}

	public function actionDetail($slug)
	{

		$criteria = new CDbCriteria;
		$criteria->compare('slug',$slug);
		$model = ModBanner::model()->find($criteria);

		if(!$model instanceof ModBanner)
			throw new CHttpException(404,'The requested page does not exist.');
		
		$this->render('detail',array('model'=>$model));
	}

	public function actionDelete($id)
	{
		$model = ModBanner::model()->findByPk($id);
		//delete the image
		if($model->delete()){
			if(file_exists($model->src.$model->image))
				unlink($model->src.$model->image);
			if(file_exists($model->thumb.$model->image))
				unlink($model->thumb.$model->image);
		}
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Extension the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model = ModBanner::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
