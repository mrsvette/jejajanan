<?php

class ProfileController extends DController
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
				'actions'=>array('index'),
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
		Yii::import('application.modules.market.models.*');
		Yii::import('application.modules.market.MarketModule');

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

	public function loadModel($id)
	{
		$model = ModClient::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
