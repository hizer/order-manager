<?php
/* @var $this BillController */
/* @var $model Bill */
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/invoice.js?v=09122021',CClientScript::POS_END);?>


<form class="form-inline">

    <div class="form-group">
        <label for="listname">Керівник: </label>
        <?php
		
		$manager = Manager::model()->findAll(array('order' => 'bydefault DESC'));
 
        $list = CHtml::listData($manager, 'manager_id', 'name');
        echo CHtml::dropDownList('Bill[manager_id]', $category, $list,
            array(
                // 'empty' => 'Виберіть цінову категорію',
                'id'=>'Bill_manager_id',
                'options'=>array($model->manager_id=>array('selected'=>'selected')),
           

				 'ajax'=>array(

				 'type'=>'post',

				 'url'=>yii::app()->createUrl('manager/getManager'),

				 'datatype'=>'json',

				 'data'=>array('manager_id'=>'js:jQuery(this).val()'),

				 'success'=>'function(result){ 

					var response = $.parseJSON(result);
					console.log(response.options.name)
					$("#m_name").html(response.options.name);
					$("#m_edrpou").html(response.options.edrpou);
					$("#m_address").html(response.options.address);
					$("#m_tel").html(response.options.tel);
					$("#m_account").html(response.options.account);
					$("#m_mfo").html(response.options.mfo);
					$("#m_comment").html(response.options.comment);
 
					}'

				 ),
        ),
		array('class'=>'input-lg')); 
		
      //  echo CHtml::dropDownList('listname', $select, array('gv' => 'ПП Олексенко Г. В.', 'bv' => 'ПП Олексенко Б. В.'),  		array('class'=>'input-lg'));
        ?>
    </div>
    <div class="form-group">
        <label for="customText">Повідомлення: </label>
        <input type="text" class="message input-lg" id="customText" autocomplete="none" name="message">
    </div>
</form>
<span id="invoiceType" class="hidden">Відправляємо рахунок №<?php echo $model->account_id; ?> від <?php echo Yii::app()->dateFormatter->format("dd.MM.y", $model->created_on); ?></span>

<div class="text-center ">
<div class="control-wrapper">
<?php

if ($model->shop_id > 0){
        $toEmail= $model->shop->email; 
    }else{
        $toEmail= $model->customers->email; 
    }
	
echo CHtml::link(
    '<i class="fa fa-envelope feature-icon"></i> Відправити',
    array('orderItems/doPdf'),
    array(
        'submit' =>  array('orderItems/doPdf'),
        'id'=>'pdfButton',
        'class'=>'bt btn-2',
        'confirm' => 'Відправити рахунок на '.$toEmail.'?',
        'params' => array(
            'html'=>'js:getHtml()',
            'email'=>'js:$("#pdfButton").data("sendingEmail")',
            'title'=>'js:$("h1").text()',
            'invoiceType'=>'js:$("#invoiceType").text()',
            'customText'=>'js:$("#customText").val()',
        ),
    )
);

?>
<a href="#" id="printButton" class="print bt btn-2 printButton" rel="print" onclick="printPage()"><i class="fa fa-print feature-icon"></i> Друкувати</a>
<a href="#" id="printButton" class="print bt btn-2 printButton" rel="print" onclick="printPageShipping()"><i class="fa fa-print feature-icon"></i> Погрузочні</a>
<?php

echo CHtml::link(
    '<i class="fa fa-file-text feature-icon"></i> Створити накладну на основі рахунку',
    array('invoice/createInvoice'),
    array(
        'submit' =>  array('invoice/createInvoiceFromBill'),
        'id'=>'ert',
        'class'=>'bt btn-2',
        'params' => array(
            'id'=>$model->bill_id,
        ),
    )
);


?>
<div class="shipment-wrapper">
<input type="text" id="delivery_cost" style="display:none" value="<?php echo $model->delivery_cost; ?>">

