<?php
$this->breadcrumbs=array(
	ucfirst(Yii::app()->controller->module->id)=>array('/'.Yii::app()->controller->module->id.'/'),
	Yii::t('global','Manage').' '.Yii::t('VendorModule.order','Order'),
);

$this->menu=array(
	array('label'=>Yii::t('global','List').' '.Yii::t('VendorModule.order','Order'), 'url'=>array('index')),
);
?>
<style>
.form-horizontal .form-group{border-top: 1px solid #e7e7e7;clear: both;padding: 20px 16px;position: relative;margin:0;}
#VCustomer_status input, #VCustomer_type input, #VCustomer_gender input, #VCustomer_tax_exempt input{float:left;margin-right:10px;}
#VCustomer_status label, #VCustomer_type label, #VCustomer_gender label, #VCustomer_tax_exempt label {width:25%;float:left;}
</style>
<div class="panel panel-default">
	<div class="panel-heading">
		<h4 class="panel-title"><?php echo Yii::t('VendorModule.order','Order');?> #<?php echo $model->id;?></b></h4>
	</div>
	<div class="panel-body">
		<ul class="nav nav-tabs">
			<li class="active">
				<a data-toggle="tab" href="#general">
					<strong><?php echo Yii::t('VendorModule.order','Details');?></strong>
				</a>
			</li>
			<li class="">
				<a data-toggle="tab" href="#update">
					<strong><?php echo Yii::t('global','Update').' '.Yii::t('VendorModule.order','Order');?></strong>
				</a>
			</li>
			<li class="">
				<a data-toggle="tab" href="#invoice">
					<strong><?php echo Yii::t('VendorModule.order','Invoice');?></strong>
				</a>
			</li>
		</ul>
		<div class="tab-content">
			<div id="general" class="tab-pane active">
				<div class="table-responsive">
				<div class="mt10"></div>
				<h4 class="no-margin"><?php echo $model->title;?></h4>
				<div class="mb20"></div>
				<?php $this->widget('zii.widgets.CDetailView', array(
					'data'=>$model,
					'htmlOptions'=>array('class'=>'table table-striped mb30'),
					'attributes'=>array(
						array(
							'label'=>'order',
							'type'=>'raw',
							'value'=>'#'.$model->id,
						),
						array(
							'label'=>'Customer',
							'type'=>'raw',
							'value'=>CHtml::link(
								$model->customer_rel->name,
								array('/vendor/vClient/manage','id'=>$model->customer_id)
							)
						),
						array(
							'name'=>'title',
							'type'=>'raw',
							'value'=>CHtml::link($model->title,array('/vendor/vProduct/manage','id'=>$model->product_id)),
						),
						array(
							'name'=>'status',
							'type'=>'raw',
							'value'=>$model->getStatuses($model->status),
						),
						array(
							'name'=>'notes',
							'type'=>'raw',
							'value'=>$model->notes,
						),
						array(
							'name'=>'promo_id',
							'type'=>'raw',
							'value'=>($model->promo_id)? $model->promo_rel->code : '-' ,
						),
						array(
							'name'=>'date_entry',
							'type'=>'raw',
							'value'=>$model->date_entry,
						),
					),
				)); ?>
				</div>
				<?php echo CHtml::link('<i class="fa fa-money"></i> '.Yii::t('VendorModule.order','Issue Invoice'),array('/vendor/vInvoice/create','order_id'=>$model->id),array('class'=>'btn btn-default act-btn','title'=>'Issue Invoice'));?>
				<?php echo CHtml::link('<i class="fa fa-trash-o"></i> '.Yii::t('global','Delete'),array('/vendor/vOrder/delete','id'=>$model->id),array('class'=>'btn btn-default','onclick'=>'return hapus(this);'));?>
			</div>
			<div id="update" class="tab-pane">
				<?php echo $this->renderPartial('_form_manage',array('model'=>$model));?>
			</div>
			<div id="invoice" class="tab-pane">
				<h4><?php echo Yii::t('VendorModule.order','Order Invoices');?></h4>
				<?php echo $this->renderPartial('/vInvoice/_view',array('dataProvider'=>$dataProvider));?>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
function hapus(data){
	if(confirm('Are you sure to delete this?')){
		$.ajax({
			'beforeSend': function() { Loading.show(); },
			'complete': function() { Loading.hide(); },
			'url': $(data).attr('href'),
			'type':'post',
		   	'dataType': 'json',
		  	'success': function(data){
				if(data.status=='success'){
					
				}
			},
		});
	}
	return false;
}
$(function(){
	$('a.act-btn').click(function(){
		var title = $(this).attr('title');
		if(confirm('Are you sure to "'+title+'" this order?')){
			$.ajax({
				'beforeSend': function() { Loading.show(); },
				'complete': function() { Loading.hide(); },
				'url': $(this).attr('href'),
				'type':'post',
			   	'dataType': 'json',
			  	'success': function(data){
					if(data.status=='success'){
						window.location.reload(true);
					}
				},
			});
		}
		return false;
	});
});
</script>
