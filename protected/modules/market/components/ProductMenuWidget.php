<?php
Yii::import('zii.widgets.CPortlet');

class ProductMenuWidget extends CPortlet{
	public $visible = true;
	public $category;
	public $url_query;
	public $type = 'all';
	public $pageSize = 3;
	
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
			if(Extension::getIsInstalled(array('id'=>'ecommerce')))
            	$this->renderContent();
        }
    }
	
	protected function renderContent()
	{
		$linkOptions = array();
		$items = ModProductCategory::getCmenuitems($linkOptions,'level');
		
		$this->render(
			'_product_menu',
			array(
				'items' => $items,
			)
		);
	}
}

?>
