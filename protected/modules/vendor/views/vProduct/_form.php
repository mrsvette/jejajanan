<!-- 2col multiselect -->
<?php echo $this->get_css(
	array('path'=>'css/tisa/lib/multi-select/css/multi-select.css'),
	array('patern'=>'../img','replacement'=>Yii::app()->request->baseUrl.'/css/tisa/lib/multi-select/img')
); ?>
<!-- multiselect, tagging -->
<?php echo $this->get_css(
	array('path'=>'css/tisa/lib/select2/select2.css'),
	array('patern'=>'./','replacement'=>Yii::app()->request->baseUrl.'/css/tisa/lib/select2/')
); ?>
<style>
.ms-container{width: 100%;}
</style>
<div class="tabbable tabs-left">
	<ul class="nav nav-tabs nav-tabs-nobg">
		<li class="active">
			<a class="tab-default" href="#prod_tab_general" data-toggle="tab">
				<span class="fa fa-bookmark"></span> general
			</a>
		</li>
		<li class="">
			<a class="tab-default" href="#prod_tab_data" data-toggle="tab">
				<span class="fa fa-clipboard"></span> data
			</a>
		</li>
		<li class="">
			<a class="tab-default" href="#prod_tab_links" data-toggle="tab">
				<span class="fa fa-link"></span> links
			</a>
		</li>
		<?php if(!$model->isNewRecord):?>
		<li class="">
			<a class="tab-default" href="#prod_tab_images" data-toggle="tab">
				<span class="fa fa-picture-o"></span> images
			</a>
		</li>
		<li class="">
			<a class="tab-default" href="#prod_tab_discount" data-toggle="tab">
				<span class="fa fa-money"></span> discount
			</a>
		</li>
		<?php endif;?>
	</ul>

	<?php $form = $this->beginWidget('CActiveForm',array(
			'id'=>'product-form',
			'htmlOptions'=>array('enctype' =>'multipart/form-data'),
	)); ?>
	<div class="tab-content">
		<div class="alert alert-success hide">
			<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
			<span id="pmessage"></span>
		</div>

		<?php echo $form->errorSummary(array($model,$model2),null,null,array('class'=>'alert alert-warning alert-block alert-dismissable fade in')); ?>
		<div class="tab-pane active" id="prod_tab_general">
			<div class="form-group">
				<div class="row">
					<div class="col-lg-6">
						<?php echo $form->labelEx($model2,'name'); ?>
						<?php echo $form->textField($model2,'name',array('size'=>80,'maxlength'=>128,'class'=>'form-control')); ?>
						<?php echo $form->error($model2,'name'); ?>
					</div>
					<div class="col-lg-6">
						<?php echo $form->labelEx($model,'model'); ?>
						<?php echo $form->textField($model,'model',array('size'=>80,'maxlength'=>128,'class'=>'form-control')); ?>
						<?php echo $form->error($model,'model'); ?>
					</div>
				</div>
			</div>
			<div class="form-group form-sep">
				<div class="row">
					<div class="col-lg-12">
						<?php echo $form->labelEx($model2,'description'); ?>
						<?php echo $form->textArea($model2,'description',array('class'=>'form-control'));?>
						<?php echo $form->error($model2,'description'); ?>
					</div>
				</div>
			</div>
			<div class="form-group">
				<div class="row">
					<div class="col-lg-6">
						<?php echo $form->labelEx($model2,'meta_title'); ?>
						<?php echo $form->textField($model2,'meta_title',array('size'=>80,'maxlength'=>128,'class'=>'form-control')); ?>
						<?php echo $form->error($model2,'meta_title'); ?>
					</div>
					<div class="col-lg-6">
						<?php echo $form->labelEx($model2,'meta_keyword'); ?>
						<?php echo $form->textField($model2,'meta_keyword',array('size'=>80,'maxlength'=>128,'class'=>'form-control')); ?>
						<?php echo $form->error($model2,'meta_keyword'); ?>
					</div>
				</div>
			</div>
			<div class="form-group form-sep">
				<div class="row">
					<div class="col-lg-12">
						<?php echo $form->labelEx($model2,'meta_description'); ?>
						<?php echo $form->textArea($model2,'meta_description',array('class'=>'form-control'));?>
						<?php echo $form->error($model2,'meta_description'); ?>
					</div>
				</div>
			</div>
		</div><!-- prod_tab_general -->
		<div class="tab-pane" id="prod_tab_data">
			<div class="form-group">
				<div class="row">
					<div class="col-lg-3 col-sm-6">
						<?php echo $form->labelEx($model,'sku'); ?>
						<?php echo $form->textField($model,'sku',array('size'=>80,'maxlength'=>128,'class'=>'form-control')); ?>
						<?php echo $form->error($model,'sku'); ?>
					</div>
					<div class="col-lg-3 col-sm-6">
						<?php echo $form->labelEx($model,'ean'); ?>
						<?php echo $form->textField($model,'ean',array('size'=>80,'maxlength'=>128,'class'=>'form-control')); ?>
						<?php echo $form->error($model,'ean'); ?>
					</div>
					<div class="col-lg-3 col-sm-6">
						<?php echo $form->labelEx($model,'isbn'); ?>
						<?php echo $form->textField($model,'isbn',array('size'=>80,'maxlength'=>128,'class'=>'form-control')); ?>
						<?php echo $form->error($model,'isbn'); ?>
					</div>
					<div class="col-lg-3 col-sm-6">
						<?php echo $form->labelEx($model,'mpn'); ?>
						<?php echo $form->textField($model,'mpn',array('size'=>80,'maxlength'=>128,'class'=>'form-control')); ?>
						<?php echo $form->error($model,'mpn'); ?>
					</div>
				</div>
			</div>
			<div class="form-group form-sep">
				<div class="row">
					<div class="col-lg-3 col-sm-6">
						<?php echo $form->labelEx($model,'price'); ?>
						<?php echo $form->textField($model,'price',array('size'=>80,'maxlength'=>128,'class'=>'form-control')); ?>
						<?php echo $form->error($model,'price'); ?>
					</div>
					<div class="col-lg-3 col-sm-6">
						<?php echo $form->labelEx($model,'quantity'); ?>
						<?php echo $form->textField($model,'quantity',array('size'=>80,'maxlength'=>128,'class'=>'form-control')); ?>
						<?php echo $form->error($model,'quantity'); ?>
					</div>
					<div class="col-lg-3 col-sm-6">
						<?php echo $form->labelEx($model,'date_available'); ?>
						<?php
						$this->widget('zii.widgets.jui.CJuiDatePicker', array(
							'model'=>$model, //Model object
							'attribute'=>'date_available', //attribute name
							'options'=>array(
								'showAnim'=>'fold',
								'dateFormat'=>'yy-mm-dd',
								'changeMonth' => 'true',
								'changeYear'=>'true',
								'constrainInput' => 'false'
							),
							'htmlOptions'=>array(
								'class'=>'form-control',
								'value'=>(!$model->isNewRecord)? date('Y-m-d',strtotime($model->date_available)) : date('Y-m-d'),
							),
						));
						?>
						<?php echo $form->error($model,'date_available'); ?>
					</div>
					<div class="col-lg-3 col-sm-6">
						<?php echo $form->labelEx($model,'tax_class_id'); ?>
						<?php echo $form->dropDownList(
							$model,
							'tax_class_id',
							CHtml::listData(VTaxClass::model()->findAll(),'id','title'),
							array('class'=>'form-control')
						); ?>
						<?php echo $form->error($model,'tax_class_id'); ?>
					</div>
				</div>
			</div>
			<div class="form-group form-sep">
				<div class="row">
					<div class="col-lg-3 col-sm-6">
						<?php echo $form->labelEx($model,'weight'); ?>
						<?php echo $form->textField($model,'weight',array('size'=>80,'maxlength'=>128,'class'=>'form-control')); ?>
						<?php echo $form->error($model,'weight'); ?>
					</div>
					<div class="col-lg-3 col-sm-6">
						<?php echo $form->labelEx($model,'length'); ?>
						<?php echo $form->textField($model,'length',array('size'=>80,'maxlength'=>128,'class'=>'form-control')); ?>
						<?php echo $form->error($model,'length'); ?>
					</div>
					<div class="col-lg-3 col-sm-6">
						<?php echo $form->labelEx($model,'width'); ?>
						<?php echo $form->textField($model,'width',array('size'=>80,'maxlength'=>128,'class'=>'form-control')); ?>
						<?php echo $form->error($model,'width'); ?>
					</div>
					<div class="col-lg-3 col-sm-6">
						<?php echo $form->labelEx($model,'height'); ?>
						<?php echo $form->textField($model,'height',array('size'=>80,'maxlength'=>128,'class'=>'form-control')); ?>
						<?php echo $form->error($model,'height'); ?>
					</div>
				</div>
			</div>
			<div class="form-group form-sep">
				<div class="row">
					<div class="col-lg-3 col-sm-6">
						<?php echo $form->labelEx($model,'weight_class_id'); ?>
						<?php echo $form->dropDownList($model,'weight_class_id',VWeightClass::items(),array('class'=>'form-control')); ?>
						<?php echo $form->error($model,'weight_class_id'); ?>
					</div>
					<div class="col-lg-3 col-sm-6">
						<?php echo $form->labelEx($model,'length_class_id'); ?>
						<?php echo $form->dropDownList($model,'length_class_id',VLengthClass::items(), array('class'=>'form-control')); ?>
						<?php echo $form->error($model,'length_class_id'); ?>
					</div>
					<div class="col-lg-3 col-sm-6">
						<?php echo $form->labelEx($model,'sort_order'); ?>
						<?php echo $form->textField($model,'sort_order',array('size'=>80,'maxlength'=>128,'class'=>'form-control')); ?>
						<?php echo $form->error($model,'sort_order'); ?>
					</div>
					<div class="col-lg-3 col-sm-6">
						<?php echo $form->labelEx($model,'status'); ?>
						<?php echo $form->dropDownList($model,'status',$model->getTextStatus('list'),array('class'=>'form-control')); ?>
						<?php echo $form->error($model,'status'); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="tab-pane" id="prod_tab_links">
			<div class="row">
				<div class="col-lg-6">
					<?php echo $form->labelEx($model3,'category_id'); ?>
					<?php echo $form->dropDownList($model3,'category_id',VCategory::getItems(),array('class'=>'form-control 2col_searchable','multiple'=>true)); ?>
					<?php echo $form->error($model3,'category_id'); ?>
				</div>
				<div class="col-lg-6">
					<?php echo $form->labelEx($model4,'related_id'); ?>
					<?php echo $form->dropDownList($model4,'related_id',VProduct::getItems(null,array($model->id)),array('class'=>'form-control 2col_searchable','multiple'=>true)); ?>
					<?php echo $form->error($model4,'related_id'); ?>
				</div>
			</div>
		</div> <!-- links -->
		<?php if(!$model->isNewRecord):?>
		<div class="tab-pane" id="prod_tab_images">
			<div class="row">
				<div class="col-lg-6">
					<?php echo $this->renderPartial('_image',array('dataProvider'=>$model->imageProvider));?>
				</div>
				<div class="col-lg-6">
					<?php echo $form->labelEx($model5,'image'); ?>
					<div class="fileinput-button btn btn-info sepH_b">
						<i class="fa fa-plus"></i>
						<span>Add image...</span>
						<?php echo $form->fileField($model5,'image',array('class'=>'form-control')); ?>
					</div>
					<div id="img-area" class="mt10"></div>
				</div>
			</div>
		</div> <!-- images -->
		<div class="tab-pane" id="prod_tab_discount">
			<div class="row">
				<div class="col-lg-12">
					<?php echo $this->renderPartial('_discount',array('model'=>$model));?>
				</div>
			</div>
		</div> <!-- images -->
		<?php endif; ?>
		<div class="tab-pane">
			<div class="form-group buttons hide">
				<?php 
				if($model->isNewRecord):
					echo CHtml::ajaxSubmitButton(Yii::t('global', 'Save'),CHtml::normalizeUrl(array('vProduct/create')),array('dataType'=>'json','success'=>'js:
						function(data){
							if(data.status=="success"){
								$("#pmessage").html(data.div);
								$("#pmessage").parent().removeClass("hide");
								setTimeout(function(){
									//$("#pmessage").parent().find(".close").trigger("click");
									window.location.reload(true);
								},3000);
								/*$.fn.yiiGridView.update("product-grid", {
									data: $(this).serialize()
								});*/
								return false;
							}else{
								$("form[id=\'product-form\']").parent().html(data.div);
							}
							return false;
						}'
					),
					array('style'=>'width:100px','class'=>'btn btn-success','id'=>uniqid()));
				else:
					echo CHtml::ajaxSubmitButton(Yii::t('global', 'Update'),CHtml::normalizeUrl(array('vProduct/update','id'=>$model->id)),array('dataType'=>'json','success'=>'js:
						function(data){
							if(data.status=="success"){
								$("#pmessage").html(data.div);
								$("#pmessage").parent().removeClass("hide");
								setTimeout(function(){
									window.location.reload(true);
								},3000);
								return false;
							}else{
								$("form[id=\'product-form\']").parent().html(data.div);
							}
							return false;
						}'
					),
					array('style'=>'width:100px','class'=>'btn btn-success','id'=>uniqid()));
				endif;
				?>
			</div>
		</div>
	</div>
	<?php $this->endWidget(); ?>
