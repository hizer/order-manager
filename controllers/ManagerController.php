<?php

class ManagerController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				//'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				//'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('index','view','admin','delete','create','update','getmanager'),
				'expression'=>'User::model()->findByPk(Yii::app()->user->id)->profile==admin',
            
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}


	public function actionGetmanager()
	{
		$key = $_POST['manager_id'];
		$model=$this->loadModel($key);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		$result = array('options' => $model);
         
        echo CJSON::encode($result);
	 
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));		
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Manager;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Manager']))
		{
			if($_POST['Manager']['bydefault'] == 1){
				
				$items = Manager::model()->findAll( array("condition"=>"bydefault = 1"));
				foreach ($items as $item)
				{
					$item->bydefault = 0;
					$item->save();
				}
				
			}
			$model->attributes=$_POST['Manager'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->manager_id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		
		//echo $_POST['Manager']['bydefault'];
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Manager']))
		{
			
			if(($_POST['Manager']['bydefault'] == 1) &&($model->bydefault == 0)){
				
				$items = Manager::model()->findAll( array("condition"=>"bydefault = 1"));
				foreach ($items as $item)
				{
					$item->bydefault = 0;
					$item->save();
				}
				
			}
			$model->attributes=$_POST['Manager'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->manager_id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$model=$this->loadModel($id);
		if($model->bydefault == 1){
			
		}else{
			$this->loadModel($id)->delete();
		}
		
		

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Manager');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Manager('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Manager']))
			$model->attributes=$_GET['Manager'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Manager the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Manager::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Manager $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='manager-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