<a href="#" id="addShipment" class="bt btn-2"><i class="fa fa-truck feature-icon"></i> Додати доставку</a>
<?php
$customer_delivery = $model->delivery_cost !=0 ? $model->delivery_cost : '300';
$shop_delivery = $model->delivery_cost !=0 ? $model->delivery_cost : '0';

if ($model->customer_id > 0){
    echo '
	 <form class="form-inline inline">    
    <div class="input-group inline">
        <input type="text" value="'.$customer_delivery.'"  id="defaultShipmentPrice" size="30" class="form-control input-lg"/>
        <span class="input-group-addon input-lg"> грн.</span>
    </div>
	 </form>    
    ';
}else{
        echo '
        <form class="form-inline inline">    
            <div class="form-group inline">
                <input type="radio"   name="radio" id="standartShipment" />
                <label for="standartShipment" class="checkbox">Стандартна   
                </label>
				<div class="input-group " style="line-height: 1; margin-bottom: 10px;">
				 	
					<input type="text" class="form-control input-lg" id="customDeliveryTable" style="width: 60px" value="200">
					<span class="input-group-addon input-lg">Стіл</span>					
				  </div>
				  <div class="input-group " style="line-height: 1; margin-bottom: 10px;">	 
					<input type="text" class="form-control input-lg" id="customDeliveryChair" style="width: 60px" value="80">					 
					<span class="input-group-addon input-lg">Стілець</span>
				  </div>
				  <div class="input-group " style="line-height: 1">	 
					<input type="text" class="form-control input-lg" id="customDeliveryStool" style="width: 60px" value="40">					 
					<span class="input-group-addon input-lg">Табурет</span>
				  </div>
            </div>         
            <div class="form-group inline">
                <input type="radio" name="radio" id="customShipment" />   
                <label for="customShipment" class="checkbox">   
                    <div class="input-group inline">    
                        <input type="text" placeholder="" value="'.$shop_delivery.'"class="form-control input-lg" id="customShipmentValue" size="30" autocomplete="none" name="customShipment"/>
                        <span class="input-group-addon input-lg"> грн.</span>
                    </div>
                </label>
            </div>
        </form>       
        ';
    }
    ?>
</div>
  
</div>

</div>
<div class="form-inline">
 <div class="form-group">
        <label for="comment">Коментар: </label>
        <input type="text" value="<?php echo $model->comment; ?>" class="message input-lg" id="comment" autocomplete="none" name="comment">
    </div>
</div>
<?php 
 
 

 
echo CHtml::link(
    '<i class="fa fa-save  feature-icon"></i> Зберегти',
    array('bill/updateBill'),
    array(
        'submit' =>  array('bill/updateBill'),
        'id'=>'updateBillButton',
        'class'=>'bt btn-2',
        'confirm' => 'Зберегти?',
        'params' => array(
            'id'=>$model->bill_id,
            'manager_id'=>'js:$("#Bill_manager_id").val()',
			'delivery_cost'=>'js:$("#delivery_cost").val()',
			'comment'=>'js:$("#comment").val()',
        ),
    )
);


 ?>

<hr class="invoice" />
<div id="wrap">
    <div id="print">
<?php
if($model->manager_id == 0 ){
	$currentManager   = Manager::model()->find(array('condition'=>"bydefault = 1"));
}else{
	$managerId = $model->manager_id;
	$currentManager = Manager::model()->findByPK($managerId);
}
 
