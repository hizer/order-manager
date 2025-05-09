<?php
/* @var $this OrderItemsController */
/* @var $model OrderItems */
/* @var $form CActiveForm */
?>

<div class="wide form">


    <div class="inline">
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


    </div>

    <div class="inline">
        <div class="row">
            <?php echo $form->label($model,'city_or_region'); ?>
            <?php echo $form->textField($model,'city_search'); ?>
        </div>

        <div class="row">
            <?php echo $form->label($model,'shop_search'); ?>
            <?php $st = CHtml::listData(Shops::model()->findAll(array('order' => 'full_name  ASC')), 'full_name', 'full_name');
            echo $form->dropDownList($model, 'shop_search', $st,
                array(
                    'empty' => 'Виберіть магазин',
                ));?>
        </div>

    </div>

    <div class="inline">
<!--        <div class="row">-->
<!--            --><?php //echo $form->label($model,'type_search'); ?>
<!--            --><?php //$type = CHtml::listData(ProductsTypes::model()->findAll(array('order' => 'name  ASC')), 'name', 'name');
//            echo $form->dropDownList($model, 'type_search', $type,
//                array(
//                    'empty' => 'Виберіть тип',
//                ));?>
<!--        </div>-->

        <div class="row">
            <?php echo $form->label($model,'product_search'); ?>
            <?php echo $form->textField($model,'product_search'); ?>
        </div>

        <div class="row">
            <?php echo $form->label($model,'color_search'); ?>
            <?php echo $form->textField($model,'color_search'); ?>
        </div>
		<div class="row">
			<?php echo $form->label($model,'type_search'); ?>
			<?php $type = CHtml::listData(ProductsTypes::model()->findAll(array('order' => 'name  ASC')), 'name', 'name');
			echo $form->dropDownList($model, 'type_search', $type,
				array(
					'empty' => 'Виберіть тип',
				));?>
		</div>
    </div>


    <div class="row buttons">
        <?php echo CHtml::submitButton('Пошук'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->