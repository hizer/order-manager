<?php
/* @var $this ChairController */
/* @var $model Chair */

$this->breadcrumbs=array(
	'Стільці'=>array('admin'),
	$model->product->product_name,
);

$this->menu=array(
 
	array('label'=>'Додати', 'url'=>array('create')),
	array('label'=>'Редагувати', 'url'=>array('update', 'id'=>$model->chair_id)),
	array('label'=>'Видалати', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->chair_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Стільці/табурети', 'url'=>array('admin')),
);
?>

<h1>Стілець #<?php echo $model->chair_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'chair_id',
		'product.product_name',
		'chairType.name',
	),
)); ?>
