<?php

class PostsController extends EController
{
	public $layout='column2';

	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_model;

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
				'actions'=>array('suggestTags'),
				'users'=>array('@'),
			),
			array('allow',
				'actions'=>array('create','getSlug'),
				'expression'=>'Rbac::ruleAccess(\'create_p\')',
			),
			array('allow',
				'actions'=>array('index','view','admin'),
				'expression'=>'Rbac::ruleAccess(\'read_p\')',
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

	/**
	 * Displays a particular model.
	 */
	public function actionView()
	{
		$this->forward('update',array('id'=>$_GET['id']));
		$post=$this->loadModel();
		$comment=$this->newComment($post);

		$this->render('view',array(
			'model'=>$post,
			'comment'=>$comment,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model = new Post;
		//default value
		$model->status = 1;
		$model->allow_comment = 0;
		$model->post_category = 1;

		$model2 = new PostContent;
		$model4 = new PostImages('create');

		if(isset($_POST['Post']))
		{
			$model->attributes = $_POST['Post'];
			$model->post_type = 0; //0=post,1=page
			if($model->save()){
				$model2->attributes = $_POST['PostContent'];
				$success = 0;
				if(is_array($model2->title)){
					foreach($model2->title as $lang=>$title){
						$model3 = new PostContent;
						$model3->post_id = $model->id;
						$model3->language = $lang;
						$model3->title = $model2->title[$lang];
						if(empty($model2->slug[$lang]))
							$model3->slug = $model->createSlug($model3->title);
						else{
							$model3->slug = $model2->slug[$lang];
							//check existance
							$exist = $model->getModelBySlug($model3->slug);
							if($exist instanceof Post)
								$model3->slug = $model3->slug.'-'.$lang;
						}
						$model3->content = $model2->content[$lang];
						$model3->meta_keywords = $model2->meta_keywords[$lang];
						$model3->meta_description = $model2->meta_description[$lang];
						if($model3->save())
							$success = $success + 1;
					}
				}
				if($success<=0)
					$model->delete();
				else{
					//upload image preview
					$file = CUploadedFile::getInstance($model4,'image');
					if(!empty($file)){
						$model4->attributes = $_POST['PostImages'];
						$model4->post_id = $model->id;
						$model4->image = $file->name;
						$model4->src = 'uploads/images/post/';
						$model4->date_entry = date(c);
						$model4->user_entry = Yii::app()->user->id;
						if($model4->save()){
							$img = $this->upload_image($model,$model4,$file);
							if(!$img)
								$model4->delete();
						}
					}
				}
				$this->redirect(array('admin'));
			}
		}
		
		/* for insert image */
		if(isset($_GET['image'])){
			$model->content = $model->content.'<img src="'.Yii::app()->request->baseUrl.'/upload/'.$_GET['image'].''.'">';
		}
		$this->render('create',array(
			'model'=>$model,
			'model2'=>$model2,
			'model3'=>$model4
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionUpdate()
	{
		$model=$this->loadModel();
		$model2=$model->content_rel;
		$model4 = $model->image_rel;
		if(!$model4 instanceof PostImages)
			$model4 = new PostImages('create');
		else
			$old_image = $model4->image;

		if(isset($_POST['Post']))
		{
			$model->attributes=$_POST['Post'];
			if($model->save()){
				$model2->attributes=$_POST['PostContent'];
				if(is_array($model2->title)){
					foreach($model2->title as $lang=>$title){
						$cont=$model->getContent($lang);
						if($cont->id>0)
							$model3=$model->getContent($lang);
						else{
							$model3=new PostContent;
							$model3->post_id=$model->id;
							$model3->language=$lang;
						}
						$model3->title=$model2->title[$lang];
						if(!empty($model2->title[$lang])){
							if(empty($model2->slug[$lang]))
								$model3->slug=$model->createSlug($model3->title);
							else
								$model3->slug=$model2->slug[$lang];
						}
						$model3->content=$model2->content[$lang];
						$model3->meta_keywords=$model2->meta_keywords[$lang];
						$model3->meta_description=$model2->meta_description[$lang];
						if(!empty($model3->title))
							$model3->save();
					}
				}
				//upload image preview
				$file = CUploadedFile::getInstance($model4,'image');
				if(!empty($file)){
					$model4->attributes = $_POST['PostImages'];
					$model4->post_id = $model->id;
					$model4->image = $file->name;
					$model4->src = 'uploads/images/post/';
					$model4->date_entry = date(c);
					$model4->user_entry = Yii::app()->user->id;
					if($model4->save()){
						$img = $this->upload_image($model,$model4,$file);
						if(!$img)
							$model4->delete();
						else{
							//delete the old image
							$model4 = $model->image_rel;
							if($model4->image != $old_image){
								if(file_exists($model4->src.$old_image))
									unlink($model4->src.$old_image);
								if(file_exists($model4->thumb.$old_image))
									unlink($model4->thumb.$old_image);
							}
						}
					}
				}

				$this->redirect(array('admin'));
			}
		}

		$this->render('update',array(
			'model'=>$model,
			'model2'=>$model2,
			'model3'=>$model4
		));
	}

	private function upload_image($post,$image,$file)
	{
		//default path uploads/images/post
		$path = 'uploads/images/post/';
		//default path uploads/images/post/_thumbs
		$path_thumbs = $path.'_thumbs/';
		$basePath = Yii::getPathOfAlias('webroot').'/';
		if(!is_dir($basePath.$path))
			Yii::app()->file->createDir($permissions=0755, $path);
		if(!is_dir($basePath.$path_thumbs))
			Yii::app()->file->createDir($permissions=0755, $path_thumbs);

		$extension = pathinfo($file->name, PATHINFO_EXTENSION);
		list($CurWidth,$CurHeight) = getimagesize($file->tempName);
		$title = $post->content_rel->title;
		if(is_array($title)){
			$title = array_values($title);
			$fname = Tools::slug($title[0]).'-'.time().'.'.$extension;
		}else
			$fname = time().'-'.$file->name;
					
		if($file->saveAs($path.$fname)){ //upload image
			//resize image to ideal size
			$ideal_width = 700;
			$ideal_height = 400;
			if(($CurWidth!=$ideal_width) || ($CurHeight!=$ideal_height)){
				$thumb2 = Yii::app()->phpThumb->create($path.$fname);
								
				if($CurWidth<=$CurHeight) //landscape picture
					$percentage = ($ideal_width/$CurWidth)*100;
				else //portrait
					$percentage = ($ideal_height/$CurHeight)*100;

				$thumb2->resizePercent($percentage);
				$thumb2->save($path.$fname);
				//force resize thumb
				$thumb3 = Yii::app()->phpThumb->create($path.$fname);
				$thumb3->adaptiveResize($ideal_width,$ideal_height);
				$thumb3->save($path.$fname);
			}
			//create thumb
			$thumb = Yii::app()->phpThumb->create($path.$fname);
			$thumb->adaptiveResize(350,200);
			$thumb->save($path_thumbs.$fname);
			//save to table
			$image->src = $path;
			$image->image = $fname;
			$image->thumb = $path_thumbs;
			if($image->update(array('src','image','thumb')))
				return true;
		}
		return false;
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 */
	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$model = $this->loadModel();
			$del1 = PostContent::model()->deleteAllByAttributes(array('post_id'=>$model->id));
			$image = $model->image_rel;
			if(!empty($image->image)){
				if(file_exists($image->src.$image->image))
					unlink($image->src.$image->image);
				if(file_exists($image->thumb.$image->image))
					unlink($image->thumb.$image->image);
			}
			$del2 = $model->delete();
			$del3 = $image->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(array('index'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$criteria=new CDbCriteria(array(
			'condition'=>'status='.Post::STATUS_PUBLISHED,
			'order'=>'update_time DESC',
			'with'=>'commentCount',
		));
		if(isset($_GET['tag']))
			$criteria->addSearchCondition('tags',$_GET['tag']);

		$dataProvider=new CActiveDataProvider('Post', array(
			'pagination'=>array(
				'pageSize'=>Yii::app()->params['postsPerPage'],
			),
			'criteria'=>$criteria,
		));

		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Post('search');
		$model->post_type=0; //post type : pages
		if(isset($_GET['Post']))
			$model->attributes=$_GET['Post'];
		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Suggests tags based on the current user input.
	 * This is called via AJAX when the user is entering the tags input.
	 */
	public function actionSuggestTags()
	{
		if(isset($_GET['q']) && ($keyword=trim($_GET['q']))!=='')
		{
			$tags=Tag::model()->suggestTags($keyword);
			if($tags!==array())
				echo implode("\n",$tags);
		}
	}
	
	public function actionGetSlug()
	{
		if(Yii::app()->request->isPostRequest)
		{
			echo CJSON::encode(array('status'=>'success','value'=>Post::createSlug($_POST['title'])));
			exit;
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 */
	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
			{
				if(Yii::app()->user->isGuest)
					$condition='status='.Post::STATUS_PUBLISHED.' OR status='.Post::STATUS_ARCHIVED;
				else
					$condition='';
				$this->_model=Post::model()->findByPk($_GET['id'], $condition);
			}
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}

	/**
	 * Creates a new comment.
	 * This method attempts to create a new comment based on the user input.
	 * If the comment is successfully created, the browser will be redirected
	 * to show the created comment.
	 * @param Post the post that the new comment belongs to
	 * @return Comment the comment instance
	 */
	protected function newComment($post)
	{
		$comment=new Comment;
		if(isset($_POST['ajax']) && $_POST['ajax']==='comment-form')
		{
			echo CActiveForm::validate($comment);
			Yii::app()->end();
		}
		if(isset($_POST['Comment']))
		{
			$comment->attributes=$_POST['Comment'];
			if($post->addComment($comment))
			{
				if($comment->status==Comment::STATUS_PENDING)
					Yii::app()->user->setFlash('commentSubmitted','Thank you for your comment. Your comment will be posted once it is approved.');
				$this->refresh();
			}
		}
		return $comment;
	}
}
