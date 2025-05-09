<?php
/* @var $this OrderItemsController */
/* @var $model OrderItems */
Yii::app()->clientScript->registerCss('cs1','

.view.d-tcell-4 {
    padding: 15px 0 0 15px;
    margin: 0px;
    width: 49.5%;
    display: inline-block;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
    height: calc(297mm / 4);
    vertical-align: top;
		margin: 0;
	line-height:1.4;
	font-family:Verdana,  Arial,  sans-serif;
	color:#000;
	font-size: 14px;
	background:none;
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


');

Yii::app()->clientScript->registerScript('print', "

$('.print').click(function() {
        pathArray = window.location.href.split( '/' );
        protocol = pathArray[0];
        host = pathArray[2];
        url = protocol + '//' + host + '/css/printLabels.css';
		$('#print').printElement({
             overrideElementCSS:[
		    '../../css/printLabels.css',
		    { href:'../../css/printLabels.css',media:'print'}],
             pageTitle:'замовленні товари'
        });
});
 
");
?>

<h1>Друкувати фантік</h1>

<a href="#" class="print bt btn-2" rel="print"><i class="fa fa-print feature-icon"></i> Друкувати</a>

<div id="print" class="d-table">
<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_viewFantik','summaryText' => '',
	 'enablePagination'=>false,
)); ?>
</div>
