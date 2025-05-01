<?php
/* @var $this OrdersController */
/* @var $model Orders */

$this->breadcrumbs=array(
	'Замовлення'=>array('admin'),
	'Додати замовлення',
);

?>

<h1>Додати замовлення</h1>
<div class="add-order-form-wrapper">
<div class="form order">
 
    <?php echo $form; ?>
</div>
<div class="form properties">

<?php
	$modelProperties = new Properties;
	Yii::import('application.controllers.PropertiesController');
	$controller_instance = new PropertiesController("Properties");
	$propertiesForm=$controller_instance->beginWidget('CActiveForm', array(
	'id'=>'properties-form-ajax',
	'enableAjaxValidation'=>false,
        'htmlOptions'=>array(
                               'onsubmit'=>"return false;",/* Disable normal form submit */
                              // 'onkeypress'=>" if(event.keyCode == 13){ send(); } " /* Do ajax call when user presses enter key */
                             ),
)); ?>

	
	<?php echo $propertiesForm->errorSummary($modelProperties); ?>

	 <div class="row">
        <?php echo $propertiesForm->labelEx($modelProperties,'attribute_id'); ?>
        <?php
        $models =  Attributes::model()->findAll(array('order' => 'name'));
        $list = CHtml::listData($models, 'attribute_id', 'name');
        echo CHtml::dropDownList('Properties[attribute_id]', $category, $list,
            array(
                'empty' => 'Виберіть атрибут',
                'id'=>'Properties_attribute_id',
                'options'=>array('10'=>array('selected'=>'selected')),
            )
        );
        ?>
    </div>

	<div class="row">
		<?php echo $propertiesForm->labelEx($modelProperties,'name'); ?>
		<?php echo $propertiesForm->textField($modelProperties,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $propertiesForm->error($modelProperties,'name'); ?>
	</div>

	<div class="row">
		<?php echo $propertiesForm->labelEx($modelProperties,'property_info_id'); ?>
        <?php

            $models = PropertiesInfo::model()->findAll(array('order' => 'collection ASC'));
            $list = CHtml::listData($models, 'property_info_id', 'collection');
            echo CHtml::dropDownList('Properties[property_info_id]', $category, $list,
                array(
                    'empty' => 'Виберіть атрибут кольору',
                    'id'=>'PropertiesInfo_property_info_id',
                    // 'options'=>array($modelProperties->propertyInfo->property_info_id=>array('selected'=>'selected')),
                )
            );
        ?>
    </div>

	<div class="row buttons">
	    <?php echo CHtml::Button('Додати колір',array('onclick'=>'send();')); ?> 
	</div>

<?php //$this->endWidget(); ?>

</div>
</div><!-- form -->
<script type="text/javascript">

$("#Properties_attribute_id").prop('required',true);
$("#Properties_name").prop('required', 'required');
function send()
 {
   var form = $("#properties-form-ajax");
   var data=form.serialize();
		 
	if( $("#Properties_attribute_id").val() == "" ){
		alert("Виберіть атрибут!");
		return;
	}
	if( $("#Properties_name").val() == "" ){
	  alert("Введіть назву нового атрибуту!");
		return;
	}

	  $.ajax({
	   type: 'POST',
		url: '<?php echo Yii::app()->createAbsoluteUrl("properties/createWithAjax"); ?>',
	   data:data,
	success:function(data){
					alert("Додано новий колір!"); 
				  },
	   error: function(data) { // if error occured
			 alert("Error occured.please try again");
			 //alert(data);
		},

	  dataType:'html'
	  });
	  form[0].reset();		
}

</script>

