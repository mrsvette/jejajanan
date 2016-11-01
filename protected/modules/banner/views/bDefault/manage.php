<?php
$this->breadcrumbs=array(
	ucfirst(Yii::app()->controller->module->id)=>array('/'.Yii::app()->controller->module->id.'/'),
	Yii::t('global','Manage').' '.Yii::t('BannerModule.banner','Banner'),
);

$this->menu=array(
	array('label'=>Yii::t('global','List').' '.Yii::t('BannerModule.banner','Banner'), 'url'=>array('view')),
);
?>
<div class="panel panel-default">
	<div class="panel-heading">
		<h4 class="panel-title"><?php echo Yii::t('global','Manage').' '.Yii::t('BannerModule.banner','Banner');?> #<?php echo $model->id;?> <?php echo $model->name;?> </h4>
	</div>
	<div class="panel-body">
		<?php $this->renderPartial('_form_banner',array('model'=>$model));?>
	</div>
</div>
