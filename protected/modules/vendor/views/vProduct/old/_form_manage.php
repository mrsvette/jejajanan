<div class="alert alert-success hide">
	<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
	<span id="message"></span>
</div>
<?php $form=$this->beginWidget('CActiveForm',array('id'=>'general-form','htmlOptions'=>array('class'=>'form-horizontal'))); ?>

<?php echo $form->errorSummary(array($model,$model2),null,null,array('class'=>'alert alert-warning alert-block alert-dismissable fade in')); ?>

<div class="form-group">
	<?php echo $form->labelEx($model,'product_category_id',array('class'=>'col-md-3')); ?>
	<div class="col-md-4">
		<?php echo $form->dropDownList($model,'product_category_id',VProductCategory::getItems(),array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'product_category_id'); ?>
	</div>
</div>
<div class="form-group">
	<?php echo $form->labelEx($model,'status',array('class'=>'col-md-3')); ?>
	<div class="col-md-4">
		<?php echo $form->radioButtonList($model,'status',$model->statuses,array('template'=>'{input} {label}','separator'=>'')); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>
</div>
<div class="form-group">
	<?php echo $form->labelEx($model,'hidden',array('class'=>'col-md-3')); ?>
	<div class="col-md-4">
		<?php echo $form->radioButtonList($model,'hidden',$model->hiddenStatus,array('template'=>'{input} {label}','separator'=>'')); ?>
		<?php echo $form->error($model,'hidden'); ?>
	</div>
</div>
<div class="form-group hide">
	<?php echo $form->labelEx($model,'setup',array('class'=>'col-md-3')); ?>
	<div class="col-md-8">
		<?php echo $form->radioButtonList($model,'setup',$model->setupStatus,array('template'=>'{input} {label}','separator'=>'')); ?>
		<?php echo $form->error($model,'setup'); ?>
	</div>
</div>
<div class="form-group">
	<?php echo $form->labelEx($model,'title',array('class'=>'col-md-3')); ?>
	<div class="col-md-8">
		<?php echo $form->textField($model,'title',array('size'=>80,'maxlength'=>128,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>
</div>
<div class="form-group">
	<?php echo $form->labelEx($model,'slug',array('class'=>'col-md-3')); ?>
	<div class="col-md-8">
		<?php echo $form->textField($model,'slug',array('size'=>80,'maxlength'=>128,'class'=>'form-control','readOnly'=>true)); ?>
		<?php echo $form->error($model,'slug'); ?>
	</div>
</div>
<div class="form-group" id="once-price">
	<?php echo $form->labelEx($model2,'once_price',array('class'=>'col-md-3 mt20')); ?>
	<div class="col-md-3">
		<label><?php echo Yii::t('MarketModule.product','Price (IDR)'); ?></label>
		<?php echo $form->textField($model2,'once_price',array('size'=>80,'maxlength'=>128,'class'=>'form-control')); ?>
	</div>
	<div class="col-md-3">
		<label><?php echo Yii::t('MarketModule.product','Total'); ?></label>
		<?php echo $form->textField($model2,'total',array('size'=>80,'maxlength'=>128,'class'=>'form-control')); ?>
	</div>
</div>

<div class="form-group">
	<?php echo $form->labelEx($model,'description',array('class'=>'col-md-3')); ?>
	<div class="col-md-8">
		<?php echo $form->textArea($model,'description',array('class'=>'form-control'));?>
		<?php echo $form->error($model,'description'); ?>
	</div>
</div>

<div class="form-group buttons col-md-12">
	<?php 
		echo CHtml::ajaxSubmitButton(Yii::t('global', 'Update'),CHtml::normalizeUrl(array('vProduct/update','id'=>$model->id)),array('dataType'=>'json','success'=>'js:
				function(data){
					if(data.status=="success"){
						$("#message").html(data.div);
						$("#message").parent().removeClass("hide");
						return false;
					}else{
						$("form[id=\'general-form\']").parent().html(data.div);
					}
					return false;
				}'
			),
			array('style'=>'width:100px','class'=>'btn btn-success','id'=>uniqid()));
	?>
</div>

<?php $this->endWidget(); ?>
<script type="text/javascript">
$(function(){
	$('#ModProductPayment_type').find('input[type="radio"]:checked').trigger('change');
	$('#VProductPayment_once_price').keyup(function(){
		var price = $(this).val()*1;
		var setup_price = $('#VProductPayment_once_setup_price').val()*1;
		var tot_price = price + setup_price;
		$('#VProductPayment_total').val(tot_price);
	});
	$('#VProductPayment_once_setup_price').keyup(function(){
		var setup_price = $(this).val()*1;
		var price = $('#VProductPayment_once_price').val()*1;
		var tot_price = price + setup_price;
		$('#VProductPayment_total').val(tot_price);
	});
	$('#VProduct_title').keyup(function(){
		var title = $(this).val();
		$.ajax({
			url: "<?php echo Yii::app()->createUrl('/vendor/vProduct/createSlug');?>",
			type: 'POST',
			dataType: 'json',
			data: {'title':title},
			success: function (data) {
				if(data.status=="success"){
					$("#VProduct_slug").val(data.div);
					return false;
				}
			},
		});
	});
});
</script>
