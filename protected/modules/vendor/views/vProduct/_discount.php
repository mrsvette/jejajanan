<div class="table-responsive">
	<?php $this->widget('zii.widgets.grid.CGridView', array(
			'dataProvider'=>$model->discountProvider,
			'itemsCssClass'=>'table table-striped mb30 dataTable no-footer',
			'id'=>'discount-grid',
			'afterAjaxUpdate' => 'reloadGrid2',
			'summaryText' => '',
			'columns'=>array(
					array(
						'name'=>'customer_group_id',
						'type'=>'raw',
						'value'=>'CHtml::activeDropDownList($data,\'customer_group_id\',VCustomerGroup::getItems(),array(\'class\'=>\'form-control\'))',
						'htmlOptions'=>array('width'=>'20%'),
					),
					array(
						'name'=>'quantity',
						'type'=>'raw',
						'value'=>'CHtml::activeTextField($data,\'quantity\',array(\'class\'=>\'form-control\'))',
						'htmlOptions'=>array('width'=>'10%'),
					),
					array(
						'name'=>'priority',
						'type'=>'raw',
						'value'=>'CHtml::activeTextField($data,\'priority\',array(\'class\'=>\'form-control\'))',
						'htmlOptions'=>array('width'=>'10%'),
					),
					array(
						'name'=>'price',
						'type'=>'raw',
						'value'=>'"<div class=\"input-group\">
							<span class=\"input-group-addon input-group-primary\"><b>Rp</b></span>".CHtml::activeTextField($data,\'price\',array(\'class\'=>\'form-control\'))."</div>"',
						'htmlOptions'=>array('width'=>'20%'),
					),
					array(
						'header'=>'Date start/end',
						'type'=>'raw',
						'value'=>'CHtml::activeTextField($data,\'date_range\',array(\'class\'=>\'form-control discound_date_range\',\'value\'=>$data->dateRange))',
						'htmlOptions'=>array('width'=>'25%'),
					),
					array(
						'class'=>'CButtonColumn',
						'template'=>'{save}{delete}',
						'buttons'=>array
								(
									'save'=>array(
											'label'=>'<i class="fa fa-save"></i> ',
											'imageUrl'=>false,
											'options'=>array('title'=>'Apply Change','class'=>'btn btn-sm btn-default tr_change'),
											'url'=>'Yii::app()->createUrl(\'/vendor/vProduct/updateDiscount\',array(\'id\'=>$data->id))',
										),
									'delete'=>array(
											'label'=>'<i class="fa fa-trash-o"></i>',
											'imageUrl'=>false,
											'options'=>array('title'=>'Delete','class'=>'btn btn-sm btn-default tr_remove'),
											'url'=>'Yii::app()->createUrl(\'/vendor/vProduct/deleteDiscount\',array(\'id\'=>$data->id))',
										),
								),
						'htmlOptions'=>array('style'=>'width:15%;text-align:center;','class'=>'table-action'),
					),
				),
			)); 
	?>
</div>
<?php echo CHtml::link('Add discount',array('/vendor/vProduct/addDiscount','id'=>$model->id),array('class'=>'btn btn-sm btn-primary','id'=>'tr_add_btn'));?>
<!-- bootstrap-datepicker -->
<?php echo $this->get_css(array('path'=>'css/tisa/lib/bootstrap-datepicker/css/datepicker3.css')); ?>
<!-- date range picker -->
<?php echo $this->get_css(array('path'=>'css/tisa/lib/bootstrap-daterangepicker/daterangepicker-bs3.css')); ?>
<!--  bootstrap-datepicker -->
<?php echo $this->get_js(array('path'=>'css/tisa/lib/bootstrap-datepicker/js/bootstrap-datepicker.js')); ?>
<!-- date range picker -->
<?php echo $this->get_js(array('path'=>'css/tisa/lib/bootstrap-daterangepicker/daterangepicker.js')); ?>
<!-- moment.js (date library) -->
<?php echo $this->get_js(array('path'=>'css/tisa/lib/moment-js/moment.min.js')); ?>
<script type="text/javascript">
$(function() {
	// daterange picker
	tisa_date_range.report_picker();
	// datepicker
	tisa_datepicker.init();
	tisa_date_range.discount_picker();
	//save button
	tisa_save_button.init();
	$('#tr_add_btn').click(function() {
		$.ajax({
			'beforeSend': function() { Loading.show(); },
			'complete': function() { Loading.hide(); },
			'url': $(this).attr('href'),
			'type':'post',
			'dataType':'json',
			'success': function(data){
				$.fn.yiiGridView.update("discount-grid");
				setTimeout(function(){
					$('#discount-grid').find('tr:first-child').find('td').each(function(){
						$(this).attr('style','background-color:#b0bed9;');
						$(this).find('#VProductDiscount_price').focus();
					});
				}, 3000);
			},
		});	
		return false;
	});
})
function reloadGrid2(){
	reloadGrid();
	tisa_save_button.init();
	tisa_datepicker.init();
	tisa_date_range.discount_picker();
}
	
// daterange picker
tisa_date_range = {
	report_picker: function() {
		if($('#reportrange').length) {
			if( $(window).width() < 974 ) {
				var dropdownPos = 'right';
			} else {
				var dropdownPos = 'left';
			}
			$('#reportrange').daterangepicker({
				opens: dropdownPos,
				ranges: {
						'Today': [moment(), moment()],
						'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
						'Last 7 Days': [moment().subtract('days', 6), moment()],
						'Last 30 Days': [moment().subtract('days', 29), moment()],
						'This Month': [moment().startOf('month'), moment().endOf('month')],
						'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
			},
			startDate: moment().subtract('days', 29),
			endDate: moment(),
			buttonClasses: ['btn','btn-sm']
			},
			function(start, end) {
				$('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
			}
		);
	}
},
discount_picker: function() {
	if($('.discound_date_range').length) {
		$('.discound_date_range').daterangepicker({
			ranges: {
			   'Next 7 Days': [moment().add('days', 1), moment().add('days', 7)],
			   'Next 14 Days': [moment().add('days', 1), moment().add('days', 14)],
			   'Next Month': [moment().add('month', 1).startOf('month'), moment().add('month', 1).endOf('month')]
			},
			opens: 'left',
			format: 'DD MMM YYYY'
		});
	}
}
}
// datepicker
tisa_datepicker = {
	init: function() {
		if ($('#p_date_available').length) {
			$('#p_date_available').datepicker({
				weekStart: 1,
				autoclose: true,
				format: "dd.mm.yyyy",
				startDate: "0d",
				todayHighlight: true
			})
		}
	}
}
tisa_save_button = {
	init: function() {
		$('.tr_change').click(function(){
			var $this = $(this);
			var customer_group_id = $this.parent().parent().find('#VProductDiscount_customer_group_id').val();
			var quantity = $this.parent().parent().find('#VProductDiscount_quantity').val();
			var priority = $this.parent().parent().find('#VProductDiscount_priority').val();
			var price = $this.parent().parent().find('#VProductDiscount_price').val();
			var date_range = $this.parent().parent().find('#VProductDiscount_date_range').val();
			$.ajax({
				'beforeSend': function() { Loading.show(); },
				'complete': function() { Loading.hide(); },
				'url': $this.attr('href'),
				'type':'post',
				'data':{'customer_group_id':customer_group_id,'quantity':quantity,'priority':priority,'price':price,'date_range':date_range},
				'success': function(data){
					$.fn.yiiGridView.update("discount-grid");
				},
			});
			return false;
		});
	}
}
</script>
