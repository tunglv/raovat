<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property string $id
 * @property string $name
 * @property string $password
 * @property string $email
 * @property string $phone
 * @property string $avatar
 * @property string $address
 * @property string $created
 * @property string $status
 * @property string $manager_id
 *
 * The followings are the available model relations:
 * @property Manager $manager
 */
class User extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
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
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, password, email, created, manager_id', 'required'),
			array('name, password, email, avatar, address', 'length', 'max'=>100),
			array('phone', 'length', 'max'=>20),
			array('status', 'length', 'max'=>7),
			array('manager_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, password, email, phone, avatar, address, created, status, manager_id', 'safe', 'on'=>'search'),
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
//			'manager' => array(self::BELONGS_TO, 'Manager', 'manager_id'),
            'userEmails' => array(self::HAS_MANY, 'UserEmail', 'user_id', 'order' => 'userEmails.id ASC'),
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
			'password' => 'Password',
			'email' => 'Email',
			'phone' => 'Phone',
			'avatar' => 'Avatar',
			'address' => 'Address',
			'created' => 'Created',
			'status' => 'Status',
			'manager_id' => 'Manager',
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
		$criteria->compare('password',$this->password,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('avatar',$this->avatar,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('manager_id',$this->manager_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function getHashPassword($password){
        Yii::import('ext.PasswordHash');
        $hasher = new PasswordHash(8, TRUE);
        $hash = $hasher->HashPassword($password);
        return $hash;
    }

    public function checkPassword($password, $hashPassword){
        Yii::import('ext.PasswordHash');
        $hasher = new PasswordHash(8, TRUE);
        $check = $hasher->CheckPassword($password, $hashPassword);
        return $check;
    }

    public function getAlias($name = ''){
        Yii::import('ext.TextParser');
        $name = $name ? $name : $this->name;
        return TextParser::toSEOString($name);
    }

    public function loginAuto($id = null, $name = null){
        $id = $id ? $id : $this->id;
        $name = $name ? $name : $this->name;

        $userIdentity = new CUserIdentity($id, '');
        $userIdentity->setState('id', $id);
        $userIdentity->setState('name', $name);

        Yii::app()->user->login($userIdentity, Yii::app()->params->user['remember']);
    }
}