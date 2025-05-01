<?php

/**
 * This is the model class for table "chair".
 *
 * The followings are the available columns in table 'chair':
 * @property integer $chair_id
 * @property integer $product_id
 * @property integer $chair_type_id
 */
class Chair extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'chair';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('product_id, chair_type_id', 'required'),
			array('product_id, chair_type_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('chair_id, product_id, chair_type_id', 'safe', 'on'=>'search'),
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
			'product'=>array(self::BELONGS_TO, 'Products', 'product_id'),
			'chairType'=>array(self::BELONGS_TO, 'ChairType', 'chair_type_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'chair_id' => 'id',
			'product_id' => 'Назва',
			'chair_type_id' => 'Модель',
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

		$criteria->compare('chair_id',$this->chair_id);
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('chair_type_id',$this->chair_type_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Chair the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
