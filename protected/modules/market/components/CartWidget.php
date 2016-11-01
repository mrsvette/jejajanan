<?php
Yii::import('zii.widgets.CPortlet');

class CartWidget extends CPortlet{
	public $visible = true;
	public $show_pagination = false;
	public $pageSize = 10;
	public $position = 'top'; //top, right
	
	public function init()
	{
		if($this->visible)
        {
			//ecommerce module has statekeyprefix, so on client area need 
			//that prefix in order to retrieve getState
			Yii::app()->user->setStateKeyPrefix('jagungbakar');
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
		Yii::import('application.modules.ecommerce.*');
		$carts = array();
		
		if(Yii::app()->user->hasState('carts'))
			$carts = Yii::app()->user->getState('carts');

		$rawData = array_values($carts);
		$params = array(
				'pagination'=>array(
					'pageSize'=>$this->pageSize,
					//'currentPage'=>($items['ModPortfolioImages_page']>0)? $items['ModPortfolioImages_page'] : null,
				),
				'keyField'=>false,
			);

		if(!$this->show_pagination){
			$params = array(
				'pagination'=>false,
				'keyField'=>false,
			);
		}

		$dataProvider = new CArrayDataProvider($rawData, $params);
		
		$this->render('_cart',array('carts'=>$carts,'dataProvider'=>$dataProvider));
	}
}
?>
