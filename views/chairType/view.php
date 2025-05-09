<?php
/* @var $this ChairTypeController */
/* @var $model ChairType */

$this->breadcrumbs=array(
	'Модельний ряд'=>array('admin'),
	$model->name,
);

$this->menu=array(
	array('label'=>'Додати моедель', 'url'=>array('create')),
	array('label'=>'Редагувати моедель', 'url'=>array('update', 'id'=>$model->chair_type_id)),
	array('label'=>'Видалити модель', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->chair_type_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Модельний ряд', 'url'=>array('admin')),
);
?>

<h1>Модель #<?php echo $model->name; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'chair_type_id',
		'name',
		'description',
		'desired_in_stock',
	),
)); ?>
