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
				<div class="row">
					<?php echo $content; ?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $this->endContent(); ?>
