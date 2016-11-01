<style>
#VReview_rating input {float:left;margin-right:10px;}
#VReview_rating label {width:10%;float:left;}
</style>
<div class="alert alert-success hide">
	<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
	<span id="cmessage"></span>
</div>
<?php $form=$this->beginWidget('CActiveForm',array(
			'id'=>'review-form',
	)); ?>

	<?php echo $form->errorSummary($model,null,null,array('class'=>'alert alert-warning alert-block alert-dismissable fade in')); ?>
	<div class="col-md-6">
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<?php echo $form->labelEx($model,'author'); ?>
					<?php echo $form->textField($model,'author',array('size'=>80,'maxlength'=>128,'class'=>'form-control')); ?>
					<?php echo $form->error($model,'author'); ?>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group">
					<?php echo $form->labelEx($model,'product_id'); ?>
					<?php $this->widget('ext.bootstrap-select.TbSelect',array(
								'attribute'=>'product_id',
								'model'=>$model,
								'data' => VProduct::getItems('- Pilih Produk -'),
								'htmlOptions' => array(
								//'multiple' => true,
								'data-live-search'=>true,
								'class'=>'form-control',
							),
					)); ?>
					<?php echo $form->error($model,'product_id'); ?>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group">
					<?php echo $form->labelEx($model,'customer_id'); ?>
					<?php $this->widget('ext.bootstrap-select.TbSelect',array(
								'attribute'=>'customer_id',
								'model'=>$model,
								'data' => VCustomer::getItems('- Pilih Customer -'),
								'htmlOptions' => array(
								//'multiple' => true,
								'data-live-search'=>true,
								'class'=>'form-control',
							),
					)); ?>
					<?php echo $form->error($model,'customer_id'); ?>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group">
					<?php echo $form->labelEx($model,'status'); ?>
					<?php echo $form->dropDownList($model,'status',$model->getTextStatus('list'),array('class'=>'form-control')); ?>
					<?php echo $form->error($model,'status'); ?>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<?php echo $form->labelEx($model,'text'); ?>
					<?php echo $form->textArea($model,'text',array('class'=>'form-control','rows'=>5)); ?>
					<?php echo $form->error($model,'text'); ?>
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group">
					<?php echo $form->labelEx($model,'rating'); ?>
					<?php echo $form->radioButtonList($model,'rating',array(1=>1,2,3,4,5),array('template'=>'{input} {label}','separator'=>'')); ?>
					<?php echo $form->error($model,'rating'); ?>
				</div>
			</div>
		</div>
	</div>

	<div class="form-group buttons col-md-12">
		<?php 
		if($model->isNewRecord):
			echo CHtml::ajaxSubmitButton(Yii::t('global', 'Save'),CHtml::normalizeUrl(array('vReview/create')),array('dataType'=>'json','success'=>'js:
				function(data){
					if(data.status=="success"){
						$("#cmessage").html(data.div);
						$("#cmessage").parent().removeClass("hide");
						setTimeout(function(){
							window.location.reload(true);
						},3000);
						return false;
					}else{
						$("form[id=\'review-form\']").parent().html(data.div);
					}
					return false;
				}'
			),
			array('style'=>'width:100px','class'=>'btn btn-success','id'=>uniqid()));
		else:
			echo CHtml::ajaxSubmitButton(Yii::t('global', 'Update'),CHtml::normalizeUrl(array('vReview/update','id'=>$model->id)),array('dataType'=>'json','success'=>'js:
				function(data){
					if(data.status=="success"){
						$("#cmessage").html(data.div);
						$("#cmessage").parent().removeClass("hide");
						return false;
					}else{
						$("form[id=\'review-form\']").parent().html(data.div);
					}
					return false;
				}'
			),
			array('style'=>'width:100px','class'=>'btn btn-success','id'=>uniqid()));
		endif;
		?>
	</div>

<?php $this->endWidget(); ?>
