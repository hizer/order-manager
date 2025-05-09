<?php
/* @var $this ProductsAttributesController */
/* @var $model ProductsAttributes */

$this->breadcrumbs=array(

	'Атрибути товарів',
);

$this->menu=array(

	array('label'=>'Додати атрибут товару', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#products-attributes-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Управління атрибутами товарів</h1>



<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'products-attributes-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
        array(
            'header'=>'№ п/п',
            'value'=>'$row+1',
        ),
        array(
            'name'=>'product_search',
            'type'=>'raw',
            'value'=>'$data->product->product_name',
        ),

        array(
            'name'=>'attribute_search',
            'type'=>'raw',
            'value'=>'$data->attribute->name',
        ),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
