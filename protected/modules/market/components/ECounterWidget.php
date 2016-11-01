<?php
Yii::import('zii.widgets.CPortlet');

class ECounterWidget extends CPortlet{
	public $visible=true;
	
	public function init()
    {
        if($this->visible)
        {
			if($this->controller->module->id!='market'){
 			$this->controller->module->setImport(array(
				'market.models.*',
			));
			}
        }
    }
 
    public function run()
    {
        if($this->visible)
        {
			if(Extension::getIsInstalled(array('id'=>'market')))
            	$this->renderContent();
        }
    }
	
	protected function renderContent()
	{
		$this->render('_ecounter');
	}
}

?>
