<?php
/* @var $this TableInsertController */
/* @var $model TableInsert */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'table-insert-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля, відмічені <span class="required">*</span> обов'язкові для заповнення.</p>

	<?php echo $form->errorSummary($model); ?>

 

	<div class="row">
		<?php echo $form->labelEx($model,'add'); ?>
		<?php echo $form->textField($model,'add'); ?>
		<?php echo $form->error($model,'add'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Додати' : 'Зберегти'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->