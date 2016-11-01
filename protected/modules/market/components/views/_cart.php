<?php if ($this->position=='top'):?>
<div class="table-responsive padding10" id="cart-wrapper">
	<table class="table mb30" id="cart-grid" counter="<?php echo $dataProvider->itemCount;?>">
		<?php if($dataProvider->itemCount>0):?>
		<!--<tr>
			<th>No</th>
			<th>Title</th>
			<th>Quantity</th>
			<th>Price</th>
			<th>Subtotal</th>
			<th>&nbsp;</th>
		</tr>-->
		<?php $tot = 0;?>
		<?php foreach($dataProvider->data as $i=>$data):?>
			<tr>
				<td><?php echo '<span class="text-gold text-bold">('.$data['qty'].')</span> '.$data['title'];?></td>
				<!--<td><center><?php //echo CHtml::textField('qty['.$data['qty'].']',$data['qty'],array('class'=>'qty','size'=>3,'attr-id'=>$data['id']));?></center></td>
				<td style="text-align:right;"><?php //echo number_format($data['pricing'],0,',','.');?></td>-->
				<?php $subtotal = ($data['pricing']*$data['qty'])-$data['discount'];?>
				<td style="text-align:right;" class="text-gold">Rp. <?php echo number_format($subtotal,2,',','.');?></td>
				<td><?php echo CHtml::link('<span class="glyphicon glyphicon-remove-sign"></span>',array('/ecommerce/carts/delete','id'=>$data['id']),array('class'=>'delete','title'=>'Delete'));?></td>
			</tr>
			<?php $tot = $tot + $subtotal;?>
		<?php endforeach;?>
		<?php $diskon = 0;?>
		<?php /*<tr>
			<td colspan="2">Subtotal</td>
			<td style="text-align:right;"><?php echo number_format($tot,0,',','.');?></td>
		</tr>
		<tr>
			<td colspan="2">Diskon</td>
			<td style="text-align:right;"><?php echo number_format($diskon,0,',','.');?></td>
		</tr>*/?>
		<?php $grand_total = $tot - $diskon;?>
		<tr>
			<td colspan="3"><b>Total</b>
				<span class="pull-right text-gold"><b>Rp. <?php echo number_format($grand_total,2,',','.');?></b></span>
			</td>
		</tr>
		<?php else:?>
		<tr><td>No items found.</td></tr>
		<?php endif;?>
	</table>
	<?php if($dataProvider->itemCount>0):?>
		<p><a class="btn btn-warning btn-gold pull-right" href="<?php echo Yii::app()->createUrl('/order/checkout');?>">Checkout</a></p>
	<?php endif;?>
</div>
<?php else:?>
	<div class="col-sm-12" id="cart-wrapper">
	<table class="table mb30" id="cart-grid">
		<?php if($dataProvider->itemCount>0):?>
		<thead>
			<tr>
			<th><strong>PRODUK</strong></th>
			<th><strong>ITEM</strong></th>
			<th><strong>TOTAL</strong></th>
			<th>&nbsp;</th>
			</tr>
		</thead>
		<tbody>
		<?php $tot = 0;?>
		<?php foreach($dataProvider->data as $i=>$data):?>
			<tr>
				<td><?php echo $data['title'];?></td>
				<td><center><?php echo CHtml::textField('qty['.$data['qty'].']',$data['qty'],array('class'=>'qty','size'=>3,'attr-id'=>$data['id']));?></center></td>
				<?php $subtotal = ($data['pricing']*$data['qty'])-$data['discount'];?>
				<td style="text-align:right;" class="text-gold">Rp. <?php echo number_format($subtotal,2,',','.');?></td>
				<td><?php echo CHtml::link('<button class="btn btn-xs btn-danger pull-right">x</button>',array('/ecommerce/carts/delete','id'=>$data['id']),array('class'=>'delete','title'=>'Delete'));?></td>
			</tr>
			<?php $tot = $tot + $subtotal;?>
		<?php endforeach;?>
		<?php $diskon = 0;?>
		<?php $grand_total = $tot - $diskon;?>
		<tr>
			<td colspan="2"><strong>ORDER TOTAL</strong></td>
			<td colspan="2"><strong>Rp. <?php echo number_format($grand_total,2,',','.');?></strong></td>
		</tr>
		<?php else:?>
		<tr><td>No items found.</td></tr>
		<?php endif;?>
		</tbody>
	</table>
</div>
<?php endif;?>
<script type="text/javascript">
$(function(){
	$('table[id="cart-grid"]').find('a.delete').click(function(){
		var confirm_text = "<?php echo Yii::t('EcommerceModule.product','Are you sure to delete this item?');?>";
		if(confirm(confirm_text)){
			$.ajax({
				beforeSend: function() { Loading.show(); },
				complete: function() { Loading.hide(); },
				url: $(this).attr('href'),
				type: 'POST',
				dataType: 'json',
				success: function (data) {
					if(data.status=="success"){
						reloadCart();
					}
				},
			});
		}
		return false;
	});
	$('table[id="cart-grid"]').find('input.qty').keyup(function(){
		$.ajax({
			url: "<?php echo Yii::app()->createUrl('/ecommerce/carts/update'); ?>",
			type: 'POST',
			dataType: 'json',
			data: {'id':$(this).attr('attr-id'),'qty':$(this).val()},
			success: function (data) {
				if(data.status=="success"){
					reloadCart();
				}
			},
		});
		return false;
	});
});
function reloadCart(){
	var position = "<?php echo $this->position;?>";
	var options = "{'show_pagination':false,'position':'"+position+"'}";
	$.ajax({	
		url: "<?php echo Yii::app()->createUrl('/site/reloadWidget'); ?>",				
		type: "POST",
		dataType: "JSON",
		data: {
			'widget_path':'application.modules.ecommerce.components.CartWidget',
			'options': options,
		},
		success: function(data){
			if(data.status=='success'){
				$('div[id="cart-wrapper"]').parent().html(data.div);
				$('#cart-counter').html($('#cart-grid').attr('counter'));
			}
		}
	});
}
</script>
