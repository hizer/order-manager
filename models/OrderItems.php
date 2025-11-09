<?php

/**
 * This is the model class for table "order_items".
 *
 * The followings are the available columns in table 'order_items':
 * @property integer $order_item_id
 * @property integer $order_id
 * @property integer $product_id
 * @property integer $width
 * @property integer $insert
 * @property integer $length
 * @property integer $height
 * @property integer $quantity
 * @property integer $price
 * @property integer $subtotal
 * @property integer $status_id
 * @property string $comment
 * @property string $comment_prod
 * @property string $delivered
 * @property string $tinting
 * @property string $patina
 * @property string $created_on
 * @property string $created_by
 * @property string $modified_on
 * @property string $modified_by
 * @property string $archive
 * @property string $joiner
 * @property string $joiner_table_top
 * @property string $joiner_table_bottom
 * @property string $packing
 * @property string $painter
 * @property string $coating
 * @property string $finish
 * @property string $finish_table_top
 * @property string $finish_table_bottom
 * @property string $primer
 * @property string $primer_table_top
 * @property string $primer_table_bottom
 * @property string $upholstery
 * @property string $joiner_updated
 * @property string $joiner_table_top_updated
 * @property string $joiner_table_bottom_updated
 * @property string $primer_updated
 * @property string $finish_updated
 * @property string $primer_table_top_updated
 * @property string $primer_table_bottom_updated
 * @property string $finish_table_top_updated
 * @property string $finish_table_bottom_updated
 * @property string $upholstery_updated
 * @property string $packing_updated
 */
