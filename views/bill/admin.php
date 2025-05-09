<?php
/* @var $this BillController */
/* @var $model Bill */

$this->breadcrumbs=array(

	'Рахунки',
);

Yii::app()->clientScript->registerScript('re-install-date-picker', "
function reinstallDatePicker(id, data) {
    $('#datepicker_for_due_date').datepicker(jQuery.extend({showMonthAfterYear:false},jQuery.datepicker.regional['uk'],{'dateFormat':'yy-mm-dd'}));
 
}
");
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#bill-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Рахунки</h1>

<?php echo CHtml::link('Розширений пошук','#',array('class'=>'search-button ')); ?>

<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

 

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'bill-grid',
	'dataProvider'=>$model->search(),
    'afterAjaxUpdate' => 'reinstallDatePicker',
	'rowHtmlOptionsExpression' => 'array("data-created"=>$data->created_on)',
	'filter'=>$model,
	'columns'=>array(
		//'bill_id',
		//'account_id',
        array(
            'name'=>'account_id',
            'value'=>'CHtml::link($data->account_id, Yii::app()->createUrl("bill/view/",array("id"=>$data->primaryKey)))',
            'type'  => 'raw',
			'headerHtmlOptions'=>array(
                    'width'=>'65px',
                ),
        ),
        array(
            'name'=>'shop_id',
            'type'=>'raw',
            'filter' => CHtml::listData(Shops::model()->findAll(array('order' => 'full_name  ASC')), 'shop_id', 'full_name'),
            'value'=>'CHtml::link($data->shop->full_name, Yii::app()->createUrl("shops/view/",array("id"=>$data->shop_id)))',
        ),
        array(
            'name'=>'customer_search',
            'type'=>'raw',
            'value'=>'Customers::model()->getCustomerLink($data->customer_id)',
        ),
		array('name' => 'comment',
            'value' => '$data->comment',
            'filter' => false,
            'headerHtmlOptions'=>array(
                    'width'=>'300px',
                ),
        ),
	 
		
		// array('header'=>'Столів',
            // 'value' => 'BillItems::model()->getTotalItemCountById($data->primaryKey,  "1" )',
            // 'filter' => false,
           // 'htmlOptions' => array('class' => 'right'),
        // ),
		// array('header'=>'Стільців',
            // 'value' => 'BillItems::model()->getTotalItemCountById($data->primaryKey,  "2" )',
            // 'filter' => false,
           // 'htmlOptions' => array('class' => 'right'),
        // ),
		// array('header'=>'Табуретів',
            // 'value' => 'BillItems::model()->getTotalItemCountById($data->primaryKey,  "3" )',
            // 'filter' => false,
           // 'htmlOptions' => array('class' => 'right'),
        // ),	
		// array('header'=>'Сума',
            // 'value' => 'BillItems::model()->getTotalBillAmount($data->primaryKey)',
            // 'filter' => false,
            // 'htmlOptions' => array('class' => 'right'),
        // ),
		//'created_on',
        array('name' => 'created_on',
            'value' => 'Yii::app()->dateFormatter->format("dd-MM-y", $data->created_on)',
            'filter' => false,
            'htmlOptions' => array('class' => 'date'),
        ),
		'creator.username',
		
		/*
		'modified_on',
		'modified_by',
		*/
		array(
			'class'=>'CButtonColumn',
            'template'=>'{view}{delete}',
		),
	),
)); ?>
