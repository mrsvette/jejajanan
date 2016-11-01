<?php
Yii::import('zii.widgets.CPortlet');

class CategoryMenu extends CPortlet{
	public $visible = true;
	public $linkOptions = array('class'=>'text-white');
	public $htmlOptions = array();
	
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
		Yii::import('application.modules.ecommerce.models.ModProductCategory');

		$criteria = new CDbCriteria;
		$criteria->compare('t.level',1);
		$criteria->order='t.id ASC';
		
		$models = ModProductCategory::model()->findAll($criteria);
		
		$items = array();
		foreach($models as $model){
			$url = array('/product/view','kslug'=>$model->slug);
			if(isset($model->parents)){
				$parents = CJSON::decode($model->parents,true);
				$parent = ModProductCategory::model()->findByPk($parents[0]);
				if($parent instanceof ModProductCategory){
					$url = array('/product/'.$parent->slug.'/'.$model->slug);
				}
			}
			$items[] = array(
					'label'=>'<i class="fa fa-angle-right"></i> '.$model->title, 
					'url'=>$url, 
					'linkOptions'=>$this->linkOptions
				);
		}
		
		$this->render('_category_menu',array('items'=>$items));
	}
}

?>
