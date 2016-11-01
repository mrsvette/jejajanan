<?php $this->pageSection = 'Product'; ?>
<?php
$this->breadcrumbs = array(
	ucfirst(Yii::app()->controller->module->id) => array('/'.Yii::app()->controller->module->id.'/'),
	Yii::t('VendorModule.vendor','Product'),
);
?>

<div class="row">
	<div class="col-sm-12 col-md-12">
		<div class="panel panel-default">
			<div class="well well-sm">
				<div class="row">
					<div class="col-lg-4 text-right col-lg-push-8 ex-search-box">
						<div class="btn-group toggle-btn-container hide">
							<button 
								class="btn btn-default btn-sm save-api" 
								data-dest="#product-form" 
								confirm="Are you sure to save?"> 
								<span class="fa fa-save"></span>
								<?php echo Yii::t('VendorModule.vendor','Save');?>
							</button>
							<button 
								class="btn btn-default btn-sm cancel-api"> 
								<span class="fa fa-reply"></span>
								<?php echo Yii::t('VendorModule.vendor','Cancel');?>
							</button>
						</div>
					</div>
					<div class="col-lg-8 col-lg-pull-4">
						<div class="btn-group">
							<button 
								class="btn btn-default btn-sm delete-api" 
								data-dest="input.choose:checked" 
								api-url="<?php echo Yii::app()->createUrl('/vendor/vProduct/delete');?>" 
								api-confirm="<?php echo Yii::t('VendorModule.vendor','Are you sure to delete this?');?>">
								<span class="fa fa-trash-o"></span>
								<?php echo Yii::t('VendorModule.vendor','Move to trash');?>
							</button>
							<button class="btn btn-default btn-sm active" href="#general" data-toggle="tab">
								<span class="fa fa-list"></span>
								<?php echo Yii::t('VendorModule.vendor','List product');?>
							</button>
							<button class="btn btn-default btn-sm" href="#new" data-toggle="tab" data-toggle-btn=".toggle-btn-container">
								<span class="fa fa-plus"></span>
								<?php echo Yii::t('VendorModule.vendor','Create new product');?>
							</button>
						</div>
					</div>
				</div>
			</div>
			<!--<div class="panel-heading">
				<h4 class="panel-title"><?php echo Yii::t('global','Manage');?> <?php echo Yii::t('VendorModule.vendor','Product');?></h4>
			</div>-->
            <div class="panel-body">
              	<div class="row">
                	<div class="col-sm-12">
						<div class="tab-content">
							<div id="general" class="tab-pane active">
								<?php echo $this->renderPartial('_list',array('dataProvider'=>$dataProvider));?>
							</div>
							<div id="new" class="tab-pane">
								<?php echo $this->renderPartial('_form',array('model'=>$model,'model2'=>$model2,'model3'=>$model3,'model4'=>$model4));?>
							</div>
						</div>
                	</div><!-- col-sm-12 -->
              	</div><!-- row -->
            </div><!-- panel-body -->
        </div><!-- panel -->
 	</div><!-- col-sm-12 -->
</div><!-- row -->
