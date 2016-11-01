<?php $this->beginContent('application.modules.vendor.views.layouts.main'); ?>
	<div class="page_bar clearfix">
		<div class="row">
			<div class="col-md-8">
				<h1 class="page_title"><?php echo strtoupper(Yii::app()->user->profile->company);?></h1>
			</div>
			<?php if(is_array($this->menu)):?>
			<div class="col-md-4 text-right">
				<?php
					$this->widget('zii.widgets.CMenu', array(
						'items'=>$this->menu,
						'htmlOptions'=>array('class'=>'nav navbar-nav navbar-right'),
						'id'=>'manage-menu',
					));
				?>
			</div>
			<?php endif;?>
		</div>
	</div>

	<?php if(is_array($this->breadcrumbs)):?>
	<nav class="breadcrumbs">
	<?php $this->widget('zii.widgets.CBreadcrumbs', array(
		'links'=>$this->breadcrumbs,
		'separator'=>'<li class="sep"> \ </li>',
		'tagName'=>'ul',
		'htmlOptions'=>array('class'=>''),
		'activeLinkTemplate'=>'<li><a href="{url}">{label}</a></li>', // will generate the clickable breadcrumb links 
		'inactiveLinkTemplate'=>'<li>{label}</li>', // will generate the current page url : <li>News</li>
	));?>
	</nav>
	<?php endif;?>

	<div class="page_content">
		<div class="container-fluid">
			<?php echo $content; ?>
		</div>
	</div>	
<?php $this->endContent(); ?>

<!-- datatables -->
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl.'/css/tisa/lib/DataTables/media/css/jquery.dataTables.min.css';?>">
<?php echo $this->get_js(array('path'=>'css/tisa/lib/DataTables/media/js/jquery.dataTables.min.js')); ?>

<script type="text/javascript">
$(function(){
	dataReload();
	$('button[data-toggle="tab"]').click(function(){
		$(this).parent().find('button').removeClass('active');
		$(this).addClass('active');
	});
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
	$('.panel-btns').addClass('hide');
	$('#manage-menu').find('a').addClass('btn btn-default no-padding');
	//datatable initialization
	if($('.dataTable').length>0 && $('.dataTable').find('td.empty').length<=0){	
		var dataTableParent = $('.dataTable').parent();
		var order_field = 1;
		if(dataTableParent[0].hasAttribute('order-field'))
			var order_field = dataTableParent.attr('order-field');
		var order_method = 'asc';
		if(dataTableParent[0].hasAttribute('order-method'))
			var order_method = dataTableParent.attr('order-method');
		$('.dataTable').DataTable({
			'paging': true,
			'lengthMenu': [ 10, 20, 25, 50, 75, 100 ],
			'pageLength': 10,
			'order': [[ order_field, order_method ]]
		});
	}
	//move datatable search
	$(".search-box").html($(".dataTables_filter").last());
	$(".dataTables_length").find('select').removeClass('form-control');
	//init choose
	$("input[name='choose_all']").click(function(){
		var table = $(this).closest('table');
		if(this.checked == true){
			table.find('.choose:not(:checked)').attr('checked',true);
		}else{
			table.find('input.choose:checked').attr('checked',false);
		}
	});
	return false;
}
$(function(){
	$('button.api-link').click(function(){
		var anchor = $(this)[0];
		var $_this = $(this);
		if(anchor.hasAttribute('confirm')){
			if(confirm($_this.attr('confirm'))){
				$.ajax({
					'beforeSend': function() { Loading.show(); },
					'complete': function() { Loading.hide(); },
					'url': $_this.attr('href'),
					'type':'post',
				  	'success': function(data){
						if(anchor.hasAttribute('redirect-url'))
							window.location.href = $_this.attr('redirect-url');
						else
							window.location.reload(true);
					},
				});
			}
		}else{
			window.location.href = $(this).attr('href');
		}
		return false;
	});
	$('button[data-toggle="tab"]').click(function(){
		if($(this)[0].hasAttribute('data-toggle-btn')){
			var btn = $(this).attr('data-toggle-btn');
			$(btn).removeClass('hide');
		}else
			$('.toggle-btn-container').addClass('hide');
	});
	$('button.save-api').click(function(){
		var anchor = $(this)[0];
		var $_this = $(this);
		if(anchor.hasAttribute('confirm')){
			if(confirm($_this.attr('confirm'))){
				$($_this.attr('data-dest')).find('input[type="submit"]').trigger('click');
			}
		}
		return false;
	});
});
</script>
