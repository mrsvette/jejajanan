<?php
$this->breadcrumbs=array(
	ucfirst(Yii::app()->controller->module->id)=>array('/'.Yii::app()->controller->module->id.'/'),
	Yii::t('global','Manage').' '.Yii::t('BannerModule.banner','Banner'),
);

$this->menu=array(
	array('label'=>Yii::t('global','List').' '.Yii::t('BannerModule.banner','Banner'), 'url'=>array('view')),
	array('label'=>Yii::t('global','Create').' '.Yii::t('BannerModule.banner','Banner'), 'url'=>'#new', 'linkOptions'=>array('data-toggle'=>'tab')),
);
?>

<div class="panel panel-default">
	<div class="panel-heading">
		<h4 class="panel-title"><?php echo Yii::t('global','Manage').' '.Yii::t('BannerModule.banner','Banner');?></h4>
	</div>
	<div class="panel-body">
		<ul class="nav nav-tabs">
			<li class="active">
				<a data-toggle="tab" href="#general">
					<strong><?php echo Yii::t('BannerModule.banner','Banner');?></strong>
				</a>
			</li>
			<li class="">
				<a data-toggle="tab" href="#new">
					<strong><?php echo Yii::t('global','Create').' '.Yii::t('BannerModule.banner','Banner');?></strong>
				</a>
			</li>
			<li class="">
				<a data-toggle="tab" href="#setting">
					<strong><?php echo Yii::t('BannerModule.banner','Banner Settings');?></strong>
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
					'id'=>'banner-grid',
					'afterAjaxUpdate' => 'reloadGrid',
					'columns'=>array(
						array(
							'value'=>'$this->grid->dataProvider->getPagination()->getOffset()+$row+1',
						),
						array(
							'name'=>'name',
							'type'=>'raw',
							'value'=>'CHtml::link(CHtml::encode($data->name), $data->url)."<br/>".
								CHtml::image(Yii::app()->request->baseUrl."/".$data->thumb.$data->image)',
						),
						array(
							'header'=>'Usage',
							'value'=>'$data->usage',
						),
						array(
							'name'=>'status',
							'value'=>'ModBanner::getStatuses($data->status)',
							'filter'=>$dataProvider->model->getStatuses(0,true),
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
											'url'=>'Yii::app()->createUrl(\'banner/bDefault/manage\',array(\'id\'=>$data->id))',
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
				<?php echo $this->renderPartial('_form_banner',array('model'=>new ModBanner('create')));?>
			</div>
			<div id="setting" class="tab-pane">
				<?php echo $this->renderPartial('_form_setting',array('model'=>$setting));?>
			</div>
		</div>
	</div>
</div>
