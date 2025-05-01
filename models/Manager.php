<?php

/**
 * This is the model class for table "manager".
 *
 * The followings are the available columns in table 'manager':
 * @property integer $manager_id
 * @property string $name
 * @property string $edrpou
 * @property string $address
 * @property string $tel
 * @property string $account
 * @property string $mfo
 * @property string $comment
 * @property integer $bydefault
 */
class Manager extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'manager';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, edrpou, address, tel, account, mfo, comment, bydefault', 'required'),
			array('bydefault', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('manager_id, name, edrpou, address, tel, account, mfo, comment, bydefault', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'manager_id' => 'Manager',
			'name' => 'Постачальник',
			'edrpou' => 'ЄДРПОУ',
			'address' => 'АДРЕСА',
			'tel' => 'Тел.',
			'account' => 'РОЗР/РАХ.',
			'mfo' => 'МФО',
			'comment' => 'Комментар',
			'bydefault' => 'По замовчуванні',
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

		$criteria->compare('manager_id',$this->manager_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('edrpou',$this->edrpou,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('tel',$this->tel,true);
		$criteria->compare('account',$this->account,true);
		$criteria->compare('mfo',$this->mfo,true);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('bydefault',$this->bydefault);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Manager the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
