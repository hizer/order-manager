<?php
/* @var $this InvoiceController */
/* @var $model Invoice */

$this->breadcrumbs=array(
	'Накладні',
);



Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#invoice-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	// if($('#Invoice_period_0').is(':checked')){		
		$('#getSummary').click()
	// }else{
		// clearSummary();
	// }
	return false;
});
	jQuery(document).ready(function () {
		// $('.search-form .buttons input').click()
		$('#getSummary').click();
});

$('.toggle-range-filter input[type=radio]').change(function() {
	console.log('clicked')
    if (this.value == '0') {
		$('#Invoice_created_on_0').datepicker('enable'); 
        $('#Invoice_created_on_1').datepicker('enable'); 
    }
    else if (this.value == '1') {
        $('#Invoice_created_on_0').datepicker('disable'); 
        $('#Invoice_created_on_1').datepicker('disable'); 
    }
});

function clearSummary(){
	$('#totalAmout').text('-');
	$('#table').text('-');
	$('#chair').text('-');
	$('#taburet').text('-');
}

function getDateFrom(){
	var ret = '';			
	if($('#Invoice_period_0').is(':checked')){		
		ret = $('#Invoice_created_on_0').val() + ' 00:00:00';
	}	
	console.log($('#Invoice_period_0').is(':checked') + ' ' + $('#Invoice_created_on_0').val())
	return ret;
}

function getDateTo(){
	var ret = '';	
	if($('#Invoice_period_0').is(':checked')){		
		ret = $('#Invoice_created_on_1').val() + ' 23:59:59';
	}	
		console.log($('#Invoice_period_0').is(':checked') + ' ' + $('#Invoice_created_on_1').val())
	return ret;
}
 
");






?>

<h1>Накладні</h1>


<?php echo CHtml::link('Розширений пошук','#',array('class'=>'search-button')); ?>
<div class="search-form"  >
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

 <?php
 
 
  
echo CHtml::ajaxLink(
    'Test request',          // the link body (it will NOT be HTML-encoded.)
    array('invoiceItems/reqTest01Loading'), // the URL for the AJAX request. If empty, it is assumed to be the current URL.
array(
			 'type'=>'POST',
			'dataType'=> 'json',
		'data' =>'js:{
			"createdFrom": getDateFrom(), 
			"createdTo": getDateTo(),
			"manager": $( "#Invoice_manager_search" ).val(),
			"shop": $( "#Invoice_shop_search" ).val(),
			"account": $( "#Invoice_account_id" ).val(),
		 
			}',
		'success' => 'function(data){
							// var response = JSON.parse( data );
                            $("#totalAmout").text(Number((data[0].totalAmout).toFixed(0)).toLocaleString());
                            $("#table").text(data[0].table);
                            $("#chair").text(data[0].chair);
                            $("#taburet").text(data[0].taburet);
                            // $("#delivery").text(" (" + data[0].delivery+ " доставка)");
							console.log("data " , data)
                            }',
		'error' => 'function(data){
							// var response = JSON.parse( data );
                            $("#totalAmout").text("не вдалось виконати запит");
                            $("#table").text("не вдалось виконати запит");
                            $("#chair").text("не вдалось виконати запит");
                            $("#taburet").text("не вдалось виконати запит");
                            // $("#delivery").text(" (" + data[0].delivery+ " доставка)");
							console.log("data " , data)
                            }',
        'beforeSend' => 'function() {           
           $(".fa-spinner").show();
           $(".value").hide();
        }',
        'complete' => 'function() {
          $(".fa-spinner").hide();
          $(".value").show();
        }',    
		
		
    ),array('class'=>'hide', 'id'=>'getSummary',)
); 
  
?>
<table border="0">
<tr>
<td>Загальна сума:</td><td> <i class="fa fa-spinner  fa-spin fa-fw" style="display:none;" ></i><strong class="value" id="totalAmout"></strong> </td>
</tr>
<tr>
<td>Столів:</td><td><i class="fa fa-spinner  fa-spin fa-fw" style="display:none;" ></i><strong class="value" id="table"></strong></td>
</tr>
<tr>
<td>Стільці:</td><td> <i class="fa fa-spinner  fa-spin fa-fw" style="display:none;" ></i><strong class="value" id="chair"></strong></td>
</tr>
<tr>
<td>Табуретів:</td><td><i class="fa fa-spinner  fa-spin fa-fw" style="display:none;" ></i><strong class="value" id="taburet"></strong></td>
</tr>
</table>
 
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'invoice-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		//'invoice_id',
        array(
            'name'=>'account_id',
            'value'=>'CHtml::link($data->account_id, Yii::app()->createUrl("invoice/view/",array("id"=>$data->primaryKey)))',
            'type'  => 'raw',
			'headerHtmlOptions'=>array(
                    'width'=>'65px',
                ),
				 'filter' => false,
        ),
        array(
            'name'=>'shop_id',
            'type'=>'raw',
			 'filter' => false,
            // 'filter' => CHtml::listData(Shops::model()->findAll(array('order' => 'full_name  ASC')), 'shop_id', 'full_name'),
            'value'=>'CHtml::link($data->shop->full_name, Yii::app()->createUrl("shops/view/",array("id"=>$data->shop_id)))',
        ),
        array(
            'name'=>'customer_id',
            'type'=>'raw',
			'filter' => false,
            'value'=>'Customers::model()->getCustomerLink($data->customer_id)',
        ),
		array(
            'name'=>'manager_id',
            'type'=>'raw',
            'value'=>'$data->manager->name',
			 'filter' => false,
			'headerHtmlOptions'=>array(
                    'width'=>'165px',
                ),
        ),
        //'created_on',
		array('name' => 'comment',
            'value' => '$data->comment',
            'filter' => false,
			'headerHtmlOptions'=>array(
                    'width'=>'300px',
                ),            
        ),
		array('header'=>'Столів',
            'value' => 'Yii::app()->format->formatNumber(InvoiceItems::model()->getTotalItemCountById($data->primaryKey,  "1" ))',
            'filter' => false,
           'htmlOptions' => array('class' => 'right'),
        ),
		array('header'=>'Стільців',
            'value' => 'InvoiceItems::model()->getTotalItemCountById($data->primaryKey,  "2" )',
            'filter' => false,
           'htmlOptions' => array('class' => 'right'),
        ),
		array('header'=>'Табуретів',
            'value' => 'InvoiceItems::model()->getTotalItemCountById($data->primaryKey,  "3" )',
            'filter' => false,
           'htmlOptions' => array('class' => 'right'),
        ),	
		array('header'=>'Сума',
            'value' => 'InvoiceItems::model()->getTotalInvoiceAmount($data->primaryKey)',
            'filter' => false,
            'htmlOptions' => array('class' => 'right'),
        ),
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
