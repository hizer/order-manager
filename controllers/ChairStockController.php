<?php

class ChairStockController extends Controller
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
			// array('allow',  // allow all users to perform 'index' and 'view' actions
				// 'actions'=>array('index','view'),
				// 'users'=>array('*'),
			// ),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','admin','createChair', 'chairJoiner', 'getTotalAmountCreatedProduct'),
				 'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete', 'view', 'update', 'chairJoiner', 'getTotalAmountCreatedProduct'),
			 'expression'=>'User::model()->findByPk(Yii::app()->user->id)->profile==admin',
      
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
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
		$model=new ChairStock;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ChairStock']))
		{
			
			$chairTypeModel = ChairType::model()->findByPk( $_POST['ChairStock']["chair_type_id"]); 
			$quantity = strval($_POST['quantity']);
			$arrItems = $_POST['ChairStock'];
			for($i = 1; $quantity >= $i; $quantity--)
			{
				$model=new ChairStock;
				$model->chair_type_id=$arrItems["chair_type_id"];
				$model->save();
			}	
			Yii::app()->user->setFlash('success', 'Успішно додано на склад <br>  модель <b>'.$chairTypeModel->name. '</b>, кількість <b>'.$_POST['quantity'] .' </b>.');
 
		//$model->unsetAttributes();
			 $this->redirect('create');
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}
	
	public function actionGetTotalAmountCreatedProduct(){
		
		$totalAmout = 0;
		$created_on_start = Yii::app()->getRequest()->getParam('createdFrom');
		$created_on_end = Yii::app()->getRequest()->getParam('createdTo');

		
		// Yii::trace("+++++ productType: ".$productType, 'info');    
		
		$criteriaItems = new CDbCriteria;
		// $criteriaItems->select = 't.product_id , t.quantity';
		 
		$criteriaItems->condition = 't.created_on >= :created_on_start 
			AND t.created_on <= :created_on_end ';

		 $criteriaItems->params = array(
				':created_on_start' => $created_on_start, 
				':created_on_end' => $created_on_end,
				);
 
		$items = ChairStock::model()->findAll($criteriaItems);
		$result = array();
		$products = array();
		foreach ($items as $item){
			$products[$item->chairType->name] += 1;
			$totalAmout += 1;
		}
		ksort($products);
		$result[] = array('totalAmout'=>$totalAmout,
						'items'=>$products
		);		
					 
		echo CJSON::encode($result);
		Yii::app()->end();
	}
	
	public function actionChairJoiner($start = '', $end ='')
    {		
		$criteria = new CDbCriteria();
		$criteria->select = 't.*';     

		if(isset($_GET[ChairStock][created_on][from]) && $_GET[ChairStock][created_on][from] != ""){ 
			 	$criteria->compare('created_on ','>='.$_GET[ChairStock][created_on][from]. " 00:00:00");	
		}else{
			 	$criteria->compare('created_on ','>='.date('Y-m-01'). " 00:00:00");				
		}
		if(isset($_GET[ChairStock][created_on][to]) && $_GET[ChairStock][created_on][to] != ""){ 
			$criteria->compare('created_on ','<='.$_GET[ChairStock][created_on][to]. " 23:59:59");		
		}		
		
        $dataProvider=new CActiveDataProvider('ChairStock' ,
			array('criteria'=>$criteria,
				'pagination'=>array(
					'pageSize'=>50,
				),
			)
		);
		Yii::trace("+++++ actionChairJoiner POST FROM: ".$_GET[ChairStock][created_on][from], 'info');
		Yii::trace("+++++ actionChairJoiner POST TO: ".$_GET[ChairStock][created_on][to], 'info');
		$dataProvider->sort->defaultOrder='created_on DESC';
		$this->render('chairJoiner',array(
			'dataProvider'=>$dataProvider,
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

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ChairStock']))
		{
			$model->attributes=$_POST['ChairStock'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->chair_stock_id));
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
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('ChairStock');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new ChairStock('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ChairStock']))
			$model->attributes=$_GET['ChairStock'];
		$this->layout='column1';
		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ChairStock the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=ChairStock::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param ChairStock $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='chair-stock-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
