<div class="alert alert-success hide">
	<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
	<span id="discount-message"></span>
</div>
<?php $form=$this->beginWidget('CActiveForm',array('id'=>'discount-form','htmlOptions'=>array('class'=>'form-horizontal'))); ?>

<?php echo $form->errorSummary(array($model),null,null,array('class'=>'alert alert-warning alert-block alert-dismissable fade in')); ?>

<div class="form-group">
	<?php echo $form->labelEx($model,'price',array('class'=>'col-md-3')); ?>
	<div class="col-md-4">
		<?php echo $form->textField($model,'price',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'price'); ?>
	</div>
</div>
	<div class="form-group">
		<?php echo $form->labelEx($model,'start_date',array('class'=>'col-md-3')); ?>
		<div class="col-md-3">
			<?php $this->widget('ext.CJuiDateTimePicker.CJuiDateTimePicker', array(
				'model'=>$model,
				'attribute'=>'start_date',
				'mode'=>'datetime',
				'options'=>array(
					'showAnim'=>'fold',
					'dateFormat'=>'yy-mm-dd',
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
			<?php $this->widget('ext.CJuiDateTimePicker.CJuiDateTimePicker', array(
				'model'=>$model,
				'attribute'=>'end_date',
				'mode'=>'datetime',
				'options'=>array(
					'showAnim'=>'fold',
					'dateFormat'=>'yy-mm-dd',
				),
				'htmlOptions'=>array(
					'class'=>'form-control','placeholder'=>date("Y-m-d")
				),
				'value'=>$model->end_date,
			)); ?>
			<?php echo $form->error($model,'end_date'); ?>
		</div>
	</div>

<?php echo $form->hiddenField($model,'product_id',array('value'=>$product->id));?>
<?php echo $form->hiddenField($model,'id',array('value'=>$model->id));?>

<div class="form-group buttons col-md-12">
	<?php 
		echo CHtml::ajaxSubmitButton(Yii::t('global', 'Save'),CHtml::normalizeUrl(array('products/discount')),array('dataType'=>'json','success'=>'js:
				function(data){
					if(data.status=="success"){
						$("#discount-message").html(data.div);
						$("#discount-message").parent().removeClass("hide");
						return false;
					}else{
						$("form[id=\'discount-form\']").parent().html(data.div);
					}
					return false;
				}'
			),
			array('style'=>'width:100px','class'=>'btn btn-success','id'=>uniqid()));
	?>
</div>

<?php $this->endWidget(); ?>
