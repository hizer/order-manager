<?php

/**
 * This is the model class for table "products_attributes".
 *
 * The followings are the available columns in table 'products_attributes':
 * @property integer $product_attribute_id
 * @property integer $product_id
 * @property integer $attribute_id
 */
class ProductsAttributes extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'products_attributes';
	}
	
	public $attribute_search;
	public $product_search;

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('product_id, attribute_id', 'required'),
			array('product_id, attribute_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('product_attribute_id, product_id, attribute_id, attribute_search, product_search', 'safe', 'on'=>'search'),
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
            'attribute'=>array(self::BELONGS_TO, 'Attributes', 'attribute_id'),
            'product'=>array(self::BELONGS_TO, 'Products', 'product_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'product_attribute_id' => 'Product Attribute',
			'product_id' => 'Товар',
			'attribute_id' => 'Атрибут',
			'attribute_search' => 'Атрибут',
			'product_search' => 'Товар',
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
		
		$criteria->with = array(
            'attribute' => array('select' => array('name')),
			'product' => array('select' => array('product_name')),
        );

		
		 
		
		$criteria->together = true;

        if (!empty($this->attribute_search))     {$criteria->addSearchCondition('attribute.name', $this->attribute_search);}
		if (!empty($this->product_search))  {$criteria->addSearchCondition('product.product_name', $this->product_search);}


		$criteria->compare('product_attribute_id',$this->product_attribute_id);
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('attribute_id',$this->attribute_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination' => array(
                'pageSize' => 50,
            ),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ProductsAttributes the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