?>
        <h1><span class="shipping-title" style="display: none">Погрузочна №</span><span class="bill-title">Рахунок - фактура №</span><?php echo $model->account_id; ?> </h1>
        <h5>від         <?php echo Yii::app()->dateFormatter->format("dd.MM.y", $model->created_on); ?> </h5>
        <div class="invoice-left">
            <div id='manager'><?php  ?>
				<table border="0" class="invoice-info">
				<tr><th width="130px">Постачальник:</th><th id="m_name"><? echo $currentManager->name;?></th></tr>
				<tr><td><b>ЄДРПОУ:</b></td><td><b id="m_edrpou"><? echo $currentManager->edrpou;?></b></td></tr>
				<tr><td><b>АДРЕСА</b></td><td id="m_address"><? echo $currentManager->address;?></td></tr>
				<tr><td><b>Тел.:</b></td><td id="m_tel"><? echo $currentManager->tel;?></td></tr>
				<tr><td><b>РОЗР/РАХ.:</b></td><td id="m_account"><? echo $currentManager->account;?></td></tr>
				<tr><td><b>МФО</b></td><td id="m_mfo"><? echo $currentManager->mfo;?></td></tr>
				<tr><td colspan="2" id="m_comment"><? echo $currentManager->comment;?></td> </tr></table>
            </div>

            <?php
                if ($model->shop_id > 0)
                {
                    $this->widget('zii.widgets.CDetailView', array(
                    'data'=>$model,
                    'attributes'=>array(

                        array(
                            'name'=>'Платник',
                            'value'=>$model->shop->full_name,
                            'template'=>"<tr class=\"print-tr\"><th width=\"130px\">{label}</th><td><span itemprop=\"name\" data-item=\"shop\"><b contentEditable='true'>{value}</b></span></td></tr>\n",
                        ),
                        array(
                            'name'=>'АДРЕСА:',
                            'value'=> Shops::getCityAndAddress($model->shop_id),
                            'template'=>"<tr class=\"print-tr\"><td><b>{label}</b></td><td><span itemprop=\"name\">{value}</span></td></tr>\n",
                        ),
                        array(
                            'name'=>'ТЕЛ',
                            'value'=> $model->shop->phone,
                            'template'=>"<tr class=\"print-tr\"><td><b>{label}.:</b></td><td><span itemprop=\"name\">{value}</span></td></tr>\n",
                        ),
                        array(
                            'name'=>'email',
                            'value'=> $model->shop->email,
                            'template'=>"<tr class=\"print-tr visible hidden\"><td class=\"visible hidden\"><b>{label}.:</b></td><td class=\"print-tr visible hidden\"><span itemprop=\"name\" data-email=\"email\">{value}</span></td></tr>\n",

                        ),
                    ),
                    ));
                }

                if ($model->customer_id > 0)
                {
                    $this->widget('zii.widgets.CDetailView', array(
                        'data'=>$model,

                        'attributes'=>array(
                            array(
                                'name'=>'Платник',
                                'value'=>Customers::model()->getCustomerName($model->customer_id),
                                'template'=>"<tr class=\"print-tr\"><th width=\"130px\">{label}</th><td><span itemprop=\"name\" data-item=\"customer\"><b>{value}</b></span></td></tr>\n",
                            ),

                            array(
                                'name'=>'АДРЕСА:',
                                'value'=> Customers::model()->getCustomerCityAndAddress($model->customer_id),
                                'template'=>"<tr class=\"print-tr\"><td><b>{label}</b></td><td><span itemprop=\"name\">{value}</span></td></tr>\n",
                            ),
                            array(
                                'name'=>'ТЕЛ',
                                'value'=> $model->customers->phone,
                                'template'=>"<tr class=\"print-tr\"><td><b>{label}.:</b></td><td><span itemprop=\"name\">{value}</span></td></tr>\n",
                            ),
                            array(
                                'name'=>'email',
                                'value'=> $model->customers->email,
                                'template'=>"<tr class=\"print-tr visible hidden\"><td class=\"visible hidden\"><b>{label}.:</b></td><td class=\"visible hidden\"><span itemprop=\"name\" data-email=\"email\">{value}</span></td></tr>\n",
                            ),
                        ),
                    ));
                }

