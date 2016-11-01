<?php $this->pageSection = 'author Dashboard'; ?>
<?php
$this->breadcrumbs = array(
	ucfirst(Yii::app()->controller->module->id) => array('/'.Yii::app()->controller->module->id.'/'),
	Yii::t('VendorModule.vendor','Dashboard'),
);

/*$this->menu=array(
	array('label'=>Yii::t('global','List').' '.Yii::t('menu','Product'), 'url'=>array('admin')),
);*/
?>

<div class="rs_user_dashboard_tab">
	<div class="tab-content">
		<div class="tab-pane active" id="profile">
			<div class="rs_user_dashboard_tab_heading">
				<h4><?php echo Yii::t('VendorModule.vendor','Your Information');?></h4>
			</div>
			<div class="rs_user_dashboard_tab_info">
				<div class="rs_author_dashboard_tab_info_img">
					<img src="images/author_pic.jpg" alt="" class="img-responsive">
					<h4><?php echo Yii::app()->user->name;?></h4>
					<p><?php echo Yii::app()->user->profile->email;?></p>
				</div>
				<div class="rs_social">
					<ul>
						<li><a href="#"><i class="fa fa-facebook"></i></a></li>
						<li><a href="#"><i class="fa fa-twitter"></i></a></li>
						<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
						<li><a href="#"><i class="fa fa-pinterest"></i></a></li>
						<li><a href="#"><i class="fa fa-dribbble"></i></a></li>
					</ul>
					<p>We work with clients big and small across a range of sectors and we utilise all forms of media to get your name out there in a way that’s right for you. We have a number of different teams within our agency that specialise in different areas.</p>
				</div>
			</div>
		</div>
	</div>
</div>
