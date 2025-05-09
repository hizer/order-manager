<?php
/* @var $this TableInsertController */
/* @var $model TableInsert */

$this->breadcrumbs=array(
	'Надбавка за додатковий розмір'=>array('ьфтфпу'),
	$model->table_insert_id=>array('view','id'=>$model->table_insert_id),
	'Оновити',
);

$this->menu=array(
 
 
);
?>

<h1>Оновити надбавку за додатковий розмір вставки </h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>