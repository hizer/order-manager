<?php
/* @var $this OrdersItemsPropertiesController */
/* @var $model OrdersItemsProperties */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'orders-items-properties-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'order_item_id'); ?>
		<?php echo $form->textField($model,'order_item_id'); ?>
		<?php echo $form->error($model,'order_item_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'property_id'); ?>
		<?php echo $form->textField($model,'property_id'); ?>
		<?php echo $form->error($model,'property_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'add_payment'); ?>
		<?php echo $form->textField($model,'add_payment'); ?>
		<?php echo $form->error($model,'add_payment'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'created_on'); ?>
		<?php echo $form->textField($model,'created_on'); ?>
		<?php echo $form->error($model,'created_on'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'created_by'); ?>
		<?php echo $form->textField($model,'created_by',array('size'=>32,'maxlength'=>32)); ?>
		<?php echo $form->error($model,'created_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'modified_on'); ?>
		<?php echo $form->textField($model,'modified_on'); ?>
		<?php echo $form->error($model,'modified_on'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'modified_by'); ?>
		<?php echo $form->textField($model,'modified_by',array('size'=>32,'maxlength'=>32)); ?>
		<?php echo $form->error($model,'modified_by'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Додати' : 'Зберегти'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->