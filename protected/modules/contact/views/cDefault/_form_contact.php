<div class="alert alert-success hide">
	<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
	<span id="contact-message"></span>
</div>

<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'contact-form',
		'enableAjaxValidation'=>false,
		'htmlOptions'=>array('class'=>'form-horizontal')
)); ?>

	<?php echo $form->errorSummary($model,null,null,array('class'=>'alert alert-warning alert-block alert-dismissable fade in')); ?>

	<div class="form-group">
			<?php echo $form->labelEx($model,'name',array('class'=>'col-md-3')); ?>
			<div class="col-md-6">
				<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>128,'class'=>'form-control')); ?>
				<?php echo $form->error($model,'name'); ?>
			</div>
	</div>
	<div class="form-group">
			<?php echo $form->labelEx($model,'email',array('class'=>'col-md-3')); ?>
			<div class="col-md-6">
				<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>128,'class'=>'form-control')); ?>
				<?php echo $form->error($model,'email'); ?>
			</div>
	</div>
	<div class="form-group">
			<?php echo $form->labelEx($model,'phone',array('class'=>'col-md-3')); ?>
			<div class="col-md-6">
				<?php echo $form->textField($model,'phone',array('size'=>60,'maxlength'=>128,'class'=>'form-control')); ?>
				<?php echo $form->error($model,'phone'); ?>
			</div>
	</div>
	<div class="form-group">
			<?php echo $form->labelEx($model,'address',array('class'=>'col-md-3')); ?>
			<div class="col-md-9">
				<?php echo $form->textField($model,'address',array('size'=>128,'maxlength'=>128,'class'=>'form-control')); ?>
				<?php echo $form->error($model,'address'); ?>
			</div>
	</div>
	<div class="form-group">
			<?php echo $form->labelEx($model,'subject',array('class'=>'col-md-3')); ?>
			<div class="col-md-6">
				<?php echo $form->textField($model,'subject',array('size'=>60,'maxlength'=>128,'class'=>'form-control')); ?>
				<?php echo $form->error($model,'subject'); ?>
			</div>
	</div>
	<div class="form-group">
			<?php echo $form->labelEx($model,'message',array('class'=>'col-md-3')); ?>
			<div class="col-md-9">
				<?php echo $form->textArea($model,'message',array('rows'=>3,'class'=>'form-control')); ?>
				<?php echo $form->error($model,'message'); ?>
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
						'id'=>'contact-submit-btn',
						'href'=>CHtml::normalizeUrl(array('cDefault/create'))
					)
				);
			else:
				echo CHtml::submitButton(
					Yii::t('global', 'Update'),
					array(
						'style'=>'width:100px',
						'class'=>'btn btn-success',
						'id'=>'contact-submit-btn',
						'href'=>CHtml::normalizeUrl(array('cDefault/update','id'=>$model->id))
					)
				);
			endif;
			?>
	</div>

<?php $this->endWidget(); ?>
<script type="text/javascript">
$(function(){
	$('#contact-submit-btn').click(function(){
		var formData = new FormData($('form[id="contact-form"]')[0]);
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
					$("#contact-message").html(data.div);
					$("#contact-message").parent().removeClass("hide");
					$.fn.yiiGridView.update('contact-grid', {
						data: $(this).serialize()
					})
					return false;
				}else{
					$("form[id='contact-form']").parent().html(data.div);
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
