<?php
$this->breadcrumbs=array(
	ucfirst(Yii::app()->controller->module->id)=>array('/'.Yii::app()->controller->module->id.'/'),
	Yii::t('global','Manage').' '.Yii::t('VendorModule.order','Order'),
);

$this->menu=array(
	array('label'=>Yii::t('global','List').' '.Yii::t('VendorModule.order','Order'), 'url'=>array('index')),
	array('label'=>Yii::t('global','Create').' '.Yii::t('VendorModule.order','Order'), 'url'=>'#new', 'linkOptions'=>array('data-toggle'=>'tab')),
);
?>

<div class="panel panel-default">
	<div class="panel-heading">
		<h4 class="panel-title"><?php echo Yii::t('global','Manage').' '.Yii::t('VendorModule.order','Order');?></h4>
	</div>
	<div class="panel-body">
		<ul class="nav nav-tabs">
			<li class="active">
				<a data-toggle="tab" href="#general">
					<strong><?php echo Yii::t('VendorModule.order','Order');?></strong>
				</a>
			</li>
			<li class="">
				<a data-toggle="tab" href="#new">
					<strong><?php echo Yii::t('global','Create').' '.Yii::t('VendorModule.order','Order');?></strong>
				</a>
			</li>
		</ul>
		<div class="tab-content">
			<div id="general" class="tab-pane active">
				<div class="table-responsive">
				<?php $this->widget('zii.widgets.grid.CGridView', array(
					'dataProvider'=>$dataProvider,
					'filter'=>$dataProvider->model,
					'itemsCssClass'=>'table table-striped mb30',
					'id'=>'order-grid',
					'afterAjaxUpdate' => 'reloadGrid',
					'columns'=>array(
						/*array(
							'value'=>'$this->grid->dataProvider->getPagination()->getOffset()+$row+1',
						),*/
						array(
							'name'=>'id',
							'type'=>'raw',
							'value'=>'CHtml::link($data->id,array(\'order/manage\',\'id\'=>$data->id))',
							'htmlOptions'=>array('style'=>'width:5%;'),
						),
						array(
							'name'=>'customer_id',
							'type'=>'raw',
							'value'=>'CHtml::link($data->customer_rel->name,array(\'vCustomer/manage\',\'id\'=>$data->customer_id))',
							'filter'=>CHtml::activeTextField($dataProvider->model,'customer_search'),
						),
						array(
							'name'=>'title',
							'type'=>'raw',
							'value'=>'$data->title',
						),
						/*array(
							'name'=>'product_id',
							'type'=>'raw',
							'value'=>'CHtml::link($data->title,array(\'products/manage\',\'id\'=>$data->product_id))',
							'filter'=>CHtml::activeTextField($dataProvider->model,'product_search'),
						),
						array(
							'name'=>'period',
							'type'=>'raw',
							'value'=>'ModProduct::periods(true,$data->period,true)->title',
							'filter'=>ModProduct::periods(false),
						),
						array(
							'name'=>'status',
							'type'=>'raw',
							'value'=>'ucfirst($data->getStatuses($data->status))',
							'filter'=>$dataProvider->model->statuses,
						),*/
						array(
							'name'=>'price',
							'type'=>'raw',
							'value'=>'number_format($data->price,2,\',\',\'.\')',
							'htmlOptions'=>array('style'=>'text-align:right;'),
						),
						array(
							'name'=>'discount',
							'type'=>'raw',
							'value'=>'number_format($data->discount,2,\',\',\'.\')',
							'htmlOptions'=>array('style'=>'text-align:right;'),
						),
						array(
							'name'=>'date_entry',
							'type'=>'raw',
							'value'=>'$data->date_entry',
						),
						array(
							'class'=>'CButtonColumn',
							'template'=>'{view}{delete}',
							'buttons'=>array
								(
									'view'=>array(
											'label'=>'<i class="fa fa-pencil"></i>',
											'imageUrl'=>false,
											'options'=>array('title'=>'View'),
											'url'=>'Yii::app()->createUrl(\'vendor/vOrder/manage\',array(\'id\'=>$data->id))',
										),
									'delete'=>array(
											'label'=>'<i class="fa fa-trash-o"></i>',
											'imageUrl'=>false,
											'options'=>array('title'=>'Delete'),
										),
								),
							'htmlOptions'=>array('style'=>'width:10%;','class'=>'table-action'),
						),
					),
				)); ?>
				</div>
			</div>
			<div id="new" class="tab-pane">
				<?php echo $this->renderPartial('_form_order',array('model'=>new VCustomerOrder));?>
			</div>
		</div>
	</div>
</div>
