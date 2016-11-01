<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'product-image-form',
	'enableAjaxValidation'=>false,
	'htmlOptions'=>array('class'=>'form-horizontal','enctype' =>'multipart/form-data'),
)); ?>
<div class="form-group">
	<?php echo $form->labelEx($model,'image',array('class'=>'col-md-3')); ?>
	<div class="col-md-9">
		<?php echo $form->fileField($model,'image',array('class'=>'')); ?>
		<?php echo $form->error($model,'image'); ?>
	</div>
</div>
<?php echo $form->hiddenField($model,'product_id',array('value'=>$product->id));?>
<?php $this->endWidget(); ?>
<script type="text/javascript">
$(function(){
	$('#ModProductImages_image').change(function(){
		var formData = new FormData($('form[id="product-image-form"]')[0]);
		$.ajax({
			beforeSend: function() { Loading.show(); },
			complete: function() { Loading.hide(); },
			url: "<?php echo Yii::app()->createUrl('/market/products/uploadImage');?>",
			type: 'POST',
			data: formData,
			dataType: 'json',
			async: false,
			success: function (data) {
				if(data.status=="success"){
					$.fn.yiiGridView.update('image-grid-view', {
						data: $(this).serialize()
					});
					$.fn.yiiListView.update('image-list-view', {
						data: $(this).serialize()
					});
					return false;
				}else{
					$("form[id='product-image-form']").parent().html(data.div);
				}
			},
			cache: false,
			contentType: false,
			processData: false
		});
		return false;
	});
});
</script>
