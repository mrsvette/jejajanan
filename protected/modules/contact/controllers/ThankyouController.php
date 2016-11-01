<?php

class ThankyouController extends DController
{
	public $layout = 'column2';
	
	public function init(){
		$this->module->setLayoutPath(Yii::getPathOfAlias('webroot.themes.'.Yii::app()->theme->name.'.views.layouts'));
	}

	/**
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
				'actions'=>array('index'),
				'users'=>array('*'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionIndex()
	{
		$message = Yii::t('contact','Thank you for contacting us. We will respond to you as soon as possible.');
		if(!Yii::app()->user->hasState('contact_expired_time'))
			Yii::app()->user->setState('contact_expired_time',time()+5);
		
		if(empty(Yii::app()->request->urlReferrer))
			$this->redirect(array('/'));
		else{
			if(time()>Yii::app()->user->getState('contact_expired_time')){
				Yii::app()->user->setState('contact_expired_time',null);
				$this->redirect(array('/'));
			}
		}

		$this->render('index',array('message'=>$message));
	}
}
