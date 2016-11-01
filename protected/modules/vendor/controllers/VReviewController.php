<?php

class VReviewController extends DController
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

		$model = new VReview;
		$model->status = 1;
		$model->rating = 1;
		
		$criteria = new CDbCriteria;
		$criteria->compare('product_rel.vendor_id',Yii::app()->user->profile->id);
		$criteria->order = 't.date_entry DESC';
		$criteria->with = array('product_rel');
		
		$dataProvider = new CActiveDataProvider('VReview',array('criteria'=>$criteria,'pagination'=>false));

		$this->render(
			'index',
			array(
				'model'=>$model,
				'dataProvider'=>$dataProvider,
			));
	}

	public function actionCreate()
	{
		$model = new VReview;
		if(Yii::app()->request->isPostRequest)
		{
			if(isset($_POST['VReview'])){
				$model->attributes = $_POST['VReview'];
				$model->date_entry = date(c);
				if($model->save()){
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
			if(isset($_POST['VReview'])){
				$model->attributes = $_POST['VReview'];
				$model->date_update = date(c);
				if($model->save()){
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
		));
	}

	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			$model = $this->loadModel($id);
			$model->delete();
		}
	}

	public function loadModel($id)
	{
		$model = VReview::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		if($model->product_rel->vendor_id!=Yii::app()->user->profile->id) //owner of the product
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
