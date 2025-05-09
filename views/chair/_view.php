<?php
/* @var $this ChairController */
/* @var $data Chair */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('chair_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->chair_id), array('view', 'id'=>$data->chair_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('product_id')); ?>:</b>
	<?php echo CHtml::encode($data->product_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('chair_type_id')); ?>:</b>
	<?php echo CHtml::encode($data->chair_type_id); ?>
	<br />


</div>