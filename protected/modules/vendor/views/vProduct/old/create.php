<?php $this->pageSection = 'upload product'; ?>
<?php
$this->breadcrumbs = array(
	ucfirst(Yii::app()->controller->module->id) => array('/'.Yii::app()->controller->module->id.'/'),
	Yii::t('VendorModule.vendor','Upload Product'),
);
?>

<div class="rs_user_profile_tab">
	<div class="tab-content">
		<div class="tab-pane active" id="profile">
			<div class="rs_user_dashboard_tab_heading">
				<h4><?php echo Yii::t('VendorModule.vendor','Upload Product');?></h4>
			</div>

			<div class="rs_user_dashboard_tab_info">
				<ul class="nav nav-tabs">
					<li class="active">
						<a data-toggle="tab" href="#general">
							<strong><i class="fa fa-briefcase"></i> <?php echo Yii::t('VendorModule.vendor','Product');?></strong>
						</a>
					</li>
					<li class="">
						<a data-toggle="tab" href="#product">
							<strong><i class="fa fa-list-ul"></i> <?php echo Yii::t('global','List').' '.Yii::t('VendorModule.vendor','Product');?></strong>
						</a>
					</li>
					<li class="">
						<a data-toggle="tab" href="#category">
							<strong><i class="fa fa-list-ul"></i> <?php echo Yii::t('global','List').' '.Yii::t('VendorModule.vendor','Category');?></strong>
						</a>
					</li>
					<li class="">
						<a data-toggle="tab" href="#new-category">
							<strong><i class="fa fa-wrench"></i> <?php echo Yii::t('global','Manage').' '.Yii::t('VendorModule.vendor','Category');?></strong>
						</a>
					</li>
				</ul>
				<div class="tab-content">
					<div id="general" class="tab-pane active">
						<div class="mt20 clearfix"></div>
						<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>
					</div>
					<div id="product" class="tab-pane">
						<div class="clearfix"></div>
						<?php echo $this->renderPartial('_product',array('dataProvider'=>$productProvider)); ?>
					</div>
					<div id="category" class="tab-pane">
						<div class="clearfix"></div>
						<?php echo $this->renderPartial('_category',array('dataProvider'=>$dataProvider)); ?>
					</div>
					<div id="new-category" class="tab-pane">
						<div class="mt20 clearfix"></div>
						<?php echo $this->renderPartial('_form_category',array('model'=>$model2)); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
