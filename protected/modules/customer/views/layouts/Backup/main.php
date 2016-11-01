<!DOCTYPE html>
<html lang="<?php echo Yii::app()->language;?>">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="language" content="<?php echo Yii::app()->language;?>" />	
	<meta name="description" content="<?php echo $this->meta_description; ?>" /> 
	<meta name="keywords" content="<?php echo $this->meta_keywords; ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="MobileOptimized" content="320">
	<!-- Favicon and touch icons -->
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo Yii::app()->request->baseUrl.'/uploads/images/'.Yii::app()->config->get('favicon'); ?>">
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php echo Yii::app()->request->baseUrl.'/uploads/images/apple-touch-icon-144-precomposed.png'; ?>">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php echo Yii::app()->request->baseUrl.'/uploads/images/apple-touch-icon-114-precomposed.png'; ?>">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php echo Yii::app()->request->baseUrl.'/uploads/images/apple-touch-icon-72-precomposed.png'; ?>">
	<link rel="apple-touch-icon-precomposed" href="<?php echo Yii::app()->request->baseUrl.'/uploads/images/apple-touch-icon-57-precomposed.png'; ?>">

	<?php echo $this->get_js(array('path'=>'css/wind/js/jquery-2.1.4.min.js')); ?>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
	<link rel="canonical" href="<?php echo Yii::app()->request->requestUri; ?>" />
</head>
<body>
	<?php echo $this->get_css(
		array('path'=>'css/wind/css/bootstrap.min.css'),
			array('patern'=>'../fonts','replacement'=>Yii::app()->request->baseUrl.'/css/wind/fonts')
		); ?>
	<?php echo $this->get_css(array('path'=>'css/wind/css/animate.min.css')); ?>
	<?php echo $this->get_css(
		array('path'=>'css/wind/css/fonts.css'),
			array('patern'=>'../fonts','replacement'=>Yii::app()->request->baseUrl.'/css/wind/fonts')
		); ?>
	<?php echo $this->get_css(
		array('path'=>'css/wind/css/style.css'),
			array('patern'=>'../images','replacement'=>Yii::app()->request->baseUrl.'/css/wind/images')
		); ?>
<div class="menu-wrap">
	<div class="rs_menu">
		<div class="rs_menu_inner_section">
			<div class="rs_menu_pic">
			<img src="<?php echo Yii::app()->request->baseUrl.'/uploads/images/menubg.jpg'; ?>" class="img-responsive" alt="">
			<div class="rs_menu_pic_overlay">
				<div class="rs_menu_inner_pic">
					<img src="<?php echo Yii::app()->request->baseUrl.'/uploads/images/icon.png'; ?>" alt="">
				</div>
			</div> 
				
			</div>
			<div class="rs_main_menu">
				<ul>
					<li><a href="#"><i class="fa fa-home"></i> home</a>
						<ul class="sub-menu">
							<li><a href="index.html"><i class="fa fa-angle-right"></i> home 1</a></li>
							<li><a href="index_digital.html"><i class="fa fa-angle-right"></i> home 2</a></li>
							<li><a href="index2.html"><i class="fa fa-angle-right"></i> home 3</a></li>
							<li><a href="index3.html"><i class="fa fa-angle-right"></i> home 4</a></li>
						</ul>
					</li>
					<li><a href="#"><i class="fa fa-shopping-cart"></i> Shop</a>
						<ul class="sub-menu">
							<li><a href="product_4Column.html"><i class="fa fa-angle-right"></i> product</a></li>
							<li><a href="product-with-sidebar.html"><i class="fa fa-angle-right"></i> product with sidebar</a></li>
							<li><a href="product_single.html"><i class="fa fa-angle-right"></i> product single</a></li>
							<li><a href="cart.html"><i class="fa fa-angle-right"></i> cart</a></li>
						</ul>
					</li>
					<li><a href="#"><i class="fa fa-files-o"></i> pages</a>
						<ul class="sub-menu">
							<li><a href="about_us.html"><i class="fa fa-angle-right"></i> about us</a></li>
							<li><a href="comingsoon.html"><i class="fa fa-angle-right"></i> comingsoon</a></li>
							<li><a href="contact.html"><i class="fa fa-angle-right"></i> contact</a></li>
							<li><a href="coupon_list.html"><i class="fa fa-angle-right"></i> coupon list</a></li>
							<li><a href="faqs.html"><i class="fa fa-angle-right"></i> faq's</a></li>
							<li><a href="forum.html"><i class="fa fa-angle-right"></i> forum</a></li>
							<li><a href="error.html"><i class="fa fa-angle-right"></i> 404 error</a></li>
						</ul>
					</li>
					<li><a href="#"><i class="fa fa-user"></i> My Profile</a>
						<ul class="sub-menu">
							<li><a href="author_profile.html"><i class="fa fa-angle-right"></i> author profile</a></li>
							<li><a href="author_dashboard.html"><i class="fa fa-angle-right"></i> author dashboard</a></li>
							<li><a href="user_dashboard.html"><i class="fa fa-angle-right"></i> user dashboard</a></li>
						</ul>
					</li>
					<li><a href="#"><i class="fa fa-stack-exchange"></i> knowledge Base</a>
						<ul class="sub-menu">
							<li><a href="knowledge.html"><i class="fa fa-angle-right"></i> knowledge Base</a></li>
							<li><a href="knowledge_single.html"><i class="fa fa-angle-right"></i> knowledge Base single</a></li>
						</ul>
					</li>
					<li><a href="#"><i class="fa fa-files-o"></i> blog</a>
						<ul class="sub-menu">
							<li><a href="blog.html"><i class="fa fa-angle-right"></i> blog</a></li>
							<li><a href="blog_single.html"><i class="fa fa-angle-right"></i> blog single</a></li>
						</ul>
					</li>
				</ul>
			</div>
			<div class="rs_social">
				<ul>
					<li><a href="#"><i class="fa fa-facebook"></i></a></li>
					<li><a href="#"><i class="fa fa-twitter"></i></a></li>
					<li><a href="#"><i class="fa fa-google-plus"></i></a></li>
					<li><a href="#"><i class="fa fa-pinterest"></i></a></li>
					<li><a href="#"><i class="fa fa-dribbble"></i></a></li>
				</ul>
			</div>
		</div>
	</div>
	<button class="close-button" id="close-button">Close Menu</button>
