<?php
/* @var $this OrderItemsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Столяр',
);
  Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/printAnalytics.js?v=12282020',CClientScript::POS_END); 



$data = OrderItems::model();
 Yii::app()->params['rowStyle'] = "even";
?>
<style type="text/css">
.d-table-row {
    display: table-row;
}

.items {
    width: 100%;
    display: table;
    background: white;
    border-collapse: collapse;
    width: 100%;

    margin-top: 15px;
}

.d-table-cell {
    display: table-cell;
    vertical-align: middle;
}
.d-table-cell p {
  margin: 0;
}

.d-table.items .list-view {
    width: 100%;
    display: table-row;
    position: relative;
 
}

.d-table-row-header.table-header {
    display: table-column;
}

.d-table-row.odd { 
    background: #E5F1F4;
 
}

.d-table-cell, .grid-view table.items td {
    font-size: 13px;
    border: 1px white solid;
    padding: 2px;
}

.subtotal.d-table-row > div {
    padding: 14px 0;
}
</style>

<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
 
	
	$('#getSummary').click()
	
	return false;
});
 jQuery(document).ready(function () { 
	 $('#getSummary').click();
	 setPrintpageTitle('OrderItems')
});
 



");

Yii::app()->clientScript->registerScript('productTable', " 

	function drawProductTable(data){
		
		var divTable = document.getElementById('product-table');
		divTable.innerHTML = '';
		
		var tbl = document.createElement('table');
		var tblHead = document.createElement('thead');	 
		var row = document.createElement('tr');
		var tblBody = document.createElement('tbody');	 
		
		 
		var thCellName = document.createElement('th');
		var thCellValue = document.createElement('th');
		var cellNameText = document.createTextNode('Назва');
		var cellValueText = document.createTextNode('Загальна кількість');
		
		thCellName.appendChild(cellNameText);
		thCellValue.appendChild(cellValueText);
		
		row.appendChild(thCellName);
		row.appendChild(thCellValue);	
		tblHead.appendChild(row);
		tbl.appendChild(tblHead);
		
			for (var key in data) {
				if (data.hasOwnProperty(key)) {
					row = document.createElement('tr');
					
					var cellName = document.createElement('td');
					var cellValue = document.createElement('td');
					
					cellNameText = document.createTextNode(key);
					cellValueText = document.createTextNode(data[key]);
					
					cellName.appendChild(cellNameText);
					cellValue.appendChild(cellValueText);
					
					row.appendChild(cellName);
					row.appendChild(cellValue);	
					
					tblBody.appendChild(row);
					console.log(key + ' -> ' + data[key]);
				}
			}
			tbl.appendChild(tblBody);
			  // appends <table> into <body>
			divTable.appendChild(tbl);
			tbl.setAttribute('class', 'items');
	}
");

 
?>
<h1>Столяр</h1>



<?php //echo CHtml::link('Розширений пошук','#',array('class'=>'search-button')); ?>
<div class=" "  >
<?php $this->renderPartial('_searchPeriod',array(
	'model'=>$model,
)); ?>
<?
	echo CHtml::button("Пошук",array('onclick'=>'$.fn.yiiListView.update("ajaxListView",{data: $(".hasDatepicker").serialize()}
            );  $("#getSummary").click(); setPrintpageTitle("OrderItems"); ','id'=>'search', 'class' => 'bt btn-2'));
?>

</div>

 <?php
  
// echo CHtml::ajaxLink(
    // 'Test request',          // the link body (it will NOT be HTML-encoded.)
    // array('orderItems/getAllFinishedProductByType'), // the URL for the AJAX request. If empty, it is assumed to be the current URL.
	// array(
			 // 'type'=>'POST',
			// 'dataType'=> 'json',
		// 'data' =>'js:{
						// "productType": [1], 
						// "jobArt": "joiner", 
						// "createdFrom": $("#OrderItems_created_on_from").val() + " 00:00:00", 
						// "createdTo": $("#OrderItems_created_on_to").val() + " 23:59:59" }',
		// 'success' => 'function(data){
						// var response = JSON.parse( data );
							// $("#totalAmout").text(Number((data[0].totalAmout).toFixed(0)).toLocaleString());      
							// drawProductTable(data)
						// }',
        // 'beforeSend' => 'function() {           
           // $(".fa-spinner").show();
           // $(".value").hide();
        // }',
        // 'complete' => 'function() {
          // $(".fa-spinner").hide();
          // $(".value").show();
        // }',
    // ),array('class'=>'hide', 'id'=>'getSummary',)
// ); 
  
echo CHtml::ajaxLink(
    'Test request',          // the link body (it will NOT be HTML-encoded.)
    array('orderItems/getTotalAmountFinishedProduct'), // the URL for the AJAX request. If empty, it is assumed to be the current URL.
	array(
			 'type'=>'POST',
			'dataType'=> 'json',
		'data' =>'js:{
						"productType": "1", 
						"jobArt": "joiner", 
						"createdFrom": $("#OrderItems_created_on_from").val() + " 00:00:00", 
						"createdTo": $("#OrderItems_created_on_to").val() + " 23:59:59" }',
		'success' => 'function(data){
						// var response = JSON.parse( data );
						$("#totalAmout").text(Number((data[0].totalAmout).toFixed(0)).toLocaleString()); 
						drawProductTable(data[0].items)						
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
<a href="#" id="printButton" class="print bt btn-2 printButton" rel="print" onclick="printPage()"><i class="fa fa-print feature-icon"></i> Друкувати</a>
<div id="print">
	 <div style="text-align: center;">
		<h3 class="d-none">Столяр</h3>
		<h4 id="selected-period" class="d-none"></h4>
	</div>
	<table border="0" style="margin: 20px 0">
	<tr>
	<td>Всього столів: </td><td> <i class="fa fa-spinner  fa-spin fa-fw" style="display:none;" ></i><strong class="value" id="totalAmout"></strong> </td>
	</tr>
	</table>

	<div id="product-table" class="grid-view">
	</div>
</div>



<div  class="grid-view">
	<div class="d-table items" >
		<div class="d-table-row-header table-header">
			<div class="d-table-cell"><?php echo CHtml::encode($data->getAttributeLabel('joiner_updated')); ?>
			</div>
			
			<div class="d-table-cell"><?php echo CHtml::encode($data->getAttributeLabel('order_item_id')); ?>
			</div>
			
			<div class="d-table-cell"><?php echo CHtml::encode($data->getAttributeLabel('product_search')); ?>
			</div>
			
			<div class="d-table-cell"><?php echo "Колір"; ?>
			</div>
			
			<div class="d-table-cell"><?php echo CHtml::encode($data->getAttributeLabel('quantity')); ?>
			</div>
			
		 
		</div>
	<?php $this->widget('zii.widgets.CListView', array(
		'dataProvider'=>$dataProvider,
		'itemView'=>'_viewJoiner',
		'id'=>'ajaxListView',
	 
	)); ?>
	</div>
</div>
