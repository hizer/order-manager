<?php
/* @var $this OrderItemsController */
/* @var $model OrderItems */

$this->breadcrumbs=array(

	'Замовлені товари',
);

Yii::app()->clientScript->registerScript('re-install-date-picker', "
function reinstallDatePicker(id, data) {
    $('#datepicker_for_due_date').datepicker(jQuery.extend({showMonthAfterYear:false},jQuery.datepicker.regional['uk'],{'dateFormat':'yy-mm-dd'}));
paintOrder();
disableButton();
getAllItems();
createTable()

$('#hiden').parent().hide()
}
");


Yii::app()->clientScript->registerScript('search', "

$(document).on('click', '.custom-toggle-link', function(e) {

    e.preventDefault();
    var url = $(this).attr('href');
    $.post(url, function(response) {
        // Handle success (e.g., update icon/text dynamically)
        console.log(response);
    }).fail(function() {
        alert('Error while toggling!');
    });
});

function disableButton(){
$('a.printButton').addClass('disable-button');
$(':input:checkbox').on('click', function(){
var len = $(':checkbox:checked').length
    if(len > 0){
        $('a.printButton').removeClass('disable-button');
    }else{
       $('a.printButton').addClass('disable-button');
    }
})
}

$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#order-items-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});


function paintOrder(){
	console.log('call paintOrder ')
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


$('#hiden').parent().hide()
function getAllItems(){
	var directionObj=[]
	var elList = document.querySelectorAll('[data-city]');
	if(elList){
		var elListLenght = elList.length
		if(elListLenght > 0){
			for(var i=0; elListLenght > i; i++){
				if(directionObj.length == 0){
					directionObj.push({
						city: elList[i].getAttribute('data-city'),					 
						[elList[i].getAttribute('data-type')]: parseInt([elList[i].getAttribute('data-quantity')]),						 
						}
					)
				}else{
					var newCIty = true;
					for(var k=0; directionObj.length > k; k++){
						
						if(elList[i].getAttribute('data-city') == directionObj[k].city){
							var typ = elList[i].getAttribute('data-type')
							if (typ in directionObj[k]){
								directionObj[k][typ] += parseInt([elList[i].getAttribute('data-quantity')])
							}else{
								directionObj[k][typ] = parseInt([elList[i].getAttribute('data-quantity')])
							}								
							newCIty = false;							
							break;
						}					
					}
					if(newCIty){							 
						directionObj.push({
							city: elList[i].getAttribute('data-city'),
							[elList[i].getAttribute('data-type')]: parseInt([elList[i].getAttribute('data-quantity')]),
							}
						)
					}
				}
			}	
		}

	}
	
	for(var i = 0, l = directionObj.length; l>i; i++){
		 
		if(!('id1' in directionObj[i])){
			directionObj[i].id1 = 0
		}
		if(!('id2' in directionObj[i])){
			directionObj[i].id2 = 0
		}
		if(!('id3' in directionObj[i])){
			directionObj[i].id3 = 0
		}
	}
		
		
	console.log('getAllItems: ', directionObj)
	return directionObj;
}

function createTable(){
	var obj = getAllItems()

	obj.sort((a, b) => Number(b.id1) - Number(a.id1));
 
	console.log('sort : ', obj);
	if($('#citytable')){
		console.log('remove trable')
		$('#citytable').remove()
	}
	 
	var table = '<div id=\\'citytable\\' class=\\'grid-view\\'><table class=\\'items\\'>'
	
	var thCity ='<tr ><td></td>'
	var thTable ='<tr><td><b>Столи</b></td>'
	var thChair ='<tr><td><b>Стільці</b></td>'
	var thTaburet ='<tr><td><b>Табурети</b></td>'
	
	for(var i = 0, l = obj.length; l>i; i++){
		
		 
		
		thCity += '<th>'+obj[i].city+'</th>'
		if('id1' in obj[i]){
			thTable += '<td>'+obj[i].id1+'</td>'
		}
		if('id2' in obj[i]){
			thChair += '<td>'+obj[i].id2+'</td>'
		}
		if('id3' in obj[i]){
			thTaburet += '<td>'+obj[i].id3+'</td>'
		}
	}
	thCity +='</tr>'
	thTable +='</tr>'
	thChair +='</tr>'
	thTaburet +='</tr>'
	
	table += thCity;
	table += thTable;
	table += thChair;
	table += thTaburet;
	
	table += '</table></div>';
	//console.log('carete' , obj.length)
	
	$(table).insertBefore($('#printButtonShop'))
}

function toggleStatus(url, element) {
    if (!confirm('Змінити статус?')) return false;

    $.ajax({
        url: url,
        type: 'POST',
        dataType: 'json',
        success: function(response) {
        //console.log('response',response)
            if (response && response.status === 'success') {
                let newValue = response.newValue;
                //console.log('newValue',newValue )
                
            } else {
                alert('Помилка! ' + (response.message || 'Unknown error occurred.'));
            }
        },
        error: function(xhr, status, error) {
            //console.log('AJAX Error:', status, error);
            //console.log('Response Text:', xhr.responseText);
            alert('AJAX error! Check the console for details.');
        }
    });

    return false;
}

createTable()
paintOrder();
disableButton();
//getAllItems();

");
?>


<?php
function generateAjaxLink($id, $attribute, $value) {
    $id = (int)$id; // Ensure ID is correct
    $iconClass = $value == 1 ? 'fa-check-circle' : 'fa-times-circle';
    $iconColor = $value == 1 ? '#00e100' : 'red';

    return CHtml::ajaxLink(
        '<i class="fa ' . $iconClass . ' primer-icon"
            data-id="' . $id . '"
            data-attribute="' . $attribute . '"
            id="primer-' . $attribute . '-icon-' . $id . '"
            style="color: ' . $iconColor . '; font-size: 29px;"
            aria-hidden="true"></i>',
            array("orderItems/toggleTable"), // Removed `id` and `attribute` from URL
        array(
            'type' => 'POST',
            'dataType'=> 'json',
            'data' => 'js:{ id: $(this).find("i").data("id"), attribute: $(this).find("i").data("attribute") }', // Get the correct ID dynamically
            'success' => 'function(response) {
                 if (response.status === "success") {
                    var icon = $("#primer-" + response.attribute + "-icon-" + response.id);
                    icon.toggleClass("fa-check-circle fa-times-circle")
                        .css("color", response.newValue == 1 ? "#00e100" : "red");
                } else {
                    alert("Не вдалося змінити статус!");
                }
            }',
            'error' => new CJavaScriptExpression("
                function(xhr, status, error) {
                    console.error('AJAX Error:', status, error);
                    alert('AJAX помилка! Спробуйте ще раз.');
                }
            "),
        ),
        array(
            'class' => 'custom-toggle-link',
            'style' => 'cursor: pointer; display: block; text-align: center; margin: 5px 0;',
            'confirm' => 'Змінити статус?'
        )
    );
}
?>
<h1>Замовленні товари</h1>
<style>
    .pb-2{
        pading-bottom:5px;
    }

     
div#order-items-grid.grid-view-loading {
    position: relative
}

div#order-items-grid.grid-view-loading:after {
    position:fixed;
    width:100%;
    left:0;right:0;top:0;bottom:0;
    background-color: rgba(255,255,255,0.7);
    z-index:9;
  height: 100%;
    content:'';
}

@-webkit-keyframes spin {
	from {-webkit-transform:rotate(0deg);}
	to {-webkit-transform:rotate(360deg);}
}

@keyframes spin {
	from {transform:rotate(0deg);}
	to {transform:rotate(360deg);}
}

div#order-items-grid.grid-view-loading::before {
    content:'';
    display:block;
    position:fixed;
    left:48%;
    top: 40%;
    width:40px;
    height:40px;
    border-style:solid;
    border-color: #00b4f3;
    border-top-color:transparent;
    border-width: 4px;
    border-radius:50%;
    -webkit-animation: spin .8s linear infinite;
    animation: spin .8s linear infinite;
    z-index:10;
}
    </style>
