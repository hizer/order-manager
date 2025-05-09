<?php
/* @var $this TableInsertController */
/* @var $model TableInsert */

$this->breadcrumbs=array(
	'Table Inserts'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TableInsert', 'url'=>array('index')),
	array('label'=>'Manage TableInsert', 'url'=>array('admin')),
);
?>

<h1>Create TableInsert</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>