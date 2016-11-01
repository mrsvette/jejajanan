<?php
Yii::import('zii.widgets.CPortlet');

class VendorMainMenu extends CPortlet{
	public $visible=true;
	
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
		$items = array(
			array('label'=>'<span class="fa fa-lock"></span> <span class="nav_title">Login</span>', 'url'=>array('/vendor/default/login'),'visible'=>Yii::app()->user->isGuest),
			array('label'=>'<span class="fa fa-dashboard"></span> <span class="nav_title">Dashboard</span>', 'url'=>array('/vendor'),'visible'=>!Yii::app()->user->isGuest),
			array('label'=>'<span class="fa fa-tags"></span> <span class="nav_title">'.Yii::t('menu','Catalog').'</span>', 'url'=>'#', 
				'items'=>array(
					array('label'=>'<span class="side_icon ion-ios7-folder-outline"></span>'.Yii::t('menu','Categories'),'url'=>array('/vendor/vCategory')),
					array('label'=>'<span class="side_icon ion-ios7-folder-outline"></span>'.Yii::t('menu','Product'),'url'=>array('/vendor/vProduct')),
					array('label'=>'<span class="side_icon ion-ios7-folder-outline"></span>'.Yii::t('menu','Manufacturers'),'url'=>array('/vendor/vManufacture')),
					array('label'=>'<span class="side_icon ion-ios7-folder-outline"></span>'.Yii::t('menu','Reviews'),'url'=>array('/vendor/vReview')),
				),'itemOptions'=>array('class'=>'nav-parent'),'linkOptions'=>array('class'=>'dropdown-toggle', 'data-toggle'=>'dropdown'),'visible'=>!Yii::app()->user->isGuest),
			array('label'=>'<span class="fa fa-puzzle-piece"></span> <span class="nav_title">'.Yii::t('menu','Extensions').'</span><b class="arrow icon-angle-down"></b>', 'url'=>'#', 
				'items'=>array(
					array('label'=>'<span class="side_icon ion-ios7-folder-outline"></span>'.Yii::t('menu','Modules'),'url'=>array('/vendor/pages/admin')),
					array('label'=>'<span class="side_icon ion-ios7-folder-outline"></span>'.Yii::t('menu','Shipping'),'url'=>array('/vendor/pages/create')),
					array('label'=>'<span class="side_icon ion-ios7-folder-outline"></span>'.Yii::t('menu','Payments'),'url'=>array('/vendor/pages/create')),
				),'itemOptions'=>array('class'=>'nav-parent'),'linkOptions'=>array('class'=>'dropdown-toggle', 'data-toggle'=>'dropdown'),'visible'=>!Yii::app()->user->isGuest),
			array('label'=>'<span class="fa fa-money"></span> <span class="nav_title">'.Yii::t('menu','Sales').'</span><b class="arrow icon-angle-down"></b>', 'url'=>'#', 
				'items'=>array(
					array('label'=>'<span class="side_icon ion-ios7-folder-outline"></span>'.Yii::t('menu','Orders'),'url'=>array('/vendor/vOrder')),
					array('label'=>'<span class="side_icon ion-ios7-folder-outline"></span>'.Yii::t('menu','Invoices'),'url'=>array('/vendor/vInvoice')),
					array('label'=>'<span class="side_icon ion-ios7-folder-outline"></span>'.Yii::t('menu','Customers'),'url'=>array('/vendor/vCustomer')),
				),'itemOptions'=>array('class'=>'nav-parent'),'linkOptions'=>array('class'=>'dropdown-toggle', 'data-toggle'=>'dropdown'),'visible'=>!Yii::app()->user->isGuest),
			/*array('label'=>'<span class="ion-ios7-pie"></span> <span class="nav_title">'.Yii::t('menu','Marketing').'</span><b class="arrow icon-angle-down"></b>', 'url'=>'#', 
				'items'=>array(
					array('label'=>'<span class="side_icon ion-ios7-folder-outline"></span>'.Yii::t('menu','Marketing'),'url'=>array('/vendor/pages/admin')),
					array('label'=>'<span class="side_icon ion-ios7-folder-outline"></span>'.Yii::t('menu','Affiliates'),'url'=>array('/vendor/pages/create')),
					array('label'=>'<span class="side_icon ion-ios7-folder-outline"></span>'.Yii::t('menu','Kupon'),'url'=>array('/vendor/pages/create')),
					array('label'=>'<span class="side_icon ion-ios7-folder-outline"></span>'.Yii::t('menu','Mail'),'url'=>array('/vendor/pages/create')),
				),'itemOptions'=>array('class'=>'nav-parent'),'linkOptions'=>array('class'=>'dropdown-toggle', 'data-toggle'=>'dropdown'),'visible'=>!Yii::app()->user->isGuest),*/
			array('label'=>'<span class="fa fa-cog"></span> <span class="nav_title">'.Yii::t('menu','System').'</span><b class="arrow icon-angle-down"></b>', 'url'=>'#', 
				'items'=>array(
					array('label'=>'<span class="side_icon ion-ios7-folder-outline"></span>'.Yii::t('menu','Setting'),'url'=>array('/vendor/pages/admin')),
					array('label'=>'<span class="side_icon ion-ios7-folder-outline"></span>'.Yii::t('menu','Store Location'),'url'=>array('/vendor/pages/create')),
					array('label'=>'<span class="side_icon ion-ios7-folder-outline"></span>'.Yii::t('menu','Language'),'url'=>array('/vendor/pages/create')),
					array('label'=>'<span class="side_icon ion-ios7-folder-outline"></span>'.Yii::t('menu','Currencies'),'url'=>array('/vendor/pages/create')),
					array('label'=>'<span class="side_icon ion-ios7-folder-outline"></span>'.Yii::t('menu','Zone'),'url'=>array('/vendor/pages/create')),
					array('label'=>'<span class="side_icon ion-ios7-folder-outline"></span>'.Yii::t('menu','Geo Zone'),'url'=>array('/vendor/pages/create')),
					array('label'=>'<span class="side_icon ion-ios7-folder-outline"></span>'.Yii::t('menu','Taxes'),'url'=>array('/vendor/pages/create')),
					array('label'=>'<span class="side_icon ion-ios7-folder-outline"></span>'.Yii::t('menu','Length Class'),'url'=>array('/vendor/pages/create')),
					array('label'=>'<span class="side_icon ion-ios7-folder-outline"></span>'.Yii::t('menu','Weight Class'),'url'=>array('/vendor/pages/create')),
				),'itemOptions'=>array('class'=>'nav-parent'),'linkOptions'=>array('class'=>'dropdown-toggle', 'data-toggle'=>'dropdown'),'visible'=>!Yii::app()->user->isGuest),
			/*array('label'=>'<span class="fa fa-wrench"></span> <span class="nav_title">'.Yii::t('menu','Tools').'</span><b class="arrow icon-angle-down"></b>', 'url'=>'#', 
				'items'=>array(
					array('label'=>'<span class="side_icon ion-ios7-folder-outline"></span>'.Yii::t('menu','Backup/Restore'),'url'=>array('/vendor/pages/admin')),
				),'itemOptions'=>array('class'=>'nav-parent'),'linkOptions'=>array('class'=>'dropdown-toggle', 'data-toggle'=>'dropdown'),'visible'=>!Yii::app()->user->isGuest),*/
			array('label'=>'<span class="fa fa-bar-chart-o"></span> <span class="nav_title">'.Yii::t('menu','Reports').'</span><b class="arrow icon-angle-down"></b>', 'url'=>'#', 
				'items'=>array(
					array('label'=>'<span class="side_icon ion-ios7-folder-outline"></span>'.Yii::t('menu','Modules'),'url'=>array('/vendor/pages/admin')),
					array('label'=>'<span class="side_icon ion-ios7-folder-outline"></span>'.Yii::t('menu','Shipping'),'url'=>array('/vendor/pages/create')),
					array('label'=>'<span class="side_icon ion-ios7-folder-outline"></span>'.Yii::t('menu','Payments'),'url'=>array('/vendor/pages/create')),
				),'itemOptions'=>array('class'=>'nav-parent'),'linkOptions'=>array('class'=>'dropdown-toggle', 'data-toggle'=>'dropdown'),'visible'=>!Yii::app()->user->isGuest),
			);