<?php echo CHtml::link('Розширений пошук','#',array('class'=>'search-button ')); ?>

<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div>


<?php $form=$this->beginWidget('CActiveForm', array(
    'enableAjaxValidation'=>true,
    'method'=>'Post',
)); ?>


<?php
$urlShop = array('orderItems/printOrderItemsShop');
echo CHtml::link(
    '<i class="fa fa-print feature-icon"></i> Друкувати Магазини',
    $urlShop,
    array(
        'submit' => $urlShop,
        'id'=>'printButtonShop',
        'class'=>'bt btn-2 printButton',
    )
);

$urlSite = array('orderItems/printOrderItemsCustomer');
echo CHtml::link(
    '<i class="fa fa-print feature-icon"></i> Друкувати Сайт',
    $urlSite,
    array(
        'submit' => $urlSite,
        'id'=>'printButtonCustomer',
        'class'=>'bt btn-2 printButton',
    )
);

$urlAll = array('orderItems/printOrderItems');
echo CHtml::link(
    '<i class="fa fa-print feature-icon"></i> Друкувати всe <i class="fa  fa-sort-alpha-asc feature-icon"></i> ',
    $urlAll,
    array(
        'submit' => $urlAll,
        'id'=>'printButtonAll',
        'class'=>'bt btn-2 printButton',
    )
);