</div>
<div class="rs_topheader">
	<div class="container-fluid">
		<div class="row">
			<div class="rs_topheader_left">
				<div class="rs_menubtn">
					<span class="rs_bars" id="open-button"><i class="fa fa-bars"></i></span>
				</div>
				<div class="rs_search">
				<a href="<?php echo Yii::app()->createUrl('/home'); ?>">
					<img src="<?php echo Yii::app()->request->baseUrl.'/uploads/images/'.Yii::app()->config->get('logo'); ?>" alt="" class="hidden-md hidden-sm hidden-xs">
					<img src="<?php echo Yii::app()->request->baseUrl.'/uploads/images/icon.png'; ?>" alt="" class="hidden-lg">
				</a>
				</div>
			</div>
			<div class="rs_topheader_center">
			</div>
			<?php if (!Yii::app()->user->isGuest):?>
			<div class="rs_topheader_right">
				<div class="rs_user_pic">
					<div>
						<h6><?php echo Yii::app()->user->customer->name;?></h6>
					</div>
					<img src="<?php echo Yii::app()->request->baseUrl.'/uploads/images/user_img.jpg'; ?>" alt="">
					<i class="glyphicon glyphicon-option-vertical" aria-hidden="true"></i>
				</div>
				<div class="rs_user_profile">
					<?php $this->widget('zii.widgets.CMenu', array(
						'items'=>array(
							array('label'=>'<i class="fa fa-user"></i> profile', 'url'=>array('customer/cProfile/update'), 'visible'=>!Yii::app()->user->isGuest),
							array('label'=>'<i class="fa fa-lock"></i> change password', 'url'=>array('customer/cProfile/password'), 'visible'=>!Yii::app()->user->isGuest),
							array('label'=>'<i class="fa fa-cog"></i> logout', 'url'=>array('customer/default/logout'), 'visible'=>!Yii::app()->user->isGuest),
						),
						'encodeLabel'=>false,
					)); ?>
				</div>
					<ul class="nav navbar-nav navbar-right">
						<li><a href="#"><i class="fa fa-heart"></i> (28)</a></li>
						<li><a href="cart.html"><i class="fa fa-shopping-cart"></i> (2)</a></li>
					</ul>
			</div>
			<?php endif;?>
		</div>
	</div>
</div>
<section id="content-frame">
	<?php echo $content; ?>
</section>

<div class="rs_bottomfooter rs_toppadder30 rs_bottompadder20">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="rs_copyright">
					<p>&copy; <a href="<?php echo Yii::app()->createUrl('/home'); ?>"><?php echo Yii::app()->config->get('site_name'); ?>.</a> All rights reserved.</p>
				</div>
			</div>
		</div>
	</div>
</div>
<link href="<?php echo Yii::app()->request->baseUrl.'/css/wind/css/font-awesome.css'; ?>" rel="stylesheet">
<link href="<?php echo Yii::app()->request->baseUrl.'/css/wind/js/plugins/offcanvasmenu/menu_elastic.min.css'; ?>" rel="stylesheet">

<script async src="<?php echo Yii::app()->request->baseUrl.'/css/wind/js/bootstrap.min.js'; ?>"></script>
<script src="<?php echo Yii::app()->request->baseUrl.'/css/wind/js/modernizr.custom.js'; ?>" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl.'/css/wind/js/plugins/countto/jquery.appear.js'; ?>" type="text/javascript"></script>

<script src="<?php echo Yii::app()->request->baseUrl.'/css/wind/js/plugins/offcanvasmenu/classie.js'; ?>" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl.'/css/wind/js/plugins/offcanvasmenu/main3.js'; ?>" type="text/javascript"></script>
<script src="<?php echo Yii::app()->request->baseUrl.'/css/wind/js/custom.js'; ?>"></script>
</body>
</html>
