<?php

class CustomerModule extends CWebModule
{
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application
		
		$this->defaultController = 'default';

		Yii::app()->setComponents(array(
			'errorHandler'=>array(
				'class'=>'CErrorHandler',
				'errorAction'=>'/site/error',
			),
			'user'=>array(
				'class'=>'CWebUser',
				'stateKeyPrefix'=>'customer',
				'loginUrl'=>Yii::app()->createUrl('customer/default/login'),
				'allowAutoLogin'=>true,
			),
		), false);

		//set view path
		//$this->setLayoutPath(Yii::getPathOfAlias('application.modules.customer').'/views/layouts');
		$this->setLayoutPath(Yii::getPathOfAlias('webroot').'/themes/sand/views/layouts');
		// import the module-level models and components
		$this->setImport(array(
			'customer.models.*',
			'customer.components.*',
			'market.models.*',
			'vendor.models.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			if(!Extension::getIsInstalled(array('id'=>'customer')))
				throw new CHttpException(404,'The requested page does not exist.');
			return true;
		}
		else
			return false;
	}

	public function install()
	{
		return true;
	}
}
