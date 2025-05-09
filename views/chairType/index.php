<?php
/* @var $this ChairTypeController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Chair Types',
);

$this->menu=array(
	array('label'=>'Create ChairType', 'url'=>array('create')),
	array('label'=>'Manage ChairType', 'url'=>array('admin')),
);
?>

<h1>Chair Types</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
