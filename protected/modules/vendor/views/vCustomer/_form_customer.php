<div class="alert alert-success hide">
	<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
	<span id="message"></span>
</div>
<?php $form=$this->beginWidget('CActiveForm',array('id'=>'customer-form')); ?>

	<?php echo $form->errorSummary($model,null,null,array('class'=>'alert alert-warning alert-block alert-dismissable fade in')); ?>
	<div class="form-group col-md-4">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>80,'maxlength'=>128,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="form-group col-md-4">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>80,'maxlength'=>128,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="form-group col-md-4">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php if($model->isNewRecord):?>
			<?php echo $form->passwordField($model,'password',array('size'=>80,'maxlength'=>128,'class'=>'form-control')); ?>
		<?php else:?>
			<?php echo $form->passwordField($model,'password',array('size'=>80,'maxlength'=>128,'class'=>'form-control','readOnly'=>true)); ?>
		<?php endif;?>
		<?php echo $form->error($model,'password'); ?>
	</div>

	<div class="form-group col-md-4">
		<?php echo $form->labelEx($model,'gender'); ?>
		<?php echo $form->dropDownList($model,'gender',$model->genders,array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'gender'); ?>
	</div>

	<div class="form-group col-md-4">
		<?php echo $form->labelEx($model,'birthday'); ?>
		<?php 
			$this->widget('ext.CJuiDateTimePicker.CJuiDateTimePicker',array(
				'model'=>$model, //Model object
				'attribute'=>'birthday', //attribute name
				'mode'=>'date', //use "time","date" or "datetime" (default)
				'language'=>'id',
				'options'=>array(
					'showAnim'=>'fold',
					'dateFormat'=>'yy-mm-dd',
					'changeMonth' => 'true',
					'changeYear'=>'true',
					'constrainInput' => 'true',
				),
				'htmlOptions'=>array('placeholder'=>'yyyy-mm-dd','class'=>'form-control'),
			));
		?>
		<?php echo $form->error($model,'birthday'); ?>
	</div>

	<div class="form-group col-md-4">
		<?php echo $form->labelEx($model,'phone'); ?>
		<?php echo $form->textField($model,'phone',array('size'=>80,'maxlength'=>128,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'phone'); ?>
	</div>

	<div class="form-group col-md-4">
		<?php echo $form->labelEx($model,'customer_group_id'); ?>
		<?php echo $form->dropDownList($model,'customer_group_id',VCustomerGroup::getItems(),array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'customer_group_id'); ?>
	</div>

	<div class="form-group col-md-8">
		<?php echo $form->labelEx($model,'address'); ?>
		<?php echo $form->textField($model,'address',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'address'); ?>
	</div>

	<div class="form-group col-md-4">
		<?php echo $form->labelEx($model,'city'); ?>
		<?php echo $form->textField($model,'city',array('size'=>80,'maxlength'=>128,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'city'); ?>
	</div>

	<div class="form-group col-md-4">
		<?php echo $form->labelEx($model,'state'); ?>
		<?php echo $form->textField($model,'state',array('size'=>80,'maxlength'=>128,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'state'); ?>
	</div>

	<div class="form-group col-md-4">
		<?php echo $form->labelEx($model,'postcode'); ?>
		<?php echo $form->textField($model,'postcode',array('size'=>80,'maxlength'=>128,'class'=>'form-control')); ?>
		<?php echo $form->error($model,'postcode'); ?>
	</div>

	<div class="form-group col-md-12">
		<?php echo $form->labelEx($model,'notes'); ?>
		<?php echo $form->textArea($model,'notes',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'notes'); ?>
	</div>

	<div class="form-group buttons col-md-12">
		<?php 
		if($model->isNewRecord):
			echo CHtml::ajaxSubmitButton(Yii::t('global', 'Save'),CHtml::normalizeUrl(array('vCustomer/create')),array('dataType'=>'json','success'=>'js:
				function(data){
					if(data.status=="success"){
						$("#message").html(data.div);
						$("#message").parent().removeClass("hide");
						//$.fn.yiiGridView.update("customer-grid");
						setTimeout(function(){
							window.location.reload(true);
						},3000);
						return false;
					}else{
						$("form[id=\'customer-form\']").parent().html(data.div);
					}
					return false;
				}'
			),
			array('style'=>'width:100px','class'=>'btn btn-success','id'=>uniqid()));
		else:
			echo CHtml::ajaxSubmitButton(Yii::t('global', 'Update'),CHtml::normalizeUrl(array('vCustomer/update','id'=>$model->id)),array('dataType'=>'json','success'=>'js:
				function(data){
					if(data.status=="success"){
						$("#message").html(data.div);
						$("#message").parent().removeClass("hide");
						return false;
					}else{
						$("form[id=\'customer-form\']").parent().html(data.div);
					}
					return false;
				}'
			),
			array('style'=>'width:100px','class'=>'btn btn-success','id'=>uniqid()));
		endif;
		?>
	</div>

<?php $this->endWidget(); ?>
