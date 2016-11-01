<?php $this->pageSection = 'author Profile'; ?>
<?php
$this->breadcrumbs = array(
	ucfirst(Yii::app()->controller->module->id) => array('/'.Yii::app()->controller->module->id.'/'),
	Yii::t('VendorModule.vendor','Profile'),
);
?>

<div class="rs_user_profile_tab">
	<div class="tab-content">
		<div class="tab-pane active" id="profile">
			<div class="rs_user_dashboard_tab_heading">
				<h4><?php echo Yii::t('VendorModule.vendor','Your Profile');?></h4>
			</div>

			<div class="rs_user_dashboard_tab_info">
				<?php if(Yii::app()->user->hasFlash('update')): ?>
				<div class="alert alert-success">
					<button class="close" data-dismiss="alert" type="button">×</button>
					<?php echo Yii::app()->user->getFlash('update'); ?>
				</div>
				<?php endif; ?>

				<?php $form=$this->beginWidget('CActiveForm', array(
					'id'=>'profile-form',
					'enableClientValidation'=>true,
					'clientOptions'=>array(
						'validateOnSubmit'=>true,
					),
				)); ?>
		
			<?php echo $form->errorSummary($model,null,null,array('class'=>'alert alert-warning alert-block alert-dismissable fade in')); ?>
			<div class="form-group row">
				<?php echo $form->labelEx($model,'company',array('class'=>'col-sm-3'));?>
				<div class="col-sm-9">
					<?php echo $form->textField($model,'company',array('class'=>'form-control input-md')); ?>
				</div>
			</div>
			<div class="form-group row">
				<?php echo $form->labelEx($model,'full_name',array('class'=>'col-sm-3'));?>
				<div class="col-sm-4">
					<?php echo $form->textField($model,'first_name',array('class'=>'form-control input-md')); ?>
				</div>
				<div class="col-sm-5">
					<?php echo $form->textField($model,'last_name',array('class'=>'form-control input-md')); ?>
				</div>
			</div>
			<div class="form-group row">
				<?php echo $form->labelEx($model,'email',array('class'=>'col-sm-3'));?>
				<div class="col-sm-9">
					<?php echo $form->textField($model,'email',array('class'=>'form-control input-md')); ?>
				</div>
			</div>
			<div class="form-group row">
				<?php echo $form->labelEx($model,'gender',array('class'=>'col-sm-3'));?>
				<div class="col-sm-4">
					<?php echo $form->dropDownList($model,'gender',array('male'=>'Male','female'=>'Female'),array('class'=>'form-control input-md')); ?>
				</div>
			</div>
			<div class="form-group row">
				<?php echo $form->labelEx($model,'birthday',array('class'=>'col-sm-3'));?>
				<div class="col-sm-4">
					<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
						'model'=>$model,
						'attribute'=>'birthday',
						'options'=>array(
							'showAnim'=>'fold',
						),
						'htmlOptions'=>array(
							'class'=>'form-control input-md','placeholder'=>date("Y-m-d")
						),
						'value'=>$model->birthday,
					)); ?>
				</div>
			</div>
			<div class="form-group row">
				<?php echo $form->labelEx($model,'phone',array('class'=>'col-sm-3'));?>
				<div class="col-sm-9">
					<?php echo $form->textField($model,'phone',array('class'=>'form-control input-md')); ?>
				</div>
			</div>
			<div class="form-group row">
				<?php echo $form->labelEx($model,'address_1',array('class'=>'col-sm-3'));?>
				<div class="col-sm-9">
					<?php echo $form->textField($model,'address_1',array('class'=>'form-control input-md')); ?>
				</div>
			</div>
			<div class="form-group row">
				<div class="col-sm-9 pull-right">
				<?php echo CHtml::submitButton(Yii::t('global','Update'),array('style'=>'min-width:100px;','id'=>'tombol','class'=>'btn btn-success btn-md')); ?>
				</div>
			</div>
		    <?php $this->endWidget(); ?>
			</div>
		</div>
	</div>
</div>
