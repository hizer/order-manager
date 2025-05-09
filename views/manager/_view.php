<?php
/* @var $this ManagerController */
/* @var $data Manager */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('manager_id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->manager_id), array('view', 'id'=>$data->manager_id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('edrpou')); ?>:</b>
	<?php echo CHtml::encode($data->edrpou); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('address')); ?>:</b>
	<?php echo CHtml::encode($data->address); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tel')); ?>:</b>
	<?php echo CHtml::encode($data->tel); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('account')); ?>:</b>
	<?php echo CHtml::encode($data->account); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mfo')); ?>:</b>
	<?php echo CHtml::encode($data->mfo); ?>
	<br />

 
	<b><?php echo CHtml::encode($data->getAttributeLabel('comment')); ?>:</b>
	<?php echo CHtml::encode($data->comment); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('bydefault')); ?>:</b>
	<?php echo CHtml::encode($data->bydefault); ?>
	<br />

 

</div>