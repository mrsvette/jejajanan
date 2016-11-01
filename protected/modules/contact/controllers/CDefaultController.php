<?php

class CDefaultController extends EController
{
	public static $_alias='Manage Contact';

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
				'actions'=>array('index','view','manage','detail'),
				'expression'=>'Rbac::ruleAccess(\'read_p\')',
			),
			array('allow',
				'actions'=>array('create','setting'),
				'expression'=>'Rbac::ruleAccess(\'create_p\')',
			),
			array('allow',
				'actions'=>array('update'),
				'expression'=>'Rbac::ruleAccess(\'update_p\')',
			),
			array('allow',
				'actions'=>array('delete'),
				'expression'=>'Rbac::ruleAccess(\'delete_p\')',
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	public function actionIndex()
	{
		$this->forward('view');
	}
		/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$model = $this->loadModel($id);
		$model->delete();
		
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('view'));
	}

	/**
	 * Manages all models.
	 */
	public function actionView()
	{
		$criteria=new CDbCriteria;
		$criteria->order='id DESC';
		if(Yii::app()->request->isAjaxRequest && isset($_GET['ModContact'])){
			foreach($_GET['ModContact'] as $attr1=>$val1){
				if(!empty($val1))
					$criteria->compare($attr1,$val1,true);
			}
		}

		$dataProvider=new CActiveDataProvider('ModContact',array('criteria'=>$criteria,'pagination'=>array('pageSize'=>5)));

		$criteria2 = new CDbCriteria;
		$criteria2->compare('name',Yii::app()->controller->module->id);
		$setting = Extension::model()->find($criteria2);
		
		$this->render('view',array(
			'dataProvider'=>$dataProvider,
			'setting'=>$setting,
		));
	}

	public function actionManage($id)
	{
		$model = $this->loadModel($id);
		
		$this->render('manage',array(
			'model'=>$model,
		));
	}

	public function actionDetail($id)
	{
		$model = $this->loadModel($id);
		if($model->status<1){
			$model->status = 1;
			$model->update('status');
		}
		
		$this->render('detail',array(
			'model'=>$model,
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
			$model = new ModContact('create');
			$model->attributes = $_POST['ModContact'];
			$model->date_entry = date(c);
			$mail_template = Extension::getConfigByModule('contact','contact_email_template');
			$contact_db_saved = Extension::getConfigByModule('contact','contact_db_saved');
			$contact_admin_email = Extension::getConfigByModule('contact','contact_admin_email');
			if($contact_db_saved)
				$exc = $model->save();
			else
				$exc = $model->validate();
			if($exc){
				//send mail
				Yii::import('application.modules.email.models.*');
		        $data = $model->attributes;
				$email = array();
				$email = array_merge($email,$data);
		        $email['to'] = $contact_admin_email;
		        $email['to_name'] = Yii::app()->config->get('site_name');
		        $email['code']      = $mail_template;
				
				$template = new ModEmailTemplate;
		        $send = $template->template_send($email);
				//also send to client
				$client_mail_template = Extension::getConfigByModule('contact','contact_email_template_client');
				$email2 = array();
				$email2 = array_merge($email2,$data);
		        $email2['to'] = $data['email'];
		        $email2['to_name'] = $data['name'];
		        $email2['code']      = $client_mail_template;
				
		        $client_send = $template->template_send($email2);

				echo CJSON::encode(array(
					'status'=>'success',
					'div'=>'Data berhasil disimpan',
				));
			}else{
				echo CJSON::encode(array(
					'status'=>'failed',
					'div'=>$this->renderPartial('_form_contact',array('model'=>$model),true,true),
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
			$model = $this->loadModel($id);
			$model->date_update = date(c);
			if($model->save()){
				echo CJSON::encode(array(
					'status'=>'success',
					'div'=>'Data berhasil disimpan',
				));
			}else{
				echo CJSON::encode(array(
					'status'=>'failed',
					'div'=>$this->renderPartial('_form_contact',array('model'=>$model),true,true),
				));
			}
			exit;
		}
	}

	public function actionSetting()
	{
		if(Yii::app()->request->isPostRequest)
		{
			$criteria = new CDbCriteria;
			$criteria->compare('name',$_POST['name']);
			$model = Extension::model()->find($criteria);
			if(!$model instanceof Extension)
				throw new CHttpException(404,'The requested page does not exist.');
			if(Yii::app()->request->isPostRequest){
				$save_configs = $model->saveConfig($_POST);
				if($save_configs){
					echo CJSON::encode(array(
						'status'=>'success',
						'div'=>Yii::t('global','Your config has been successfully saved.')
					));
					exit;
				}
			}
		}
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
		$model=ModContact::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
