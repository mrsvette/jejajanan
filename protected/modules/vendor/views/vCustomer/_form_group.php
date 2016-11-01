<style>
#VCustomerGroup_taxed input {float:left;margin-right:10px;}
#VCustomerGroup_taxed label {width:10%;float:left;}
</style>
<div class="alert alert-success hide">
	<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
	<span id="cmessage"></span>
</div>
<?php $form=$this->beginWidget('CActiveForm',array('id'=>'group-form')); ?>

	<?php echo $form->errorSummary($model,null,null,array('class'=>'alert alert-warning alert-block alert-dismissable fade in')); ?>
	<div class="form-group col-md-6">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>80,'maxlength'=>128,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>
	
	<div class="form-group col-md-6">
		<?php echo $form->labelEx($model,'taxed'); ?>
		<?php echo $form->radioButtonList($model,'taxed',array('No','Yes'),array('template'=>'{input} {label}','separator'=>'')); ?>
		<?php echo $form->error($model,'taxed'); ?>
	</div>

	<div class="form-group col-md-12">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="form-group buttons col-md-12">
		<?php 
		if($model->isNewRecord):
			echo CHtml::ajaxSubmitButton(Yii::t('global', 'Save'),CHtml::normalizeUrl(array('vCustomer/createGroup')),array('dataType'=>'json','success'=>'js:
				function(data){
					if(data.status=="success"){
						$("#cmessage").html(data.div);
						$("#cmessage").parent().removeClass("hide");
						$.fn.yiiGridView.update("group-grid");
						return false;
					}else{
						$("form[id=\'group-form\']").parent().html(data.div);
					}
					return false;
				}'
			),
			array('style'=>'width:100px','class'=>'btn btn-success','id'=>uniqid()));
		else:
			echo CHtml::ajaxSubmitButton(Yii::t('global', 'Update'),CHtml::normalizeUrl(array('vCustomer/updateGroup','id'=>$model->id)),array('dataType'=>'json','success'=>'js:
				function(data){
					if(data.status=="success"){
						$("#cmessage").html(data.div);
						$("#cmessage").parent().removeClass("hide");
						return false;
					}else{
						$("form[id=\'group-form\']").parent().html(data.div);
					}
					return false;
				}'
			),
			array('style'=>'width:100px','class'=>'btn btn-success','id'=>uniqid()));
		endif;
		?>
	</div>

<?php $this->endWidget(); ?>
