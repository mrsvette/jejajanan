<?php

class VOrderController extends DController
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
				'actions'=>array('index'),
				'users'=>array('@'),
			),
			array('allow',
				'actions'=>array('create','activate'),
				'users'=>array('@'),
			),
			array('allow',
				'actions'=>array('update','manage','suspend','unsuspend'),
				'users'=>array('@'),
			),
			array('allow',
				'actions'=>array('delete'),
				'users'=>array('@'),
			),
			array('allow',
				'actions'=>array('getListProductItems'),
				'users'=>array('*'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

		/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();
		
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('view'));
	}

	/**
	 * Manages all models.
	 */
	public function actionIndex()
	{
		$criteria = new CDbCriteria;
		if(isset($_GET['status']))
			$criteria->compare('t.status',$_GET['status']);
		$criteria->order='t.id DESC';
		if(Yii::app()->request->isAjaxRequest && isset($_GET['VCustomerOrder'])){
			$rel_count = 0;
			foreach($_GET['VCustomerOrder'] as $attr1=>$val1){
				if(!empty($val1)){
					$client_attr = array(
						'company_search'=>array('company'),
						'client_search'=>array('first_name','last_name')
					);
					$product_attr = array(
						'product_search'=>array('title'),
					);
					if(in_array($attr1,array_keys($client_attr))){
						$criteria->compare('client_rel.'.$client_attr[$attr1][0],$val1,true);
						if(count($client_attr[$attr1])>1)
							$criteria->compare('client_rel.'.$client_attr[$attr1][1],$val1,true,'OR');
						$rel_count = $rel_count+1;
					}elseif(in_array($attr1,array_keys($product_attr))){
						$criteria->compare('product_rel.'.$product_attr[$attr1][0],$val1,true);
						$rel_count = $rel_count+1;
					}else{
						$criteria->compare('t.'.$attr1,$val1,true);
					}
				}
			}
			if($rel_count>0){
				$criteria->with=array('client_rel','product_rel');
				$criteria->together=true;
			}
		}

		$dataProvider=new CActiveDataProvider('VCustomerOrder',array('criteria'=>$criteria));
		if(Yii::app()->request->isAjaxRequest && isset($_GET['VCustomerOrder'])){
			$dataProvider->model->attributes = $_GET['VCustomerOrder'];
		}

		$this->render('index',array(
			'dataProvider'=>$dataProvider,
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
			$model = new VCustomerOrder;
			$model->attributes = $_POST['VCustomerOrder'];
			$model->vendor_id = Yii::app()->user->profile->id;
			$model->group_id = time();
			$product = VProduct::model()->findByPk($model->product_id);
			$model->price = $product->price;
			$model->title = ucfirst(strtolower($product->description_one_rel->name));
			$model->status = VCustomerOrder::PENDING_SETUP;
			$model->date_entry=date(c);
			if($model->save()){
				echo CJSON::encode(array(
					'status'=>'success',
					'div'=>'Data berhasil disimpan',
				));
			}else{
				echo CJSON::encode(array(
					'status'=>'failed',
					'div'=>$this->renderPartial('_form_order',array('model'=>$model),true,true),
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
			$model->attributes = $_POST['VCustomerOrder'];
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
		$model = $this->loadModel($id);

		$criteria = new CDbCriteria;
		$criteria->compare('item_rel.rel_id',$id);
		if(isset($_GET['status']))
			$criteria->compare('t.status',$_GET['status']);
		$criteria->order = 't.id ASC';
		$criteria->with = array('item_rel');
		$criteria->together = true;

		$dataProvider=new CActiveDataProvider('VInvoice',array('criteria'=>$criteria));

		$this->render('manage',array(
			'model'=>$model,
			'dataProvider'=>$dataProvider,
		));
	}

	public function actionActivate($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			Yii::app()->clientScript->scriptMap['jquery.js'] = false;
			$model = $this->loadModel($id);
			if($model->activate()){
				echo CJSON::encode(array(
					'status'=>'success',
					'div'=>'Data berhasil disimpan',
				));
			}
			exit;
		}
	}

	public function actionSuspend($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			Yii::app()->clientScript->scriptMap['jquery.js'] = false;
			$model = $this->loadModel($id);
			$model->status = VCustomerOrder::SUSPENDED;
			$model->suspended_at = date(c);
			$model->date_update = date(c);
			$model->user_update = Yii::app()->user->id;
			if($model->save()){
				echo CJSON::encode(array(
					'status'=>'success',
					'div'=>'Data berhasil disimpan',
				));
			}
			exit;
		}
	}

	public function actionUnsuspend($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			Yii::app()->clientScript->scriptMap['jquery.js'] = false;
			$model = $this->loadModel($id);
			$model->status = VCustomerOrder::PENDING_SETUP;
			$model->unsuspended_at = date(c);
			$model->date_update = date(c);
			$model->user_update = Yii::app()->user->id;
			if($model->save()){
				echo CJSON::encode(array(
					'status'=>'success',
					'div'=>'Data berhasil disimpan',
				));
			}
			exit;
		}
	}

	public function actionGetListProductItems()
	{
		if(Yii::app()->request->isPostRequest){
			$model = new VCustomerOrder;
			$items = VProduct::items($_POST['product_category_id']);
			echo CJSON::encode(array(
					'status'=>'success',
					'div'=>CHtml::activeDropDownList($model,'product_id',$items,array('class'=>'form-control')),
				));
			exit;
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
		$model = VCustomerOrder::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
