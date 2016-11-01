<div class="content">
	<div class="row">
		<div class="col-md-12 general-title">
			<h4>Recent Items <span class="hidden-xs"><a href="shop-four.html">View all</a></span></h4>
			<hr>
		</div>
		<!-- end col -->
	</div>
	<!-- end row -->
	<div class="row">
		<?php $this->widget('zii.widgets.CListView', array(
			'dataProvider'=>$dataProvider,
			'itemView'=>'__product',
		)); ?>
		<!-- end col -->
	</div>
</div>
