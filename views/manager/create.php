<?php
/* @var $this ManagerController */
/* @var $model Manager */

$this->breadcrumbs=array(
	'Managers'=>array('index'),
	'Create',
);

$this->menu=array(
	 
	array('label'=>'Керівники', 'url'=>array('admin')),
);
?>

<h1>Додати керівника</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>