</div>
<!--  2col multiselect -->
<script src="<?php echo Yii::app()->request->baseUrl;?>/css/tisa/lib/multi-select/js/jquery.multi-select.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl;?>/css/tisa/js/jquery.quicksearch.js"></script>
<!-- multiselect, tagging -->
<script src="<?php echo Yii::app()->request->baseUrl;?>/css/tisa/lib/select2/select2.min.js"></script>
<script type="text/javascript">
$(function(){
	$('#VProductImages_image').change(function(){
		var formData = new FormData($('form[id="product-form"]')[0]);
		$.ajax({
			beforeSend: function() { Loading.show(); },
			complete: function() { Loading.hide(); },
			url: "<?php echo Yii::app()->createUrl('/vendor/vProduct/uploadImage',array('id'=>$model->id));?>",
			type: 'POST',
			data: formData,
			dataType: 'json',
			async: false,
			success: function (data) {
				if(data.status=="success"){
					$('#img-area').html(data.image);
					$.fn.yiiGridView.update('image-grid-view');
				}else{
					$('#img-area').html(data.div);
				}
			},
			cache: false,
			contentType: false,
			processData: false
		});
		return false;
	});
	if($('.2col_searchable').length) {
		$('.2col_searchable').multiSelect({
			selectableHeader: '<div class="custom-header-search"><input type="text" class="search-input input-sm form-control" autocomplete="off" placeholder="Selectable..."></div>',
			selectionHeader: '<div class="custom-header-search"><input type="text" class="search-input input-sm form-control" autocomplete="off" placeholder="Selection..."></div>',
			afterInit: function(ms){
				var that = this,
				$selectableSearch = that.$selectableUl.prev('div').children('input'),
				$selectionSearch = that.$selectionUl.prev('div').children('input'),
				selectableSearchString = '#'+that.$container.attr('id')+' .ms-elem-selectable:not(.ms-selected)',
				selectionSearchString = '#'+that.$container.attr('id')+' .ms-elem-selection.ms-selected';
						
				that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
					.on('keydown', function(e){
						if (e.which === 40){
							that.$selectableUl.focus();
							return false;
						}
					});
						
				that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
					.on('keydown', function(e){
						if (e.which == 40){
							that.$selectionUl.focus();
							return false;
						}
					});
			},
			afterSelect: function(){
				this.qs1.cache();
				this.qs2.cache();
			},
			afterDeselect: function(){
				this.qs1.cache();
				this.qs2.cache();
			}
		});
	}
});
</script>