$urlAllDate = array('orderItems/printOrderItemsDate');
echo CHtml::link(
    '<i class="fa fa-print fa-print  feature-icon"></i>  Друкувати всe <i class="fa fa-calendar feature-icon"></i>',
    $urlAllDate,
    array(
        'submit' => $urlAllDate,
        'id'=>'printButtonAllDate',
        'class'=>'bt btn-2 printButton',
    )
);

$urlLabel = array('orderItems/printOrderItemsLabel');
echo CHtml::link(
    '<i class="fa fa-print feature-icon"></i> Наклейка на коробку',
    $urlLabel,
    array(
        'submit' => $urlLabel,
        'id'=>'printButtonLabel',
        'class'=>'bt btn-2 printButton',
    )
);

$urlFantik = array('orderItems/printOrderItemsFantik');
echo CHtml::link(
    '<i class="fa fa-print feature-icon"></i> Фантік',
    $urlFantik,
    array(
        'submit' => $urlFantik,
        'id'=>'printButtonFantik',
        'class'=>'bt btn-2 printButton',
    )
);

?>


    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'order-items-grid',
        'dataProvider'=>$model->search(),
        'filter'=>$model,
        'afterAjaxUpdate' => 'reinstallDatePicker', // (#1)
		'beforeAjaxUpdate' => 'js:function(id, options) {
			console.log("options", options)
		  }',
		  'rowHtmlOptionsExpression' => 'array("data-created"=>$data->created_on)',
        'columns'=>array(
            array(
                'name'=>'order_item_id',
                'type'=>'raw',
              //  'headerHtmlOptions' => array('style' => 'display:none'),
              //  'htmlOptions' => array('style' => 'display:none'),
              //  'filter'=>CHtml::activeTextField($model, 'order_item_id', array('id'=>'hiden','style'=>'display:none')),
                //'filter'=>array('htmlOptions' => array('style' => 'display:none'),)
            ),
            array(
                'id'=>'autoId',
                'class'=>'CCheckBoxColumn',
                'selectableRows' => 50,
                'checkBoxHtmlOptions' => array('class' => 'classname'),
            ),
            array(
                'name'=>'order_id',
                'type'=>'raw',
                'value'=>'CHtml::link(Orders::model()->getOrderWithPause($data->order_id), Yii::app()->createUrl("orders/view/",array("id"=>$data->order_id)))',
                'headerHtmlOptions'=>array(
                    'width'=>'165px',
                ),
            ),
            array(
                'name' => 'created_on',
                'value' => 'Yii::app()->dateFormatter->format("dd-MM-y", $data->order->created_on)',
                'headerHtmlOptions'=>array(
                    'width'=>'65px',
                ),
                'filter' => false,
                'htmlOptions' => array('class' => 'date'),
            ),
            array(
                'name'=>'city_search',
                //'filter' => CHtml::listData(Shops::model()->findAll(array('order' => 'full_name  ASC')), 'full_name', 'full_name'),
                'type'=>'raw',
                'value'=>'$data->order->city->city_name',
            ),
            array(
                'name'=>'shop_search',

                'filter' => CHtml::listData(Shops::model()->findAll(array('order' => 'full_name  ASC')), 'full_name', 'full_name'),///copy
                'type'=>'raw',
                'value'=>'$data->order->shop->full_name',
            ),
            array(
                'name'=>'customer_search',
                'type'=>'raw',
                'value'=>'Orders::model()->getCustomerName($data->order->customer_id)',
            ),
            array(
                'name'=>'product_search',
                'type'=>'raw',
                 //'value'=>'$data->product->product_name',
				'value'=> function($data){
					return '<div data-quantity="'.$data->quantity.'" data-type="id'.$data->product->productType->product_type_id.'" data-city="'.$data->order->city->city_name.'">' . $data->product->product_name . '</div>';
				}
            ),
//            array(
//                'class'=>'DToggleColumn',
//                'name'=>'product_id',
//                'filter'=>array(2=>'Стілець', 1=>'Стіл', 0=>''),
//                'titles'=>array(2=>'Стілець', 1=>'Стіл', 0=>''),
//                'type'=>'raw',
//            ),
            array(
                'name'=>'length',
                'type'=>'raw',
                'headerHtmlOptions'=>array(
                    'width'=>'37px',
                ),
            ),
            array(
                'name'=>'insert',
                'type'=>'raw',
                'headerHtmlOptions'=>array(
                    'width'=>'37px',
                ),
            ),
            array(
                'name'=>'width',
                'type'=>'raw',
                'headerHtmlOptions'=>array(
                    'width'=>'37px',
                ),
            ),
            array(
                'name'=>'height',
                'type'=>'raw',
                'headerHtmlOptions'=>array(
                    'width'=>'37px',
                ),
            ),
            array(
                'name'=>'quantity',
                'type'=>'raw',
                'headerHtmlOptions'=>array(
                    'width'=>'37px',
                ),
            ),
            array(
                'name'=>'comment',
                'value'=>'$data->getStyledComment($data->order_item_id)',               
            ), 
			array(
                'name'=>'comment_prod',
                'headerHtmlOptions'=>array(
                    'width'=>'175px',
                ),   
				'htmlOptions' => array('class' => 'comment_prod'),				
            ), 
			array(
                'header'=>'Колір',
                'value'=>'$data->getColor($data->order_item_id)',
                'headerHtmlOptions'=>array(
                    'width'=>'175px',
                ),
            ),
            /*array(
                'name'  => 'status_id',
                'type'  => 'raw',
                'filter' => CHtml::listData(Status::model()->findAll(array('order' => 'status_id  ASC')), 'status_id', 'status_name'),
                'value'=>'Status::getOrderStatus($data->order_id, $data->status_id,  $getModel = Yii::app()->controller->id)',
                //'value'=>'$data->order_id',

            ),
            'price',
            'subtotal',
            'created_by',
            'modified_on',
            'modified_by',
            */
            array('header' => 'Дата доставки',
                'value' => '$data->order->delivery_date!==null ? Yii::app()->dateFormatter->format("dd-MM-y", $data->order->delivery_date) : ""',
                'filter' => false,
                'htmlOptions' => array('class' => 'delivery-date'),
            ),


            array(
                'class'=>'DToggleColumn',
                'name'=>'joiner',
                'confirmation'=>'Змінити статус?',
                'filter'=>array(1=>'Так', 0=>'Ні'),
                'titles'=>array(1=>'Так', 0=>'Ні'), 
				'htmlOptions'=>array('width'=>'20px'),
            ),         
             
            array(
                'name' => 'primer',
                'type' => 'raw',
                'filter' => array(1 => 'Так', 0 => 'Ні'),
                'value' => function ($data) {
                    $id = $data->primaryKey;
                    $productType = $data->product->productType->product_type_id;
                    $links = "";
            
                    // If product type is NOT 1, show a single "primer" button.
                    if ($productType != "1") {
                        $links .= generateAjaxLink($id, "primer", $data->primer);
                    }
                    // If product type is 1, show two buttons: primer_table_top & primer_table_bottom.
                    else {
                        $links .= generateAjaxLink($id, "primer_table_top", $data->primer_table_top);
                        $links .= '<div style="border-bottom: 1px solid #ccc"></div>';
                        $links .= generateAjaxLink($id, "primer_table_bottom", $data->primer_table_bottom);
                    }
            
                    return $links;
                },
                'headerHtmlOptions' => array(
                    'width' => '165px',
                ),
            ),

            array(
                'name' => 'finish',
                'type' => 'raw',
                'filter' => array(1 => 'Так', 0 => 'Ні'),
                'value' => function ($data) {
                    $id = $data->primaryKey;
                    $productType = $data->product->productType->product_type_id;
                    $links = "";
            
                    // If product type is NOT 1, show a single "primer" button.
                    if ($productType != "1") {
                        $links .= generateAjaxLink($id, "finish", $data->finish);
                    }
                    // If product type is 1, show two buttons: primer_table_top & primer_table_bottom.
                    else {
                        $links .= generateAjaxLink($id, "finish_table_top", $data->finish_table_top);
                        $links .= '<div style="border-bottom: 1px solid #ccc"></div>';
                        $links .= generateAjaxLink($id, "finish_table_bottom", $data->finish_table_bottom);
                    }
            
                    return $links;
                },
                'headerHtmlOptions' => array(
                    'width' => '165px',
                ),
            ),
            
            // array(
            //     'name' => 'finish',
            //     'type' => 'raw',
            //     'filter'=>array(1=>'Так', 0=>'Ні'),
            //     'value' => function($data) {
                    
            //         $link = ($data->product->productType->product_type_id != "1") ?
            //          CHtml::ajaxLink(
            //             ($data->finish == 1 ? '<i class="fa fa-check-circle" id="finish-icon-'.$data->order_item_id.'" style="color: #00e100;font-size: 29px;" aria-hidden="true"></i>' 
            //                                     : '<i class="fa fa-times-circle" id="finish-icon-'.$data->order_item_id.'" style="color: red;font-size: 29px;" aria-hidden="true"></i>'),
            //                 Yii::app()->createUrl("orderItems/toggleTable", array("id" => $data->order_item_id, "attribute" => "finish")), // URL
            //                 array(
            //                     'type' => 'POST',
            //                     'success' => 'function(response) {
            //                         var res = JSON.parse(response);
            //                         if(res.status === "success") {
            //                             var icon = $("#finish-icon-' . $data->order_item_id . '");
            //                             if(res.newValue == 1) {
            //                                 icon.removeClass("fa-times-circle").addClass("fa-check-circle").css("color", "#00e100");
            //                             } else {
            //                                 icon.removeClass("fa-check-circle").addClass("fa-times-circle").css("color", "red");
            //                             }
            //                         } else {
            //                             alert("Не вдалося змінити статус!");
            //                         }
            //                     }',
            //                     'error' => 'function(xhr, status, error) {
            //                         alert("AJAX error!", status, error);
            //                     }',
            //                 ),
            //                 array(
            //                     'class' => 'custom-toggle-link',
            //                     'style' => 'cursor: pointer; display: block; text-align: center;',
            //                     'confirm'=>'Змінити статус?'
            //                 )
            //             ) : '';
            //         $link1  = ($data->product->productType->product_type_id == "1") 
            //         ? 
            //          CHtml::ajaxLink(
            //             ($data->finish_table_top == 1 ? '<i class="fa fa-check-circle " id="finish-top-icon-'.$data->order_item_id.'" style="color: #00e100;font-size: 29px;" aria-hidden="true"></i>' 
            //             : '<i class="fa fa-times-circle" id="finish-top-icon-'.$data->order_item_id.'" style="color: red;font-size: 29px;" aria-hidden="true"></i>'),
            //                 Yii::app()->createUrl("orderItems/toggleTable", array("id" => $data->order_item_id, "attribute" => "finish_table_top")), // URL
            //                 array(
            //                     'type' => 'POST',
            //                     'success' => 'function(response) {
            //                         var res = JSON.parse(response);
            //                         if(res.status === "success") {
            //                             var icon = $("#finish-top-icon-' . $data->order_item_id . '");
            //                             if(res.newValue == 1) {
            //                                 icon.removeClass("fa-times-circle").addClass("fa-check-circle").css("color", "#00e100");
            //                             } else {
            //                                 icon.removeClass("fa-check-circle").addClass("fa-times-circle").css("color", "red");
            //                             }
            //                         } else {
            //                             alert("Не вдалося змінити статус!");
            //                         }
            //                     }',
            //                     'error' => 'function(xhr, status, error) {
            //                         alert("AJAX error!", status, error);
            //                     }',
            //                 ),
            //                 array(
            //                     'class' => 'custom-toggle-link',
            //                     'style' => 'cursor: pointer; margin: 5px 0; display: block; padding-bottom: 5px; border-bottom: 1px solid #aaa; ; text-align: center;',
            //                     'confirm'=>'Змінити статус?'
            //                 )
            //             ) : '';
            //         $link2 = ($data->product->productType->product_type_id == "1") 
            //         ? 
            //         CHtml::ajaxLink(
            //             ($data->finish_table_bottom == 1 ? '<i class="fa fa-check-circle " id="finish-bottom-icon-'.$data->order_item_id.'" style="color: #00e100;font-size: 29px;" aria-hidden="true"></i>' 
            //             : '<i class="fa fa-times-circle" id="finish-bottom-icon-'.$data->order_item_id.'" style="color: red;font-size: 29px;" aria-hidden="true"></i>'),
            //                 Yii::app()->createUrl("orderItems/toggleTable", array("id" => $data->order_item_id, "attribute" => "finish_table_bottom")), // URL
            //                 array(
            //                     'type' => 'POST',
            //                     'success' => 'function(response) {
            //                         var res = JSON.parse(response);
            //                         if(res.status === "success") {
            //                             var icon = $("#finish-bottom-icon-' . $data->order_item_id . '");
            //                             if(res.newValue == 1) {
            //                                 icon.removeClass("fa-times-circle").addClass("fa-check-circle").css("color", "#00e100");
            //                             } else {
            //                                 icon.removeClass("fa-check-circle").addClass("fa-times-circle").css("color", "red");
            //                             }
            //                         } else {
            //                             alert("Не вдалося змінити статус!");
            //                         }
            //                     }',
            //                     'error' => 'function(xhr, status, error) {
            //                         alert("AJAX error!", status, error);
            //                     }',
            //                 ),
            //                 array(
            //                     'class' => 'custom-toggle-link',
            //                     'style' => 'cursor: pointer; margin: 5px 0; display: block; text-align: center;',
            //                     'confirm'=>'Змінити статус?'
            //                 )
            //             ) : '';

            //         return  $link . '' .$link1 . '' . $link2;
            //     },
            //     'headerHtmlOptions' => array(
            //         'width' => '165px',
            //     ),
            // ),
            // array(
                // 'class'=>'DToggleColumn',
                // 'name'=>'coating',
                // 'confirmation'=>'Змінити статус?',
                // 'filter'=>array(1=>'Так', 0=>'Ні'),
                // 'titles'=>array(1=>'Так', 0=>'Ні'),
                // 'htmlOptions'=>array('width'=>'20px'),
            // ),
            // array(
                // 'class'=>'DToggleColumn',
                // 'name'=>'painter',
                // 'confirmation'=>'Змінити статус?',
                // 'filter'=>array(1=>'Так', 0=>'Ні'),
                // 'titles'=>array(1=>'Так', 0=>'Ні'), 
                // 'htmlOptions'=>array('width'=>'20px'),
            // ),
            array(
                'class'=>'DToggleColumn',
                'name'=>'upholstery',
                'confirmation'=>'Змінити статус?',
                'filter'=>array(1=>'Так', 0=>'Ні'),
                'titles'=>array(1=>'Так', 0=>'Ні'), 
                'htmlOptions'=>array('width'=>'20px'),
				'visible'=>'!$data->isTable($data->order_item_id)',
            ),
			array(
                'class'=>'DToggleColumn',
                'name'=>'packing',
                'confirmation'=>'Змінити статус?',
                'filter'=>array(1=>'Так', 0=>'Ні'),
                'titles'=>array(1=>'Так', 0=>'Ні'), 
				'htmlOptions'=>array('width'=>'20px')
            ),
            array(
                'class'=>'CButtonColumn',
            ),
        ),
    )); ?>
<?php $this->endWidget(); ?>

