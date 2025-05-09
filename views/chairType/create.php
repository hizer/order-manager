<?php
/* @var $this ChairTypeController */
/* @var $model ChairType */

$this->breadcrumbs=array(
	'Модельний ряд стільців/табуретів'=>array('admin'),
	'додати',
);

$this->menu=array(
 
	array('label'=>'Модельний ряд', 'url'=>array('admin')),
);
?>

<h1>Додати модель стільця/табурета</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>