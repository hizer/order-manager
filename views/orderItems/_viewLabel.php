<?php
/* @var $this OrderItemsController */
/* @var $data OrderItems */
?>

<div class="view d-tcell" data-item="<?php echo CHtml::encode($data->order->shop_id); ?>"
	<?php if($data->isTable($data->order_item_id)){
		echo "data-type='table'";
		}
	?>
data-quantity="<?php echo CHtml::encode($data->quantity); ?>">
<div class="view d-tcell-content">


	 <img class="logo" src="/images/admin/logo.png" alt="">
	 <br />
	<br />
	<?php if ($data->order->shop_id > 0){?>
	<b>Отримувач:</b>
	<?php echo CHtml::encode($data->order->shop->full_name); ?>
	<br />
	<?php } ?>
	
	<?php if ($data->order->customer_id > 0){?>
	<b>ПІБ отримувача:</b>
	<?php echo CHtml::encode($data->order->getCustomerName($data->order->customer_id)); ?>
	<br />
	<?php } ?>

	<b><?php echo CHtml::encode($data->order->city->getAttributeLabel('city_name')); ?>:</b>
	<?php echo CHtml::encode($data->order->city->city_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('order_item_id')); ?>:</b>
	<?php echo "№ ".CHtml::encode($data->order_item_id); ?>
	<br />



	<b><?php echo CHtml::encode($data->getAttributeLabel('product_id')); ?>:</b>
	<?php echo CHtml::encode($data->product->productType->name) ." ".CHtml::encode($data->product->product_name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('quantity')); ?>:</b>
	<span class="quantity"><?php echo CHtml::encode($data->quantity); ?></span>
	<br />
	
	<?php if ($data->isTable($data->order_item_id)){?>	
	<b><?php echo "Розмір(мм)"; ?>:</b>
	<?php echo CHtml::encode($data->getProductSize($data->order_item_id)); ?>
	<br />	
	<?php } ?>
	
	<?php echo CHtml::encode($data->getProductProperties($data->order_item_id)); ?>
	
	
	<?php if (CHtml::encode($data->comment) != ''){?>
	<b><?php echo CHtml::encode($data->getAttributeLabel('comment')); ?>:</b>
	<?php echo CHtml::encode($data->comment); ?>
	<br />
	<?php } ?>
	
	<?php if ($data->isTable($data->order_item_id)){?>	
	<b>Ноги в коробці зі столом:</b> <span class="square"></span>Так &nbsp;&nbsp;&nbsp; <span class="square"></span>Ні
	<br />	
	<?php } ?>
	
	
	<b class="test">ПІБ упаковщика: ___________________</b>	
	

	<?php 
	
 
	/*
	<b><?php echo CHtml::encode($data->getAttributeLabel('quantity')); ?>:</b>
	<?php echo CHtml::encode($data->quantity); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price')); ?>:</b>
	<?php echo CHtml::encode($data->price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('subtotal')); ?>:</b>
	<?php echo CHtml::encode($data->subtotal); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('comment')); ?>:</b>
	<?php echo CHtml::encode($data->comment); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_on')); ?>:</b>
	<?php echo CHtml::encode($data->created_on); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_by')); ?>:</b>
	<?php echo CHtml::encode($data->created_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modified_on')); ?>:</b>
	<?php echo CHtml::encode($data->modified_on); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modified_by')); ?>:</b>
	<?php echo CHtml::encode($data->modified_by); ?>
	<br />

	*/ ?>
</div>
</div>