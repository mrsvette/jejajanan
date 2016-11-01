<div class="table-responsive">
	<?php $this->widget('zii.widgets.grid.CGridView', array(
			'dataProvider'=>$dataProvider,
			'filter'=>$dataProvider->model,
			'itemsCssClass'=>'table table-striped mb30',
			'id'=>'category-grid',
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
						'name'=>'childs',
						'type'=>'raw',
						'value'=>'(!empty($data->childs))? $data->childItems : "-"'
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
											'url'=>'Yii::app()->createUrl(\'/vendor/vProduct/updateCategory\',array(\'id\'=>$data->id))',
											//'visible'=>'Rbac::ruleAccess(\'read_p\')',
										),
									'delete'=>array(
											'label'=>'<i class="fa fa-trash-o"></i>',
											'imageUrl'=>false,
											'options'=>array('title'=>'Delete'),
											'url'=>'Yii::app()->createUrl(\'/vendor/vProduct/deleteCategory\',array(\'id\'=>$data->id))',
											//'visible'=>'Rbac::ruleAccess(\'delete_p\')',
										),
								),
							'htmlOptions'=>array('style'=>'width:10%;','class'=>'table-action'),
						),
					),
			)); 
	?>
</div>
