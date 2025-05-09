<?php
/* @var $this ManagerController */
/* @var $model Manager */

$this->breadcrumbs=array(
	'Managers'=>array('admin'),
	'Manage',
);

$this->menu=array(
	// array('label'=>'List Manager', 'url'=>array('index')),
	array('label'=>'Додати керівника', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#manager-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Керівники</h1>

 

 <?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'manager-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
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
            'value'=>'$data->bydefault == 0 ? Ні : Так',
        ),
	 
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
