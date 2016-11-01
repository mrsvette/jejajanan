<?php
$this->breadcrumbs=array(
	ucfirst(Yii::app()->controller->module->id)=>array('/'.Yii::app()->controller->module->id.'/'),
	Yii::t('global','Manage').' '.Yii::t('ContactModule.contact','Contact'),
);

$this->menu=array(
	array('label'=>Yii::t('global','List').' '.Yii::t('ContactModule.contact','Contact'), 'url'=>array('view')),
	array('label'=>Yii::t('global','Create').' '.Yii::t('ContactModule.contact','Contact'), 'url'=>'#new', 'linkOptions'=>array('data-toggle'=>'tab')),
);
?>

<div class="panel panel-default">
	<div class="panel-heading">
		<h4 class="panel-title"><?php echo Yii::t('global','Manage').' '.Yii::t('ContactModule.contact','Contact');?></h4>
	</div>
	<div class="panel-body">
		<ul class="nav nav-tabs">
			<li class="active">
				<a data-toggle="tab" href="#general">
					<strong><?php echo Yii::t('ContactModule.contact','Contact');?></strong>
				</a>
			</li>
			<li class="">
				<a data-toggle="tab" href="#new">
					<strong><?php echo Yii::t('global','Create').' '.Yii::t('ContactModule.contact','Contact');?></strong>
				</a>
			</li>
			<li class="">
				<a data-toggle="tab" href="#setting">
					<strong><?php echo Yii::t('ContactModule.contact','Contact Settings');?></strong>
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
					'id'=>'contact-grid',
					'afterAjaxUpdate' => 'reloadGrid',
					'columns'=>array(
						array(
							'value'=>'$this->grid->dataProvider->getPagination()->getOffset()+$row+1',
						),
						array(
							'name'=>'name',
							'type'=>'raw',
							'value'=>'($data->status==0)? "<b>".$data->name."</b>":$data->name',
						),
						array(
							'name'=>'email',
							'type'=>'raw',
							'value'=>'($data->status==0)? "<b>".$data->email."</b>":$data->email',
						),
						array(
							'name'=>'phone',
							'type'=>'raw',
							'value'=>'($data->status==0)? "<b>".$data->phone."</b>":$data->phone',
						),
						array(
							'name'=>'address',
							'type'=>'raw',
							'value'=>'($data->status==0)? "<b>".$data->address."</b>":$data->address',
						),
						array(
							'name'=>'date_entry',
							'type'=>'raw',
							'value'=>'($data->status==0)? "<b>".$data->date_entry."</b>":$data->date_entry',
						),
						array(
							'class'=>'CButtonColumn',
							'template'=>'{detail}{view}{delete}',
							'buttons'=>array
								(
									'detail'=>array(
											'label'=>'<i class="fa fa-search"></i>',
											'imageUrl'=>false,
											'options'=>array('title'=>'Detail'),
											'url'=>'Yii::app()->createUrl(\'contact/cDefault/detail\',array(\'id\'=>$data->id))',
											'visible'=>'Rbac::ruleAccess(\'read_p\')',
										),
									'view'=>array(
											'label'=>'<i class="fa fa-pencil"></i>',
											'imageUrl'=>false,
											'options'=>array('title'=>'View'),
											'url'=>'Yii::app()->createUrl(\'contact/cDefault/manage\',array(\'id\'=>$data->id))',
											'visible'=>'Rbac::ruleAccess(\'read_p\')',
										),
									'delete'=>array(
											'label'=>'<i class="fa fa-trash-o"></i>',
											'imageUrl'=>false,
											'options'=>array('title'=>'Delete'),
											'visible'=>'Rbac::ruleAccess(\'delete_p\')',
										),
								),
							'htmlOptions'=>array('style'=>'width:10%;','class'=>'table-action'),
						),
					),
				)); ?>
				</div>
			</div>
			<div id="new" class="tab-pane">
				<?php echo $this->renderPartial('_form_contact',array('model'=>new ModContact('create')));?>
			</div>
			<div id="setting" class="tab-pane">
				<?php echo $this->renderPartial('_form_setting',array('model'=>$setting));?>
			</div>
		</div>
	</div>
</div>
