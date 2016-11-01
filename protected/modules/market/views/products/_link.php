<div class="alert alert-success hide">
	<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
	<span id="link-message"></span>
</div>
<?php $form=$this->beginWidget('CActiveForm',array('id'=>'link-form','htmlOptions'=>array('class'=>'form-horizontal'))); ?>

<?php echo $form->errorSummary(array($model),null,null,array('class'=>'alert alert-warning alert-block alert-dismissable fade in')); ?>

<div class="form-group">
	<?php echo $form->labelEx($model,'related_id',array('class'=>'col-md-3')); ?>
	<div class="col-md-4">
		<?php echo $form->dropDownList($model,'related_id',ModProduct::getListItems($product->id),array('class'=>'form-control multiple','multiple'=>'multiple')); ?>
		<?php echo $form->error($model,'related_id'); ?>
	</div>
</div>
<?php echo $form->hiddenField($model,'product_id',array('value'=>$product->id));?>

<div class="form-group buttons col-md-12">
	<?php 
		echo CHtml::ajaxSubmitButton(Yii::t('global', 'Save'),CHtml::normalizeUrl(array('products/related','id'=>$product->id)),array('dataType'=>'json','success'=>'js:
				function(data){
					if(data.status=="success"){
						$("#link-message").html(data.div);
						$("#link-message").parent().removeClass("hide");
						return false;
					}else{
						$("form[id=\'link-form\']").parent().html(data.div);
					}
					return false;
				}'
			),
			array('style'=>'width:100px','class'=>'btn btn-success','id'=>uniqid()));
	?>
</div>

<?php $this->endWidget(); ?>
