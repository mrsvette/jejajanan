<div class="table-responsive">
	<?php $this->widget('zii.widgets.grid.CGridView', array(
			'dataProvider'=>$dataProvider,
			'itemsCssClass'=>'table table-striped mb30',
			'id'=>'order-grid',
			'afterAjaxUpdate' => 'reloadGrid',
			'columns'=>array(
						/*array(
							'value'=>'$this->grid->dataProvider->getPagination()->getOffset()+$row+1',
						),*/
						array(
							'name'=>'id',
							'type'=>'raw',
							'value'=>'CHtml::link($data->id,array(\'vOrder/manage\',\'id\'=>$data->id))',
							'htmlOptions'=>array('style'=>'width:5%;'),
						),
						array(
							'name'=>'title',
							'type'=>'raw',
							'value'=>'$data->title',
						),
						/*array(
							'name'=>'service_type',
							'type'=>'raw',
							'value'=>'ucfirst($data->service_type)',
						),*/
						array(
							'name'=>'price',
							'type'=>'raw',
							'value'=>'number_format($data->price,2,\',\',\'.\')',
						),
						array(
							'name'=>'status',
							'type'=>'raw',
							'value'=>'ucfirst($data->getStatuses($data->status))',
							'filter'=>$dataProvider->model->statuses,
						),
						array(
							'name'=>'date_entry',
							'type'=>'raw',
							'value'=>'$data->date_entry',
						),
						array(
							'class'=>'CButtonColumn',
							'template'=>'{view}',
							'buttons'=>array
								(
									'view'=>array(
											'label'=>'<i class="fa fa-pencil"></i>',
											'imageUrl'=>false,
											'options'=>array('title'=>'View'),
											'url'=>'Yii::app()->createUrl(\'vendor/vOrder/manage\',array(\'id\'=>$data->id))',
										),
								),
							'htmlOptions'=>array('style'=>'width:10%;','class'=>'table-action'),
						),
					),
		)); ?>
</div>
