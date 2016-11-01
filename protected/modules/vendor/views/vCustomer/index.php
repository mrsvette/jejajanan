<?php
$this->breadcrumbs=array(
	ucfirst(Yii::app()->controller->module->id)=>array('/'.Yii::app()->controller->module->id.'/'),
	Yii::t('global','Manage').' '.Yii::t('VendorModule.customer','Customer'),
);

$this->menu=array(
	array('label'=>Yii::t('global','List').' '.Yii::t('VendorModule.customer','Customer'), 'url'=>array('index')),
	array('label'=>Yii::t('global','Create').' '.Yii::t('VendorModule.customer','Customer'), 'url'=>'#new', 'linkOptions'=>array('data-toggle'=>'tab')),
);
?>

<div class="panel panel-default">
	<div class="panel-heading">
		<h4 class="panel-title"><?php echo Yii::t('global','Manage').' '.Yii::t('VendorModule.customer','Customer');?></h4>
	</div>
	<div class="panel-body">
		<ul class="nav nav-tabs">
			<li class="active">
				<a data-toggle="tab" href="#general">
					<strong><?php echo Yii::t('VendorModule.customer','Customer');?></strong>
				</a>
			</li>
			<li class="">
				<a data-toggle="tab" href="#new">
					<strong><?php echo Yii::t('global','Create').' '.Yii::t('VendorModule.customer','Customer');?></strong>
				</a>
			</li>
			<li class="">
				<a data-toggle="tab" href="#category">
					<strong><?php echo Yii::t('product','Group');?></strong>
				</a>
			</li>
			<li class="">
				<a data-toggle="tab" href="#new-category">
					<strong><?php echo Yii::t('global','Create').' '.Yii::t('VendorModule.customer','Group');?></strong>
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
					'id'=>'customer-grid',
					'afterAjaxUpdate' => 'reloadGrid',
					'columns'=>array(
						array(
							'value'=>'$this->grid->dataProvider->getPagination()->getOffset()+$row+1',
						),
						array(
							'name'=>'name',
							'type'=>'raw',
							'value'=>'CHtml::link($data->name,array(\'vCustomer/manage\',\'id\'=>$data->id))'
						),
						array(
							'name'=>'email',
							'type'=>'raw',
							'value'=>'$data->email'
						),
						array(
							'name'=>'status',
							'type'=>'raw',
							'value'=>'ucfirst($data->status)',
							'filter'=>$dataProvider->model->statuses,
						),
						/*array(
							'name'=>'customer_group_id',
							'type'=>'raw',
							'value'=>'$data->group_rel->title',
							'filter'=>CHtml::listData(ModCustomerGroup::model()->findAll(), 'id', 'title')
						),
						array(
							'name'=>'type',
							'type'=>'raw',
							'value'=>'ucfirst($data->type)'
						),*/
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
											'url'=>'Yii::app()->createUrl(\'vendor/vCustomer/manage\',array(\'id\'=>$data->id))',
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
				<?php echo $this->renderPartial('_form_customer',array('model'=>$model));?>
			</div>
			<div id="category" class="tab-pane">
				<?php echo $this->renderPartial('_group',array('dataProvider'=>$groupProvider));?>
			</div>
			<div id="new-category" class="tab-pane">
				<?php echo $this->renderPartial('_form_group',array('model'=>$model2));?>
			</div>
		</div>
	</div>
</div>
