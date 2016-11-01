<div class="table-responsive">
	<?php $this->widget('zii.widgets.grid.CGridView', array(
			'dataProvider'=>$dataProvider,
			'filter'=>$dataProvider->model,
			'itemsCssClass'=>'table table-striped mb30',
			'id'=>'product-grid',
			'afterAjaxUpdate' => 'reloadGrid',
			'columns'=>array(
					array(
						'value'=>'$this->grid->dataProvider->getPagination()->getOffset()+$row+1',
					),
					array(
						'name'=>'title',
						'type'=>'raw',
						'value'=>'$data->title'
					),
					array(
						'name'=>'slug',
						'type'=>'raw',
						'value'=>'$data->slug'
					),
					array(
						'class'=>'CButtonColumn',
						'template'=>'{update}{delete}',
						'buttons'=>array
								(
									'update'=>array(
											'label'=>'<i class="fa fa-pencil"></i> ',
											'imageUrl'=>false,
											'options'=>array('title'=>'View'),
											'url'=>'Yii::app()->createUrl(\'/vendor/vProduct/update\',array(\'id\'=>$data->id))',
										),
									'delete'=>array(
											'label'=>'<i class="fa fa-trash-o"></i>',
											'imageUrl'=>false,
											'options'=>array('title'=>'Delete'),
											'url'=>'Yii::app()->createUrl(\'/vendor/vProduct/delete\',array(\'id\'=>$data->id))',
										),
								),
							'htmlOptions'=>array('style'=>'width:10%;','class'=>'table-action'),
						),
					),
			)); 
	?>
</div>
