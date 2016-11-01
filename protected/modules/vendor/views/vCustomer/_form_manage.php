<div class="alert alert-success hide">
	<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
	<span id="message"></span>
</div>
<?php $form=$this->beginWidget('CActiveForm',array('id'=>'customer-form','htmlOptions'=>array('class'=>'form-horizontal'))); ?>

	<?php echo $form->errorSummary($model,null,null,array('class'=>'alert alert-warning alert-block alert-dismissable fade in')); ?>

	<h4><?php echo Yii::t('VendorModule.customer','Customer profile details');?></h4>

	<div class="form-group">
		<?php echo $form->labelEx($model,'status',array('class'=>'col-md-3')); ?>
		<div class="col-md-6">
			<?php echo $form->radioButtonList($model,'status',$model->statuses,array('template'=>'{input} {label}','separator'=>'')); ?>
			<?php echo $form->error($model,'status'); ?>
		</div>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'customer_group_id',array('class'=>'col-md-3')); ?>
		<div class="col-md-4">
			<?php echo $form->dropDownList($model,'customer_group_id',VCustomerGroup::getItems(),array('class'=>'form-control')); ?>
			<?php echo $form->error($model,'customer_group_id'); ?>
		</div>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'email',array('class'=>'col-md-3')); ?>
		<div class="col-md-4">
			<?php echo $form->textField($model,'email',array('size'=>80,'maxlength'=>128,'class'=>'form-control')); ?>
			<?php echo $form->error($model,'email'); ?>
		</div>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'name',array('class'=>'col-md-3')); ?>
		<div class="col-md-4">
			<?php echo $form->textField($model,'name',array('size'=>80,'maxlength'=>128,'class'=>'form-control')); ?>
			<?php echo $form->error($model,'name'); ?>
		</div>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'gender',array('class'=>'col-md-3')); ?>
		<div class="col-md-4">
			<?php echo $form->radioButtonList($model,'gender',$model->genders,array('template'=>'{input} {label}','separator'=>'')); ?>
			<?php echo $form->error($model,'gender'); ?>
		</div>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'birthday',array('class'=>'col-md-3')); ?>
		<div class="col-md-4">
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
	</div>

	<h4><?php echo Yii::t('VendorModule.customer','Address and contact details');?></h4>

	<div class="form-group">
		<?php echo $form->labelEx($model,'address',array('class'=>'col-md-3')); ?>
		<div class="col-md-9">
		<?php echo $form->textField($model,'address',array('class'=>'form-control')); ?>
		<?php echo $form->error($model,'address'); ?>
		</div>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'country',array('class'=>'col-md-3')); ?>
		<div class="col-md-4">
			<?php echo $form->dropDownList($model,'country',$model->countries,array('class'=>'form-control')); ?>
			<?php echo $form->error($model,'country'); ?>
		</div>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'state',array('class'=>'col-md-3')); ?>
		<div class="col-md-4">
			<?php echo $form->textField($model,'state',array('size'=>80,'maxlength'=>128,'class'=>'form-control')); ?>
			<?php echo $form->error($model,'state'); ?>
		</div>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'city',array('class'=>'col-md-3')); ?>
		<div class="col-md-4">
			<?php echo $form->textField($model,'city',array('size'=>80,'maxlength'=>128,'class'=>'form-control')); ?>
			<?php echo $form->error($model,'city'); ?>
		</div>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'postcode',array('class'=>'col-md-3')); ?>
		<div class="col-md-4">
			<?php echo $form->textField($model,'postcode',array('size'=>80,'maxlength'=>128,'class'=>'form-control')); ?>
			<?php echo $form->error($model,'postcode'); ?>
		</div>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'phone',array('class'=>'col-md-3')); ?>
		<div class="col-md-4">
			<?php echo $form->textField($model,'phone',array('size'=>80,'maxlength'=>128,'class'=>'form-control')); ?>
			<?php echo $form->error($model,'phone'); ?>
		</div>
	</div>

	<h4><?php echo Yii::t('VendorModule.customer','Additional settings');?></h4>

	<div class="form-group">
		<?php echo $form->labelEx($model,'currency',array('class'=>'col-md-3')); ?>
		<div class="col-md-4">
			<?php echo $form->dropDownList($model,'currency',$model->currencies,array('class'=>'form-control')); ?>
			<?php echo $form->error($model,'currency'); ?>
		</div>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'tax_exempt',array('class'=>'col-md-3')); ?>
		<div class="col-md-4">
			<?php echo $form->radioButtonList($model,'tax_exempt',array('No','Yes'),array('template'=>'{input} {label}','separator'=>'')); ?>
			<?php echo $form->error($model,'tax_exempt'); ?>
		</div>
	</div>

	<div class="form-group">
		<?php echo $form->labelEx($model,'notes',array('class'=>'col-md-3')); ?>
		<div class="col-md-9">
			<?php echo $form->textArea($model,'notes',array('class'=>'form-control')); ?>
			<?php echo $form->error($model,'notes'); ?>
		</div>
	</div>

	<div class="form-group buttons col-md-12">
		<?php 
		if($model->isNewRecord):
			echo CHtml::ajaxSubmitButton(Yii::t('global', 'Save'),CHtml::normalizeUrl(array('vCustomer/create')),array('dataType'=>'json','success'=>'js:
				function(data){
					if(data.status=="success"){
						$("#message").html(data.div);
						$("#message").parent().removeClass("hide");
						$.fn.yiiGridView.update("customer-grid");
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
		endif;
		?>
	</div>

<?php $this->endWidget(); ?>
