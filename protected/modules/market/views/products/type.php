<?php
$this->breadcrumbs=array(
	ucfirst(Yii::app()->controller->module->id)=>array('/'.Yii::app()->controller->module->id.'/'),
	Yii::t('global','Manage').' '.Yii::t('MarketModule.product','Product'),
);

$this->menu=array(
	array('label'=>Yii::t('global','List').' '.Yii::t('MarketModule.product','Product Type'), 'url'=>array('view','tabs'=>'type')),
);
?>
<div class="panel panel-default">
	<div class="panel-heading">
		<h4 class="panel-title">#<?php echo $model->id;?> - <b><?php echo $model->name;?></b></h4>
	</div>
	<div class="panel-body">
		<ul class="nav nav-tabs">
			<li class="active">
				<a data-toggle="tab" href="#general">
					<strong><?php echo Yii::t('global','Update').' '.Yii::t('MarketModule.product','Product Type');?></strong>
				</a>
			</li>
			<li class="">
				<a data-toggle="tab" href="#list">
					<strong><?php echo Yii::t('global','List').' '.Yii::t('MarketModule.product','Product Type');?></strong>
				</a>
			</li>
		</ul>
		<div class="tab-content">
			<div id="general" class="tab-pane active">
				<div class="mt20"></div>
				<?php echo $this->renderPartial('_form_type',array('model'=>$model));?>
			</div>
			<div id="list" class="tab-pane">
				
				<div class="table-responsive">
				<?php $this->widget('zii.widgets.grid.CGridView', array(
					'dataProvider'=>$dataProvider,
					'itemsCssClass'=>'table table-striped mb30',
					'id'=>'product-type-grid',
					'afterAjaxUpdate' => 'reloadGrid',
					'columns'=>array(
						array(
							'value'=>'$this->grid->dataProvider->getPagination()->getOffset()+$row+1',
						),
						array(
							'name'=>'name',
							'type'=>'raw',
							'value'=>'$data->name'
						),
						array(
							'name'=>'code',
							'type'=>'raw',
							'value'=>'$data->code',
						),
						array(
							'name'=>'position',
							'type'=>'raw',
							'value'=>'$data->position',
						),
						array(
							'class'=>'CButtonColumn',
							'template'=>'{view}{delete}',
							'buttons'=>array
								(
									'view'=>array(
											'label'=>'<i class="fa fa-pencil"></i>',
											'imageUrl'=>false,
											'options'=>array('title'=>'Manage'),
											'url'=>'Yii::app()->createUrl(\'market/products/updateType\',array(\'id\'=>$data->id))',
											'visible'=>'Rbac::ruleAccess(\'read_p\')',
										),
									'delete'=>array(
											'label'=>'<i class="fa fa-trash-o"></i>',
											'imageUrl'=>false,
											'options'=>array('title'=>'Delete'),
											'url'=>'Yii::app()->createUrl(\'market/products/deleteType\',array(\'id\'=>$data->id))',
											'visible'=>'Rbac::ruleAccess(\'delete_p\')',
										),
								),
							'htmlOptions'=>array('style'=>'width:10%;','class'=>'table-action'),
						),
					),
				)); ?>
				</div>
			</div>
		</div>
	</div>
</div>
