<?php
/* @var $this TableInsertController */
/* @var $model TableInsert */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'table_insert_id'); ?>
		<?php echo $form->textField($model,'table_insert_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'add'); ?>
		<?php echo $form->textField($model,'add'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->