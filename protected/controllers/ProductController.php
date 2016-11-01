<?php

class ProductController extends DController
{
	public $layout = 'column1';

	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
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
			array('allow',  // allow all users to access 'index' and 'view' actions.
				'actions'=>array('view','category'),
				'users'=>array('*'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionCategory()
	{
		var_dump($_GET);exit;
	}

	public function actionView($id)
	{
		$this->layout = 'column_single_item';

		$model = VProduct::model()->findByPk($id);
		if(!$model instanceof VProduct)
			throw new CHttpException(404,'The requested page does not exist.');

		$this->pageSection = $model->description_one_client_rel->name;
		$this->breadcrumbs = array(
			'Product' => array('/product'),
			$model->description_one_client_rel->name,
		);

		$this->render('view', array('model'=>$model));
	}
}
