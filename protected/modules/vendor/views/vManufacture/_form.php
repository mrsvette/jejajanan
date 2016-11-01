<div class="alert alert-success hide">
	<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
	<span id="cmessage"></span>
</div>
<?php $form=$this->beginWidget('CActiveForm',array(
			'id'=>'manufacture-form',
			'htmlOptions'=>array('enctype' =>'multipart/form-data'),
	)); ?>

	<?php echo $form->errorSummary($model,null,null,array('class'=>'alert alert-warning alert-block alert-dismissable fade in')); ?>
	<div class="col-md-6">
		<div class="form-group">
			<?php echo $form->labelEx($model,'name'); ?>
			<?php echo $form->textField($model,'name',array('size'=>80,'maxlength'=>128,'class'=>'form-control')); ?>
			<?php echo $form->error($model,'name'); ?>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<?php echo $form->labelEx($model,'image'); ?>
			<?php if(!$model->isNewRecord):?>
			<div id="img-area">
				<?php echo CHtml::image(Yii::app()->request->baseUrl.'/'.$model->image);?>
			</div>
			<?php endif; ?>
			<?php echo $form->fileField($model,'image',array('class'=>'')); ?>
			<?php echo $form->error($model,'image'); ?>
		</div>
	</div>

	<div class="form-group buttons col-md-12">
		<?php echo CHtml::submitButton(($model->isNewRecord)? Yii::t('global', 'Save') : Yii::t('global', 'Update'),array('class'=>'btn btn-success'));?>
	</div>

<?php $this->endWidget(); ?>
<script type="text/javascript">
$(function(){
	$('form[id="manufacture-form"]').submit(function(){
		var formData = new FormData($('form[id="manufacture-form"]')[0]);
		var url = "<?php echo ($model->isNewRecord)? Yii::app()->createUrl('/vendor/vManufacture/create') : Yii::app()->createUrl('/vendor/vManufacture/update',array('id'=>$model->id));?>";
		var isNewRecord = "<?php echo $model->isNewRecord;?>";
		$.ajax({
			beforeSend: function() { Loading.show(); },
			complete: function() { Loading.hide(); },
			url: url,
			type: 'POST',
			data: formData,
			dataType: 'json',
			async: false,
			success: function (data) {
				if(data.status=="success"){
					$("#cmessage").html(data.div);
					$("#cmessage").parent().removeClass("hide");
					setTimeout(function(){
						window.location.reload(true);
					},3000);
					return false;
				}else{
					$("form[id='manufacture-form']").parent().html(data.div);
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
