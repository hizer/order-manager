<?php
/* @var $this ChairController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Chairs',
);

$this->menu=array(
	array('label'=>'Create Chair', 'url'=>array('create')),
	array('label'=>'Manage Chair', 'url'=>array('admin')),
);
?>

<h1>Chairs</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
