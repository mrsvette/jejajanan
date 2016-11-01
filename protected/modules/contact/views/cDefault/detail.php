<?php
$this->breadcrumbs=array(
	ucfirst(Yii::app()->controller->module->id)=>array('/'.Yii::app()->controller->module->id.'/'),
	Yii::t('global','Detail').' '.Yii::t('ContactModule.contact','Contact'),
);

$this->menu=array(
	array('label'=>Yii::t('global','List').' '.Yii::t('ContactModule.contact','Contact'), 'url'=>array('view')),
);
?>
<div class="panel panel-default">
	<div class="panel-heading">
		<h4 class="panel-title">
			Message from <b><?php echo $model->name;?></b> [ <a href="mailto:<?php echo $model->email;?>;"><i><?php echo $model->email;?></i></a> ] 
			<span class="pull-right fa fa-clock-o"> <?php echo date("d F Y H:i",strtotime($model->date_entry));?></span>
		</h4>
	</div>
	<div class="panel-body">
		<ul class="nav nav-tabs">
			<li class="active">
				<a data-toggle="tab" href="#general">
					<strong><?php echo Yii::t('ContactModule.contact','Message');?></strong>
				</a>
			</li>
			<li class="">
				<a data-toggle="tab" href="#detail">
					<strong><?php echo Yii::t('ContactModule.contact','Client Detail');?></strong>
				</a>
			</li>
		</ul>
		<div class="tab-content">
			<div id="general" class="tab-pane active">
				<blockquote>
					<p><?php echo $model->message;?></p>
					<small><?php echo $model->name;?></small>
				</blockquote>
			</div>
			<div id="detail" class="tab-pane">
				<div class="table-responsive">
				<?php $this->widget('zii.widgets.CDetailView', array(
					'data'=>$model,
					'htmlOptions'=>array('class'=>'table table-striped mb30'),
					'attributes'=>array(
						array(
							'label'=>'name',
							'type'=>'raw',
							'value'=>$model->name,
						),
						array(
							'label'=>'email',
							'type'=>'raw',
							'value'=>$model->email,
						),
						array(
							'label'=>'phone',
							'type'=>'raw',
							'value'=>$model->phone,
						),
						array(
							'label'=>'address',
							'type'=>'raw',
							'value'=>$model->address,
						),
					),
				));
				?>
				</div>
			</div>
		</div> <!-- tab-content -->
	</div>
</div>