class OrderItems extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'order_items';
	}
    public $city_search;
    public $customer_search;
    public $shop_search;
    public $product_search;
    public $type_search;
	public $all_customer_search;
    public $color_search;
    public $eaf_search;
    public $stone_search;
    public $glass_search;
    public $patina_search;
    public $tinting_search;
    public $create_search;
    public $period_start_search;
    public $period_end_search;
	public $finish_date_last_change = "-";
	 
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('width, length, height, price, quantity', 'required'),
			array('order_id, product_id, width, insert, length, height, quantity, status_id, tinting, patina, archive, joiner, joiner_table_top, joiner_table_bottom, finish, finish_table_top, finish_table_bottom, coating , packing, painter, primer, primer_table_top, primer_table_bottom, upholstery', 'numerical', 'integerOnly'=>true),
			array('price, subtotal', 'numerical', 'integerOnly'=>false),
			array('created_by, modified_by', 'length', 'max'=>32),
            array('comment, comment_prod', 'length', 'max'=>255),
            array('modified_on', 'default',
                'value'=>new CDbExpression('NOW()'),
                'setOnEmpty'=>false,'on'=>'update'),

            array('modified_by', 'default',
                'value'=>Yii::app()->user->id ,
                'setOnEmpty'=>false,'on'=>'update'),

            array('modified_on','default',
                'value'=>new CDbExpression('NOW()'),
                'setOnEmpty'=>false,'on'=>'insert'),

            array('created_by, modified_by', 'default',
                'value'=>Yii::app()->user->id ,
                'setOnEmpty'=>false,'on'=>'insert'),

            array('status_id', 'default', 'value' => '1'),
            array('archive', 'default', 'value' => '0'),
            array('joiner', 'default', 'value' => '0'),
            array('joiner_table_top', 'default', 'value' => '0'),
            array('joiner_table_bottom', 'default', 'value' => '0'),
            array('packing', 'default', 'value' => '0'),
            array('painter', 'default', 'value' => '0'),
            array('coating', 'default', 'value' => '0'),
            array('finish', 'default', 'value' => '0'),
            array('finish_table_top', 'default', 'value' => '0'),
            array('finish_table_bottom', 'default', 'value' => '0'),
            array('primer', 'default', 'value' => '0'),
            array('primer_table_top', 'default', 'value' => '0'),
            array('primer_table_bottom', 'default', 'value' => '0'),
            array('upholstery', 'default', 'value' => '0'),
            
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('order_item_id, order_id, product_id, width, insert, length, height, quantity, price, subtotal, status_id, comment,comment_prod, tinting, patina, created_on, created_by, modified_on, modified_by, archive, city_search, customer_search, shop_search, order_total, product_search, type_search, all_customer_search, color_search, eaf_search, stone_search, glass_search, patina_search, tinting_search, create_search, joiner, packing, painter, upholstery, period_start_search, period_end_search', 'safe', 'on'=>'search'),
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
            'chair'=>array(self::BELONGS_TO, 'Chair', 'product_id'),            
            'orderItemProperty'=>array(self::HAS_MANY, 'OrdersItemsProperties', 'order_item_id'),
            'colorItemProperty'=>array(self::HAS_MANY, 'OrdersItemsProperties', 'order_item_id'),
            'eafItemProperty'=>array(self::HAS_MANY, 'OrdersItemsProperties', 'order_item_id'),
            'stoneItemProperty'=>array(self::HAS_MANY, 'OrdersItemsProperties', 'order_item_id'),
            'glassItemProperty'=>array(self::HAS_MANY, 'OrdersItemsProperties', 'order_item_id'),
            'billItem'=>array(self::HAS_ONE, 'BillItems', 'order_item_id'),
            'invoiceItem'=>array(self::HAS_ONE, 'InvoiceItems', 'order_item_id'),
		    'status'=>array(self::BELONGS_TO, 'Status', 'status_id'),
            'user'=>array(self::BELONGS_TO, 'User', 'modified_by'),
            'order'=>array(self::BELONGS_TO, 'Orders', 'order_id'),
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
			'order_item_id' => 'Арт.',
			'order_id' => '№ Зам.',
			'product_id' => 'Товар',
			'product_search' => 'Товар',
			'type_search' => 'Тип',
			'all_customer_search' => 'Показати замовлення',
			'width' => 'Ш., мм',
			'insert' => 'Вст., мм',
			'length' => 'Д., мм',
			'height' => 'Вис., мм',
			'quantity' => 'Шт.',
			'price' => 'Ціна',
			'subtotal' => 'Загальна вартість',
			'status_id' => 'Статус',
			'comment' => 'Коментар в рахунок',
			'comment_prod' => 'Коментар для цеху',
			'tinting' => 'Тонування',
			'patina' => 'Патіна',
            'created_on' => 'Створено',
            'created_by' => 'Створений',
            'modified_on' => 'Змінено',
            'modified_by' => 'Змінив',
            'archive' => 'Архів',
            'joiner' => 'Стол.',
            'joiner_table_top' => 'Стол. верх',
            'joiner_table_bottom' => 'Стол. низ',
            'coating' => 'Покр',
            'finish' => 'Фініш',
            'finish_table_top' => 'Фініш верх',
            'finish_table_bottom' => 'Фініш низ',
            'primer' => 'Грунт',
            'primer_table_top' => 'Грунт верх',
            'primer_table_bottom' => 'Грунт низ',
            'packing' => 'Упак.',
            'painter' => 'Маляр',
            'upholstery' => 'Обивк.',
            'customer_search'=>'Покупець',
            'city_search'=>'Місто доставки',
            'city_or_region'=>'Місто або область',
            'color_search'=>'Покраска',
            'eaf_search'=>'HPL',
            'glass_search'=>'Скло',
            'stone_search'=>'Камінь',
            'patina_search'=>'Патіна',
            'tinting_search'=>'Тонування',
            'shop_search'=>'Магазин',
            'joiner_updated'=>'Стол. оновлено',
            'joiner_table_top_updated'=>'Стол. верх оновлено',
            'joiner_table_bottom_updated'=>'Стол. низ оновлено',
            'primer_updated'=>'Грунт оновлено',
            'primer_table_top_updated'=>'Грунт верх оновлено',
            'primer_table_bottom_updated'=>'Грунт низ оновлено',
            'finish_updated'=>'Фініш оновлено',
            'finish_table_top_updated'=>'Фініш верх оновлено',
            'finish_table_bottom_updated'=>'Фініш низ оновлено',
            'upholstery_updated'=>'Обивк. оновлено',
            'packing_updated'=>'Упак. оновлено',
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
	 
	 public function serchPeriod(){
 
        $criteria=new CDbCriteria;
        
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'sort' => array(
                'defaultOrder' => 'order_id ASC',

            ),
            'pagination' => array(
                'pageSize' => 1000,
            ),
        ));
 
	 }
	 
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
         $criteria->with = array(
            'order.customers' => array('select' => array('last_name', 'first_name')),
            'order.shop' => array('select' => array('full_name')),
            'order.city' => array('select' => array('city_name')),
            'product' => array('select' => array('product_name')),
            'product.productType' => array('select' => array('name')),
           // 'orderItemProperty.property' => array('select' => array('name')),
            'colorItemProperty.property' => array('select' => array('name')),
        );

        $criteria->together = true;
 

        if (!empty($this->all_city_search))     {$criteria->addSearchCondition(new CDbExpression( 'CONCAT(city.city_name, " ", city.region_name)' ), $this->city_search);}

        if (!empty($this->city_search))     {$criteria->addSearchCondition(new CDbExpression( 'CONCAT(city.city_name, " ", city.region_name)' ), $this->city_search);}
        if (!empty($this->customer_search)) {$criteria->addSearchCondition(new CDbExpression( 'CONCAT(customers.last_name, " ", customers.first_name)' ), $this->customer_search);}
       if (!empty($this->shop_search))     {$criteria->addSearchCondition('shop.full_name' , $this->shop_search);}
        if (!empty($this->product_search))  {$criteria->addSearchCondition('product.product_name', $this->product_search);}
        if (!empty($this->type_search))     {$criteria->addSearchCondition('productType.name',$this->type_search, false);}
		if (!empty($this->all_customer_search))     { $criteria->addCondition($this->all_customer_search .' > 0 ');}
       // if (!empty($this->color_search))    {$criteria->addCondition('property.name',$this->color_search, true,'OR');}
       // if (!empty($this->eaf_search))      {$criteria->addCondition('property.name',$this->eaf_search, true,'OR');}
       // if (!empty($this->stone_search))    {$criteria->addCondition('property.name',$this->stone_search, true,'OR');}
      //  if (!empty($this->glass_search))    {$criteria->addCondition('property.name',$this->glass_search, true,'OR');}


		$criteria->compare('t.order_item_id',$this->order_item_id);
		$criteria->compare('t.order_id',$this->order_id);
		$criteria->compare('t.product_id',$this->product_id);
		$criteria->compare('t.width',$this->width);
		$criteria->compare('t.insert',$this->insert);
		$criteria->compare('t.length',$this->length);
		$criteria->compare('t.height',$this->height);
		$criteria->compare('t.quantity',$this->quantity);
		$criteria->compare('t.price',$this->price);
		$criteria->compare('t.subtotal',$this->subtotal);
		$criteria->compare('t.status_id',$this->status_id);
		$criteria->compare('t.comment',$this->comment,true);
		//$criteria->compare('t.comment_prod',$this->comment_prod,true);
		$criteria->compare('t.tinting',$this->tinting,true);
		$criteria->compare('t.patina',$this->patina,true);
		$criteria->compare('property.name',$this->color_search,true);
		//$criteria->compare('order.shop.full_name',$this->shop_search);
		//$criteria->compare('t.created_on',$this->created_on);
		//$criteria->compare('t.create_search',$this->created_on);
        $criteria->mergeWith($this->dateRangeSearchCriteria('order.created_on', $this->created_on));
        //$criteria->mergeWith($this->dateRangeSearchCriteria('t.modified_on', $this->modified_on));
		$criteria->compare('t.created_by',$this->created_by,true);
		$criteria->compare('t.modified_on',$this->modified_on,true);
		$criteria->compare('t.modified_by',$this->modified_by,true);
		$criteria->compare('t.archive',$this->archive,true);
        $criteria->compare('t.joiner',$this->joiner);
        $criteria->compare('t.joiner_table_top',$this->joiner_table_top,true);
        $criteria->compare('t.joiner_table_bottom',$this->joiner_table_bottom,true);
        $criteria->compare('t.packing',$this->packing,true);
        $criteria->compare('t.painter',$this->painter,true);
        $criteria->compare('t.finish',$this->finish,true);
        $criteria->compare('t.finish_table_top',$this->finish_table_top,true);
        $criteria->compare('t.finish_table_bottom',$this->finish_table_bottom,true);
        $criteria->compare('t.coating',$this->coating,true);
        $criteria->compare('t.primer',$this->primer,true);
        $criteria->compare('t.primer_table_top',$this->primer_table_top,true);
        $criteria->compare('t.primer_table_bottom',$this->primer_table_bottom,true);
        $criteria->compare('t.upholstery',$this->upholstery,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort' => array(
                'defaultOrder' => 'order.order_id DESC',
				//'defaultOrder' => 'city.city_name, shop.full_name',
                'attributes'=>array(
                    'city_search'=>array(
                        'asc'=>'city.city_name',
                        'desc'=>'city.city_name DESC',
                    ),
                    '*',
                    'customer_search'=>array(
                        'asc'=>'customers.last_name',
                        'desc'=>'customers.last_name DESC',
                    ),
                    '*',
                    'shop_search'=>array(
                        'asc'=>'shop.full_name',
                        'desc'=>'shop.full_name DESC',
                    ),
                    '*',
                    'product_search'=>array(
                        'asc'=>'product.product_name',
                        'desc'=>'product.product_name DESC',
                    ),
                    '*',
                    'type_search'=>array(
                        'asc'=>'productType.name',
                        'desc'=>'productType.name DESC',
                    ),
                    '*',
                    'color_search'=>array(
                        'asc'=>'property.name',
                        'desc'=>'property.name DESC',
                    ),
                    '*',
                    'eaf_search'=>array(
                        'asc'=>'property.name',
                        'desc'=>'property.name DESC',
                    ),
                    '*',
                    'stone_search'=>array(
                        'asc'=>'property.name',
                        'desc'=>'property.name DESC',
                    ),
                    '*',
                    'glass_search'=>array(
                        'asc'=>'property.name',
                        'desc'=>'property.name DESC',
                    ),
                    '*',
                ),

            ),
            'pagination' => array(
                'pageSize' => 1000,
            ),
		));
	}
	
	public function search_date()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
         $criteria->with = array(
            'order.customers' => array('select' => array('last_name', 'first_name')),
            'order.shop' => array('select' => array('full_name')),
            'order.city' => array('select' => array('city_name')),
            'product' => array('select' => array('product_name')),
            'product.productType' => array('select' => array('name')),
           // 'orderItemProperty.property' => array('select' => array('name')),
            'colorItemProperty.property' => array('select' => array('name')),
        );

        $criteria->together = true;
 

        if (!empty($this->all_city_search))     {$criteria->addSearchCondition(new CDbExpression( 'CONCAT(city.city_name, " ", city.region_name)' ), $this->city_search);}

        if (!empty($this->city_search))     {$criteria->addSearchCondition(new CDbExpression( 'CONCAT(city.city_name, " ", city.region_name)' ), $this->city_search);}
        if (!empty($this->customer_search)) {$criteria->addSearchCondition(new CDbExpression( 'CONCAT(customers.last_name, " ", customers.first_name)' ), $this->customer_search);}
       if (!empty($this->shop_search))     {$criteria->addSearchCondition('shop.full_name' , $this->shop_search);}
        if (!empty($this->product_search))  {$criteria->addSearchCondition('product.product_name', $this->product_search);}
        if (!empty($this->type_search))     {$criteria->addSearchCondition('productType.name',$this->type_search, false);}
		if (!empty($this->all_customer_search))     { $criteria->addCondition($this->all_customer_search .' > 0 ');}
       // if (!empty($this->color_search))    {$criteria->addCondition('property.name',$this->color_search, true,'OR');}
       // if (!empty($this->eaf_search))      {$criteria->addCondition('property.name',$this->eaf_search, true,'OR');}
       // if (!empty($this->stone_search))    {$criteria->addCondition('property.name',$this->stone_search, true,'OR');}
      //  if (!empty($this->glass_search))    {$criteria->addCondition('property.name',$this->glass_search, true,'OR');}


		$criteria->compare('t.order_item_id',$this->order_item_id);
		$criteria->compare('t.order_id',$this->order_id);
		$criteria->compare('t.product_id',$this->product_id);
		$criteria->compare('t.width',$this->width);
		$criteria->compare('t.insert',$this->insert);
		$criteria->compare('t.length',$this->length);
		$criteria->compare('t.height',$this->height);
		$criteria->compare('t.quantity',$this->quantity);
		$criteria->compare('t.price',$this->price);
		$criteria->compare('t.subtotal',$this->subtotal);
		$criteria->compare('t.status_id',$this->status_id);
		$criteria->compare('t.comment',$this->comment,true);
		$criteria->compare('t.comment_prod',$this->comment_prod,true);
		$criteria->compare('t.tinting',$this->tinting,true);
		$criteria->compare('t.patina',$this->patina,true);
		$criteria->compare('property.name',$this->color_search,true);
		//$criteria->compare('order.shop.full_name',$this->shop_search);
		//$criteria->compare('t.created_on',$this->created_on);
		//$criteria->compare('t.create_search',$this->created_on);
        $criteria->mergeWith($this->dateRangeSearchCriteria('order.created_on', $this->created_on));
        //$criteria->mergeWith($this->dateRangeSearchCriteria('t.modified_on', $this->modified_on));
		$criteria->compare('t.created_by',$this->created_by,true);
		$criteria->compare('t.modified_on',$this->modified_on,true);
		$criteria->compare('t.modified_by',$this->modified_by,true);
		$criteria->compare('t.archive',$this->archive,true);
        $criteria->compare('t.joiner',$this->joiner);
        $criteria->compare('t.joiner_table_top',$this->joiner_table_top,true);
        $criteria->compare('t.joiner_table_bottom',$this->joiner_table_bottom,true);
        $criteria->compare('t.packing',$this->packing,true);
        $criteria->compare('t.painter',$this->painter,true);
        $criteria->compare('t.finish',$this->finish,true);
        $criteria->compare('t.finish_table_top',$this->finish_table_top,true);
        $criteria->compare('t.finish_table_bottom',$this->finish_table_bottom,true);
        $criteria->compare('t.coating',$this->coating,true);
        $criteria->compare('t.primer',$this->primer,true);
        $criteria->compare('t.primer_table_top',$this->primer_table_top,true);
        $criteria->compare('t.primer_table_bottom',$this->primer_table_bottom,true);
        $criteria->compare('t.upholstery',$this->upholstery,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort' => array(
                'defaultOrder' => 'order.order_id ASC',
				//'defaultOrder' => 'city.city_name, shop.full_name',
                'attributes'=>array(
                    'city_search'=>array(
                        'asc'=>'city.city_name',
                        'desc'=>'city.city_name DESC',
                    ),
                    '*',
                    'customer_search'=>array(
                        'asc'=>'customers.last_name',
                        'desc'=>'customers.last_name DESC',
                    ),
                    '*',
                    'shop_search'=>array(
                        'asc'=>'shop.full_name',
                        'desc'=>'shop.full_name DESC',
                    ),
                    '*',
                    'product_search'=>array(
                        'asc'=>'product.product_name',
                        'desc'=>'product.product_name DESC',
                    ),
                    '*',
                    'type_search'=>array(
                        'asc'=>'productType.name',
                        'desc'=>'productType.name DESC',
                    ),
                    '*',
                    'color_search'=>array(
                        'asc'=>'property.name',
                        'desc'=>'property.name DESC',
                    ),
                    '*',
                    'eaf_search'=>array(
                        'asc'=>'property.name',
                        'desc'=>'property.name DESC',
                    ),
                    '*',
                    'stone_search'=>array(
                        'asc'=>'property.name',
                        'desc'=>'property.name DESC',
                    ),
                    '*',
                    'glass_search'=>array(
                        'asc'=>'property.name',
                        'desc'=>'property.name DESC',
                    ),
                    '*',
                ),

            ),
            'pagination' => array(
                'pageSize' => 1000,
            ),
		));
	}
	
	public function search_city()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
         $criteria->with = array(
            'order.customers' => array('select' => array('last_name', 'first_name')),
            'order.shop' => array('select' => array('full_name')),
            'order.city' => array('select' => array('city_name')),
            'product' => array('select' => array('product_name')),
            'product.productType' => array('select' => array('name')),
           // 'orderItemProperty.property' => array('select' => array('name')),
            'colorItemProperty.property' => array('select' => array('name')),
        );

        $criteria->together = true;
 

        if (!empty($this->all_city_search))     {$criteria->addSearchCondition(new CDbExpression( 'CONCAT(city.city_name, " ", city.region_name)' ), $this->city_search);}

        if (!empty($this->city_search))     {$criteria->addSearchCondition(new CDbExpression( 'CONCAT(city.city_name, " ", city.region_name)' ), $this->city_search);}
        if (!empty($this->customer_search)) {$criteria->addSearchCondition(new CDbExpression( 'CONCAT(customers.last_name, " ", customers.first_name)' ), $this->customer_search);}
        if (!empty($this->shop_search))     {$criteria->addSearchCondition('shop.full_name' , $this->shop_search, false);}
        if (!empty($this->product_search))  {$criteria->addSearchCondition('product.product_name', $this->product_search);}
        if (!empty($this->type_search))     {$criteria->addSearchCondition('productType.name',$this->type_search, false);}
		if (!empty($this->all_customer_search))     { $criteria->addCondition($this->all_customer_search .' > 0 ');}
       // if (!empty($this->color_search))    {$criteria->addCondition('property.name',$this->color_search, true,'OR');}
       // if (!empty($this->eaf_search))      {$criteria->addCondition('property.name',$this->eaf_search, true,'OR');}
       // if (!empty($this->stone_search))    {$criteria->addCondition('property.name',$this->stone_search, true,'OR');}
      //  if (!empty($this->glass_search))    {$criteria->addCondition('property.name',$this->glass_search, true,'OR');}


		$criteria->compare('t.order_item_id',$this->order_item_id);
		$criteria->compare('t.order_id',$this->order_id);
		$criteria->compare('t.product_id',$this->product_id);
		$criteria->compare('t.width',$this->width);
		$criteria->compare('t.insert',$this->insert);
		$criteria->compare('t.length',$this->length);
		$criteria->compare('t.height',$this->height);
		$criteria->compare('t.quantity',$this->quantity);
		$criteria->compare('t.price',$this->price);
		$criteria->compare('t.subtotal',$this->subtotal);
		$criteria->compare('t.status_id',$this->status_id);
		$criteria->compare('t.comment',$this->comment,true);
		$criteria->compare('t.comment_prod',$this->comment_prod,true);
		$criteria->compare('t.tinting',$this->tinting,true);
		$criteria->compare('t.patina',$this->patina,true);
		$criteria->compare('property.name',$this->color_search,true);
		//$criteria->compare('t.created_on',$this->created_on);
		//$criteria->compare('t.create_search',$this->created_on);
        $criteria->mergeWith($this->dateRangeSearchCriteria('t.created_on', $this->created_on));
        //$criteria->mergeWith($this->dateRangeSearchCriteria('t.modified_on', $this->modified_on));
		$criteria->compare('t.created_by',$this->created_by,true);
		$criteria->compare('t.modified_on',$this->modified_on,true);
		$criteria->compare('t.modified_by',$this->modified_by,true);
		$criteria->compare('t.archive',$this->archive,true);
        $criteria->compare('t.joiner',$this->joiner,true);
        $criteria->compare('t.joiner_table_top',$this->joiner_table_top,true);
        $criteria->compare('t.joiner_table_bottom',$this->joiner_table_bottom,true);
        $criteria->compare('t.packing',$this->packing,true);
        $criteria->compare('t.painter',$this->painter,true);
        $criteria->compare('t.finish',$this->finish,true);
        $criteria->compare('t.finish_table_top',$this->finish_table_top,true);
        $criteria->compare('t.finish_table_bottom',$this->finish_table_bottom,true);
        $criteria->compare('t.coating',$this->coating,true);
        $criteria->compare('t.primer',$this->primer,true);
        $criteria->compare('t.primer_table_top',$this->primer_table_top,true);
        $criteria->compare('t.primer_table_bottom',$this->primer_table_bottom,true);
        $criteria->compare('t.upholstery',$this->upholstery,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort' => array(
                'defaultOrder' => 'city.city_name, shop.full_name',
                'attributes'=>array(
                    'city_search'=>array(
                        'asc'=>'city.city_name',
                        'desc'=>'city.city_name DESC',
                    ),
                    '*',
                    'customer_search'=>array(
                        'asc'=>'customers.last_name',
                        'desc'=>'customers.last_name DESC',
                    ),
                    '*',
                    'shop_search'=>array(
                        'asc'=>'shop.full_name',
                        'desc'=>'shop.full_name DESC',
                    ),
                    '*',
                    'product_search'=>array(
                        'asc'=>'product.product_name',
                        'desc'=>'product.product_name DESC',
                    ),
                    '*',
                    'type_search'=>array(
                        'asc'=>'productType.name',
                        'desc'=>'productType.name DESC',
                    ),
                    '*',
                    'color_search'=>array(
                        'asc'=>'property.name',
                        'desc'=>'property.name DESC',
                    ),
                    '*',
                    'eaf_search'=>array(
                        'asc'=>'property.name',
                        'desc'=>'property.name DESC',
                    ),
                    '*',
                    'stone_search'=>array(
                        'asc'=>'property.name',
                        'desc'=>'property.name DESC',
                    ),
                    '*',
                    'glass_search'=>array(
                        'asc'=>'property.name',
                        'desc'=>'property.name DESC',
                    ),
                    '*',
                ),

            ),
            'pagination' => array(
                'pageSize' => 1000,
            ),
		));
	}
	
	public function search_shop()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
         $criteria->with = array(
            'order.customers' => array('select' => array('last_name', 'first_name')),
            'order.shop' => array('select' => array('full_name')),
            'order.city' => array('select' => array('city_name')),
            'product' => array('select' => array('product_name')),
            'product.productType' => array('select' => array('name')),
           // 'orderItemProperty.property' => array('select' => array('name')),
            'colorItemProperty.property' => array('select' => array('name')),
        );

        $criteria->together = true;
 

        if (!empty($this->all_city_search))     {$criteria->addSearchCondition(new CDbExpression( 'CONCAT(city.city_name, " ", city.region_name)' ), $this->city_search);}

        if (!empty($this->city_search))     {$criteria->addSearchCondition(new CDbExpression( 'CONCAT(city.city_name, " ", city.region_name)' ), $this->city_search);}
        if (!empty($this->customer_search)) {$criteria->addSearchCondition(new CDbExpression( 'CONCAT(customers.last_name, " ", customers.first_name)' ), $this->customer_search);}
        if (!empty($this->shop_search))     {$criteria->addSearchCondition('shop.full_name' , $this->shop_search, false);}
        if (!empty($this->product_search))  {$criteria->addSearchCondition('product.product_name', $this->product_search);}
        if (!empty($this->type_search))     {$criteria->addSearchCondition('productType.name',$this->type_search, false);}
		if (!empty($this->all_customer_search))     { $criteria->addCondition($this->all_customer_search .' > 0 ');}
       // if (!empty($this->color_search))    {$criteria->addCondition('property.name',$this->color_search, true,'OR');}
       // if (!empty($this->eaf_search))      {$criteria->addCondition('property.name',$this->eaf_search, true,'OR');}
       // if (!empty($this->stone_search))    {$criteria->addCondition('property.name',$this->stone_search, true,'OR');}
      //  if (!empty($this->glass_search))    {$criteria->addCondition('property.name',$this->glass_search, true,'OR');}


		$criteria->compare('t.order_item_id',$this->order_item_id);
		$criteria->compare('t.order_id',$this->order_id);
		$criteria->compare('t.product_id',$this->product_id);
		$criteria->compare('t.width',$this->width);
		$criteria->compare('t.insert',$this->insert);
		$criteria->compare('t.length',$this->length);
		$criteria->compare('t.height',$this->height);
		$criteria->compare('t.quantity',$this->quantity);
		$criteria->compare('t.price',$this->price);
		$criteria->compare('t.subtotal',$this->subtotal);
		$criteria->compare('t.status_id',$this->status_id);
		$criteria->compare('t.comment',$this->comment,true);
		$criteria->compare('t.comment_prod',$this->comment_prod,true);
		$criteria->compare('t.tinting',$this->tinting,true);
		$criteria->compare('t.patina',$this->patina,true);
		$criteria->compare('property.name',$this->color_search,true);
		//$criteria->compare('t.created_on',$this->created_on);
		//$criteria->compare('t.create_search',$this->created_on);
        $criteria->mergeWith($this->dateRangeSearchCriteria('t.created_on', $this->created_on));
        //$criteria->mergeWith($this->dateRangeSearchCriteria('t.modified_on', $this->modified_on));
		$criteria->compare('t.created_by',$this->created_by,true);
		$criteria->compare('t.modified_on',$this->modified_on,true);
		$criteria->compare('t.modified_by',$this->modified_by,true);
		$criteria->compare('t.archive',$this->archive,true);
        $criteria->compare('t.joiner',$this->joiner,true);
        $criteria->compare('t.joiner_table_top',$this->joiner_table_top,true);
        $criteria->compare('t.joiner_table_bottom',$this->joiner_table_bottom,true);
        $criteria->compare('t.packing',$this->packing,true);
        $criteria->compare('t.painter',$this->painter,true);
        $criteria->compare('t.finish',$this->finish,true);
        $criteria->compare('t.finish_table_top',$this->finish_table_top,true);
        $criteria->compare('t.finish_table_bottom',$this->finish_table_bottom,true);
        $criteria->compare('t.coating',$this->coating,true);
        $criteria->compare('t.primer',$this->primer,true);
        $criteria->compare('t.primer_table_top',$this->primer_table_top,true);
        $criteria->compare('t.primer_table_bottom',$this->primer_table_bottom,true);
        $criteria->compare('t.upholstery',$this->upholstery,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort' => array(
                'defaultOrder' => 'shop.full_name, city.city_name ',
                'attributes'=>array(
                    'city_search'=>array(
                        'asc'=>'city.city_name',
                        'desc'=>'city.city_name DESC',
                    ),
                    '*',
                    'customer_search'=>array(
                        'asc'=>'customers.last_name',
                        'desc'=>'customers.last_name DESC',
                    ),
                    '*',
                    'shop_search'=>array(
                        'asc'=>'shop.full_name',
                        'desc'=>'shop.full_name DESC',
                    ),
                    '*',
                    'product_search'=>array(
                        'asc'=>'product.product_name',
                        'desc'=>'product.product_name DESC',
                    ),
                    '*',
                    'type_search'=>array(
                        'asc'=>'productType.name',
                        'desc'=>'productType.name DESC',
                    ),
                    '*',
                    'color_search'=>array(
                        'asc'=>'property.name',
                        'desc'=>'property.name DESC',
                    ),
                    '*',
                    'eaf_search'=>array(
                        'asc'=>'property.name',
                        'desc'=>'property.name DESC',
                    ),
                    '*',
                    'stone_search'=>array(
                        'asc'=>'property.name',
                        'desc'=>'property.name DESC',
                    ),
                    '*',
                    'glass_search'=>array(
                        'asc'=>'property.name',
                        'desc'=>'property.name DESC',
                    ),
                    '*',
                ),

            ),
            'pagination' => array(
                'pageSize' => 1000,
            ),
		));
	}
	
	public function search_finish()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
         $criteria->with = array(
            'order.customers' => array('select' => array('last_name', 'first_name')),
            'order.shop' => array('select' => array('full_name')),
            'order.city' => array('select' => array('city_name')),
            'product' => array('select' => array('product_name')),
            'product.productType' => array('select' => array('name')),
           // 'orderItemProperty.property' => array('select' => array('name')),
            'colorItemProperty.property' => array('select' => array('name')),
        );

        $criteria->together = true;
 

        if (!empty($this->all_city_search))     {$criteria->addSearchCondition(new CDbExpression( 'CONCAT(city.city_name, " ", city.region_name)' ), $this->city_search);}

        if (!empty($this->city_search))     {$criteria->addSearchCondition(new CDbExpression( 'CONCAT(city.city_name, " ", city.region_name)' ), $this->city_search);}
        if (!empty($this->customer_search)) {$criteria->addSearchCondition(new CDbExpression( 'CONCAT(customers.last_name, " ", customers.first_name)' ), $this->customer_search);}
        if (!empty($this->shop_search))     {$criteria->addSearchCondition('shop.full_name' , $this->shop_search, false);}
        if (!empty($this->product_search))  {$criteria->addSearchCondition('product.product_name', $this->product_search);}
        if (!empty($this->type_search))     {$criteria->addSearchCondition('productType.name',$this->type_search, false);}
		if (!empty($this->all_customer_search))     { $criteria->addCondition($this->all_customer_search .' > 0 ');}
       // if (!empty($this->color_search))    {$criteria->addCondition('property.name',$this->color_search, true,'OR');}
       // if (!empty($this->eaf_search))      {$criteria->addCondition('property.name',$this->eaf_search, true,'OR');}
       // if (!empty($this->stone_search))    {$criteria->addCondition('property.name',$this->stone_search, true,'OR');}
      //  if (!empty($this->glass_search))    {$criteria->addCondition('property.name',$this->glass_search, true,'OR');}


		$criteria->compare('t.order_item_id',$this->order_item_id);
		$criteria->compare('t.order_id',$this->order_id);
		$criteria->compare('t.product_id',$this->product_id);
		$criteria->compare('t.width',$this->width);
		$criteria->compare('t.insert',$this->insert);
		$criteria->compare('t.length',$this->length);
		$criteria->compare('t.height',$this->height);
		$criteria->compare('t.quantity',$this->quantity);
		$criteria->compare('t.price',$this->price);
		$criteria->compare('t.subtotal',$this->subtotal);
		$criteria->compare('t.status_id',$this->status_id);
		$criteria->compare('t.comment',$this->comment,true);
		$criteria->compare('t.comment_prod',$this->comment_prod,true);
		$criteria->compare('t.tinting',$this->tinting,true);
		$criteria->compare('t.patina',$this->patina,true);
		$criteria->compare('property.name',$this->color_search,true);
		//$criteria->compare('t.created_on',$this->created_on);
		//$criteria->compare('t.create_search',$this->created_on);
        $criteria->mergeWith($this->dateRangeSearchCriteria('t.created_on', $this->created_on));
        //$criteria->mergeWith($this->dateRangeSearchCriteria('t.modified_on', $this->modified_on));
		$criteria->compare('t.created_by',$this->created_by,true);
		$criteria->compare('t.modified_on',$this->modified_on,true);
		$criteria->compare('t.modified_by',$this->modified_by,true);
		$criteria->compare('t.archive',$this->archive,true);
        $criteria->compare('t.joiner',$this->joiner,true);
        $criteria->compare('t.joiner_table_top',$this->joiner_table_top,true);
        $criteria->compare('t.joiner_table_bottom',$this->joiner_table_bottom,true);
        $criteria->compare('t.packing',$this->packing,true);
        $criteria->compare('t.painter',$this->painter,true);
        $criteria->compare('t.finish',$this->finish,true);
        $criteria->compare('t.finish_table_top',$this->finish_table_top,true);
        $criteria->compare('t.finish_table_bottom',$this->finish_table_bottom,true);
        $criteria->compare('t.coating',$this->coating,true);
        $criteria->compare('t.primer',$this->primer,true);
        $criteria->compare('t.primer_table_top',$this->primer_table_top,true);
        $criteria->compare('t.primer_table_bottom',$this->primer_table_bottom,true);
        $criteria->compare('t.upholstery',$this->upholstery,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort' => array(
                'defaultOrder' => 'finish_updated DESC',
                'attributes'=>array(
                    'city_search'=>array(
                        'asc'=>'city.city_name',
                        'desc'=>'city.city_name DESC',
                    ),
                    '*',
                    'customer_search'=>array(
                        'asc'=>'customers.last_name',
                        'desc'=>'customers.last_name DESC',
                    ),
                    '*',
                    'shop_search'=>array(
                        'asc'=>'shop.full_name',
                        'desc'=>'shop.full_name DESC',
                    ),
                    '*',
                    'product_search'=>array(
                        'asc'=>'product.product_name',
                        'desc'=>'product.product_name DESC',
                    ),
                    '*',
                    'type_search'=>array(
                        'asc'=>'productType.name',
                        'desc'=>'productType.name DESC',
                    ),
                    '*',
                    'color_search'=>array(
                        'asc'=>'property.name',
                        'desc'=>'property.name DESC',
                    ),
                    '*',
                    'eaf_search'=>array(
                        'asc'=>'property.name',
                        'desc'=>'property.name DESC',
                    ),
                    '*',
                    'stone_search'=>array(
                        'asc'=>'property.name',
                        'desc'=>'property.name DESC',
                    ),
                    '*',
                    'glass_search'=>array(
                        'asc'=>'property.name',
                        'desc'=>'property.name DESC',
                    ),
                    '*',
                ),

            ),
            'pagination' => array(
                'pageSize' => 1000,
            ),
		));
	}

    public function filter()
    {
        $criteria=new CDbCriteria;
        $criteria->compare('order_id',$this->order_id, false);
        $criteria->compare('archive',$this->archive,true);
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'sort' => array(
                'defaultOrder' => 'order_id DESC',

            ),
            'pagination' => array(
                'pageSize' => 1000,
            ),
        ));
    }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return OrderItems the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
    public function getProductName($id){

        $product = Products::model()->findByPk($id);
        echo "<span data-product-name='".$product->product_name."'>".$product->product_name."</span>";
    }

    public function getColor($id){
        $properties  = OrdersItemsProperties::model()->findAll(
            array("condition"=>"order_item_id = $id")
        );
        foreach ($properties as $property){
           echo "<p><b>".$property->property->attribute->name.": </b>";
           echo $property->property->name.' <a class="update-color" title="Редагувати" href="/ordersItemsProperties/update?id='.$property->order_item_property_id.'"><img src="../images/admin/update.png" alt="Редагувати"></a>';
        }
        if ($this->tinting == 1){
            echo "<p><b>Тонування:</b> Так";        }
        if ($this->patina == 1){
            echo "<p><b>Патіна:</b> Золото";
        }elseif($this->patina == 2){
            echo "<p><b>Патіна:</b> Мідь";
        }elseif($this->patina == 3){
            echo "<p><b>Патіна:</b> Бронза";
        }
    }
	
	public function getStyledComment($id){
		$item  = OrderItems::model()->findByPk($id);
        echo "<span class='text-green'>".$item->comment."</span>";
	}
	
	public function getColorWithoutLink($id){
        $properties  = OrdersItemsProperties::model()->findAll(
            array("condition"=>"order_item_id = $id")
        );
        foreach ($properties as $property){
           echo "<p><b>".$property->property->attribute->name.": </b>";
           echo $property->property->name;
        }
        if ($this->tinting == 1){
            echo "<p><b>Тонування:</b> Так";        }
        if ($this->patina == 1){
            echo "<p><b>Патіна:</b> Золото";
        }elseif($this->patina == 2){
            echo "<p><b>Патіна:</b> Мідь";
        }elseif($this->patina == 3){
            echo "<p><b>Патіна:</b> Бронза";
        }
    }

    public function getColorName($id){

        $properties = OrdersItemsProperties::model()->with('property')->findByAttributes(
            array(
                'order_item_id'=>$id
            ),
            array(
                'condition' =>'property.attribute_id = :id',
                'params'=>array(':id'=> '2')
            )
        );
        if ($properties->property->name != "" ){
            echo "<span data-color='".$properties->property->name."'>".$properties->property->name."</span>";
        }
        //echo $properties->property->name;
    }

    public function getEafName($id){

        $properties  = OrdersItemsProperties::model()->with('property')->findByAttributes(
            array(
                'order_item_id'=>$id
            ),
            array(
                'condition' =>'property.attribute_id = 1 OR property.attribute_id = 12'
            )
        );
        echo $properties->property->name;
    }

    public function getStoneName($id){

        $properties  = OrdersItemsProperties::model()->with('property')->findByAttributes(
            array(
                'order_item_id'=>$id
            ),
            array(
                'condition' =>'property.attribute_id = :id',
                'params'=>array(':id'=> '3')
            )
        );
        echo $properties->property->name;
    }

    public function getGlassName($id){

        $properties  = OrdersItemsProperties::model()->with('property')->findByAttributes(
            array(
                'order_item_id'=>$id
            ),
            array(
                'condition' =>'property.attribute_id = :id',
                'params'=>array(':id'=> '5')
            )
        );
        echo $properties->property->name;
    }

    public function getShopName($id){

        $properties  = OrderItems::model()->findByPk($id);
        echo "<span data-shop='".$properties->order->shop->full_name."'>".$properties->order->shop->full_name."</span>";
    }

	public function isTable($id){
		$product = OrderItems::model()->findByPk($id);
		$productType    = $product->product->product_type_id;
		
		if ($productType == 1){
            return true;
        }else{
			return false;
		}
	}

    public function getProductNameAndSize($id){

        $product = OrderItems::model()->findByPk($id);

        $itemId     = $product->order_item_id;
        $width      = $product->width;
        $insert     = $product->insert;
        $length     = $product->length;
        $comment    = $product->comment;
        $comment_prod    = $product->comment_prod;

        $properties = OrdersItemsProperties::model()->findAll('order_item_id=:order_item_id',
            array(
                ':order_item_id'=>$itemId,
            )
        );
		$numItems = count($properties);
		$i = 0;
        foreach ($properties as $p){
            $color .=  $p->property->attribute->name ." <b>". $p->property->name."</b>";
			if($i == $numItems - 1) {
					$color .= " ";
				}else{
					$color .= ", "; 
				}
			$i++;
        }

        $size           = $length."(+".$insert.")x".$width;
        $productName    = $product->product->product_name;
        $productType    = $product->product->product_type_id;
        $typeName       = $product->product->productType->name;
		
			
        if ($productType == 1){
			
			if(!empty($size)  or  !empty($color) or !empty($comment)){
				$productName .= ":";
			}
			
			if(!empty($color)){
				$color = ", " . $color;	
			}
			
			
			if($comment != "") {
				echo "<b>".$typeName." ".$productName."</b>  ".$size . $color." <br /><span style='color: #08a708'>".$comment."</span>" ;	
			}else{
				echo "<b>".$typeName." ".$productName."</b>  ".$size . $color;	
			}    
        }
        if($productType > 1){
			if(!empty($color) or !empty($comment)){
				$productName .= ":";
			}
            echo "<b>".$typeName." ".$productName."</b> ".$color." <span style='color: #08a708'>".$comment."</span>";
        }
		if($comment_prod != ""){
			 echo " <p class='hidden print-visible comment_prod'><span >".$comment_prod." </span> ";
		}
    }
	
	public function getProductProperties($id){
		$product = OrderItems::model()->findByPk($id);

        $itemId     = $product->order_item_id;
		$properties = OrdersItemsProperties::model()->findAll('order_item_id=:order_item_id',
            array(
                ':order_item_id'=>$id,
            )
        );

        foreach ($properties as $property){
			
            $color .= "<b>".$property->property->attribute->name.": </b>  ". $property->property->name. "<br />";			
        }		
		
		echo $color;
	}

    public function getProductSize($id){

        $product = OrderItems::model()->findByPk($id);

        $itemId     = $product->order_item_id;
        $width      = $product->width;
        $insert     = $product->insert;
        $length     = $product->length;
       

        $properties = OrdersItemsProperties::model()->findAll('order_item_id=:order_item_id',
            array(
                ':order_item_id'=>$itemId,
            )
        );


        //$size           = $length."(+".$insert.")x".$width;
        //$productName    = $product->product->product_name;
        $productType    = $product->product->product_type_id;
        //$typeName       = $product->product->productType->name;
 
		if ($productType == 1){
			
				echo $length."(+".$insert.")x".$width;
        }else if($productType > 1)
        {
            echo $length."x".$width;
        }else{
			echo $length."x".$width;
		}
	 
    }
	public function setNewFinishDate($newDate){
		$finish_date_last_change = $newDate;
	}
	public function getNewFinishDate(){
		return $finish_date_last_change;
	}
	
	
	public function isNewUpdateDate($currDate, $paramName){
		
		if ($currDate !=="0000-00-00 00:00:00" ){		
		
			$currDate = Yii::app()->dateFormatter->format("dd-MM-y", $currDate);		 
			 
			if(Yii::app()->params[$paramName] === $currDate ){
				 return  true;	
			}else{
				Yii::app()->params[$paramName]  = $currDate;	
				 return false;		
			}			
		}
		else{
			Yii::app()->params[$paramName] = "0000-00-00 00:00:00"; 
			return false;
		}				
	}
	
	public function getCountPrintShopItems(){
	 
		$productTypes = array(1=>0, 2=>0, 3=>0);
		foreach ($this->order_item_id as $item){
			 $product = OrderItems::model()->findByPk($item);
			 
			$productTypes[$product->product->product_type_id] += $product->quantity;
		}
		echo "Столів: <b>" . $productTypes[1] . "</b>, стільців: <b>" . $productTypes[2] . "</b>, табуретів: <b>" . $productTypes[3] . "</b>";
	}
	public function getCountFinishedItemsAll($productionType, $updated){
		$count = "";
		
		$updated_start = $updated . " 00:00:00";
		$updated_end = $updated . " 23:59:59";
		$items = OrderItems::model()->findAll($productionType.'_updated > :'.$productionType.'_updated_start
				AND '.$productionType.'_updated < :'.$productionType.'_updated_end AND '.$productionType.' = 1 ', array(
				':'.$productionType.'_updated_start' => $updated_start, 
				':'.$productionType.'_updated_end' => $updated_end,
			)
		);

        foreach ($items as $item){			
            $count +=  $item->quantity;			
        }
		return  $count;
	}
	
	public function getCountFinishedItemsByType($itemType, $productionType, $updated){
		$count = 0;
		
		$updated_start = $updated . " 00:00:00";
		$updated_end = $updated . " 23:59:59";
		
		$criteria = new CDbCriteria;
        $criteria->select = 't.quantity';
        $criteria->join ='LEFT JOIN products ON products.product_id = t.product_id';
        $criteria->condition = 't.'.$productionType.'_updated > :'.$productionType.'_updated_start 
			AND t.'.$productionType.'_updated < :'.$productionType.'_updated_end  
			 AND t.'.$productionType.' = 1
			 AND products.product_type_id = :prodTypeId';

        $criteria->params = array(
				 ':prodTypeId' => $itemType, 
				':'.$productionType.'_updated_start' => $updated_start, 
				':'.$productionType.'_updated_end' => $updated_end,
				);
 
		$items = OrderItems::model()->findAll($criteria);

        foreach ($items as $item){			
            $count +=  $item->quantity;			
        }

		return  $count;
	}
	
	public function getCountFinishedChair($finish_updated){
		$count = 0;
		
		$finish_updated_start = $finish_updated . " 00:00:00";
		$finish_updated_end = $finish_updated . " 23:59:59";
		
		$criteria = new CDbCriteria;
        $criteria->select = 't.quantity';
        $criteria->join ='LEFT JOIN products ON products.product_id = t.product_id';
        $criteria->condition = 't.finish_updated > :finish_updated_start 
			AND t.finish_updated < :finish_updated_end  
			 AND t.finish = 1
			 AND products.product_type_id = :prodTypeId';

        $criteria->params = array(
				 ':prodTypeId' => '2', 
				':finish_updated_start' => $finish_updated_start, 
				':finish_updated_end' => $finish_updated_end,
				);
 
		$items = OrderItems::model()->findAll($criteria);

        foreach ($items as $item){			
            $count +=  $item->quantity;			
        }

		return  $count;
	}
	
	public function getCountFinishedTaburet($finish_updated){
		$count = "0";
		
		$finish_updated_start = $finish_updated . " 00:00:00";
		$finish_updated_end = $finish_updated . " 23:59:59";
		
		$criteria = new CDbCriteria;
        $criteria->select = 't.quantity';
        $criteria->join ='LEFT JOIN products ON products.product_id = t.product_id';
        $criteria->condition = 't.finish_updated > :finish_updated_start 
			AND t.finish_updated < :finish_updated_end  
			 AND t.finish = 1
			 AND products.product_type_id = :prodTypeId';

        $criteria->params = array(
				 ':prodTypeId' => '3', 
				':finish_updated_start' => $finish_updated_start, 
				':finish_updated_end' => $finish_updated_end,
				);
 
		$items = OrderItems::model()->findAll($criteria);

        foreach ($items as $item){			
            $count +=  $item->quantity;			
        }

		return  $count;
	}
	
	 
	
    public function behaviors()
    {
        return array(
            'dateRangeSearch'=>array(
                'class'=>'application.components.behaviors.EDateRangeSearchBehavior',
            ),
        );
    }

    public function getMetaData(){
        $data = parent::getMetaData();
        $data->columns['glass_search'] = array('name' => 'glass_search','defaultValue'=>'$data->getGlassName($data->order_item_id)' );
        $data->columns['eaf_search'] = array('name' => 'eaf_search');
        return $data;
    }

}
