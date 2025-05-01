<?php

class InvoiceItemsController extends Controller
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

            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions'=>array('index','view','create','update','deleteAndReturnToItems','createInvoice', 'reqTest01Loading'),
                'users'=>array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions'=>array('admin','delete','getSummOfTotalInvoiceAmount', 'reqTest01Loading'),
                'users'=>array('admin'),
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
        $model=new InvoiceItems;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['InvoiceItems']))
        {
            $model->attributes=$_POST['InvoiceItems'];
            if($model->save())
                $this->redirect(array('view','id'=>$model->invoice_item_id));
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

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['InvoiceItems']))
        {
            $model->attributes=$_POST['InvoiceItems'];
            if($model->save())
                $this->redirect(array('view','id'=>$model->invoice_item_id));
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

    public function actionDeleteAndReturnToItems($id)
    {
        $invoiceItems = $this->loadModel($id);
        $item = $invoiceItems->order_item_id;


        $orderItem = OrderItems::model()->findByPk($item);
        $orderItem->archive = 0;
        $orderId = $orderItem->order_id;
        $orderItem->save(false);

        $order = Orders::model()->findByPk($orderId);
        $order->archive = 0;
        $order->save(false);


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
        $dataProvider=new CActiveDataProvider('InvoiceItems');
        $this->render('index',array(
            'dataProvider'=>$dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model=new InvoiceItems('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['InvoiceItems']))
            $model->attributes=$_GET['InvoiceItems'];

        $this->render('admin',array(
            'model'=>$model,
        ));
    }
	
	public function actionGetSummOfTotalInvoiceAmount($model){
				
		$count = 10;
		
		// $criteria = new CDbCriteria;
        // $criteria->select = 't.order_item_id';
        // $criteria->join ='LEFT JOIN order_items ON order_items.order_item_id = t.order_item_id';
        // $criteria->condition = 't.invoice_id = :invoice_id';

        // $criteria->params = array(				
			// ':invoice_id' => $invoiceId, 			
		// );
 
		// $items = InvoiceItems::model()->findAll($criteria);

        // foreach ($items as $item){		
			// if($item->orderItem->product->product_type_id == $typeId){
				// $count +=  $item->orderItem->quantity;		
			// }       	
        // }

		return  $count;
	}
	
	public function getTotalItemCountById($model){
		
	}
	
	public function actionReqTest01Loading() {		
		
		
		$table = 0;
		$chair = 0;
		$taburet = 0;
		$totalAmout = 0;
		$deliveryCost = 0;
		$created_on_start = Yii::app()->getRequest()->getParam('createdFrom');
		$created_on_end = Yii::app()->getRequest()->getParam('createdTo');
		$manager = Yii::app()->getRequest()->getParam('manager');
		$shop = Yii::app()->getRequest()->getParam('shop');
		$account = Yii::app()->getRequest()->getParam('account');
		$customer = Yii::app()->getRequest()->getParam('customer');
		 
		
		$criteriaInvoices=new CDbCriteria;
		$criteriaInvoices->select='delivery_cost';  
		// $criteriaInvoices->condition='created_on >= :created_on_start 
						// AND created_on <= :created_on_end					 
						// ';
		// $criteriaInvoices->params=array(
					// ':created_on_start' => $created_on_start, 
					// ':created_on_end' => $created_on_end
	 
					// );   			
					
		if(!empty($created_on_start)){ 
			$criteriaInvoices->compare('created_on ','>='.$created_on_start);		
		}	
		if(!empty($created_on_end)){ 
			$criteriaInvoices->compare('created_on ','<='.$created_on_end);		
		}			
			 // Yii::trace("+++++ actionChairJoiner POST FROM: ".$_GET[ChairStock][created_on][from], 'info');
		$invoices=Invoice::model()->findAll($criteriaInvoices); 
 
		foreach ($invoices as $invoice){
			$deliveryCost += $invoice->delivery_cost;
		}

   
		$criteriaItems = new CDbCriteria;
		$criteriaItems->select = 't.*';
		$criteriaItems->join ='LEFT JOIN order_items ON order_items.order_item_id = t.order_item_id';
			// $criteriaItems->condition = 't.created_on >= :created_on_start 
				// AND t.created_on <= :created_on_end ';

			 // $criteriaItems->params = array(
				 
					// ':created_on_start' => $created_on_start, 
					// ':created_on_end' => $created_on_end,
					// );
		if (!empty($manager))  {			
			$criteriaItems->addSearchCondition('invoice.manager_id', $manager, false);
			$criteriaItems->with = array(
				'invoice' => array('select' => array('manager_id')),          
			);  
		}
		if (!empty($shop))  {
			$criteriaItems->addSearchCondition('invoice.shop_id', $shop, false);			
			$criteriaItems->with = array(
				'invoice' => array('select' => array('shop_id')),          
			);
		}
		
		if(!empty($account))  {
			$criteriaItems->addSearchCondition('invoice.account_id', $account, false);			
			$criteriaItems->with = array(
				'invoice' => array('select' => array('account_id')),          
			);
		}
		if(!empty($created_on_start)){ 
		// $criteriaItems->addSearchCondition('t.created_on', $created_on_start, true, 'AND', '>=');
		$criteriaItems->compare('t.created_on ','>='.$created_on_start);
			Yii::trace("+++++++++++++++ created_on_start NOT EMPTY ". $created_on_start, 'info');
		}	
		else{
			Yii::trace("+++++++++++++++ created_on_start EMPTY", 'info');
		}
		if(!empty($created_on_end)){ 
		// $criteriaItems->addSearchCondition('t.created_on', $created_on_end, true, 'AND', '>=');
		$criteriaItems->compare('t.created_on ','<='.$created_on_end);
			Yii::trace("+++++++++++++++ created_on_end NOT EMPTY ". $created_on_end , 'info');
		}
		else{
			Yii::trace("+++++++++++++++ created_on_end EMPTY", 'info');
		}
 
		 
		$items = InvoiceItems::model()->findAll($criteriaItems);

		foreach ($items as $item){		
			if($item->orderItem->product->product_type_id == 1){
				$table +=  $item->orderItem->quantity;		
			}else if($item->orderItem->product->product_type_id == 2){
				$chair +=  $item->orderItem->quantity;	
			}else if($item->orderItem->product->product_type_id == 3){
				$taburet +=  $item->orderItem->quantity;	
			}  

			$totalAmout += $item->orderItem->subtotal;
		}
		
		$totalAmout += deliveryCost;
		$result = array();
			$result[] = array('totalAmout'=>$totalAmout, 'delivery'=>$deliveryCost, 'table'=>$table,'chair'=>$chair,'taburet'=>$taburet);
		
		 
		echo CJSON::encode($result);
		Yii::app()->end();
		// }
		// echo $created_on_start;
	}

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return InvoiceItems the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model=InvoiceItems::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param InvoiceItems $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='invoice-items-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
