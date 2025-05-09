<?php
/* @var $this TableInsertController */
/* @var $model TableInsert */

$this->breadcrumbs=array(
	 
	'Надбавки за додатковий розмір вставки',
);

 

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#table-insert-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Надбавки за додатковий розмір вставки</h1>

</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'table-insert-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		//'table_insert_id',
		'add',
		array(
			'class'=>'CButtonColumn',
			'template'=>'{update}'

		),
	),
)); ?>
