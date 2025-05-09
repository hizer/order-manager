<?php
/* @var $this TableInsertController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Table Inserts',
);

$this->menu=array(
	array('label'=>'Create TableInsert', 'url'=>array('create')),
	array('label'=>'Manage TableInsert', 'url'=>array('admin')),
);
?>

<h1>Table Inserts</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
