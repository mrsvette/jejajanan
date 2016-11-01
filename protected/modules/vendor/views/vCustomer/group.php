<?php
$this->breadcrumbs=array(
	ucfirst(Yii::app()->controller->module->id)=>array('/'.Yii::app()->controller->module->id.'/'),
	Yii::t('global','Manage').' '.Yii::t('VendorModule.customer','Customer'),
);

$this->menu=array(
	array('label'=>Yii::t('global','List').' '.Yii::t('VendorModule.customer','Customer'), 'url'=>array('index')),
);
?>

<div class="panel panel-default">
	<div class="panel-heading">
		<h4 class="panel-title"><?php echo Yii::t('global','Update').' '.Yii::t('VendorModule.customer','Group');?> <?php echo $model->id; ?></h4>
	</div>
	<div class="panel-body">
		<?php echo $this->renderPartial('_form_group', array('model'=>$model)); ?>
	</div>
</div>
