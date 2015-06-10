<?php

/**
 * This is the model class for table "object".
 *
 * The followings are the available columns in table 'object':
 * @property string $id
 * @property string $title
 * @property string $alias
 * @property string $desc
 * @property string $content
 * @property string $image
 * @property double $price
 * @property string $price_type
 * @property string $ward_id
 * @property string $ward_name
 * @property string $district_id
 * @property string $district_name
 * @property string $province_id
 * @property string $province_name
 * @property string $phone
 * @property string $mobile
 * @property string $email
 * @property string $address
 * @property string $status
 * @property integer $created
 * @property integer $user_id
 * @property string $user_name
 * @property string $link_web
 * @property string $type
 * @property string $kind
 * @property integer $date_start
 * @property integer $date_end
 * @property string $code
 * @property string $skyper
 * @property string $yahoo
 * @property integer $viewed
 */
class Object extends CActiveRecord
{
    public $upload_method = 'url';
    public $image_file;
    public $image_url;
    public $verifyCode;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Object the static model class
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
		return 'object';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, desc, image, mobile, date_start, date_end, code', 'required'),
			array('created, user_id, viewed', 'numerical', 'integerOnly'=>true),
			array('price', 'numerical'),
			array('title, alias, image, ward_name, district_name, province_name, phone, mobile, email, address, user_name, link_web, skyper, yahoo', 'length', 'max'=>255),
			array('desc', 'length', 'max'=>1000),
			array('price_type', 'length', 'max'=>3),
			array('ward_id, district_id, province_id', 'length', 'max'=>5),
			array('status', 'length', 'max'=>7),
			array('type, date_total', 'length', 'max'=>2),
			array('kind', 'length', 'max'=>1),
			array('code', 'length', 'max'=>10),
			array('content', 'safe'),

            array('date_end','checkTime'),

            array('image_file', 'file', 'allowEmpty' => true),
            array('image_file', 'file', 'types'=>'jpg, gif, png', 'allowEmpty' => true),

            array('image_url', 'url', 'allowEmpty' => true),
            array('upload_method', 'checkUpload'),

