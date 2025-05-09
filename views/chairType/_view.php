<?php
/* @var $this ChairTypeController */
/* @var $data ChairType */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('chair_type_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->chair_type_id), array('view', 'id'=>$data->chair_type_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />


</div>