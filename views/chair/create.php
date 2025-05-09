<?php
/* @var $this ChairController */
/* @var $model Chair */

$this->breadcrumbs=array(
	'Chairs'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Chair', 'url'=>array('index')),
	array('label'=>'Manage Chair', 'url'=>array('admin')),
);
?>

<h1>Додати модель до стільця/табурета</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>