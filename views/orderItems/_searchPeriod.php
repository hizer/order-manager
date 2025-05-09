<?php
/* @var $this OrderItemsController */
/* @var $model OrderItems */
/* @var $form CActiveForm */
?>


<div class="form">

    <?php echo CHtml::beginForm('', 'get', array('id'=>'searchform')); ?>

    <p>Створено</p>
	<div class="form-period">
    <?php
    // Date range search inputs
    $attribute = 'created_on';
	$model=new OrderItems();
    for ($i = 0; $i <= 1; $i++)
    {
     $label = $i == 0 ? "from" : "to";
		echo ($i == 0 ? Yii::t('main', '<p>Від: ') : Yii::t('main', '<p>До: '));
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'id'=>CHtml::activeId($model, $attribute.'_'.$label),
			'name'=>'OrderItems[created_on]['.$label.']',  
            // 'model'=>$model,
			'value'=>($i == 0 ? date('Y-m-01') : date('Y-m-d')),		
            'language' => 'uk',
            'attribute'=>$attribute."[$label]",
            'options'=>array(
				'showOn' => 'focus',
                'showAnim'=>'fold',
                'dateFormat'=>'yy-mm-dd',
				'showOtherMonths' => true,
				'selectOtherMonths' => true,
				'changeMonth' => true,
				'changeYear' => true,
				'showButtonPanel' => true,
            ),
        ));
    }
	
    ?>
</div>


    <?php echo CHtml::endForm(); ?>

</div><!-- form -->
