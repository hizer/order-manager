<?php
/* @var $this ChairTypeController */
/* @var $model ChairType */

$this->breadcrumbs=array(
 
	'Модельний ряд',
);

$this->menu=array(
	 
	array('label'=>'Додати модель', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#chair-type-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Модельний ряд стільців/табуретів</h1>

 

<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'chair-type-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		//'chair_type_id',
		'name',
		'description',
		'desired_in_stock',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
