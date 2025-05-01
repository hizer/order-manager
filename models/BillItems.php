<?php

/**
 * This is the model class for table "bill_items".
 *
 * The followings are the available columns in table 'bill_items':
 * @property string $bill_item_id
 * @property string $bill_id
 * @property string $order_item_id
 * @property string $created_on
 * @property string $created_by
 * @property string $modified_on
 * @property string $modified_by
 */
class BillItems extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'bill_items';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('bill_id, order_item_id', 'required'),
			array('bill_id, order_item_id', 'length', 'max'=>10),
			array('created_by, modified_by', 'length', 'max'=>40),
            array('modified_on', 'default',
                'value'=>new CDbExpression('NOW()'),
                'setOnEmpty'=>false,'on'=>'update'),

            array('modified_by', 'default',
                'value'=>Yii::app()->user->id ,
                'setOnEmpty'=>false,'on'=>'update'),

            array('created_on, modified_on','default',
                'value'=>new CDbExpression('NOW()'),
                'setOnEmpty'=>false,'on'=>'insert'),

            array('created_by, modified_by', 'default',
                'value'=>Yii::app()->user->id ,
                'setOnEmpty'=>false,'on'=>'insert'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('bill_item_id, bill_id, order_item_id, created_on, created_by, modified_on, modified_by', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(

            'orderItem'=>array(self::BELONGS_TO, 'OrderItems', 'order_item_id'),
            'bill'=>array(self::BELONGS_TO, 'Bill', 'bill_id'),
            'creator' => array(self::BELONGS_TO, 'User', 'created_by'),
            'updater' => array(self::BELONGS_TO, 'User', 'modified_by'),


		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'bill_item_id' => 'Bill Item',
			'bill_id' => 'Bill',
			'order_item_id' => 'Order Item',
			'created_on' => 'Created On',
			'created_by' => 'Created By',
			'modified_on' => 'Modified On',
			'modified_by' => 'Modified By',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('bill_item_id',$this->bill_item_id,true);
		$criteria->compare('bill_id',$this->bill_id,true);
		$criteria->compare('order_item_id',$this->order_item_id,true);
		$criteria->compare('created_on',$this->created_on,true);
		$criteria->compare('created_by',$this->created_by,true);
		$criteria->compare('modified_on',$this->modified_on,true);
		$criteria->compare('modified_by',$this->modified_by,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort' => array(
                'defaultOrder' => 'bill_item_id DESC',

            ),
		));
	}

    public function filter()
    {
        $criteria=new CDbCriteria;
        $criteria->compare('bill_item_id',$this->bill_item_id,false);
        $criteria->compare('bill_id',$this->bill_id,false);
        $criteria->compare('order_item_id',$this->order_item_id,false);
        $criteria->compare('created_on',$this->created_on,false);
        $criteria->compare('created_by',$this->created_by,true);
        $criteria->compare('modified_on',$this->modified_on,true);
        $criteria->compare('modified_by',$this->modified_by,true);
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'sort' => array(
                'defaultOrder' => 'bill_item_id ASC',

            ),
            'pagination' => array(
                'pageSize' => 50,
            ),
        ));
    }
	
	public function getTotalBillAmount($billId){
		
		$amoumt = 0;
		
		$bill=Bill::model()->findByPK($billId);
		$amoumt += $bill->delivery_cost;
		
		$criteria = new CDbCriteria;
        $criteria->select = 't.order_item_id';
        $criteria->join ='LEFT JOIN order_items ON order_items.order_item_id = t.order_item_id';
        $criteria->condition = 't.bill_id = :bill_id';

        $criteria->params = array(				
			':bill_id' => $billId, 			
		);
 
		$items = BillItems::model()->findAll($criteria);

        foreach ($items as $item){			
            $amoumt +=  $item->orderItem->subtotal;			
        }

		return  $amoumt;
	}
	
	public function getTotalItemCountById($billId, $typeId){
		
		$count = 0;
		
		$criteria = new CDbCriteria;
        $criteria->select = 't.order_item_id';
        $criteria->join ='LEFT JOIN order_items ON order_items.order_item_id = t.order_item_id';
        $criteria->condition = 't.bill_id = :bill_id';

        $criteria->params = array(				
			':bill_id' => $billId, 			
		);
 
		$items = BillItems::model()->findAll($criteria);

        foreach ($items as $item){		
			if($item->orderItem->product->product_type_id == $typeId){
				$count +=  $item->orderItem->quantity;		
			}       	
        }

		return  $count;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BillItems the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
