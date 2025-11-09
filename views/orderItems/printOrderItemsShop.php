<?php
/* @var $this OrderItemsController */
/* @var $model OrderItems */
Yii::app()->clientScript->registerCss('cs1','

div.page-break{
page-break-after: always;
margin-bottom:0px;
padding:0;

}
.text-center{
	text-align: center;
}
.shop-name{
	margin-top: 35px;
}
');

Yii::app()->clientScript->registerScript('print', "
function paintOrder(){
var d = new Date();
$('[data-created]').each(function(){
    var get = $(this).data('created')
    var res = (new Date(d).getTime() - new Date(get).getTime())/1000/60/60/24
    if (res < 14 ){
        $(this).find('.date').addClass('green')
    }else if(res >=14 && res <=21){
        $(this).find('.date').addClass('yellow')
    }else if(res>21) {
       $(this).find('.date').addClass('red')
    }
})
}
paintOrder();
$('.print').click(function() {
        pathArray = window.location.href.split( '/' );
        protocol = pathArray[0];
        host = pathArray[2];
        url = protocol + '//' + host + '/css/printItems.css';
		$('#print').printElement({
             overrideElementCSS:[
		    '../../css/printItems.css',
		    { href:'../../css/printItems.css',media:'print'}],
             pageTitle:'замовленні товари'
        });
});
paintOrder();
var elements = [];

/*$('span[data-cityname]').each(function(){
    var currShop = $(this).text();
    var nextShop = $(this).closest('tr').next().find('span[data-cityname]').text();
    var prevShop = $(this).closest('tr').prev().find('span[data-cityname]').text();
	
    
    if ( currShop !='' &&  currShop != nextShop){
		var a = $(this).closest('tbody').find()
		
		
var emptyRow = '<tr><td colspan=\'20\' style=\'height: 20px; padding:0; margin:0;\'></td></tr>'    

    $(emptyRow).insertAfter( $(this).closest('tr'));
    }
    if (currShop !='' && currShop != prevShop){
        $(this).css({'fontWeight':'bold', 'backgroundColor' : 'yellow'})
    }

elements.push(name);
});*/

/*$('tr[data-shopname]').each(function(){
    var currShop = $(this).attr('data-shopname');
    var nextShop = $(this).closest('tr').next().find('tr[data-shopname]').attr('data-shopname');
    //var prevShop = $(this).closest('tr').prev().find('tr[data-shopname]').attr('data-shopname');
	
    
    if ( currShop !='' &&  currShop != nextShop){
		var height= 0;
		var list = document.querySelectorAll('[data-shopname=\''+currShop+'\']'); 		
		for(var i = 0, l=list.length; i< l; i++){
			height += list[i].offsetHeight;
		}
		
		height = 920 - height;
		var emptyRow = '<tr><td colspan=\'20\' style=\'height: '+height+'px; padding:0; margin:0;\'></td></tr>'    

		$(emptyRow).insertAfter( $(this).closest('tr'));
    }
});*/

var arrShopsToPrint = {};
var arrProductType = {};
function splitTable(table, maxHeight) {
	var header = table.children('thead');
	if (!header.length)
		return;

	var headerHeight = header.outerHeight();
	var header = header.detach();

	var splitIndices = [0];
	var rows = table.children('tbody').children();

	maxHeight -= headerHeight;
	var currHeight = 0;
	rows.each(function(i, row) {
		var currShop = $(this).attr('data-shopname');
		var nextShop = $(this).prev().attr('data-shopname');
		currHeight += $(rows[i]).outerHeight();
		
		if ((currHeight > maxHeight || currShop != nextShop) && currShop != '') {
			splitIndices.push(i);
			
			currHeight = $(rows[i]).outerHeight();
			//console.log([i] + ': '+currShop , nextShop)
		}
	});
	splitIndices.push(undefined);

	table = table.replaceWith('<div id=\"_split_table_wrapper\"></div>');
	table.empty();

	for(var i=1; i<splitIndices.length-1; i++) {
		var newTable = table.clone();
		
		if (i>0){newTable.addClass('cloned').attr('id', 'table'+i)}
		header.clone().appendTo(newTable);
		$('<tbody />').appendTo(newTable);
		
		$('<div class=\"shop-name\" data-id=\"'+i+'\" data-shop=\"'+rows.get(splitIndices[i]).getAttribute('data-shopname')+'\">' + rows.get(splitIndices[i]).getAttribute('data-cityname')+' - '+ rows.get(splitIndices[i]).getAttribute('data-shopname') + '</div>').appendTo(\"#_split_table_wrapper\");
		rows.slice(splitIndices[i], splitIndices[i+1]).appendTo(newTable.children('tbody'));			
		newTable.appendTo(\"#_split_table_wrapper\");
		getCountProductType(rows.get(splitIndices[i]).getAttribute('data-shopname'), i)	
		if (splitIndices[i+1] !== undefined) {		
			//console.log('rows', rows)		
		
			$('<div class=\"page-break\" id=\"page-break-'+i+'\"></div>').appendTo(\"#_split_table_wrapper\");
				//arrProductType = {};	
		}
	}
}
	
	function getCountProductType(shop, id){
		var shopRows = document.querySelectorAll('[id=\"table'+id+'\"] [data-shopname=\"'+shop+'\"]')
		var tempArr = {};
		//arrProductType = {};
		
		if(!arrShopsToPrint.hasOwnProperty(shop)){
			arrShopsToPrint[shop] = 0;
		}
		if( arrProductType[shop] === undefined){
			arrProductType[shop] = {};
		}
		if( tempArr[shop] === undefined){
			tempArr[shop] = {};
		}
		arrShopsToPrint[shop] = arrShopsToPrint[shop] +  1;
		 for(var i=0; i < shopRows.length; i++) {
			 var type = shopRows.item(i).getAttribute('data-type')
			 var quantity = shopRows.item(i).getAttribute('data-quantity')
			 arrProductType[shop][type] =  parseInt(quantity)  + (arrProductType[shop][type] === undefined ? 0 : parseInt(arrProductType[shop][type]));
			 tempArr[shop][type] =  parseInt(quantity)  + (tempArr[shop][type] === undefined ? 0 : parseInt(tempArr[shop][type]));
			 
		 }
		var ret = ' * '
		console.log('tempArr' , tempArr[shop])
		 
		 //tempArr = Object.keys(tempArr).sort(function(a,b){return tempArr[a]-tempArr[b]})
		 
		for (var s in tempArr) {
			//tempArr[s] = Object.keys(tempArr[s]).sort(function(a,b){return tempArr[s][a]-tempArr[s][b]})
			for (var k in tempArr[s]) {
				ret +=  k  + ': <b>' + tempArr[s][k]+ '</b> * '; 
			}
			ret += ' // Сторінка: '+ arrShopsToPrint[shop];
		}
		 
		//$('<span > ' + ret +'</span>').insert('[ data-id=\"'+i+'\"]')
		$('[ data-id=\"'+id+'\"]').append('<span style=\"text-transform: uppercase; font-weight: bold; \">' + ret +'</span>')
		 //console.log('arrProductType',shop, arrProductType)
		 
	}
	
	function setAllProductCountToShop(){
		var ret = ' * '
		 console.log('arrProductType ' , arrProductType)
		 
		for (var s in arrProductType) {
			for (var k in arrProductType[s]) {
				ret +=  '<span class=\" summary-count\" style=\"text-transform: uppercase; font-weight: bold; \">' + k  + ': ' + arrProductType[s][k]+ '</span> ** '; 
			}
			 console.log('ымагаз ' , s)
			 if(arrShopsToPrint[s] > 1){
				 $('[ data-shop=\"'+s+'\"]').append('<span style=\" text-transform: uppercase; font-weight: bold;\"> з '+arrShopsToPrint[s]+' // ' + ret +'</span>')
			 }else{
				$('[ data-shop=\"'+s+'\"]').append('<span style=\" text-transform: uppercase; font-weight: bold;\"> з '+arrShopsToPrint[s]+'</span> // ') 
			 }
			
			ret =''
		}
		
		//var shopRows = document.querySelectorAll('.shop-name')
		 
		// console.log('ret ' , ret)
		
		
		


			console.log('arrShopsToPrint' , arrShopsToPrint)
	}
$(document).ready(function(){
//$(function() { 
splitTable($('.items'), 990); 
setAllProductCountToShop()
	

//});
});
");
?>

<h1>Магазини: друкувати замовленні товари</h1>

<a href="#" class="print bt btn-2" rel="print"><i class="fa fa-print feature-icon"></i> Друкувати</a>

<div id="print">
 <?php 

//$orderItems->getCountPrintShopItems();


?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'order-items-grid',
    'itemsCssClass' => 'items order',
    'dataProvider'=>$orderItems->search_shop(),
    'template' => '{items} {pager}',//{summary}
    'rowHtmlOptionsExpression' => 'array("data-created"=>$data->created_on, 
	"data-shopname"=>$data->order->shop->full_name, 
	"data-cityname"=>$data->order->city->city_name,	
	"data-quantity"=>$data->quantity,
	"data-type"=>$data->product->productType->name)',
    'columns'=>array(
        array(
            'name' => 'created_on',
            'htmlOptions' => array('class' => 'date'),
            'value'=>'Yii::app()->dateFormatter->format("dd-MM-y", $data->order->created_on)',
            'headerHtmlOptions'=>array(
                'width'=>'69px',
            ),
            //'htmlOptions' => array('class' => 'created_on'),
        ),
		array(
            'name'=>'order_id',
            'type'=>'raw',
            'headerHtmlOptions'=>array(
                'width'=>'37px',
            ),
            'htmlOptions' => array('class' => 'order_id'),
        ),
        array(
            'name'=>'order_item_id',
            'type'=>'raw',
            'headerHtmlOptions'=>array(
                'width'=>'37px',
            ),
            'htmlOptions' => array('class' => 'order_id'),
        ),
        /*array(
            'name'=>'city_search',
            'type'=>'raw',
            'value'=>'$data->order->city->city_name',
            'headerHtmlOptions'=>array(
                'width'=>'85px',
            ),
            'htmlOptions' => array('class' => 'city_search'),
        ),*/
        /*array(
            'name'=>'shop_search',
             'type'=>'raw',
            'value'=>' $data->order_id ? $data->getShopName($data->order_item_id) : ""' ,
            'headerHtmlOptions'=>array(
                'width'=>'135px',
            ),
            'htmlOptions' => array('class' => 'shop_search', ),
        ),*/
        array(
            'name'=>'product_id',
            'type'=>'raw',
            'value'=>'$data->product->product_name',
            'headerHtmlOptions'=>array(
                'width'=>'100px',
            ),
            'htmlOptions' => array('class' => 'product_id'),
        ),

        array(
            'name'=>'length',
            'type'=>'raw',
            'headerHtmlOptions'=>array(
                'width'=>'37px',
            ),
            'htmlOptions' => array('class' => 'size'),
        ),
        array(
            'name'=>'insert',
            'type'=>'raw',
            'headerHtmlOptions'=>array(
                'width'=>'37px',
            ),
            'htmlOptions' => array('class' => 'size'),
        ),
        array(
            'name'=>'width',
            'type'=>'raw',
            'headerHtmlOptions'=>array(
                'width'=>'37px',
            ),
            'htmlOptions' => array('class' => 'size'),
        ),
        array(
            'name'=>'height',
            'type'=>'raw',
            'headerHtmlOptions'=>array(
                'width'=>'37px',
            ),
            'htmlOptions' => array('class' => 'size'),
        ),
        array(
            'name'=>'quantity',
            'type'=>'raw',
            'headerHtmlOptions'=>array(
                'width'=>'37px',
            ),
            'htmlOptions' => array('class' => 'size'),
        ),
        array(
            'header'=>'Колір',
            'value'=>'$data->getColor($data->order_item_id)',
            'headerHtmlOptions'=>array(
                'width'=>'137px',
            ),
            'htmlOptions' => array('class' => 'color'),
        ),/*
		array(
			'name'=>'joiner',
			'type'=>'raw',
			'value'=>' $data->joiner == 0 ? "" : "С"' ,
			'htmlOptions'=>array('width'=>'20px', 'class' => 'text-center'),
		),
*/
		array(
			'name'=>'joiner',
			'type' => 'raw',
			'value' => function($data) {
				$output = '';

				if ($data->product->productType->product_type_id != "1") {
					$output .= '<span style=" ">' . 
								($data->joiner == 1 ? 'C' : '&nbsp;') . 
							'</span>';
				}

				if ($data->product->productType->product_type_id == "1") {
					$output .= '<span style="margin: 5px 0; display: block;   border-bottom: 1px solid #aaa;">' . 
								($data->joiner_table_top == 1 ? 'C' : '&nbsp;') . 
							'</span>';

					$output .= '<span style=" margin: 5px 0; display: block;">' . 
								($data->joiner_table_bottom == 1 ? 'C' : '&nbsp;') . 
							'</span>';
				}

				return $output;
			},
			'htmlOptions' => array('style' => 'text-align: center; '),
		),
		// array(
		// 	'name'=>'primer',
		// 	'type'=>'raw',
		// 	'value'=>' $data->primer == 0 ? "" : "Г"' ,
		// 	'htmlOptions'=>array('width'=>'20px', 'class' => 'text-center'),
		// ),

		array(
			'name'=>'primer',
			'type' => 'raw',
			'value' => function($data) {
				$output = '';

				if ($data->product->productType->product_type_id != "1") {
					$output .= '<span style=" ">' . 
								($data->primer == 1 ? 'Г' : '&nbsp;') . 
							'</span>';
				}

				if ($data->product->productType->product_type_id == "1") {
					$output .= '<span style="margin: 5px 0; display: block;   border-bottom: 1px solid #aaa;">' . 
								($data->primer_table_top == 1 ? 'Г' : '&nbsp;') . 
							'</span>';

					$output .= '<span style=" margin: 5px 0; display: block;">' . 
								($data->primer_table_bottom == 1 ? 'Г' : '&nbsp;') . 
							'</span>';
				}

				return $output;
			},
			'htmlOptions' => array('style' => 'text-align: center; '),
		),

		array(
			'name'=>'finish',
			'type' => 'raw',
			'value' => function($data) {
				$output = '';

				if ($data->product->productType->product_type_id != "1") {
					$output .= '<span style=" ">' . 
								($data->finish == 1 ? 'Ф' : '&nbsp;') . 
							'</span>';
				}

				if ($data->product->productType->product_type_id == "1") {
					$output .= '<span style="margin: 5px 0; display: block;   border-bottom: 1px solid #aaa;">' . 
								($data->finish_table_top == 1 ? 'Ф' : '&nbsp;') . 
							'</span>';

					$output .= '<span style=" margin: 5px 0; display: block;">' . 
								($data->finish_table_bottom == 1 ? 'Ф' : '&nbsp;') . 
							'</span>';
				}

				return $output;
			},
			'htmlOptions' => array('style' => 'text-align: center; '),
		),

		// array(
		// 	'name'=>'finish',
		// 	'type'=>'raw',
		// 	'value'=>' $data->finish == 0 ? "" : "Ф"' ,
		// 	'htmlOptions'=>array('width'=>'20px', 'class' => 'text-center'),
		// ),
		// array(
			// 'name'=>'coating',
			// 'type'=>'raw',
			// 'value'=>' $data->coating == 0 ? "" : "П"' ,
			// 'htmlOptions'=>array('width'=>'20px', 'class' => 'text-center'),
		// ),
		// array(
			// 'name'=>'painter',
			// 'type'=>'raw',
			// 'value'=>' $data->painter == 0 ? "" : "М"' ,
			// 'htmlOptions'=>array('width'=>'20px', 'class' => 'text-center'),
		// ),
		array(
			'name'=>'upholstery',
			'type'=>'raw',
			'value'=>' $data->upholstery == 0 ? "" : "О"' ,
			'htmlOptions'=>array('width'=>'20px', 'class' => 'text-center'),
			'visible'=>'!$data->isTable($data->order_item_id)',
		),
		array(
			'name'=>'packing',
			'type'=>'raw',
			'value'=>' $data->packing == 0 ? "" : "У"' ,
			'htmlOptions'=>array('width'=>'20px')
		),		
        array(
            'name'=>'comment',
            'type'=>'raw',
            'headerHtmlOptions'=>array(
                'width'=>'80px',
            ),
            'htmlOptions' => array('class' => 'customer_search text-green'),
        ),
		array(
            'name'=>'comment_prod',
            'type'=>'raw',
            'headerHtmlOptions'=>array(
                'width'=>'80px',
            ),
            'htmlOptions' => array('class' => 'comment_prod'),
        ),
		array('header' => 'Дата доставки',
			'value' => '$data->order->delivery_date!==null ? Yii::app()->dateFormatter->format("dd-MM-y", $data->order->delivery_date) : ""',
			'filter' => false,
			'htmlOptions' => array('class' => 'delivery-date'),
		),



    ),
)); ?>
</div>
