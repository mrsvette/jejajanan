<?php
Yii::import('zii.widgets.CPortlet');

class ProductCategoryWidget extends CPortlet{
	public $visible = true;
	public $use_thumb = true;
	public $pageSize = 4;
	public $pagination = true;
	public $show_pagination = false;
	public $url_query;
	public $level = 1; //0, 1, dst
	
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
		$criteria->order = 'id DESC';
		$criteria->compare('level',$this->level);

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
		
		$params = array(
				'criteria'=>$criteria,
				'pagination'=>array(
					'pageSize'=>$this->pageSize,
					'currentPage'=>($items['ModProductCategory_page']>0)? $items['ModProductCategory_page'] : null,
				)
			);
		
		if(!$this->pagination){
			$params = array(
				'criteria'=>$criteria,
				'pagination'=>false
			);
		}
		$dataProvider = new CActiveDataProvider('ModProductCategory', $params);
		
		$this->render(
			'_product_category',
			array(
				'dataProvider' => $dataProvider,
			)
		);
	}
}

?>
