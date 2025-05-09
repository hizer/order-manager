<?php
/* @var $this OrderItemsController */
/* @var $data OrderItems */
?>

<?php 
$type = "packing";
Yii::app()->params[$type.'Updated'] === 'odd' ? Yii::app()->params['rowStyle'] = 'even' : Yii::app()->params['rowStyle'] = 'odd';

if( $data->isNewUpdateDate(CHtml::encode($data->packing_updated), $type)){
}else{
	if(Yii::app()->params[$type.'Updated'] != "0000-00-00 00:00:00"){
		
		$updated = CHtml::encode(Yii::app()->dateFormatter->format("y-MM-dd", $data->packing_updated));
		echo "<tr><td colspan='6' ><strong>   ";
		echo CHtml::encode(Yii::app()->dateFormatter->format("dd-MM-y", $data->packing_updated));
		echo "<td><strong> ";
		echo "Всього: " . $data->getCountFinishedItemsAll($type, $updated) . "</br>";
		echo "Столи: " . $data->getCountFinishedItemsByType(1, $type, $updated) . "</br>";
		echo "Стільці: " . $data->getCountFinishedItemsByType(2, $type, $updated)  . "</br>";
		echo "Табурети: " . $data->getCountFinishedItemsByType(3, $type, $updated)  . "</br>";
		echo"</strong></td></tr>";
	}else{
		echo "<tr><td colspan='5'>";
		echo"-";
		echo"</td></tr>";
	}	
}
?> 

 <tr class="<?php echo  Yii::app()->params['rowStyle'];?>" >
<td>
	<b><?php //echo CHtml::encode($data->getAttributeLabel('finish_updated')); ?></b>
	<?php echo CHtml::encode(Yii::app()->dateFormatter->format("HH:mm:ss", $data->packing_updated)); ?>
</td>
<td>
	<b><?php//echo CHtml::encode($data->getAttributeLabel('order_item_id')); ?></b>
	<?php echo CHtml::link(CHtml::encode($data->order_item_id), array('view', 'id'=>$data->order_item_id)); ?>
	 
</td>
<td>
	<b><?php //echo CHtml::encode($data->getAttributeLabel('order_id')); ?></b>
	<?php echo CHtml::encode($data->product->product_name); ?>
	 
</td>
<td>
	<b><?php //echo CHtml::encode($data->getAttributeLabel('order_id')); ?></b>
	<?php echo CHtml::encode($data->getColorWithoutLink($data->order_item_id)); ?>
</td>
<td>
	<b><?php //echo CHtml::encode($data->getAttributeLabel('order_id')); ?></b>
	<?php echo CHtml::encode($data->order->shop->full_name); ?>
</td>
<td>
	<b><?php //echo CHtml::encode($data->getAttributeLabel('order_id')); ?></b>
	<?php echo CHtml::encode(Orders::model()->getCustomerName($data->order->customer_id)); ?>
</td>
 
<td>
	<b><?php //echo CHtml::encode($data->getAttributeLabel('quantity')); ?></b>
	<?php echo CHtml::encode($data->quantity); ?>
	 
</td>

 
	<?php /*
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

</tr>

