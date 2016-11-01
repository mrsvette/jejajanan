<?php $this->beginContent('application.modules.customer.views.layouts.main'); ?>
<!--Breadcrumb start-->
<div class="rs_pagetitle rs_toppadder40 rs_bottompadder40">
	<div class="rs_overlay"></div>
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="page_title">
					<h3 class="rs_bottompadder20"><?php echo $this->pageSection;?></h3>
				</div>
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<?php $this->widget('zii.widgets.CBreadcrumbs', array(
					'links'=>$this->breadcrumbs,
					'tagName'=>'ul',
					'separator'=>'',
					'activeLinkTemplate'=>'<li><a href="{url}">{label}</a></li>',
					'inactiveLinkTemplate'=>'<li class="active"><span>{label}</span></li>',
					'htmlOptions'=>array ('class'=>'breadcrumb')
				)); ?>
			</div>
		</div>		
	</div>
</div>
<!--Breadcrumb end-->
<div class="rs_graybg rs_toppadder100 rs_bottompadder40">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
					<div class="row">
						<div class="rs_tab_wrapper">
							<div class="rs_user_profile_img">
								<div class="rs_menu_pic_overlay"><h6 class="text-center">Dashboard</h6></div>
							</div>
							 <div class="rs_left_tabwrapper">
								<ul class="nav nav-tabs" id="vendor-left-menu">
									<li class="active">
										<span><i class="fa fa-home"></i></span>
										<?php echo CHtml::link(Yii::t('CustomerModule.customer','Dashboard'),array('/customer'));?>
									</li>
									<li>
										<span><i class="fa fa-user"></i></span>
										<?php echo CHtml::link(Yii::t('CustomerModule.customer','Profile'),array('/customer/cProfile/update'));?>
									</li>
									<li>
										<span><i class="fa fa-usd"></i></span>
										<?php echo CHtml::link(Yii::t('CustomerModule.customer','Invoices'),array('/customer/cInvoice'));?>
									</li>
									<li>
										<span><i class="fa fa-list"></i></span>
										<?php echo CHtml::link(Yii::t('CustomerModule.customer','Order History'),array('/customer/cOrder'));?>
									</li>
									<li>
										<span><i class="fa fa-envelope"></i></span>
										<?php echo CHtml::link(Yii::t('CustomerModule.customer','Messages'),array('/customer/cMessages'));?>
									</li>
									<li>
										<span><i class="fa fa-power-off"></i></span>
										<?php echo CHtml::link('Logout',array('/customer/default/logout'));?>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-9 col-md-9 col-sm-8 col-xs-12">
					<div class="row">
						<?php echo $content; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $this->widget('ext.widgets.loading.LoadingWidget');?>
<script type="text/javascript">
$(function(){
	var url = "<?php echo Yii::app()->request->requestUri;?>";
	$('ul[id="vendor-left-menu"]').find('a').each(function(){
		var href = $(this).attr('href');
		if(href == url)
			$(this).parent().addClass('active');
		else{
			if($(this).parent().hasClass('active'))
				$(this).parent().removeClass('active');
		}
	});
});
$(function(){
	dataReload();
});
function reloadGrid(id, data) {
	dataReload();
	return false;
}
function dataReload(){
	$('input[type=text]').addClass('form-control');
	$('textarea').addClass('form-control');
	$('select').addClass('form-control');
	$('input[type=password]').addClass('form-control');
	$('input[type=submit]').addClass('btn btn-primary');
	$('input[type=button]').addClass('btn btn-primary');
	$('.yiiPager').addClass('dataTables_paginate paging_full_numbers');
	$('.dataTables_paginate').removeClass('yiiPager');
	return false;
}
</script>
<?php $this->endContent(); ?>
