<div class="alert alert-success hide">
	<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
	<span id="cmessage"></span>
</div>
<?php $form=$this->beginWidget('CActiveForm',array(
			'id'=>'category-form',
	)); ?>

	<?php echo $form->errorSummary($model,null,null,array('class'=>'alert alert-warning alert-block alert-dismissable fade in')); ?>
	<div class="col-md-6">
		<div class="form-group">
			<?php echo $form->labelEx($model2,'name'); ?>
			<?php echo $form->textField($model2,'name',array('size'=>80,'maxlength'=>128,'class'=>'form-control')); ?>
			<?php echo $form->error($model2,'name'); ?>
		</div>
		<div class="form-group">
			<?php echo $form->labelEx($model2,'description'); ?>
			<?php echo $form->textArea($model2,'description',array('class'=>'form-control'));?>
			<?php echo $form->error($model2,'description'); ?>
		</div>
		<div class="form-group">
			<?php echo $form->labelEx($model2,'meta_title'); ?>
			<?php echo $form->textField($model2,'meta_title',array('size'=>80,'maxlength'=>128,'class'=>'form-control')); ?>
			<?php echo $form->error($model2,'meta_title'); ?>
		</div>
		<div class="form-group">
			<?php echo $form->labelEx($model2,'meta_keyword'); ?>
			<?php echo $form->textField($model2,'meta_keyword',array('size'=>80,'maxlength'=>128,'class'=>'form-control')); ?>
			<?php echo $form->error($model2,'meta_keyword'); ?>
		</div>
		<div class="form-group">
			<?php echo $form->labelEx($model2,'meta_description'); ?>
			<?php echo $form->textArea($model2,'meta_description',array('class'=>'form-control')); ?>
			<?php echo $form->error($model2,'meta_description'); ?>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<?php echo $form->labelEx($model,'parent_id'); ?>
			<?php echo $form->dropDownList($model,'parent_id',$model->getItems('-'), array('class'=>'form-control')); ?>
			<?php echo $form->error($model,'parent_id'); ?>
		</div>
		<div class="form-group">
			<?php echo $form->labelEx($model,'sort_order'); ?>
			<?php echo $form->textField($model,'sort_order', array('class'=>'form-control')); ?>
			<?php echo $form->error($model,'sort_order'); ?>
		</div>
		<div class="form-group">
			<?php echo $form->labelEx($model,'status'); ?>
			<?php echo $form->dropDownList($model,'status',$model->getTextStatus('list'), array('class'=>'form-control')); ?>
			<?php echo $form->error($model,'status'); ?>
		</div>
		<?php if(!$model->isNewRecord):?>
		<div class="form-group">
			<?php echo $form->labelEx($model,'image'); ?>
			<div id="img-area">
				<?php echo CHtml::image(Yii::app()->request->baseUrl.'/'.$model->image);?>
			</div>
			<?php echo $form->fileField($model,'image',array('class'=>'')); ?>
			<?php echo $form->error($model,'image'); ?>
		</div>
		<?php endif; ?>
	</div>

	<div class="form-group buttons col-md-12">
		<?php 
		if($model->isNewRecord):
			echo CHtml::ajaxSubmitButton(Yii::t('global', 'Save'),CHtml::normalizeUrl(array('vCategory/create')),array('dataType'=>'json','success'=>'js:
				function(data){
					if(data.status=="success"){
						$("#cmessage").html(data.div);
						$("#cmessage").parent().removeClass("hide");
						setTimeout(function(){
							//$("#cmessage").parent().find(".close").trigger("click");
							window.location.reload(true);
						},3000);
						/*$.fn.yiiGridView.update("category-grid", {
							data: $(this).serialize()
						});*/
						return false;
					}else{
						$("form[id=\'category-form\']").parent().html(data.div);
					}
					return false;
				}'
			),
			array('style'=>'width:100px','class'=>'btn btn-success','id'=>uniqid()));
		else:
			echo CHtml::ajaxSubmitButton(Yii::t('global', 'Update'),CHtml::normalizeUrl(array('vCategory/update','id'=>$model->id)),array('dataType'=>'json','success'=>'js:
				function(data){
					if(data.status=="success"){
						$("#cmessage").html(data.div);
						$("#cmessage").parent().removeClass("hide");
						return false;
					}else{
						$("form[id=\'category-form\']").parent().html(data.div);
					}
					return false;
				}'
			),
			array('style'=>'width:100px','class'=>'btn btn-success','id'=>uniqid()));
		endif;
		?>
	</div>

<?php $this->endWidget(); ?>
<script type="text/javascript">
$(function(){
	$('#VCategory_image').change(function(){
		var formData = new FormData($('form[id="category-form"]')[0]);
		$.ajax({
			beforeSend: function() { Loading.show(); },
			complete: function() { Loading.hide(); },
			url: "<?php echo Yii::app()->createUrl('/vendor/vCategory/uploadImage',array('id'=>$model->id));?>",
			type: 'POST',
			data: formData,
			dataType: 'json',
			async: false,
			success: function (data) {
				if(data.status=="success"){
					$('#img-area').html(data.image);
				}else{
					$("form[id='category-form']").parent().html(data.div);
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
