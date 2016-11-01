<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<link rel="shortcut icon" type="image/x-icon" href="<?php echo Yii::app()->request->baseUrl.'/uploads/images/'.Yii::app()->config->get('favicon'); ?>">
	
	<!-- jQuery -->
	<?php echo $this->get_js(array('path'=>'css/tisa/js/jquery.min.js')); ?>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
	<!-- bootstrap framework -->
	<?php echo $this->get_css(
		array('path'=>'css/tisa/bootstrap/css/bootstrap.min.css'),
			array('patern'=>'../fonts','replacement'=>Yii::app()->request->baseUrl.'/css/tisa/bootstrap/css/fonts')
		); ?>
	<!-- font awesome icons -->
	<?php echo $this->get_css(
		array('path'=>'css/tisa/icons/font-awesome/css/font-awesome.min.css'),
			array('patern'=>'../fonts','replacement'=>Yii::app()->request->baseUrl.'/css/tisa/icons/font-awesome/fonts')
		); ?>
	<!-- ionicons -->	
	<?php echo $this->get_css(
		array('path'=>'css/tisa/icons/ionicons/css/ionicons.min.css'),
			array('patern'=>'../fonts','replacement'=>Yii::app()->request->baseUrl.'/css/tisa/icons/ionicons/fonts')
		); ?>
	<!-- main stylesheet -->
	<?php echo $this->get_css(
		array('path'=>'css/tisa/css/style.css'),
			array('patern'=>'../img','replacement'=>Yii::app()->request->baseUrl.'/css/tisa/img')
		); ?>

	<!-- top bar -->
	<?php if(!Yii::app()->user->isGuest):?>
	<header class="navbar navbar-fixed-top" role="banner">
		<div class="container-fluid">
			<div class="navbar-header pull-right">
				<?php echo CHtml::link(CHtml::image(''),array('/'.Yii::app()->controller->module->id),array('class'=>'navbar-brand'));?>
			</div>
			<ul class="top_links">
				<?php $this->widget('application.modules.vendor.components.VCounterWidget'); ?>
			</ul>
			<ul class="nav navbar-nav navbar-left">
					<li><a href="javascript:void(0)" class="slidebar-toggle"><span class="navbar_el_icon ion-navicon-round"></span></a></li>
					<li class="user_menu">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<span class="navbar_el_icon ion-person"></span> <span class="caret"></span>
						</a>
						<?php
							$this->widget('zii.widgets.CMenu', array(
								'items'=>array(
									array('label'=>Yii::t('menu','Change Password'), 'url'=>array('/appadmin/profile/changePassword')),
									array('label'=>'Logout', 'url'=>array('/appadmin/default/logout')),
								),
								'htmlOptions'=>array('class'=>'dropdown-menu dropdown-menu-left'),
								'encodeLabel'=>false,
							));
						?>
					</li>
			</ul>
		</div>
	</header>
	<?php endif;?>
	<section>
		<!-- main content -->
		<div id="main_wrapper">
		<?php echo $content; ?>	
		</div>
		<!-- side navigation -->
		<?php if(!Yii::app()->user->isGuest):?>
		<nav id="side_nav">
			<?php $this->widget('VendorMainMenu');?>
		</nav>
		<?php endif;?>
	</section>
	<!-- easing -->
	<?php echo $this->get_js(array('path'=>'css/tisa/js/jquery.easing.1.3.min.js')); ?>
	<!-- bootstrap js plugins -->
	<?php echo $this->get_js(array('path'=>'css/tisa/bootstrap/js/bootstrap.min.js')); ?>
	<!-- top dropdown navigation -->
	<?php echo $this->get_js(array('path'=>'css/tisa/js/tinynav.min.js')); ?>
	<!-- perfect scrollbar -->
	<?php echo $this->get_js(array('path'=>'css/tisa/lib/perfect-scrollbar/min/perfect-scrollbar-0.4.8.with-mousewheel.min.js')); ?>
	<!-- common functions -->
	<?php echo $this->get_js(array('path'=>'css/tisa/js/tisa_common.min.js')); ?>
<?php $this->widget('ext.widgets.loading.LoadingWidget');?>
</body>
