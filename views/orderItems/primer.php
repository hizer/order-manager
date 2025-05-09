<?php
/* @var $this OrderItemsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Грунт',
);

 

$data = OrderItems::model();
 Yii::app()->params['rowStyle'] = "even";
?>
<style type="text/css">
.grid-view-loading
{
	background:url(loading.gif) no-repeat;
}

.grid-view table.items
{
	background: white;
	border-collapse: collapse;
	width: 100%;
	border: 1px #D0E3EF solid;
	margin-top:15px;
}

.grid-view table.items th, .grid-view table.items td
{
	font-size: 13px;
	border: 1px white solid;
	padding: 2px;
}

.grid-view table.items th
{
	color: white;
	background: url("bg.gif") repeat-x scroll left top #5ea2ca;
	text-align: center;
}

.grid-view table.items th a
{
	color: #EEE;
	font-weight: bold;
	text-decoration: none;
}

.grid-view table.items th a:hover
{
	color: #FFF;
}

.grid-view table.items th a.asc
{
	background:url(up.gif) right center no-repeat;
	padding-right: 10px;
}

.grid-view table.items th a.desc
{
	background:url(down.gif) right center no-repeat;
	padding-right: 10px;
}

.grid-view table.items tr.even
{
	background: #F8F8F8;
}

.grid-view table.items tr.odd
{
	background: #E5F1F4;
}

.grid-view table.items tr.selected
{
	background: #BCE774;
}

.grid-view table.items tr:hover.selected
{
	background: #CCFF66;
}

.grid-view table.items tbody tr:hover
{
	background: #ECFBD4;
}

.grid-view .link-column img
{
	border: 0;
}

.grid-view .button-column
{
	text-align: center;
	width: 60px;
}

.grid-view .button-column img
{
	border: 0;
}

.grid-view .checkbox-column
{
	width: 15px;
}

.grid-view .summary
{
	margin: 0 0 5px 0;
	text-align: right;
}

.grid-view .pager
{
	margin: 5px 0 0 0;
	text-align: right;
}

.grid-view .empty
{
	font-style: italic;
}

.grid-view .filters input,
.grid-view .filters select
{
	 
	border: 1px solid #ccc;
}



</style>
<h1>Грунт</h1>
<div  class="grid-view">
<table class="items" >
	<tr>
		<th><?php echo CHtml::encode($data->getAttributeLabel('primer_updated')); ?>
		</th>
		
		<th><?php echo CHtml::encode($data->getAttributeLabel('order_item_id')); ?>
		</th>
		
		<th><?php echo CHtml::encode($data->getAttributeLabel('product_search')); ?>
		</th>
		
		<th><?php echo "Колір"; ?>
		</th>
		
		<th><?php echo CHtml::encode($data->getAttributeLabel('quantity')); ?>
		</th>
		
	 
	</tr>
<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_viewPrimer',
)); ?>
</table>
</div>
