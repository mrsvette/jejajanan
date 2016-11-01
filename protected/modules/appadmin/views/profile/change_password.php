<?php
$this->breadcrumbs=array(
	ucfirst(Yii::app()->controller->module->id)=>array('/'.Yii::app()->controller->module->id.'/'),
	'Profile'=>array('update'),
	Yii::t('global','Change').' Password',
);

$this->menu=array(
	array('label'=>Yii::t('menu','Account Setting'), 'url'=>array('update')),
);
?>

<div class="panel panel-default">
	<div class="panel-heading">
		<h4 class="panel-title"><?php echo Yii::t('global','Change');?> Password</h4>
	</div>
	<div class="panel-body">
		<?php if(Yii::app()->user->hasFlash('changepass')): ?>
		<div class="alert alert-success">
			<?php echo Yii::app()->user->getFlash('changepass'); ?>
		</div>
		<?php endif; ?>

		<div class="form wide">
			<?php $form=$this->beginWidget('CActiveForm', array(
					'id'=>'changepass-form',
					'enableAjaxValidation'=>false,
			)); ?>

			<p class="note"><?php echo Yii::t('global','Fields with <span class="required">*</span> are required.');?></p>
			
			<?php echo $form->errorSummary($model); ?>

			<div class="form-group row">
				<?php echo $form->labelEx($model,'passwordlm',array('class'=>'col-md-3')); ?>
				<div class="col-md-4">
				<?php echo $form->passwordField($model,'passwordlm'); ?>
				<?php echo $form->error($model,'passwordlm'); ?>
				</div>
			</div>

			<div class="form-group row">
				<?php echo $form->labelEx($model,'passwordbr',array('class'=>'col-md-3')); ?>
				<div class="col-md-4">
				<?php echo $form->passwordField($model,'passwordbr'); ?>
				<?php echo $form->error($model,'passwordbr'); ?>
				</div>
			</div>

			<div class="form-group row">
				<?php echo $form->labelEx($model,'passwordbr_repeat',array('class'=>'col-md-3')); ?>
				<div class="col-md-4">				
				<?php echo $form->passwordField($model,'passwordbr_repeat'); ?>
				<?php echo $form->error($model,'passwordbr_repeat'); ?>
				</div>
			</div>
			
			<?php if(CCaptcha::checkRequirements()): ?>
			<div class="form-group row">
				<?php echo $form->labelEx($model,'verifyCode',array('class'=>'col-md-3')); ?>
				<div class="col-md-4">				
				<?php $this->widget('CCaptcha',array('clickableImage'=>true,'buttonLabel'=>'','imageOptions'=>array('class'=>'captcha'))); ?>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-md-3">&nbsp;</label>
				<div class="col-md-4">	
				<?php echo $form->textField($model,'verifyCode'); ?>
				</div>
			</div>
			<?php endif; ?>

			<div class="form-group cbtn">
				<?php echo CHtml::submitButton(Yii::t('global','Save'),array('style'=>'min-width:100px;')); ?>
			</div>

			<?php $this->endWidget(); ?>
		</div>
	</div>
</div>
