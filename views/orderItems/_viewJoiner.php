<?php
/* @var $this OrderItemsController */
/* @var $data OrderItems */
?>

<?php 
$type = "joiner";
//show only tables

if($data->isTable($data->order_item_id)){
	//Yii::app()->params[$type.'Updated'] === 'odd' ? Yii::app()->params['rowStyle'] = 'even' : Yii::app()->params['rowStyle'] = 'odd';

	if( $data->isNewUpdateDate(CHtml::encode($data->joiner_updated), $type)){
	}else{
		if(Yii::app()->params[$type] != "0000-00-00 00:00:00"){
			
			$updated = CHtml::encode(Yii::app()->dateFormatter->format("y-MM-dd", $data->joiner_updated));
			echo "<div class='subtotal d-table-row'><div  class='d-table-cell'> <strong>   ";
			echo CHtml::encode(Yii::app()->dateFormatter->format("dd-MM-y", $data->joiner_updated));
			echo "</strong> </div><div class='d-table-cell'></div><div class='d-table-cell'></div><div  class='d-table-cell'></div>";
			// echo "Всього: " . $data->getCountFinishedItemsAll($type, $updated) . "</br>";
			echo "<div  class='d-table-cell text-right'>Всього: " . $data->getCountFinishedItemsByType(1, $type, $updated) . "</div>";
			// echo "Стільці: " . $data->getCountFinishedItemsByType(2, $type, $updated)  . "</br>";
			// echo "Табурети: " . $data->getCountFinishedItemsByType(3, $type, $updated)  . "</br>";
			echo"</div>";
		}else{
			echo "<div class='minus'>";
			echo "-";
			echo "</div>";
		}	
	}
	?> 

	 <div class=" d-table-row odd <?php echo  Yii::app()->params['rowStyle'];?>" >
	<div class="d-table-cell">

		<?php echo CHtml::encode(Yii::app()->dateFormatter->format("HH:mm:ss", $data->joiner_updated)); ?>	 
	</div>
	<div class="d-table-cell">

		<?php echo CHtml::link(CHtml::encode($data->order_item_id), array('view', 'id'=>$data->order_item_id)); ?>
		 
	</div>
	<div class="d-table-cell">

		<?php echo CHtml::encode($data->product->product_name); ?>
		 
	</div><div class="d-table-cell">

		<?php echo CHtml::encode($data->getColorWithoutLink($data->order_item_id)); ?>
		 
	</div>
	 
	<div class="d-table-cell">

		<?php echo CHtml::encode($data->quantity); ?>
		 
	</div>

	 
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
<?
}
?>
</div>

