<?php $this->pageSection = 'author Login'; ?>
<?php
$this->breadcrumbs = array(
	ucfirst(Yii::app()->controller->module->id) => array('/'.Yii::app()->controller->module->id.'/'),
	Yii::t('OutletModule.outlet','Login'),
);
?>
<div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-12">
	<div class="rs_user_dashboard_tab_heading">
			<h4><?php echo Yii::t('OutletModule.outlet','Please enter your login detail');?></h4>
	</div>
	<div class="rs_user_dashboard_tab_info">
			<?php if(Yii::app()->user->hasFlash('login')): ?>
			<div class="alert alert-success alert-block">
				<?php 
					header('refresh: 2; url='.Yii::app()->user->returnUrl);
					echo Yii::app()->user->getFlash('login'); 
				?>
			</div>
			<?php endif; ?>	
			<?php $form=$this->beginWidget('CActiveForm', array(
					'id'=>'login-form',
					'enableClientValidation'=>true,
					'clientOptions'=>array(
						'validateOnSubmit'=>true,
					),
				)); ?>
		
			<?php echo $form->errorSummary($model,null,null,array('class'=>'alert alert-warning alert-block alert-dismissable fade in')); ?>
			<div class="form-group">
				<?php echo $form->labelEx($model,'email');?>
				<?php echo $form->textField($model,'email',array('class'=>'form-control input-lg')); ?>
			</div>
			<div class="form-group">
				<?php echo $form->labelEx($model,'password');?>
				<?php echo $form->passwordField($model,'password',array('class'=>'form-control input-lg')); ?>
				<span class="help-block">
				<?php echo CHtml::link(Yii::t('OutletModule.outlet','Have a problem with your login account?'),'#',array('class'=>'request-password'));?>
				</span>
			</div>
			<div class="submit_section">
				<?php echo CHtml::submitButton(Yii::t('global','Login'),array('style'=>'min-width:100px;','id'=>'tombol','class'=>'btn btn-info btn-block btn-lg')); ?>
			</div>
		    <?php $this->endWidget(); ?>
	</div>
</div>
