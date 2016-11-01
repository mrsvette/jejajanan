<?php
			$this->widget('zii.widgets.grid.CGridView', array(
				'dataProvider'=>$dataProvider,
				'itemsCssClass'=>'table table-striped mb30',
				'id'=>'image-grid-view',
				'afterAjaxUpdate' => 'reloadGrid',
				'columns'=>array(
				array(
					'value'=>'$this->grid->dataProvider->getPagination()->getOffset()+$row+1',
				),
				array(
					'name'=>'image',
					'type'=>'raw',
					'value'=>'CHtml::image(Yii::app()->request->baseUrl."/".$data->thumb.$data->image,$data->image,array(\'style\'=>\'height:100px;\',\'title\'=>$data->image))'
				),
				array(
					'name'=>'type',
					'type'=>'raw',
					'value'=>'CHtml::dropDownList(\'type\',$data->type,Lookup::items(\'ProductImageType\'),array(\'id\'=>$data->id))'
				),
				array(
					'class'=>'CButtonColumn',
					'template'=>'{delete}',
					'buttons'=>array(
						'delete'=>array(
							'imageUrl'=>false,
							'label'=>'<span class="fa fa-trash-o"></span>',
							'options'=>array('title'=>'Delete'),
							'url'=>'Yii::app()->createUrl("/".Yii::app()->controller->module->id."/vProduct/deleteImage", array("id"=>$data->id))',
						),	
					),
					'htmlOptions'=>array('style'=>'width:10%;','class'=>'table-action'),
				),
			),
			));
		?>
<script type="text/javascript">
function deleteImage(id){
	if(confirm('Anda yakin ingin mengapus item ini?')){
		$.ajax({
			'beforeSend': function() { Loading.show(); },
			'complete': function() { Loading.hide(); },
			'url': '<?php echo Yii::app()->createUrl('/'.Yii::app()->controller->module->id.'/vProduct/deleteImage');?>',
			'dataType': 'json',
			'type':'post',
			'data':{'id':id},
			'success': function(data) {
				if(data.status=='success'){
					$.fn.yiiGridView.update('image-grid-view', {
						data: $(this).serialize()
					});
				}
			}
		});
	}
	return false;
}
$('#grid-view').find('a.delete').click(function(){
	if(confirm('Anda yakin ingin mengapus item ini?')){
		$.ajax({
			'beforeSend': function() { Loading.show(); },
			'complete': function() { Loading.hide(); },
			'url': $(this).attr('href'),
			'dataType': 'json',
			'type':'post',
			'success': function(data) {
				if(data.status=='success'){
					$.fn.yiiGridView.update('image-grid-view', {
						data: $(this).serialize()
					});
				}
			}
		});
	}
	return false;
});
$('#image-grid-view').find('select[name="type"]').change(function(){
	var $this=$(this);
	$.ajax({
		'beforeSend': function() { Loading.show(); },
		'complete': function() { Loading.hide(); },
		'url': '<?php echo Yii::app()->createUrl('/'.Yii::app()->controller->module->id.'/vProduct/updateImageType');?>',
		'dataType': 'json',
		'type':'post',
		'data':{'id':$this.attr('id'),'value':$this.val()},
		'success': function(data) {
			if(data.status=='success'){
				$.fn.yiiGridView.update('image-grid-view', {
					data: $(this).serialize()
				});
			}
		}
	});
	return false;
});
</script>
