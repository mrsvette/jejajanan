<div class="col-md-3 col-sm-6">
	<div class="item-box">
		<div class="item-media entry">
			<img src="<?php echo Yii::app()->request->baseUrl.'/'.$data->productImage->thumb.$data->productImage->image;?>" alt="" class="img-responsive">
			<div class="magnifier">
				<div class="item-author">
					<a href="<?php echo Yii::app()->createUrl('/product/view',array('id'=>$data->id,'title'=>$data->description_one_client_rel->name));?>"><?php echo $data->vendor_rel->company;?></a>
				</div>
				<!-- end author -->
			</div>
			<div class="theme__button">
				<p>
					<a href="single-item.html" title="">
						<?php 
							$pricing = $data->productPrice;
							echo $pricing->currency.' '.$pricing->price;
						?>
					</a>
				</p>
			</div>
		</div>
		<!-- end item-media -->
		<h4><?php echo $data->productDescription->name; ?></h4>
		<p>
			<small><a href="single-item.html"><i class="fa fa-eye"></i> <?php echo $data->viewed; ?></a></small>
			<small><a href="single-item.html"><i class="fa fa-comment-o"></i> <?php echo $data->review_count; ?></a></small>
		</p>
	</div>
	<!-- end item-box -->
</div>
