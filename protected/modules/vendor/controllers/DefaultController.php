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
				'actions'=>array('login','error'),
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

		$this->render('index');
	}

	public function actionLogin()
	{
		$this->layout = 'column1';

		$model = new LoginForm;
		if(isset($_POST['LoginForm'])){
			$model->attributes = $_POST['LoginForm'];
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
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

	public function actionError()
	{
		$this->layout = 'column1';

	    if($error = Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}

	public function loadModel($id)
	{
		$model = ModClient::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
