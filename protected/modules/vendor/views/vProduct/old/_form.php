<div class="alert alert-success hide">
	<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
	<span id="message"></span>
</div>
<?php $form=$this->beginWidget('CActiveForm',array('id'=>'product-form')); ?>

	<?php echo $form->errorSummary($model,null,null,array('class'=>'alert alert-warning alert-block alert-dismissable fade in')); ?>
	<div class="form-group col-md-6">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>80,'maxlength'=>128,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="form-group col-md-6">
		<?php echo $form->labelEx($model,'product_category_id'); ?>
		<?php echo $form->dropDownList($model,'product_category_id', VProductCategory::getItems(),array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'product_category_id'); ?>
	</div>

	<div class="form-group col-md-12">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('class'=>'form-control'));?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="form-group buttons col-md-12">
		<?php 
		if($model->isNewRecord):
			echo CHtml::ajaxSubmitButton(Yii::t('global', 'Save'),CHtml::normalizeUrl(array('vProduct/create')),array('dataType'=>'json','success'=>'js:
				function(data){
					if(data.status=="success"){
						$("#message").html(data.div);
						$("#message").parent().removeClass("hide");
						setTimeout(function(){
							$("#message").parent().find(".close").trigger("click");
						},3000);
						$.fn.yiiGridView.update("product-grid", {
							data: $(this).serialize()
						});
						return false;
					}else{
						$("form[id=\'product-form\']").parent().html(data.div);
					}
					return false;
				}'
			),
			array('style'=>'width:100px','class'=>'btn btn-success','id'=>uniqid()));
		else:
			echo CHtml::ajaxSubmitButton(Yii::t('global', 'Update'),CHtml::normalizeUrl(array('vProducts/update','id'=>$model->id)),array('dataType'=>'json','success'=>'js:
				function(data){
					if(data.status=="success"){
						$("#message").html(data.div);
						$("#message").parent().removeClass("hide");
						setTimeout(function(){
							$("#message").parent().find(".close").trigger("click");
						},3000);
						return false;
					}else{
						$("form[id=\'product-form\']").parent().html(data.div);
					}
					return false;
				}'
			),
			array('style'=>'width:100px','class'=>'btn btn-success','id'=>uniqid()));
		endif;
		?>
	</div>

<?php $this->endWidget(); ?>
