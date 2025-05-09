<?php
/* @var $this TableInsertController */
/* @var $data TableInsert */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('table_insert_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->table_insert_id), array('view', 'id'=>$data->table_insert_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('add')); ?>:</b>
	<?php echo CHtml::encode($data->add); ?>
	<br />


</div>