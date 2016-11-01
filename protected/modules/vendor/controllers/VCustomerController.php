<?php

class VCustomerController extends DController
{
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
				'actions'=>array('index','manage'),
				'users'=>array('@'),
			),
			array('allow',
				'actions'=>array('create','createGroup'),
				'users'=>array('@'),
			),
			array('allow',
				'actions'=>array('update','group','updateGroup'),
				'users'=>array('@'),
			),
			array('allow',
				'actions'=>array('delete','deleteGroup'),
				'users'=>array('@'),
			),
			array('allow',
				'actions'=>array('getcity','confirmEmail'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Manages all models.
	 */
	public function actionIndex()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('vendor_id',Yii::app()->user->profile->id);
		$criteria->order = 'id DESC';
		if(Yii::app()->request->isAjaxRequest && isset($_GET['VCustomer'])){
			foreach($_GET['VCustomer'] as $attr1=>$val1){
				if(!empty($val1))
					$criteria->compare($attr1,$val1,true);
			}
		}

		$dataProvider = new CActiveDataProvider('VCustomer',array('criteria'=>$criteria));

		$criteria2 = new CDbCriteria;
		$criteria2->compare('vendor_id',Yii::app()->user->profile->id);
		$criteria2->order = 'id DESC';
		if(Yii::app()->request->isAjaxRequest && isset($_GET['VCustomerGroup'])){
			foreach($_GET['VCustomerGroup'] as $attr=>$val){
				if(!empty($val) || $val>=0)
					$criteria2->compare($attr,$val,true);
			}
		}
		$groupProvider = new CActiveDataProvider('VCustomerGroup',array('criteria'=>$criteria2));
		
		$model = new VCustomer('create');
		$model2 = new VCustomerGroup;
		$model2->taxed = 1;

		$this->render('index',array(
			'dataProvider'=>$dataProvider,
			'groupProvider'=>$groupProvider,
			'model'=>$model,
			'model2'=>$model2,
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
			$model = new VCustomer('create');
			$model->attributes = $_POST['VCustomer'];
			$model->vendor_id = Yii::app()->user->profile->id;
			$model->salt = md5($model->generateSalt());
			$model->ip = $_SERVER['REMOTE_ADDR'];
			$model->date_entry = date(c);
			if($model->save()){
				$model->password = $model->hashPassword($model->password,$model->salt);
				$model->update(array('password'));
				echo CJSON::encode(array(
					'status'=>'success',
					'div'=>'Data berhasil disimpan',
				));
			}else{
				echo CJSON::encode(array(
					'status'=>'failed',
					'div'=>$this->renderPartial('_form_client',array('model'=>$model),true,true),
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
			$model = VCustomer::model()->findByPk($id);
			$model->attributes = $_POST['VCustomer'];
			$model->vendor_id = Yii::app()->user->profile->id;
			$model->date_update = date(c);
			if($model->save()){
				echo CJSON::encode(array(
					'status'=>'success',
					'div'=>'Data berhasil disimpan',
				));
			}else{
				echo CJSON::encode(array(
					'status'=>'failed',
					'div'=>$this->renderPartial('_form_manage',array('model'=>$model),true,true),
				));
			}
			exit;
		}
	}

	public function actionManage($id)
	{
		$model = VCustomer::model()->findByPk($id);
		if(!$model instanceof VCustomer)
			throw new CHttpException(404,'The requested page does not exist.');

		$criteria = new CDbCriteria;
		$criteria->compare('customer_id',$model->id);
		$criteria->compare('vendor_id',Yii::app()->user->profile->id);
		$criteria->order = 'id DESC';

		$orderProvider = new CActiveDataProvider('VCustomerOrder',array('criteria'=>$criteria));

		$invoiceProvider = new CActiveDataProvider('VInvoice',array('criteria'=>$criteria));

		$this->render('manage',array(
			'model'=>$model,
			'orderProvider'=>$orderProvider,
			'invoiceProvider'=>$invoiceProvider
		));
	}

	public function actionCreateGroup()
	{
		if(Yii::app()->request->isPostRequest)
		{
			Yii::app()->clientScript->scriptMap['jquery.js'] = false;
			$model = new VCustomerGroup;
			$model->attributes = $_POST['VCustomerGroup'];
			$model->vendor_id = Yii::app()->user->profile->id;
			$model->date_entry = date(c);
			if($model->save()){
				echo CJSON::encode(array(
					'status'=>'success',
					'div'=>'Data berhasil disimpan',
				));
			}else{
				echo CJSON::encode(array(
					'status'=>'failed',
					'div'=>$this->renderPartial('_form_group',array('model'=>$model),true,true),
				));
			}
			exit;
		}
	}

	public function actionUpdateGroup($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			Yii::app()->clientScript->scriptMap['jquery.js'] = false;
			$model = VCustomerGroup::model()->findByPk($id);
			$model->attributes = $_POST['VCustomerGroup'];
			$model->date_update = date(c);
			if($model->save()){
				echo CJSON::encode(array(
					'status'=>'success',
					'div'=>'Data berhasil disimpan',
				));
			}else{
				echo CJSON::encode(array(
					'status'=>'failed',
					'div'=>$this->renderPartial('_form_group',array('model'=>$model),true,true),
				));
			}
			exit;
		}
	}

	public function actionDeleteGroup($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			$model = VCustomerGroup::model()->findByPk($id);
			$model->delete();
		}
	}

	public function actionGroup($id)
	{
		$model = VCustomerGroup::model()->findByPk($id);
		if(!$model instanceof VCustomerGroup)
			throw new CHttpException(404,'The requested page does not exist.');
		$this->render('group',array('model'=>$model));
	}

	public function actionGetcity()
	{
		if(Yii::app()->request->isAjaxRequest){
			if(isset($_POST['province_id'])){
				// Stop jQuery from re-initialization
				Yii::app()->clientScript->scriptMap['jquery.js'] = false;
				$model=new VCustomer;
				echo CJSON::encode(array(
					'status'=>'success',
					'div'=>CHtml::activeDropDownList($model,'city',ModCity::items($_POST['province_id']),array('class'=>'form-control')),
				));
				exit;
			}
		}
	}

	public function actionConfirmEmail($hash)
	{
		$this->layout = 'column1';

		$criteria = new CDbCriteria;
		$criteria->compare('meta_key','confirm_email');
		$criteria->compare('meta_value',$hash);

		$model = ExtensionMeta::model()->find($criteria);
		if($model instanceof ExtensionMeta){
			$client = $this->loadModel($model->client_id);
			$client->status = VCustomer::ACTIVE;
			$client->date_update = date(c);
			if($client->save()){
				Yii::app()->user->setFlash('confirm',Yii::t('EcommerceModule.client','Your email is succesfully confirmed.'));
				$this->render('confirm_email');
			}
		}else
			throw new CHttpException(404,'The requested page does not exist.');
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$model = $this->loadModel($id);

		$criteria = new CDbCriteria;
		$criteria->compare('customer_id',$model->id);
		$criteria->compare('vendor_id',Yii::app()->user->profile->id);

		$del1 = VCustomerOrder::model()->deleteAll($criteria);
		$del2 = VInvoice::model()->deleteAll($criteria);
		$del5 = $model->delete();
		
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('view'));
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
		$model = VCustomer::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
