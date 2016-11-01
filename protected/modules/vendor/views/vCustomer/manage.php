<?php
$this->breadcrumbs=array(
	ucfirst(Yii::app()->controller->module->id)=>array('/'.Yii::app()->controller->module->id.'/'),
	Yii::t('global','Manage').' '.Yii::t('VendorModule.customer','Customer'),
);

$this->menu=array(
	array('label'=>Yii::t('global','List').' '.Yii::t('VendorModule.customer','Customer'), 'url'=>array('index')),
);
?>
<style>
.form-horizontal .form-group{border-top: 1px solid #e7e7e7;clear: both;padding: 20px 16px;position: relative;margin:0;}
#VCustomer_status input, #VCustomer_type input, #VCustomer_gender input, #VCustomer_tax_exempt input{float:left;margin-right:10px;}
#VCustomer_type label, #VCustomer_gender label, #VCustomer_tax_exempt label {width:25%;float:left;}
#VCustomer_status label {width:20%;float:left;}
</style>
<div class="panel panel-default">
	<div class="panel-heading">
		<h4 class="panel-title"><?php echo Yii::t('VendorModule.customer','Customer');?> #<?php echo $model->id;?> - <b><?php echo $model->name;?></b></h4>
	</div>
	<div class="panel-body">
		<ul class="nav nav-tabs">
			<li class="active">
				<a data-toggle="tab" href="#general">
					<strong><?php echo Yii::t('VendorModule.customer','Profile');?></strong>
				</a>
			</li>
			<li class="">
				<a data-toggle="tab" href="#update">
					<strong><?php echo Yii::t('global','Update').' '.Yii::t('VendorModule.customer','Customer');?></strong>
				</a>
			</li>
			<li class="">
				<a data-toggle="tab" href="#order">
					<strong><?php echo Yii::t('VendorModule.customer','Order');?></strong>
				</a>
			</li>
			<li class="">
				<a data-toggle="tab" href="#invoice">
					<strong><?php echo Yii::t('VendorModule.customer','Invoice');?></strong>
				</a>
			</li>
		</ul>
		<div class="tab-content">
			<div id="general" class="tab-pane active">
				<div class="table-responsive">
				<?php $this->widget('zii.widgets.CDetailView', array(
					'data'=>$model,
					'htmlOptions'=>array('class'=>'table table-striped mb30'),
					'attributes'=>array(
						array(
							'label'=>'id',
							'type'=>'raw',
							'value'=>$model->id,
						),
						array(
							'label'=>'Name',
							'type'=>'raw',
							'value'=>$model->name,
						),
						array(
							'name'=>'email',
							'type'=>'raw',
							'value'=>$model->email,
						),
						array(
							'name'=>'status',
							'type'=>'raw',
							'value'=>ucfirst($model->status),
						),
						array(
							'name'=>'customer_group_id',
							'type'=>'raw',
							'value'=>$model->group_rel->name,
						),
						array(
							'name'=>'ip',
							'type'=>'raw',
							'value'=>$model->ip,
						),
						array(
							'name'=>'currency',
							'type'=>'raw',
							'value'=>(!empty($model->currency))? $model->currency : 'IDR',
						),
						array(
							'name'=>'address',
							'type'=>'raw',
							'value'=>$model->address.', '.ucfirst($model->city).', '.ucfirst($model->state).', '.$model->postcode,
						),
						array(
							'name'=>'phone',
							'type'=>'raw',
							'value'=>$model->phone,
						),
						array(
							'name'=>'date_entry',
							'type'=>'raw',
							'value'=>$model->date_entry,
						),
					),
				)); ?>
				</div>
				<?php //echo CHtml::link('<i class="fa fa-trash-o"></i> '.Yii::t('global','Delete'),array('/market/clients/delete','id'=>$model->id),array('class'=>'btn btn-default','onclick'=>'return hapus(this);'));?>
			</div>
			<div id="update" class="tab-pane">
				<?php echo $this->renderPartial('_form_manage',array('model'=>$model));?>
			</div>
			<div id="order" class="tab-pane">
				<?php echo $this->renderPartial('_customer_order',array('dataProvider'=>$orderProvider));?>
			</div>
			<div id="invoice" class="tab-pane">
				<?php echo $this->renderPartial('_customer_invoice',array('dataProvider'=>$invoiceProvider));?>
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
</script>
