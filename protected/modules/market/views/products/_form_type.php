<div class="alert alert-success hide">
	<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
	<span id="tmessage"></span>
</div>
<?php $form=$this->beginWidget('CActiveForm',array(
			'id'=>'type-form',
	)); ?>

	<?php echo $form->errorSummary($model,null,null,array('class'=>'alert alert-warning alert-block alert-dismissable fade in')); ?>
	
	<div class="form-group col-sm-6">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>80,'maxlength'=>128,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="form-group col-sm-3">
		<?php echo $form->labelEx($model,'code'); ?>
		<?php echo $form->textField($model,'code',array('size'=>80,'maxlength'=>128,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'code'); ?>
	</div>

	<div class="form-group col-sm-3">
		<?php echo $form->labelEx($model,'position'); ?>
		<?php echo $form->textField($model,'position',array('size'=>80,'maxlength'=>128,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'position'); ?>
	</div>

	<?php echo $form->hiddenField($model,'type',array('value'=>'ProductType'));?>

	<div class="form-group buttons col-md-12">
		<?php 
		if($model->isNewRecord):
			echo CHtml::ajaxSubmitButton(Yii::t('global', 'Save'),CHtml::normalizeUrl(array('products/createType')),array('dataType'=>'json','success'=>'js:
				function(data){
					if(data.status=="success"){
						$("#tmessage").html(data.div);
						$("#tmessage").parent().removeClass("hide");
						$.fn.yiiGridView.update("product-type-grid", {
							data: $(this).serialize()
						});
						return false;
					}else{
						$("form[id=\'type-form\']").parent().html(data.div);
					}
					return false;
				}'
			),
			array('style'=>'width:100px','class'=>'btn btn-success','id'=>uniqid()));
		else:
			echo CHtml::ajaxSubmitButton(Yii::t('global', 'Update'),
				CHtml::normalizeUrl(array('products/updateType','id'=>$model->id)),
				array(
					'dataType'=>'json',
					'success'=>'js:
					function(data){
						if(data.status=="success"){
							$("#tmessage").html(data.div);
							$("#tmessage").parent().removeClass("hide");
							$.fn.yiiGridView.update("product-type-grid", {
								data: $(this).serialize()
							});
							return false;
						}else{
							$("form[id=\'type-form\']").parent().html(data.div);
						}
						return false;
					}'
			),
			array('style'=>'width:100px','class'=>'btn btn-success','id'=>uniqid()));
		endif;
		?>
	</div>

<?php $this->endWidget(); ?>
