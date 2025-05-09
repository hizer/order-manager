<?php
/* @var $this InvoiceController */
/* @var $model Invoice */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

<p>Пошук за:</p>
<div class="compactRadioGroup toggle-range-filter">
	 
	 <input id="Invoice_period_0" value="0" checked="checked" type="radio" name="Invoice[period_search]"> 
	 <label for="Invoice_period_0">обраний період</label><br>
	<input id="Invoice_period_1" value="1" type="radio" name="Invoice[period_search]"> 
	<label for="Invoice_period_1">весь період</label>
	     
</div>

<p>Створено</p>
    <?php
    // Date range search inputs
    $attribute = 'created_on';			 
    for ($i = 0; $i <= 1; $i++)
    {
        echo ($i == 0 ? Yii::t('main', '<p>Від: ') : Yii::t('main', '<p>До: '));
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'id'=>CHtml::activeId($model, $attribute.'_'.$i), 
			// 'attribute'=>$attribute."[$i]",
			 'name'=>'Invoice[created_on]['. $i .']',    
			'value'=>($i == 0 ? date('Y-m-01') : date('Y-m-d')),			
             // 'model'=>$model,
            'language' => 'uk',
            'attribute'=>$attribute."[$i]",
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
	
	 <div class="row">
            <?php echo $form->label($model,'shop_search'); ?>
            <?php $st = CHtml::listData(Shops::model()->findAll(array('order' => 'full_name  ASC')), 'shop_id', 'full_name');
            echo $form->dropDownList($model, 'shop_search', $st,
                array(
                    'empty' => 'Виберіть магазин',
                ));?>
				
        </div>
		
		<div class="row">
            <?php echo $form->label($model,'manager_search'); ?>
            <?php $st = CHtml::listData(Manager::model()->findAll(array('order' => 'name  ASC')), 'manager_id', 'name');
            echo $form->dropDownList($model, 'manager_search', $st,
                array(
                    'empty' => 'Виберіть керівника',
                ));?>
				
				
			<?php echo $form->label($model,'account_id'); ?>
			<?php echo $form->textField($model,'account_id',array('size'=>10,'maxlength'=>10)); ?>	
			
        </div>
	 
	<div class="row buttons">
		<?php echo CHtml::submitButton('Пошук'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->