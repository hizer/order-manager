<?php
/* @var $this ManagerController */
/* @var $model Manager */

$this->breadcrumbs=array(
	'Керівники'=>array('admin'),
	$model->name,
);

$this->menu=array(

	array('label'=>'Додати керівника', 'url'=>array('create')),
	array('label'=>'Редагувати керівника', 'url'=>array('update', 'id'=>$model->manager_id)),
	array('label'=>'Видалити керівника', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->manager_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Керівники', 'url'=>array('admin')),
);
?>

<h1><?php echo $model->name; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'manager_id',
		'name',
		'edrpou',
		'address',
		'tel',
		'account',
		'mfo',
		'comment',
		array(
            'name'=>'bydefault',
            'value'=>$model->bydefault == 0 ? Ні : Так,
        ),
	),
)); ?>
