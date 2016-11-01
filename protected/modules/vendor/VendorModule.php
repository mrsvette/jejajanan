<?php

class VendorModule extends CWebModule
{
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application
		
		$this->defaultController = 'default';

		Yii::app()->setComponents(array(
			'errorHandler'=>array(
				'class'=>'CErrorHandler',
				'errorAction'=>'/vendor/default/error',
			),
			'user'=>array(
				'class'=>'CWebUser',
				'stateKeyPrefix'=>'client',
				'loginUrl'=>Yii::app()->createUrl('vendor/default/login'),
				'allowAutoLogin'=>true,
			),
		), false);
		//set view path
		//$this->setLayoutPath(Yii::getPathOfAlias('application.modules.appadmin').'/views/layouts');
		//$this->setLayoutPath(Yii::getPathOfAlias('webroot').'/themes/wind/views/layouts');
		// import the module-level models and components
		$this->setImport(array(
			'vendor.models.*',
			'vendor.components.*',
			'market.models.*',
		));

		//set the language session if not already have
		if(!Yii::app()->user->hasState('vlanguage')){
			$criteria = new CDbCriteria;
			$criteria->compare('code',strtolower(Yii::app()->user->profile->lang));
			$language = VLanguage::model()->find($criteria);
			Yii::app()->user->setState('vlanguage',$language);
		}
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			if(!Extension::getIsInstalled(array('id'=>'vendor')))
				throw new CHttpException(404,'The requested page does not exist.');
			return true;
		}
		else
			return false;
	}

	public function install()
	{
		/*$sql = "CREATE TABLE IF NOT EXISTS `tbl_mod_vendor` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `name` varchar(128) NOT NULL,
		  `description` text,
		  `slug` varchar(256) NOT NULL,
		  `image` varchar(128) NOT NULL,
		  `thumb` varchar(128) DEFAULT NULL,
		  `src` varchar(128) NOT NULL,
		  `url` varchar(256) DEFAULT NULL,
		  `start_date` datetime DEFAULT NULL,
		  `end_date` datetime DEFAULT NULL,
		  `config` text,
		  `status` int(11) DEFAULT '0' COMMENT '0=disabled, 1=enabled',
		  `date_entry` datetime NOT NULL,
		  `user_entry` int(11) NOT NULL,
		  `date_update` datetime DEFAULT NULL,
		  `user_update` int(11) DEFAULT '0',
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
		
		$command = Yii::app()->db->createCommand($sql);
		$command->execute();*/
		return true;
	}
}
