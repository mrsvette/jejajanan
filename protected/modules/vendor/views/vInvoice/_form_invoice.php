<div class="alert alert-success hide">
	<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
	<span id="message"></span>
</div>
<?php $form=$this->beginWidget('CActiveForm',array('id'=>'invoice-form')); ?>

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
	</div>
	<div class="form-group buttons col-md-12">
		<?php 
		if($model->isNewRecord):
			echo CHtml::ajaxSubmitButton(Yii::t('global', 'Save'),CHtml::normalizeUrl(array('vInvoice/create')),array('dataType'=>'json','success'=>'js:
				function(data){
					if(data.status=="success"){
						$("#message").html(data.div);
						$("#message").parent().removeClass("hide");
						$.fn.yiiGridView.update("invoice-grid");
						setTimeout(function(){
							window.location.href = data.href;
						},3000);
						return false;
					}else{
						$("form[id=\'invoice-form\']").parent().html(data.div);
					}
					return false;
				}'
			),
			array('style'=>'width:100px','class'=>'btn btn-success','id'=>uniqid()));
		else:
			echo CHtml::ajaxSubmitButton(Yii::t('global', 'Update'),CHtml::normalizeUrl(array('vInvoice/update','id'=>$model->id)),array('dataType'=>'json','success'=>'js:
				function(data){
					if(data.status=="success"){
						$("#message").html(data.div);
						$("#message").parent().removeClass("hide");
						setTimeout(function(){
							window.location.reload(true);
						},3000);
						return false;
					}else{
						$("form[id=\'invoice-form\']").parent().html(data.div);
					}
					return false;
				}'
			),
			array('style'=>'width:100px','class'=>'btn btn-success','id'=>uniqid()));
		endif;
		?>
	</div>

<?php $this->endWidget(); ?>
