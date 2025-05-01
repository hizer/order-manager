<?php

/**
 * This is the model class for table "chair_stock".
 *
 * The followings are the available columns in table 'chair_stock':
 * @property integer $chair_stock_id
 * @property integer $chair_type_id
 * @property integer $on_stock
 * @property string $created_on
 * @property integer $created_by
 * @property string $modified_on
 * @property integer $modified_by
 */
class ChairStock extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'chair_stock';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('chair_type_id', 'required'),
			array('chair_type_id, on_stock, created_by, modified_by', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('chair_stock_id, chair_type_id, on_stock, created_on, created_by, modified_on, modified_by', 'safe', 'on'=>'search'),
		
		
				array('modified_on', 'default',
					'value'=>new CDbExpression('NOW()'),
					'setOnEmpty'=>false,'on'=>'update'),

				array('modified_by', 'default',
					'value'=>Yii::app()->user->id ,
					'setOnEmpty'=>false,'on'=>'update'),

				array('created_on','default',
					'value'=>new CDbExpression('NOW()'),
					'setOnEmpty'=>false,'on'=>'insert'),

				array('created_by', 'default',
					'value'=>Yii::app()->user->id ,
					'setOnEmpty'=>false,'on'=>'insert'),
			
			array('on_stock', 'default', 'value' => '1'),
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
			'chairType'=>array(self::BELONGS_TO, 'ChairType', 'chair_type_id'),
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
			'chair_stock_id' => 'Chair Stock',
			'chair_type_id' => 'Модель',
			'on_stock' => 'На складі',
			'created_on' => 'Створено',
            'created_by' => 'Створений',
            'modified_on' => 'Змінено',
            'modified_by' => 'Змінив',     
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

		$criteria->compare('chair_stock_id',$this->chair_stock_id);
		$criteria->compare('chair_type_id',$this->chair_type_id);
		$criteria->compare('on_stock',$this->on_stock);
		$criteria->compare('created_on',$this->created_on,true);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('modified_on',$this->modified_on,true);
		$criteria->compare('modified_by',$this->modified_by);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort' => array(
                'defaultOrder' => 'chair_stock_id DESC',
				),
			'pagination' => array(
					'pageSize' => 100,
				),
		));
	}
	
	public function isNewCreateDate($currDate){
		
		if ($currDate !=="0000-00-00 00:00:00" ){		
		
			// $currDate = Yii::app()->dateFormatter->format("dd-MM-y", $currDate);		 
			 
			if(Yii::app()->params['chairJoinerCreated'] === $currDate ){
				 return  true;	
			}else{
				Yii::app()->params['chairJoinerCreated']  = $currDate;	
				 return false;		
			}			
		}
		else{
			Yii::app()->params['chairJoinerCreated'] = "0000-00-00 00:00:00"; 
			return false;
		}				
	}
	
	public function getCountFinishedItemsAll($updated){		 
		
		$chairTypes = ChairType::model()->findAll();
		
		$created_start = $updated . " 00:00:00";
		$created_end = $updated . " 23:59:59";
		$items = ChairStock::model()->findAll(
		'created_on > :created_start AND  created_on < :created_end ', array(
				':created_start' => $created_start, 
				':created_end' => $created_end,
			)
		);		 
		
		return  $items;
	}
	
	public function getAllChairs(){		
		 
		$criteria = new CDbCriteria;
		$criteria->select = 't.*';
		$criteria->order = 't.product_type_id asc, t.product_name asc';
		$criteria->condition = 'product_type_id >= :chair AND product_type_id <= :taburet';
			$criteria->params = array(
					':chair' => 2, 
					':taburet' => 3, 
					);
		
		$chairs = Products::model()->findAll($criteria);		
		
		return $chairs;
	}
	
	public function getAllItemsOnStock(){
		
		$ret = array();
		
		$chairTypes = ChairType::model()->findAll();
		
		foreach ($chairTypes as $chairType){					
			
			$criteria = new CDbCriteria;
			$criteria->select = 't.*';
			$criteria->join ='LEFT JOIN chair_type ON chair_type.chair_type_id = t.chair_type_id';
			$criteria->condition = 't.on_stock = :on_stock 
				AND chair_type.chair_type_id = :chairTypeId';
			$criteria->params = array(
					':on_stock' => 1, 
					':chairTypeId' => $chairType->chair_type_id,
					);		
		 		
			$items = ChairStock::model()->findAll($criteria);
			
			$ret[$chairType->name]["min"] = $chairType->desired_in_stock;	
			$ret[$chairType->name]["value"] = count($items);	
			
			Yii::trace("+++++ getAllItemsOnStock id: ".$chair->chair_type_id. " count" . count($items), 'info');
        }
		
		return $ret;
	}
	
	public function afterSave() {

    	Yii::app()->user->setFlash('success', 'Успішно збережено!');

	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ChairStock the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
