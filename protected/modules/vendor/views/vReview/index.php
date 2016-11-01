<?php $this->pageSection = 'Review'; ?>
<?php
$this->breadcrumbs = array(
	ucfirst(Yii::app()->controller->module->id) => array('/'.Yii::app()->controller->module->id.'/'),
	Yii::t('VendorModule.vendor','Review'),
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
							<button 
								class="btn btn-default btn-sm delete-api" 
								data-dest="input.choose:checked" 
								api-url="<?php echo Yii::app()->createUrl('/vendor/vReview/delete');?>" 
								api-confirm="<?php echo Yii::t('VendorModule.vendor','Are you sure to delete this?');?>">
								<span class="fa fa-trash-o"></span>
								<?php echo Yii::t('VendorModule.vendor','Move to trash');?>
							</button>
							<button class="btn btn-default btn-sm active" href="#general" data-toggle="tab">
								<span class="fa fa-list"></span>
								<?php echo Yii::t('VendorModule.vendor','List review');?>
							</button>
							<button class="btn btn-default btn-sm" href="#new" data-toggle="tab">
								<span class="fa fa-plus"></span>
								<?php echo Yii::t('VendorModule.vendor','Create new review');?>
							</button>
						</div>
					</div>
				</div>
			</div>
            <div class="panel-body">
              	<div class="row">
                	<div class="col-sm-12">
						<div class="tab-content">
							<div id="general" class="tab-pane active">
								<?php echo $this->renderPartial('_list',array('dataProvider'=>$dataProvider));?>
							</div>
							<div id="new" class="tab-pane">
								<?php echo $this->renderPartial('_form',array('model'=>$model));?>
							</div>
						</div>
                	</div><!-- col-sm-12 -->
              	</div><!-- row -->
            </div><!-- panel-body -->
        </div><!-- panel -->
 	</div><!-- col-sm-12 -->
</div><!-- row -->
