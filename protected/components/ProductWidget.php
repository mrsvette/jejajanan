<?php
Yii::import('zii.widgets.CPortlet');

class ProductWidget extends CPortlet{
	public $visible = true;
	public $type = 'latest';
	public $pagination = true;
	public $pageSize = 10;
	
	public function init()
	{
		if($this->visible)
		{

		}
	}
 
	public function run()
	{
		if($this->visible)
		{
			Yii::import('application.modules.vendor.models.*');
	 		$this->renderContent();
		}
	}
	
	protected function renderContent()
	{
		$criteria = new CDbCriteria;
		switch ($type) {
			case 'latest':
				$criteria->order = 'id DESC';
				break;
			default:
				$criteria->order = 'id DESC';
		}

		$params = array('criteria'=>$criteria);
		if($this->pagination){
			$params['pagination'] = array('pageSize'=>$this->pageSize);
		}

		$dataProvider = new CActiveDataProvider('VProduct', $params);

		$this->render('_product',array('dataProvider'=>$dataProvider));
	}
}

?>
