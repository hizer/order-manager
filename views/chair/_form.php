<?php
/* @var $this ChairController */
/* @var $model Chair */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'chair-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля, відмічені <span class="required">*</span> обов'язкові для заповнення.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php //echo $form->labelEx($model,'product_id'); ?>
		<?php //echo $form->textField($model,'product_id'); ?>
		<?php //echo $form->error($model,'product_id'); ?>
	</div>

  <div class="row">
        <?php echo $form->labelEx($model,'product_id'); ?>
        <?php

        $models = Products::model()->findAllByAttributes(array(
				'product_type_id'=>array('2','3'),
			),
			array('order' => 'product_name')
		);
        $list = CHtml::listData($models, 'product_id', 'product_name');
        echo CHtml::dropDownList('Chair[product_id]', $category, $list,
            array(
                'empty' => 'Виберіть товар',
                'id'=>'Chair_product_id',
                'options'=>array($model->product_id=>array('selected'=>'selected')),
            )
        );
        ?>
		<?php echo $form->error($model,'product_id'); ?>
    </div>
	
	<div class="row">
        <?php echo $form->labelEx($model,'chair_type_id'); ?>
        <?php

        $models = ChairType::model()->findAll(array('order' => 'name'));
        $list = CHtml::listData($models, 'chair_type_id', 'name');
        echo CHtml::dropDownList('Chair[chair_type_id]', $category, $list,
            array(
                'empty' => 'Виберіть модель',
                'id'=>'Chair_type_id',
                'options'=>array($model->chair_type_id=>array('selected'=>'selected')),
            )
        );
        ?>
		<?php echo $form->error($model,'chair_type_id'); ?>
    </div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Додати' : 'Зберегти'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->