            array('verifyCode', 'required'),
            array('verifyCode', 'CaptchaExtendedValidator', 'allowEmpty'=>!CCaptcha::checkRequirements()),

			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, alias, desc, content, date_total, image, price, price_type, ward_id, ward_name, district_id, district_name, province_id, province_name, phone, mobile, email, address, status, created, user_id, user_name, link_web, type, kind, date_start, date_end, code, skyper, yahoo, viewed', 'safe', 'on'=>'search'),
		);
	}

    public function checkTime($attribute, $params){
        $post = $_POST['Object'];
        if(isset($post['date_start']) || isset($post['date_end'])) {
            $timeOpen = isset($post['date_start']) ? $post['date_start'] : $this->date_start;
            $timeClose = isset($post['date_end']) ? $post['date_end'] : $this->date_end;

            if(($timeOpen > $timeClose)) {
                $this->addError('date_end','Thời gian bắt đầu không được lớn hơn thời gian kết thúc');
                //Yii::app()->user->setFlash('error', "Thời gian mở cửa không được lớn hơn thời gian đóng cửa");
            }
        }
    }

    public function checkUpload($attribute, $params)
    {
        if(Yii::app()->controller->action->id == 'update' || Yii::app()->controller->action->id == 'updateObject') return true;

        $post = $_POST['Object'];

        $uv = new CUrlValidator;
        $urlValidate = $uv->validateValue($post['image_url']);

        if($post['upload_method'] == 'url'){
            $size = getimagesize($post['image_url']);
            if(!$post['image_url'] || ($post['image_url'] && !$urlValidate) || !$size){
                $this->addError('upload_method', 'Đường dẫn URl ảnh phải đúng định dạng');
            }
        } elseif($post['upload_method'] == 'file'){
            if(!$_FILES['browse_file']['size'])  $this->addError('upload_method', 'Bạn cần chọn 1 ảnh để upload');
            else{
                $name = $_FILES["browse_file"]["name"];
                $ext = pathinfo($name, PATHINFO_EXTENSION);
                if(!in_array($ext, array('jpg', 'gif', 'png')))
                    $this->addError('upload_method', 'Bạn cần chọn 1 ảnh để upload');
            }
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title',
			'alias' => 'Alias',
			'desc' => 'Desc',
			'content' => 'Content',
			'image' => 'Image',
			'price' => 'Price',
			'price_type' => 'Price Type',
			'ward_id' => 'Ward',
			'ward_name' => 'Ward Name',
			'district_id' => 'District',
			'district_name' => 'District Name',
			'province_id' => 'Province',
			'province_name' => 'Province Name',
			'phone' => 'Phone',
			'mobile' => 'Mobile',
			'email' => 'Email',
			'address' => 'Address',
			'status' => 'Status',
			'created' => 'Created',
			'user_id' => 'User',
			'user_name' => 'User Name',
			'link_web' => 'Link Web',
			'type' => 'Type',
			'kind' => 'Kind',
			'date_start' => 'Date Start',
			'date_end' => 'Date End',
			'code' => 'Code',
			'skyper' => 'Skyper',
			'yahoo' => 'Yahoo',
			'viewed' => 'Viewed',
            'date_total' => 'Date Total'
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('alias',$this->alias,true);
		$criteria->compare('desc',$this->desc,true);
		$criteria->compare('content',$this->content,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('price',$this->price);
		$criteria->compare('price_type',$this->price_type,true);
		$criteria->compare('ward_id',$this->ward_id,true);
		$criteria->compare('ward_name',$this->ward_name,true);
		$criteria->compare('district_id',$this->district_id,true);
		$criteria->compare('district_name',$this->district_name,true);
		$criteria->compare('province_id',$this->province_id,true);
		$criteria->compare('province_name',$this->province_name,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('mobile',$this->mobile,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('created',$this->created);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('user_name',$this->user_name,true);
		$criteria->compare('link_web',$this->link_web,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('kind',$this->kind,true);
		$criteria->compare('date_start',$this->date_start);
		$criteria->compare('date_end',$this->date_end);
		$criteria->compare('date_total',$this->date_total);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('skyper',$this->skyper,true);
		$criteria->compare('yahoo',$this->yahoo,true);
		$criteria->compare('viewed',$this->viewed);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function getStatusData() {
        return array(
            'enable' => 'Đã duyệt',
            'disable' => 'Hủy',
            'pending' => 'Chờ duyệt'
        );
    }
    public function getStatusLabel() {
        return $this->statusData[$this->status];
    }

    //1: Thuong, 2: vip
    public function getKindData() {
        return array(
            '1' => 'Tin thường',
            '2' => 'Tin Vip',
        );
    }
    public function getKindLabel() {
        return $this->kindData[$this->kind];
    }

    //1: Thuong, 2: vip
    public function getTimeData() {
        return array(
            '1' => '1 ngày',
            '2' => '3 ngày',
            '3' => '5 ngày',
        );
    }
    public function getTimeLabel(){
        return $this->timeData[$this->date_total];
    }

    //1: may tinh-may van phong, 2: bat dong san, 3: oto, 4: dien thoai - sim so, 5: thoi trang - my pham, 6: dien lanh - dien may, 7: dien tu - ky thuat so, 8: du lich - the thao, 9: noi - ngoai that, 10: xe dap - xe may, 11: do dung - me va be, 12: vat lieu - xay dung, 13: dich vu
    public function getTypeData() {
        return array(
            '1' => 'Máy tính - máy văn phòng',
            '2' => 'Bất động sản',
            '3' => 'Oto',
            '4' => 'Điện thoại - sim số',
            '5' => 'Thời trang - mỹ phẩm',
            '6' => 'Điện lạnh - điện máy',
            '7' => 'Điện tử - kỹ thuật số',
            '8' => 'Du lịch - thể thao',
            '9' => 'Nội - ngoại thất',
            '10' => 'Xe đạp - xe máy',
            '11' => 'Đồ dùng - mẹ và bé',
            '12' => 'Vật liệu - xây dựng',
            '13' => 'Dịch vụ',
        );
    }
    public function getTypeLabel($type = '') {
        $type = $type ? $type : $this->type;
        return $this->typeData[$type];
    }

    public function getAliasData(){
        return array(
            'may-tinh-may-van-phong' => '1',
            'bat-dong-san' => '2',
            'oto' => '3',
            'dien-thoai-sim-so' => '4',
            'thoi-trang-my-pham' => '5',
            'dien-lanh-dien-may' => '6',
            'dien-tu-ky-thuat-so' => '7',
            'du-lich-the-thao' => '8',
            'noi-ngoai-that' => '9',
            'xe-dap-xe-may' => '10',
            'do-dung-me-va-be' => '11',
            'vat-lieu-xay-dung' => '12',
            'dich-vu' => '13',
        );
    }

    public function getAliasLabel($alias = ''){
        return $this->aliasData[$alias];
    }

    public function getNewSyntax(){
        $chars = array(0,1,2,3,4,5,6,7,8,9,'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
        $new_syntax = '';
        $max = count($chars) - 1;

        for($i=0;$i<5;$i++){
            $new_syntax .= $chars[rand(0, $max)];
        }

        if($this->exists("code = '{$new_syntax}'")){
            return $this->getNewSyntax();
        }
        return $new_syntax;
    }

    public function getImageUrl($id = null, $size = 'thumb'){
        $id = $id ? $id : $this->id;

        $imgConf = Yii::app()->params->object;
        $contentPath = $imgConf['path']."{$id}/".$size.'.jpg?t='.time();
        return Yii::app()->getBaseUrl(TRUE).'/'.$contentPath;
    }

    public function getUrl($id = null, $alias = null){
        $id = $id ? $id : $this->id;
        $alias = $alias ? $alias : $this->alias;

        return Yii::app()->createUrl('/web/object/detail', array('id' => $id, 'alias'=>$alias));
    }
}