<?php
/* @var $this TableInsertController */
/* @var $model TableInsert */

$this->breadcrumbs=array(
		'Надбавка за додатковий розмір вставки'=>array('admin'),
	'Огляд',
);

 
?>

<h1>Надбавка за додатковий розмір вставки</h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		 
		'add',
	),
)); ?>
