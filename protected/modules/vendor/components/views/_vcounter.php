<li>
	<a href="<?php echo Yii::app()->createUrl('/vendor/vCustomer');?>">
		<span><?php echo VCustomer::getCount('active');?></span>Customer
	</a>
</li>
<li>
	<a href="<?php echo Yii::app()->createUrl('/vendor/vInvoice',array('status'=>'unpaid'));?>">
		<span><?php echo VInvoice::getCount('unpaid');?></span>Invoice
	</a>
</li>
<li>
	<a href="<?php echo Yii::app()->createUrl('/vendor/vOrder',array('status'=>'pending_setup'));?>">
		<span><?php echo VCustomerOrder::getCountOrder('pending_setup');?></span>Orders
	</a>
</li>
