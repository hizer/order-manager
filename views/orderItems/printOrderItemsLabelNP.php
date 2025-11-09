<?php
/* @var $this OrderItemsController */
/* @var $model OrderItems */
Yii::app()->clientScript->registerCss('cs1','

.view.d-tcell {
    padding: 15px 0 0 15px;
    margin: 0px;
    width: 49.5%;
    display: inline-block;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
    height: 100mm;
	width: 100mm;
    vertical-align: top;
		margin: 0;
	line-height:1.4;
	font-family:Verdana,  Arial,  sans-serif;
	color:#000;
	font-size: 14px;
    line-height: 1.5;
	background: none;
}

img.logo {
    max-height: 70px;
    width: auto;
}

.d-tcell:nth-child(7n+0),
.d-tcell:nth-child(8n+0) {
  margin-top: 15px;
}
.square{
	height: 13px;
    width: 13px;
    border: 1px solid #000;
    display: inline-block;
    padding: 0;
    margin: 0 2px 0 3px;
}

 .summary{
  display: none;
 }


');

Yii::app()->clientScript->registerScript('print', "

$('.print').click(function() {
	pathArray = window.location.href.split( '/' );
	protocol = pathArray[0];
	host = pathArray[2];
	url = protocol + '//' + host + '/css/printLabels.css';
	
	$('#print').printElement({
			overrideElementCSS:[
		'../../css/printLabelsNP.css',
		{ href:'../../css/printLabelsNP.css',media:'print'}],
			pageTitle:'замовленні товари'
	});
});

$('.d-tcell').each(function(){
	var _this = $(this);
    var quantity = parseInt(_this.data( 'quantity' ))
	if(_this.data( 'type' ) == 'table'){
		el = _this.clone(); 
		el.insertAfter( _this );	
	}
	if(!isNaN(quantity) && quantity > 1){
		 console.log('quantity ',quantity)
		 _this.find('.quantity').text('1 / ' + quantity)
		 for(i = quantity; i>1; i--){
			var el = _this.clone(); 
			el.find('.quantity').text(i + ' / ' + quantity);
			el.insertAfter( _this );	
		 }	 
	 }
  
});
 
");
?>

<h1>Друкувати етикетки 10x10</h1>

<a href="#" class="print bt btn-2" rel="print"><i class="fa fa-print feature-icon"></i> Друкувати</a>

<div id="print" class="d-table">
<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_viewLabelNP',
	 
)); ?>
</div>
