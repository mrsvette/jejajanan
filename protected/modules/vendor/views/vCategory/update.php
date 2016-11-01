<?php $this->pageSection = 'Update Category'; ?>
<?php
$this->breadcrumbs = array(
	ucfirst(Yii::app()->controller->module->id) => array('/'.Yii::app()->controller->module->id.'/'),
	Yii::t('VendorModule.vendor','Category') => array('/'.Yii::app()->controller->module->id.'/vCategory'),
	$model->description_one_rel->name,
);
?>

<div class="row">
	<div class="col-sm-12 col-md-12">
		<div class="panel panel-default">
			<div class="well well-sm">
				<div class="row">
					<div class="col-lg-4 text-right col-lg-push-8 ex-search-box">
					</div>
					<div class="col-lg-8 col-lg-pull-4">
						<div class="btn-group">
							<button class="btn btn-default btn-sm active" href="#update" data-toggle="tab">
								<span class="fa fa-pencil"></span>
								<?php echo Yii::t('VendorModule.vendor','Update category');?>
							</button>
							<button class="btn btn-default btn-sm api-link" href="<?php echo Yii::app()->createUrl('/'.Yii::app()->controller->module->id.'/vCategory');?>">
								<span class="fa fa-list"></span>
								<?php echo Yii::t('VendorModule.vendor','List category');?>
							</button>
							<button class="btn btn-default btn-sm api-link" 
								href="<?php echo Yii::app()->createUrl('/'.Yii::app()->controller->module->id.'/vCategory/delete',array('id'=>$model->id));?>" 
								confirm="<?php echo Yii::t('VendorModule.vendor','Are you sure to delete this?');?>" 
								redirect-url="<?php echo Yii::app()->createUrl('/'.Yii::app()->controller->module->id.'/vCategory');?>">
								<span class="fa fa-trash-o"></span>
								<?php echo Yii::t('VendorModule.vendor','Move to trash');?>
							</button>
						</div>
					</div>
				</div>
			</div>
            <div class="panel-body">
              	<div class="row">
                	<div class="col-sm-12">
						<div class="tab-content">
							<div id="update" class="tab-pane active">
								<?php echo $this->renderPartial('_form',array('model'=>$model,'model2'=>$model2));?>
							</div>
						</div>
                	</div><!-- col-sm-12 -->
              	</div><!-- row -->
            </div><!-- panel-body -->
        </div><!-- panel -->
 	</div><!-- col-sm-12 -->
</div><!-- row -->
