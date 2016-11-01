<?php if($model->url):?>
	<a href="<?php echo $model->url;?>">
		<?php //echo CHtml::image(Yii::app()->request->baseUrl.'/'.$model->src.$model->image,$model->name,array('class'=>'img-responsive'));?>
		<img rel-src="<?php echo Yii::app()->request->baseUrl.'/'.$model->src.$model->image;?>" title="<?php echo $model->name;?>" class="img-responsive hide late"/>
	</a>
<?php else:?>
	<?php //echo CHtml::image(Yii::app()->request->baseUrl.'/'.$model->src.$model->image,$model->name,array('class'=>'img-responsive'));?>
	<img rel-src="<?php echo Yii::app()->request->baseUrl.'/'.$model->src.$model->image;?>" title="<?php echo $model->name;?>" class="img-responsive hide late"/>
<?php endif;?>
