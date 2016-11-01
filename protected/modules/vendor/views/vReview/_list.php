<div class="table-responsive" >
	<?php $this->widget('zii.widgets.grid.CGridView', array(
			'dataProvider'=>$dataProvider,
			'itemsCssClass'=>'table table-striped mb30 dataTable no-footer',
			'id'=>'review-grid',
			'afterAjaxUpdate' => 'reloadGrid',
			'summaryText' => '',
			'htmlOptions'=>array('order-field'=>0,'order-method'=>'desc'),
			'columns'=>array(
					array(
						'header'=>CHtml::checkbox('choose_all'),
						'value'=>'CHtml::checkbox("choose[".$data->id."]",0,array("class"=>"choose","id"=>$data->id))',
						'type'=>'raw',
					),
					array(
						'header'=>'Product',
						'type'=>'raw',
						'value'=>'CHtml::link($data->product_rel->description_one_rel->name,array(\'vProduct/update\',\'id\'=>$data->product_id))',
					),
					array(
						'header'=>'Customer',
						'type'=>'raw',
						'value'=>'CHtml::link($data->customer_rel->name,array(\'vCustomer/update\',\'id\'=>$data->customer_id))',
					),
					array(
						'header'=>'Rating',
						'type'=>'raw',
						'value'=>'$data->rating'
					),
					array(
						'header'=>'Status',
						'type'=>'raw',
						'value'=>'$data->textStatus'
					),
					array(
						'header'=>'Date Entry',
						'type'=>'raw',
						'value'=>'date("d F Y, H:i",strtotime($data->date_entry))'
					),
					array(
						'class'=>'CButtonColumn',
						'template'=>'{update}{delete}',
						'buttons'=>array
								(
									'update'=>array(
											'label'=>'<i class="fa fa-pencil"></i> ',
											'imageUrl'=>false,
											'options'=>array('title'=>'Update'),
											'url'=>'Yii::app()->createUrl(\'/vendor/vReview/update\',array(\'id\'=>$data->id))',
										),
									'delete'=>array(
											'label'=>'<i class="fa fa-trash-o"></i>',
											'imageUrl'=>false,
											'options'=>array('title'=>'Delete'),
											'url'=>'Yii::app()->createUrl(\'/vendor/vReview/delete\',array(\'id\'=>$data->id))',
										),
								),
							'htmlOptions'=>array('style'=>'width:10%;','class'=>'table-action'),
						),
					),
			)); 
	?>
</div>
<script type="text/javascript">
$(function(){
	$('.delete-api').click(function(){
		var msg = $(this).attr('api-confirm');
		if(confirm(msg)){
			var dest = $(this).attr('data-dest');
			var url = $(this).attr('api-url');
			$(dest).each(function(){
				var ihref = url+'/id/'+$(this).attr('id');
				delete_item(ihref);
			});
			$.fn.yiiGridView.update("review-grid");
		}
		return false;
	});
});
function delete_item(url)
{
	$.ajax({
		'beforeSend': function() { Loading.show(); },
		'complete': function() { Loading.hide(); },
		'url': url,
		'type':'post',
		'success': function(data){
		},
	});
}
</script>
