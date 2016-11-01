<div class="alert alert-success hide">
	<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
	<span id="message"></span>
</div>
<?php $form=$this->beginWidget('CActiveForm',array('id'=>'order-form')); ?>

	<?php echo $form->errorSummary($model,null,null,array('class'=>'alert alert-warning alert-block alert-dismissable fade in')); ?>
	<div class="col-md-6">
		<div class="form-group">
			<?php echo $form->labelEx($model,'customer_id'); ?>
			<?php $this->widget('ext.bootstrap-select.TbSelect',array(
						'attribute'=>'customer_id',
						'model'=>$model,
						'data' => VCustomer::getItems('- Pilih Customer -'),
						'htmlOptions' => array(
							//'multiple' => true,
							'data-live-search'=>true,
							'class'=>'form-control no-margin',
						),
					)); 
			?>
			<?php echo $form->error($model,'customer_id'); ?>
		</div>

		<div class="form-group">
			<?php echo $form->labelEx($model,'product_id'); ?>
			<?php $this->widget('ext.bootstrap-select.TbSelect',array(
						'attribute'=>'product_id',
						'model'=>$model,
						'data' => VProduct::getItems('- Pilih Produk -'),
						'htmlOptions' => array(
							//'multiple' => true,
							'data-live-search'=>true,
							'class'=>'form-control no-margin',
						),
					)); 
			?>
			<?php echo $form->error($model,'product_id'); ?>
		</div>

	</div>
	<div class="col-md-6">
		<div class="form-group">
			<?php echo $form->labelEx($model,'promo_id'); ?>
			<?php echo $form->textField($model,'promo_id',array('size'=>80,'maxlength'=>128,'class'=>'form-control')); ?>
			<?php echo $form->error($model,'promo_id'); ?>
		</div>
		<div class="form-group">
			<?php echo $form->labelEx($model,'notes'); ?>
			<?php echo $form->textArea($model,'notes',array('class'=>'form-control','rows'=>4)); ?>
			<?php echo $form->error($model,'notes'); ?>
		</div>
	</div>
	<div class="form-group buttons col-md-12">
		<?php 
		if($model->isNewRecord):
			echo CHtml::ajaxSubmitButton(Yii::t('global', 'Save'),CHtml::normalizeUrl(array('vOrder/create')),array('dataType'=>'json','success'=>'js:
				function(data){
					if(data.status=="success"){
						$("#message").html(data.div);
						$("#message").parent().removeClass("hide");
						$.fn.yiiGridView.update("order-grid");
						setTimeout(function(){
							window.location.reload(true);
						},3000);
						return false;
					}else{
						$("form[id=\'order-form\']").parent().html(data.div);
					}
					return false;
				}'
			),
			array('style'=>'width:100px','class'=>'btn btn-success','id'=>uniqid()));
		else:
			echo CHtml::ajaxSubmitButton(Yii::t('global', 'Update'),CHtml::normalizeUrl(array('vOrder/update','id'=>$model->id)),array('dataType'=>'json','success'=>'js:
				function(data){
					if(data.status=="success"){
						$("#message").html(data.div);
						$("#message").parent().removeClass("hide");
						$.fn.yiiGridView.update("order-grid");
						return false;
					}else{
						$("form[id=\'order-form\']").parent().html(data.div);
					}
					return false;
				}'
			),
			array('style'=>'width:100px','class'=>'btn btn-success','id'=>uniqid()));
		endif;
		?>
	</div>

<?php $this->endWidget(); ?>
