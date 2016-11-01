<?php
Yii::import('zii.widgets.CPortlet');

class TestimonialWidget extends CPortlet{

	public $visible = true;
	public $class_name = 'col-md-4 col-lg-4';
	public $use_thumb = true;
	public $pageSize = 3;
	public $pagination = true;
	public $show_pagination = false;
	public $url_query;
	
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
		Yii::app()->clientscript->scriptMap['jquery.js'] = false;
		$criteria = new CDbCriteria;
		$criteria->order = 'id DESC';

		
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
					'currentPage'=>($items['ModTestimonial_page']>0)? $items['ModTestimonial_page']-1 : null,
				)
			);
		if(!$this->pagination){
			$criteria->limit = 18;
			$params = array(
				'criteria'=>$criteria,
				'pagination'=>false
			);
		}
		
		$dataProvider = new CActiveDataProvider('ModTestimonial', $params);
		
		$this->render(
			'_testimonial',
			array(
				'dataProvider' => $dataProvider,
			)
		);
	}
}

?>
