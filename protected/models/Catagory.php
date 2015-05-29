<?php

/**
 * This is the model class for table "catagory".
 *
 * The followings are the available columns in table 'catagory':
 * @property string $id
 * @property string $name
 * @property string $manager_id
 * @property string $created
 * @property string $updated
 * @property integer $parent
 * @property string $status
 * @property string $alias
 *
 * The followings are the available model relations:
 * @property Manager $manager
 * @property Product[] $products
 */
class Catagory extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Catagory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'catagory';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, manager_id, created, alias', 'required'),
			array('parent', 'numerical', 'integerOnly'=>true),
			array('name, alias', 'length', 'max'=>255),
			array('manager_id', 'length', 'max'=>11),
			array('status', 'length', 'max'=>7),
			array('updated', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, manager_id, created, updated, parent, status, alias', 'safe', 'on'=>'search'),
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
			'manager' => array(self::BELONGS_TO, 'Manager', 'manager_id'),
			'products' => array(self::HAS_MANY, 'Product', 'catagory'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'manager_id' => 'Manager',
			'created' => 'Created',
			'updated' => 'Updated',
			'parent' => 'Parent',
			'status' => 'Status',
			'alias' => 'Alias',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('manager_id',$this->manager_id,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('updated',$this->updated,true);
		$criteria->compare('parent',$this->parent);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('alias',$this->alias,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /*
     * Function return object catagory
     * @param: alias catagory
     */
    public function getCatagoryByAlias($alias=''){
        if($alias){
            $criteria = new CDbCriteria();
            $criteria->compare('t.alias', $alias);
            $criteria->compare('t.status', 'ENABLE');
            $criteria->order = 't.created DESC';

            $catagory = $this->find($criteria);

            return $catagory;
        }else return false;
    }

    public function getStatusData(){
        return array(
            'ENABLE' => 'Hiển thị',
            'DISABLE' => 'Ẩn',
            'PENDING' => 'Chờ duyệt'
        );
    }

    public function getStatusLabel(){
        return $this->statusData[$this->status];
    }

    public function getAll($cache = true){
        $data = $this->findAll();
        return $data;
    }

    public function getData(){
        return CHtml::listData($this->getAll(), 'id', 'name');
    }
}