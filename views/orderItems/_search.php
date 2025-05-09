<?php
/* @var $this OrderItemsController */
/* @var $model OrderItems */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
    <p>Створено</p>
    <?php
    // Date range search inputs
    $attribute = 'created_on';
    for ($i = 0; $i <= 1; $i++)
    {
        echo ($i == 0 ? Yii::t('main', '<p>Від: ') : Yii::t('main', '<p>До: '));
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'id'=>CHtml::activeId($model, $attribute.'_'.$i),
            'model'=>$model,
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
        <?php echo $form->label($model,'city_or_region'); ?>
        <?php echo $form->textField($model,'city_search'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'customer_search'); ?>
        <?php echo $form->textField($model,'customer_search'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'type_search'); ?>
        <?php $type = CHtml::listData(ProductsTypes::model()->findAll(array('order' => 'name  ASC')), 'name', 'name');
        echo $form->dropDownList($model, 'type_search', $type,
            array(
                'empty' => 'Виберіть тип',
            ));?>
    </div>
	<div class="row">
        <?php echo $form->label($model,'all_customer_search'); ?>
        <?php echo $form->dropDownList($model, 'all_customer_search', array('order.order_id' => 'Всі ','order.shop_id' => 'Тільки магазини ', 'order.customer_id' => 'Тільки сайт'));?>
    </div>	
	<div class="row">
		<div class="span2">
			<?php echo $form->label($model,'joiner'); ?>
			 <div class="compactRadioGroup">
				<?php   echo $form->radioButtonList($model, 'joiner',
					array(  0 => 'Ні',
						1 => 'Так' ) );
				?>
			</div> 
        </div> 
		 <div class="span2">
			<?php echo $form->label($model,'finish'); ?>
			 <div class="compactRadioGroup">
				<?php   echo $form->radioButtonList($model, 'finish',
					array(  0 => 'Ні',
						1 => 'Так' ) );
				?>
			</div>
        </div>
		 <div class="span2">
			<?php echo $form->label($model,'upholstery'); ?>
			 <div class="compactRadioGroup">
				<?php   echo $form->radioButtonList($model, 'upholstery',
					array(  0 => 'Ні',
						1 => 'Так' ) );
				?>
			</div>
        </div>
		<div class="span2">
			<?php echo $form->label($model,'packing'); ?>
			 <div class="compactRadioGroup">
				<?php   echo $form->radioButtonList($model, 'packing',
					array(  0 => 'Ні',
						1 => 'Так' ) );
				?>
			</div>
        </div>
    </div>
	<div class="row buttons">
		<?php echo CHtml::submitButton('Пошук'); ?>
	</div>
<?php $this->endWidget(); ?>
</div><!-- search-form -->