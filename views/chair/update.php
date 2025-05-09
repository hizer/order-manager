<?php
/* @var $this ChairController */
/* @var $model Chair */

$this->breadcrumbs=array(
	'Chairs'=>array('index'),
	$model->chair_id=>array('view','id'=>$model->chair_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Chair', 'url'=>array('index')),
	array('label'=>'Create Chair', 'url'=>array('create')),
	array('label'=>'View Chair', 'url'=>array('view', 'id'=>$model->chair_id)),
	array('label'=>'Manage Chair', 'url'=>array('admin')),
);
?>

<h1>Update Chair <?php echo $model->chair_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>