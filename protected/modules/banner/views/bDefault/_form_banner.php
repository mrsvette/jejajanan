<style>
#ModBanner_status input {float:left;margin-right:10px;}
#ModBanner_status label {width:20%;float:left;}
</style>
<div class="alert alert-success hide">
	<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
	<span id="banner-message"></span>
</div>

<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'banner-form',
		'enableAjaxValidation'=>false,
		'htmlOptions'=>array('class'=>'form-horizontal','enctype' =>'multipart/form-data'),
)); ?>


	<?php echo $form->errorSummary($model,null,null,array('class'=>'alert alert-warning alert-block alert-dismissable fade in')); ?>

	<div class="form-group">
		<?php echo $form->labelEx($model,'name',array('class'=>'col-md-3')); ?>
		<div class="col-md-4">
			<?php if($model->isNewRecord):?>
				<?php echo $form->textField($model,'name',array('class'=>'form-control')); ?>
			<?php else:?>
				<?php echo $form->textField($model,'name',array('class'=>'form-control','readOnly'=>true)); ?>
			<?php endif;?>
			<?php echo $form->error($model,'name'); ?>
		</div>
	</div>
	<div class="form-group">
		<?php echo $form->labelEx($model,'description',array('class'=>'col-md-3')); ?>
		<div class="col-md-9">
			<?php echo $form->textArea($model,'description',array('class'=>'form-control')); ?>
			<?php echo $form->error($model,'description'); ?>
		</div>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'image',array('class'=>'col-md-3')); ?>
		<div class="col-md-9">
			<?php if(!$model->isNewRecord):?>
				<?php echo CHtml::image(Yii::app()->request->baseUrl.'/'.$model->thumb.$model->image,'',array('class'=>'mb10'));?>
			<?php endif;?>
			<?php echo $form->fileField($model,'image',array('class'=>'')); ?>
			<?php echo $form->error($model,'image'); ?>
		</div>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'url',array('class'=>'col-md-3')); ?>
		<div class="col-md-5">
			<?php echo $form->textField($model,'url',array('class'=>'form-control','placeholder'=>'http://www.domain-name.com')); ?>
			<?php echo $form->error($model,'url'); ?>
		</div>
	</div>
	<div class="form-group">
		<?php echo $form->labelEx($model,'start_date',array('class'=>'col-md-3')); ?>
		<div class="col-md-3">
			<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
				'model'=>$model,
				'attribute'=>'start_date',
				'options'=>array(
					'showAnim'=>'fold',
				),
				'htmlOptions'=>array(
					'class'=>'form-control','placeholder'=>date("Y-m-d")
				),
				'value'=>$model->start_date,
			)); ?>
			<?php echo $form->error($model,'start_date'); ?>
		</div>
	</div>
	<div class="form-group">
		<?php echo $form->labelEx($model,'end_date',array('class'=>'col-md-3')); ?>
		<div class="col-md-3">
			<?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
				'model'=>$model,
				'attribute'=>'end_date',
				'options'=>array(
					'showAnim'=>'fold',
				),
				'htmlOptions'=>array(
					'class'=>'form-control','placeholder'=>date("Y-m-d")
				),
				'value'=>$model->end_date,
			)); ?>
			<?php echo $form->error($model,'end_date'); ?>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-3">Image Size</label>
		<div class="col-md-2">
			<div class="input-group">
				<?php if($model->isNewRecord):?>
					<?php echo $form->textField($model,'config[image_width]',array('class'=>'form-control','placeholder'=>'width')); ?>
				<?php else:?>
					<?php echo $form->textField($model,'config[image_width]',array('class'=>'form-control','placeholder'=>'width','readOnly'=>true)); ?>
				<?php endif;?>
				<span class="input-group-addon">px</span>
			</div>
		</div>
		<div class="col-md-2">
			<div class="input-group">
				<?php if($model->isNewRecord):?>
					<?php echo $form->textField($model,'config[image_height]',array('class'=>'form-control','placeholder'=>'height')); ?>
				<?php else:?>
					<?php echo $form->textField($model,'config[image_height]',array('class'=>'form-control','placeholder'=>'height','readOnly'=>true)); ?>
				<?php endif;?>
				<span class="input-group-addon">px</span>
			</div>
		</div>
		<?php echo $form->error($model,'config'); ?>
	</div>
	<div class="form-group">
		<?php echo $form->labelEx($model,'status',array('class'=>'col-md-3')); ?>
		<div class="col-md-5">
			<?php echo $form->radioButtonList($model,'status',$model->getStatuses(0,true),array('template'=>'{input} {label}','separator'=>'')); ?>
			<?php echo $form->error($model,'status'); ?>
		</div>
	</div>

	<div class="form-group buttons col-md-12">
		<?php 
			if($model->isNewRecord):
				echo CHtml::submitButton(
					Yii::t('global', 'Create'),
					array(
						'style'=>'width:100px',
						'class'=>'btn btn-success',
						'id'=>'banner-submit-btn',
						'href'=>CHtml::normalizeUrl(array('bDefault/create'))
					)
				);
			else:
				echo CHtml::submitButton(
					Yii::t('global', 'Update'),
					array(
						'style'=>'width:100px',
						'class'=>'btn btn-success',
						'id'=>'banner-submit-btn',
						'href'=>CHtml::normalizeUrl(array('bDefault/update','id'=>$model->id))
					)
				);
			endif;
			?>
	</div>

<?php $this->endWidget(); ?>
<script type="text/javascript">
$(function(){
	$('#banner-submit-btn').click(function(){
		var formData = new FormData($('form[id="banner-form"]')[0]);
		$.ajax({
			beforeSend: function() { Loading.show(); },
			complete: function() { Loading.hide(); },
			url: $(this).attr('href'),
			type: 'POST',
			data: formData,
			dataType: 'json',
			async: false,
			success: function (data) {
				if(data.status=="success"){
					$("#banner-message").html(data.div);
					$("#banner-message").parent().removeClass("hide");
					$.fn.yiiGridView.update('banner-grid', {
						data: $(this).serialize()
					})
					return false;
				}else{
					$("form[id='banner-form']").parent().html(data.div);
				}
			},
			cache: false,
			contentType: false,
			processData: false
		});
		return false;
	});

	$('.nav-banner').find('li:first').addClass('active');
	$('.tab-pane-banner:first').addClass('active');

	$('#banner-image').change(function(){
		var formData = new FormData($('form[id="banner-form"]')[0]);
		$.ajax({
			beforeSend: function() { Loading.show(); },
			complete: function() { Loading.hide(); },
			url: $(this).attr('href'),
			type: 'POST',
			data: formData,
			dataType: 'json',
			async: false,
			success: function (data) {
				if(data.status=="success"){
					$.fn.yiiGridView.update('banner-image-grid');
					return false;
				}else{
					//$("form[id='banner-form']").parent().html(data.div);
				}
			},
			cache: false,
			contentType: false,
			processData: false
		});
		return false;
	});
});
</script>
