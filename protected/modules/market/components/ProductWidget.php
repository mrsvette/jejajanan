<?php
Yii::import('zii.widgets.CPortlet');

class ProductWidget extends CPortlet{
	public $visible = true;
	public $category;
	public $use_thumb = true;
	public $pageSize = 3;
	public $pagination = true;
	public $show_pagination = false;
	public $url_query;
	public $type = 'all';
	public $order_by = 'id';
	
	public function init()
    {
        if($this->visible)
        {
			/*if($this->controller->module->id!='ecommerce'){
	 			$this->controller->module->setImport(array(
					'ecommerce.models.*',
				));
			}*/
        }
    }
 
    public function run()
    {
        if($this->visible)
        {
			if(Extension::getIsInstalled(array('id'=>'ecommerce')))
            	$this->renderContent();
        }
    }
	
	protected function renderContent()
	{
		$criteria = new CDbCriteria;
		if(isset($this->category)){
			$criteria->compare('category_rel.slug',$this->category);
			$criteria->with = array('category_rel','payment_rel');
		}

		$items = array();
		if(isset($this->url_query)){
			$pairs = explode('&',$this->url_query);
			foreach ($pairs as $pair) {
				$keyVal = explode('=',$pair);
				$key = &$keyVal[0];
				$val = urlencode($keyVal[1]);
				$items[$key] = $val;
			}
		}
		//order
		switch ($this->order_by){
			case 'id':
				$criteria->order ='t.id DESC';
				break;
			case 'terbaru':
				$criteria->order = 't.id DESC';
				break;
			case 'terpopuler':
				$criteria->order = 't.viewed DESC';
				break;
			case 'termurah':
				$criteria->order = 'payment_rel.once_price ASC';
				break;
			case 'termahal':
				$criteria->order = 'payment_rel.once_price DESC';
				break;
		}	
	
		$params = array(
				'criteria'=>$criteria,
				'pagination'=>array(
					'pageSize'=>$this->pageSize,
					'currentPage'=>($items['ModProduct_page']>0)? $items['ModProduct_page'] : null,
				)
			);
		
		if(!$this->pagination){
			$params = array(
				'criteria'=>$criteria,
				'pagination'=>false
			);
		}
		$dataProvider = new CActiveDataProvider('ModProduct', $params);
		
		$this->render(
			'_product',
			array(
				'dataProvider' => $dataProvider,
			)
		);
	}
}

?>