		/*$custom_menu = self::getModulesMenu('custom');
		if(is_array($custom_menu) && count($custom_menu)>0){
			foreach($custom_menu as $i=>$custom){
				array_push($items,$custom);
			}
		}*/

		$this->render('_vendor_main_menu',array('items'=>$items,'Rbac'=>$Rbac));
	}

	public function getModulesMenu($group='appearance')
	{
		$items = array();
		switch ($group){
			case 'appearance': //default items for appearance
				$items = array(
					array('label'=>'<span class="side_icon ion-ios7-folder-outline"></span> Menu','url'=>array('/vendor/menu/view')),
					array('label'=>'<span class="side_icon ion-ios7-folder-outline"></span> '.Yii::t('menu','Themes'), 'url'=>array('/vendor/themes/view')),
				);
				break;
			case 'manage': //default items for appearance
				$items = array(
					array('label'=>'<span class="side_icon ion-ios7-folder-outline"></span> Users', 'url'=>array('/vendor/users/view')),
					array('label'=>'<span class="side_icon ion-ios7-folder-outline"></span> Parameter', 'url'=>array('/vendor/params/view')),
					array('label'=>'<span class="side_icon ion-ios7-folder-outline"></span> '.Yii::t('menu','Extensions'), 'url'=>array('/vendor/extensions/view')),
				);
				break;
		}
		$criteria = new CDbCriteria;
		$criteria->compare('status','installed');
		$criteria->order='name ASC';
		$models = Extension::model()->findAll($criteria);
		
		foreach($models as $model){
			$mod_class = ucfirst($model->name).'Module';
			Yii::import('application.modules.'.$model->name.'.'.$mod_class);
			if(method_exists($mod_class,'fetchNavigation')){
				$nav = $mod_class::fetchNavigation();
				if(!empty($nav[$group])){
					foreach($nav[$group] as $i=>$item){
						array_push($items, $item);
					}
				}
			}
		}
		return $items;
	}
}

?>
