<?php
/* @var $this InvoiceController */
/* @var $model Invoice */

$this->breadcrumbs=array(
	'Invoices'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Invoice', 'url'=>array('index')),
	array('label'=>'Manage Invoice', 'url'=>array('admin')),
);
?>

<h1>Create Invoice</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>