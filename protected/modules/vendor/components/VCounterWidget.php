<?php
Yii::import('zii.widgets.CPortlet');

class VCounterWidget extends CPortlet{
	public $visible=true;
	
	public function init()
    {
        if($this->visible)
        {
			if($this->controller->module->id!='vendor'){
 			$this->controller->module->setImport(array(
				'vendor.models.*',
			));
			}
        }
    }
 
    public function run()
    {
        if($this->visible)
        {
			if(Extension::getIsInstalled(array('id'=>'vendor')))
            	$this->renderContent();
        }
    }
	
	protected function renderContent()
	{
		$this->render('_vcounter');
	}
}

?>
