<?php
Yii::import('zii.widgets.CPortlet');

class BannerWidget extends CPortlet{

	public $visible = true;
	public $id;
	
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
            $this->renderContent();
        }
    }
	
	protected function renderContent()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('slug',$this->id);
		$criteria->compare('status',1);
	
		$model = ModBanner::model()->find($criteria);
		if(!$model instanceof ModBanner)
			return false;
		//check date
		if(!empty($model->start_date)){
			if(time()<strtotime($model->start_date))
				return false;
			if(!empty($model->end_date)){
				if(time()>strtotime($model->end_date))
					return false;
			}
		}	
		if(!empty($model->end_date)){
			if(time()>strtotime($model->end_date))
				return false;
			if(!empty($model->start_date)){
				if(time()<strtotime($model->start_date))
					return false;
			}
		}		
	
		$this->render(
			'_banner',
			array(
				'model' => $model,
			)
		);
	}
}

?>
