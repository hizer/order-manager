<?php
/* @var $this ChairTypeController */
/* @var $model ChairType */

$this->breadcrumbs=array(
	'Модельний ряд'=>array('admin'),
	$model->name=>array('view','id'=>$model->chair_type_id),
	'Редагувати',
);

$this->menu=array(
	array('label'=>'Додати', 'url'=>array('create')),
	array('label'=>'Модельний ряд', 'url'=>array('admin')),
);
?>

<h1>Редагувати тип #<?php echo $model->name; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>