?>
        </div>
        <div class="invoice-right"><img src="/images/admin/logo.jpg" alt=""></div>

        <div class="pdv">

            <?php
            if ( $orderItems !== null )
            {
                $this->widget('zii.widgets.grid.CGridView', array(
                    'id'=>'order-items-grid',
                    'itemsCssClass' => 'items order',
                    'dataProvider'=>$orderItems->search(),
                    'template' => '{items} {pager}',//{summary}
                    'enableSorting' => false,
					'rowCssClassExpression' => '$data->product->productType->product_type_id != 1 ? "bg-chair" : "bg-table"',
                    'columns'=>array(
                        array(
                            
                            'header'=>'Поф.',
							'value'=>' ',
							'headerHtmlOptions'=>array(
                                'class'=>'hidden custom-empty',
                            ),
                            'htmlOptions'=>array(
                                'class'=>'hidden custom-empty',
                            ),
                        ),	
						array(                            
                            'header'=>'Обб.',
							'value'=>' ',
							'headerHtmlOptions'=>array(
                                'class'=>'hidden custom-empty',
                            ),
                            'htmlOptions'=>array(
                                'class'=>'hidden custom-empty',
                            ),                      
                        ),
						array(                            
                            'header'=>'Уп.',
							'value'=>' ',
							'headerHtmlOptions'=>array(
                                'class'=>'hidden custom-empty',
                            ),
                            'htmlOptions'=>array(
                                'class'=>'hidden custom-empty',
                            ),
                        ),
						array(
                            'header'=>'№ п/п',
                            'value'=>'$row+1',
                            'htmlOptions'=>array(
                                'width'=>'70px',
                            ),
                            'headerHtmlOptions'=>array(
                                'width'=>'70px',
                                'class'=>'field_id',
                            ),
                        ),
                        'order_id',
						'order_item_id',						
                        array(
                            'name'=>'product_id',
                            'header'=>'Найменування',
                            'value'=>'$data->getProductNameAndSize($data->order_item_id)',
                            'htmlOptions'=>array(
                                'width'=>'550px',
                            ),
                            'headerHtmlOptions'=>array(
                                'class'=>'field_name',
                                'width'=>'550px'
                            ),
                        ),
                        array(
                            'header'=>'Од. вим.',
                            'value'=>'штук',
                            'htmlOptions'=>array(
                                'width'=>'100px',
                            ),
                            'headerHtmlOptions'=>array(
                                'class'=>'field_type',
                                'width'=>'100px',
                            ),
                        ),
                        array(
                            'name'=>'product_type_id',
                            'header'=>'тип',
                            'value'=>'$data->product->productType->product_type_id',
                            'headerHtmlOptions'=>array(
                                'class'=>'hidden ',
                            ),
                            'htmlOptions'=>array(
                                'class'=>'hidden type',
                            ),
                        ),
                        array(
                            'name'=>'quantity',
                            'htmlOptions'=>array(
                                'width'=>'70px',
                                'class'=>'right quantity',
                            ),
                            'headerHtmlOptions'=>array(
                                'class'=>'field_q',
                                'width'=>'70px',
                            ),
                        ),
                        array(
                            'name'=>'price',
                            'header'=>'Ціна без ПДВ',
                            'htmlOptions'=>array(
                                'width'=>'150',
                                'class'=>'right',
								'class'=>'right cell_price',
                            ),
                            'headerHtmlOptions'=>array(
                                'class'=>'field_price',
                            ),
                        ),
                        array(
                            'name'=>'subtotal',
                            'header'=>'Сума без ПДВ',
                            'htmlOptions'=>array(
                                'width'=>'150',
                                'data-subtotal'=>subtotal,
                                'class'=>'right cell_total',
                            ),
                            'headerHtmlOptions'=>array(
                                'class'=>'field_total',
                            ),
                        ),
						/*array(                            
                            'name'=>'comment_prod',
							 
							'headerHtmlOptions'=>array(
                                'class'=>'hidden shipping-visible',
                            ),
                            'htmlOptions'=>array(
                                'class'=>'hidden shipping-visible',
                            ),
                        ),*/
                        array(
                            'class'=>'CButtonColumn',
                            'template'=>'{update}{delete}',
                            'headerHtmlOptions'=>array(
                                'class'=>'visible hidden',
                            ),
                            'htmlOptions' => array('class' => 'visible hidden'),
                            'buttons'=>array
                            (
                                'update' => array
                                (
                                    'url'=>'$this->grid->controller->createUrl("/orderItems/update", array("id"=>$data->primaryKey))',
                                ),
                                'delete' => array
                                (
                                    'url'=>'$this->grid->controller->createUrl("/billItems/delete", array("id"=>$data->billItem->primaryKey))',
                                ),
                            ),
                        ),
                    ),
                ));
            }

            echo CHtml::openTag('table', array('class'=>'pdv'));

            echo CHtml::openTag('tr');
            echo CHtml::tag('td', array('width'=>'610px'), '');
            echo CHtml::tag('td', array('width'=>'210px'), '<b>Всього без ПДВ</b>');
            echo CHtml::tag('td', array('width'=>'100px', 'class'=>'right'), '<b class="subtotal" ></b>');
            echo CHtml::closeTag('tr');
            echo CHtml::openTag('tr');
            echo CHtml::tag('td', array('class'=>'bar'), '');
            echo CHtml::tag('td', array(), '<b>ПДВ 0%</b>');
            echo CHtml::tag('td', array('class'=>'right'), '<b class="right">0.00</b>');
            echo CHtml::closeTag('tr');
            echo CHtml::openTag('tr');
            echo CHtml::tag('td', array('class'=>'bar'), '');
            echo CHtml::tag('td', array('class'=>'bar'), '<b>Загальна сума з ПДВ</b>');
            echo CHtml::tag('td', array('class'=>'right'), '<b class="subtotal"></b>');
            echo CHtml::closeTag('tr');
            echo CHtml::closeTag('table');
            ?>

        </div>
        <div class="total-wrap">
            <div style="text-decoration: underline">Всього до сплати</div>
            <div id="total"></div>
            <div style="font-weight: bold; padding-bottom: 20px">В т. ч. ПДВ 0% <span style="padding-left: 120px">0. 00 грн</span></div>
        </div>

        <table style="width:100%; " class="sender">
            <tr>
                <td style="width:11%">
                    <b>Відпустив</b>
                </td>
                <td style="width:39%">
                    <p class="underline-pdf">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <td style="width:15%">
                    <b>Одержав</b>
                </td>
                <td style="width:35%">
                    <p class="underline-pdf">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </td>
            </tr>
            <tr>
                <td>
                    <span>Керівник: </span>
                </td>
                <td>
                    <p class="underline-pdf"><span class="name"></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </td>
                <td>
                    
                </td>
                <td>
                </td>
            </tr>
        </table>
		<div style="margin-top: 40px; width:100%">
		
			<div style="width: 60%; display: inline-block;     vertical-align: top;">
			<?php
			if ($model->customer_id > 0){
				echo "<div>".Orders::model()->getCustomerPrepaidComment($model->customer_id)."</div>";
			}
			?>
			<div style="font-weight: bold; border: 2px solid #333; padding: 10px 7px 10px 15px; margin-right: 15px;">
			Увага!<br/>
			Платником по даному рахунку має бути юридична особа, фізична особа чи фізична особа підприємець
			(ФОП), що вказана в графі  "Платник". В призначені платежу вкажіть "Оплата згідно рахунку 
			№ (відповідний до номеру в «шапці») та дату рахунку". В разі помилково вкзаних реквізитів платника
			кошти будуть повернуті. Якщо потрібно замінити реквізити (ПІБ) платника - повідомте у відповідь
			на цей рахунок.
			</div>
			</div>
			<div class="footer" style="width: 39%; font-weight: bold; display: inline-block;">
				Ваш підпис свідчить, про цілісність, відповідність кольору та розміру і повну комплектацію замовлення.
				Претензій до виробника не маєте.
			
			</div>
		</div>
		</div>
</div>