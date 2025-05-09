<?php
/* @var $this ChairController */
/* @var $model Chair */

$this->breadcrumbs=array(
	'Стільці/табурети',
);

$this->menu=array(
	array('label'=>'Додати', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#chair-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Стільці/табурети</h1>

 

<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'chair-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		//'chair_id',
		 
		array(
			'name'=>'product.product_name',
			'type'=>'raw',
			'value'=>'$data->product->product_name',
		),
		array(
			'name'=>'chairType.name',
			'type'=>'raw',
			'value'=>'$data->chairType->name',
		),
		//'product_id',
		//'chair_type_id',
 
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
