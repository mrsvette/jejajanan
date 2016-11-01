<?php

class DefaultController extends DController
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
				'actions'=>array('index','logout'),
				'users'=>array('@'),
			),
			array('allow',
				'actions'=>array('login'),
				'users'=>array('*'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionIndex()
	{
		$this->layout = 'column2';

		$this->pageSection = 'Customer Dashboard';
		$this->breadcrumbs = array(
			ucfirst(Yii::app()->controller->module->id) => array('/'.Yii::app()->controller->module->id.'/'),
			Yii::t('CustomerModule.customer','Dashboard'),
		);

		$this->render('index');
	}

	public function actionLogin()
	{
		$this->layout = 'column1';

		$model = new CustomerLoginForm;
		if(isset($_POST['CustomerLoginForm'])){
			$model->attributes = $_POST['CustomerLoginForm'];
			if($model->validate() && $model->login())
				$this->redirect('index'); //$this->redirect(Yii::app()->user->returnUrl);
		}

		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(array('default/index'));
	}

	public function loadModel($id)
	{
		$model = ModClient::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
