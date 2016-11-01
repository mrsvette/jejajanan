<?php

class CartsController extends DController
{
/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='column2';
	
	public function init(){
		$this->module->setLayoutPath(Yii::getPathOfAlias('webroot.themes.'.Yii::app()->config->get('theme').'.views.layouts'));
	}

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
				'actions'=>array('view'),
				'users'=>array('*'),
			),
			array('allow',
				'actions'=>array('create'),
				'users'=>array('*'),
			),
			array('allow',
				'actions'=>array('update'),
				'users'=>array('*'),
			),
			array('allow',
				'actions'=>array('delete'),
				'users'=>array('*'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Manages all models.
	 */
	public function actionView()
	{
		
		$this->render('view',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Creates a new cart.
	 * id : product id.
	 */
	public function actionCreate($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			Yii::app()->clientScript->scriptMap['jquery.js'] = false;
			$carts = array();
			if(Yii::app()->user->hasState('carts'))
				$carts = Yii::app()->user->getState('carts');
			
			//get the product
			$product = ModProduct::model()->findByPk($id);
			if(!$product instanceof ModProduct){
				echo CJSON::encode(array('status'=>'failed')); exit;
			}
			//get the currency
			if(!Yii::app()->user->hasState('currency'))
				Yii::app()->user->setState('currency',ModCurrency::getDefault()->attributes);
			
			if(!empty($carts[$product->id]))
				unset($carts[$product->id]);
			//build cart structure
			$carts[$product->id] = array(
				'id'=>$product->id,
				'title'=>$product->title,
				'pricing'=>$product->pricing,
				'qty'=>(isset($_POST['qty']))? $_POST['qty'] : 1,
				'discount'=>$product->discount,
				'product'=>$product->attributes,
				'currency'=>Yii::app()->user->getState('currency'),//use session for changing currency
			);

			Yii::app()->user->setState('carts',$carts);

			echo CJSON::encode(array('status'=>'success'));
			exit;
		}
	}

	public function actionUpdate()
	{
		if(Yii::app()->request->isPostRequest)
		{
			Yii::app()->clientScript->scriptMap['jquery.js'] = false;
			$carts = Yii::app()->user->getState('carts');
			$id = $_POST['id'];
			$carts[$id]['qty'] = (int)$_POST['qty'];
			if($carts[$id]['qty']<=0)
				$carts[$id]['qty'] = 1;
			Yii::app()->user->setState('carts',$carts);
			echo CJSON::encode(array('status'=>'success'));
			exit;
		}
	}

		/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			Yii::app()->clientScript->scriptMap['jquery.js'] = false;
			if(!Yii::app()->user->hasState('carts')){
				echo CJSON::encode(array('status'=>'failed')); exit;
			}
			$carts = Yii::app()->user->getState('carts');
			unset($carts[$id]);
			Yii::app()->user->setState('carts',$carts);
			echo CJSON::encode(array('status'=>'success')); exit;
		}
	}
}
