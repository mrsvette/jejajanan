<style>
.multiple {
  border: 1px solid #d5d5d5;
  height: 150px !important;
  padding: 5px;
  width: 100%;
}
#icon img{height:150px;}
#icon{margin-bottom:5px;}
</style>
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
			<?php echo $form->labelEx($model,'title'); ?>
			<?php echo $form->textField($model,'title',array('size'=>80,'maxlength'=>128,'class'=>'form-control')); ?>
			<?php echo $form->error($model,'title'); ?>
		</div>

		<div class="form-group">
			<?php echo $form->labelEx($model,'childs'); ?>
			<?php echo $form->dropDownList($model,'childs',$model->getItems(null),array('class'=>'form-control multiple','multiple'=>'multiple')); ?>
			<?php echo $form->error($model,'childs'); ?>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<?php echo $form->labelEx($model,'description'); ?>
			<?php echo $form->textArea($model,'description',array('class'=>'form-control'));?>
			<?php echo $form->error($model,'description'); ?>
		</div>
	</div>

	<div class="form-group buttons col-md-12">
		<?php 
		if($model->isNewRecord):
			echo CHtml::ajaxSubmitButton(Yii::t('global', 'Save'),CHtml::normalizeUrl(array('vProduct/createCategory')),array('dataType'=>'json','success'=>'js:
				function(data){
					if(data.status=="success"){
						$("#cmessage").html(data.div);
						$("#cmessage").parent().removeClass("hide");
						setTimeout(function(){
							$("#cmessage").parent().find(".close").trigger("click");
						},3000);
						$.fn.yiiGridView.update("category-grid", {
							data: $(this).serialize()
						});
						return false;
					}else{
						$("form[id=\'category-form\']").parent().html(data.div);
					}
					return false;
				}'
			),
			array('style'=>'width:100px','class'=>'btn btn-success','id'=>uniqid()));
		else:
			echo CHtml::ajaxSubmitButton(Yii::t('global', 'Update'),CHtml::normalizeUrl(array('vProducts/updateCategory','id'=>$model->id)),array('dataType'=>'json','success'=>'js:
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
