<?php $this->pageSection = $model->title; ?>
<?php
$this->breadcrumbs = array(
	ucfirst(Yii::app()->controller->module->id) => array('/'.Yii::app()->controller->module->id.'/'),
	Yii::t('VendorModule.vendor','Product'),
	$model->title
);
?>

<div class="rs_user_profile_tab">
	<div class="tab-content">
		<div class="tab-pane active" id="profile">
			<div class="rs_user_dashboard_tab_heading">
				<h4><?php echo Yii::t('global','Update').' - '.$model->title;?></h4>
			</div>

			<div class="rs_user_dashboard_tab_info">
				<ul class="nav nav-tabs">
					<li class="active">
						<a data-toggle="tab" href="#general">
							<strong><i class="fa fa-briefcase"></i> <?php echo Yii::t('VendorModule.product','General');?></strong>
						</a>
					</li>
					<li>
						<a data-toggle="tab" href="#data">
							<strong><i class="fa fa-briefcase"></i> <?php echo Yii::t('VendorModule.product','Data');?></strong>
						</a>
					</li>
					<li>
						<a data-toggle="tab" href="#links">
							<strong><i class="fa fa-briefcase"></i> <?php echo Yii::t('VendorModule.product','Links');?></strong>
						</a>
					</li>
					<li class="">
						<a data-toggle="tab" href="#image">
							<strong><i class="fa fa-picture-o"></i> <?php echo Yii::t('VendorModule.product','Images');?></strong>
						</a>
					</li>
					<li class="">
						<a data-toggle="tab" href="#discount">
							<strong><i class="fa fa-money"></i> <?php echo Yii::t('VendorModule.product','Discount');?></strong>
						</a>
					</li>
				</ul>
				<div class="tab-content">
					<div id="general" class="tab-pane active">
						<div class="mt20"></div>
						<?php echo $this->renderPartial('_form_manage',array('model'=>$model,'model2'=>$model2));?>
					</div>
					<div id="data" class="tab-pane">
						<?php echo $this->renderPartial('_data',array('model'=>$model));?>
					</div>
					<div id="links" class="tab-pane">
						<?php echo $this->renderPartial('_links',array('model'=>$model));?>
					</div>
					<div id="image" class="tab-pane">
						<?php echo $this->renderPartial('_image',array('model'=>$model,'imageProvider'=>$imageProvider));?>
					</div>
					<div id="discount" class="tab-pane">
						<?php echo $this->renderPartial('_discount',array('model'=>$model));?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
