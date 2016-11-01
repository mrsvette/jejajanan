<div class="table-responsive">
	<?php $this->widget('zii.widgets.grid.CGridView', array(
			'dataProvider'=>$dataProvider,
			'filter'=>$dataProvider->model,
			'itemsCssClass'=>'table table-striped mb30',
			'id'=>'group-grid',
			'afterAjaxUpdate' => 'reloadGrid',
			'columns'=>array(
					array(
						'value'=>'$this->grid->dataProvider->getPagination()->getOffset()+$row+1',
					),
					array(
						'name'=>'name',
						'type'=>'raw',
						'value'=>'$data->name'
					),
					array(
						'name'=>'taxed',
						'type'=>'raw',
						'value'=>'($data->taxed>0)? "Yes":"No"',
						'filter'=>array('No','Yes'),
					),
					array(
						'name'=>'description',
						'type'=>'raw',
						'value'=>'$data->description'
					),
					array(
						'class'=>'CButtonColumn',
						'template'=>'{update}{delete}',
						'buttons'=>array
								(
									'update'=>array(
											'label'=>'<i class="fa fa-pencil"></i>',
											'imageUrl'=>false,
											'options'=>array('title'=>'View'),
											'url'=>'Yii::app()->createUrl(\'vendor/vCustomer/group\',array(\'id\'=>$data->id))',
										),
									'delete'=>array(
											'label'=>'<i class="fa fa-trash-o"></i>',
											'imageUrl'=>false,
											'options'=>array('title'=>'Delete'),
											'url'=>'Yii::app()->createUrl(\'vendor/vCustomer/deleteGroup\',array(\'id\'=>$data->id))',
										),
								),
							'htmlOptions'=>array('style'=>'width:10%;','class'=>'table-action'),
						),
					),
			)); 
	?>
</div>
