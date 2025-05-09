<?php
/* @var $this ManagerController */
/* @var $model Manager */

$this->breadcrumbs=array(
	'Managers'=>array('index'),
	$model->name=>array('view','id'=>$model->manager_id),
	'Update',
);

$this->menu=array(
	// array('label'=>'Додати керівника', 'url'=>array('create')),
	// array('label'=>'View Manager', 'url'=>array('view', 'id'=>$model->manager_id)),
	array('label'=>'Керівники', 'url'=>array('admin')),
);
?>

<h1>Редагувати керівника <?php echo $model->manager_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>