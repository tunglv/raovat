<?php

/**
 * This is the model class for table "product".
 *
 * The followings are the available columns in table 'product':
 * @property string $id
 * @property string $name
 * @property string $desc
 * @property string $content
 * @property string $image
 * @property string $created
 * @property string $update
 * @property integer $user_id
 * @property integer $manager_id
 * @property string $catagory
 * @property string $status
 * @property string $alias
 *
 * The followings are the available model relations:
 * @property Catagory $catagory0
 */
class Product extends CActiveRecord
{
    public $upload_method = 'file';
    public $image_file;
    public $image_url;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Product the static model class
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
		return 'product';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, desc, content, image, created, catagory, alias', 'required'),
			array('user_id, manager_id, is_slide', 'numerical', 'integerOnly'=>true),
			array('name, alias', 'length', 'max'=>255),
			array('desc', 'length', 'max'=>300),
			array('image', 'length', 'max'=>100),
			array('catagory', 'length', 'max'=>11),
			array('status', 'length', 'max'=>7),
			array('is_slide', 'length', 'max'=>2),
			array('update', 'safe'),

            array('image_file', 'file', 'allowEmpty' => true),
            array('image_file', 'file', 'types'=>'jpg, gif, png', 'allowEmpty' => true),

            array('image_url', 'url', 'allowEmpty' => true, 'on' => 'update'),
            array('upload_method', 'checkUpload', 'on' => 'create'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, is_slide, name, desc, content, image, created, update, user_id, manager_id, catagory, status, alias', 'safe', 'on'=>'search'),
		);
	}
    public function checkUpload($attribute, $params)
    {
        $post = $_POST['NewKnowledge'];

        $uv = new CUrlValidator;
        $urlValidate = $uv->validateValue($post['image_url']);

        if($post['upload_method'] == 'url'){
            $size = getimagesize($post['image_url']);
            if(!$post['image_url'] || ($post['image_url'] && !$urlValidate) || !$size){
                $this->addError('upload_method', 'Đường dẫn URl ảnh phải đúng định dạng');
            }
        } elseif($post['upload_method'] == 'file' && !$_FILES['browse_file']['size']){
            $this->addError('upload_method', 'Bạn cần chọn 1 ảnh để upload');
        }
    }
    /**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'catagory0' => array(self::BELONGS_TO, 'Catagory', 'catagory'),
			'manager' => array(self::BELONGS_TO, 'Manager', 'manager_id'),
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
			'desc' => 'Desc',
			'content' => 'Content',
			'image' => 'Image',
			'created' => 'Created',
			'update' => 'Update',
			'user_id' => 'User',
			'manager_id' => 'Manager',
			'catagory' => 'Catagory',
			'status' => 'Status',
			'alias' => 'Alias',
            'is_slide' => 'Is slide'
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
		$criteria->compare('desc',$this->desc,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('update',$this->update,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('manager_id',$this->manager_id);
		$criteria->compare('catagory',$this->catagory,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('alias',$this->alias,true);
		$criteria->compare('is_slide',$this->is_slide,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * Get url of product
     * @param alias of product
     */
    public function getUrl($alias = null){
        if(!$alias) $alias = $this->alias;
        return Yii::app()->createUrl('san-pham/chi-tiet/'.$alias);
    }

    /**
     * @param string $alias
     * @return bool|CActiveRecord product
     */
    public function getProductByAlias($alias = null){
        if($alias){
            $criteria = new CDbCriteria();
            $criteria->compare('t.alias', $alias);
            $criteria->compare('t.status', 'ENABLE');
            $criteria->order = 't.created DESC';

            $product = $this->find($criteria);

            return $product;
        }else return false;
    }

    /**
     * @param null $id
     */
    public function getProductById($id = null){
        if($id){
            $product = $this->findByPk($id, array('condition'=>'t.`status`="ENABLE"'));
            return $product;
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

    public function getImageUrl($id = null, $size = '420'){
        $id = $id ? $id : $this->id;

        $imgConf = Yii::app()->params->product;
        $contentPath = $imgConf['path']."{$id}/".$size.'.jpg';
        return Yii::app()->getBaseUrl(TRUE).'/'.$contentPath;
    }
}