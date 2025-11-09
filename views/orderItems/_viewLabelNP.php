<?php
/* @var $this OrderItemsController */
/* @var $data OrderItems */
?>

<?php if ($data->isTable($data->order_item_id)){?>	

	<div class="view d-tcell">
		<div class="view d-tcell-content" style="padding-top: 30px; font-size: 23px; line-height: 2; text-align: center">
			<div style=" font-size: 29px;
				padding-top: 10px;
				overflow: hidden;
				white-space: nowrap;
				text-overflow: ellipsis;">					 
				<?php if ($data->order->shop_id > 0){?>
						<?php echo CHtml::encode($data->order->shop->full_name); ?>					
					
				<?php } ?>
				
				<?php if ($data->order->customer_id > 0){?>
								
						<?php echo CHtml::encode($data->order->getCustomerName($data->order->customer_id)); ?>
						<?php } ?>
			</div>

			<div style="border: 2px solid; font-size: 35px; width: line-height: 1.5">
				<b><?php echo CHtml::encode($data->getAttributeLabel('order_item_id')); ?>:</b>
				<?php echo "№ ".CHtml::encode($data->order_item_id); ?>
			</div>
			
			<div >	
				<?php echo CHtml::encode($data->order->city->city_name); ?>
			</div>

			<div style="font-weight: bold;">			 
					Ноги в коробці зі столом
			</div>

			<div>			 
					Так &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Ні
			</div>

		</div>
	</div>

	<div class="view d-tcell">
		<div class="view d-tcell-content" style="padding-top: 30px; font-size: 23px; line-height: 2; text-align: center">
			<div style=" font-size: 29px;
				padding-top: 10px;
				overflow: hidden;
				white-space: nowrap;
				text-overflow: ellipsis;">					 
				<?php if ($data->order->shop_id > 0){?>
						<?php echo CHtml::encode($data->order->shop->full_name); ?>					
					
				<?php } ?>
				
				<?php if ($data->order->customer_id > 0){?>
								
						<?php echo CHtml::encode($data->order->getCustomerName($data->order->customer_id)); ?>
						<?php } ?>
			</div>

			<div style="border: 2px solid; font-size: 35px; width: line-height: 1.5">
				<b><?php echo CHtml::encode($data->getAttributeLabel('order_item_id')); ?>:</b>
				<?php echo "№ ".CHtml::encode($data->order_item_id); ?>
			</div>
			
			<div >	
				<?php echo CHtml::encode($data->order->city->city_name); ?>
			</div>

			<div style="font-weight: bold;">			 
					Ноги в коробці зі столом
			</div>

			<div>			 
					Так &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Ні
			</div>

		</div>
	</div>
	
	<?php } ?>


<div class="view d-tcell" data-item="<?php echo CHtml::encode($data->order->shop_id); ?>"
	<?php if($data->isTable($data->order_item_id)){
		echo "data-type='table'";
		}
	?>
data-quantity="<?php echo CHtml::encode($data->quantity); ?>">
<div class="view d-tcell-content">


	<img class="logo" src="/images/admin/logo.png" alt="">
	<br />
	<?php if ($data->order->shop_id > 0){?>
		<div style="font-size: 19px">
			<b>Отримувач:</b>
			<?php echo CHtml::encode($data->order->shop->full_name); ?>
			 
		</div>
	<?php } ?>
	
	<?php if ($data->order->customer_id > 0){?>
		<div style="font-size: 19px">
	<b>ПІБ отримувача:</b>
	<?php echo CHtml::encode($data->order->getCustomerName($data->order->customer_id)); ?>
	</div>
	<?php } ?>

	<div style="font-size: 19px">
	<b><?php echo CHtml::encode($data->order->city->getAttributeLabel('city_name')); ?>:</b>
	<?php echo CHtml::encode($data->order->city->city_name); ?>
	</div>

	<div style="border: 2px solid;font-size: 25px; width: fit-content;">
	<b><?php echo CHtml::encode($data->getAttributeLabel('order_item_id')); ?>:</b>
	<?php echo "№ ".CHtml::encode($data->order_item_id); ?>
	</div>

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