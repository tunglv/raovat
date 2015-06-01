<?php

    /**
    * This is the model class for table "user_email".
    *
    * The followings are the available columns in table 'user_email':
    * @property string $id
    * @property string $user_id
    * @property string $email
    * @property string $openid_id
    * @property string $openid_service
    * @property integer $is_main
    * @property string $created
    *
    * The followings are the available model relations:
    * @property User $user
    */
    class UserEmail extends CActiveRecord
    {
        /**
        * Returns the static model of the specified AR class.
        * @param string $className active record class name.
        * @return UserEmail the static model class
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
            return 'user_email';
        }

        /**
        * @return array validation rules for model attributes.
        */
        public function rules()
        {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                array('email', 'required'),
                array('email', 'email'),

                array('email', 'unique', 'className' => 'UserEmail', 'attributeName' => 'email', 'message' => '{attribute} đã được sử dụng'),


                array('is_main', 'numerical', 'integerOnly'=>true),
                array('user_id', 'length', 'max'=>10),
                array('email, openid_id', 'length', 'max'=>255),
                array('openid_service', 'length', 'max'=>8),
                // The following rule is used by search().
                // Please remove those attributes that should not be searched.
                array('id, user_id, email, openid_id, openid_service, is_main, created', 'safe', 'on'=>'search'),
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
                'user' => array(self::BELONGS_TO, 'User', 'user_id'),
            );
        }

        /**
        * @return array customized attribute labels (name=>label)
        */
        public function attributeLabels()
        {
            return array(
                'id' => 'ID',
                'user_id' => 'User',
                'email' => 'Email',
                'openid_id' => 'Openid',
                'openid_service' => 'Openid Service',
                'is_main' => 'Is Main',
                'created' => 'Created',
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
            $criteria->compare('user_id',$this->user_id,true);
            $criteria->compare('email',$this->email,true);
            $criteria->compare('openid_id',$this->openid_id,true);
            $criteria->compare('openid_service',$this->openid_service,true);
            $criteria->compare('is_main',$this->is_main);
            $criteria->compare('created',$this->created,true);

            return new CActiveDataProvider($this, array(
                'criteria'=>$criteria,
            ));
        }
        public function beforeSave(){
            if($this->isNewRecord){
                $this->created = MyDateTime::getCurrentTime();
            }
            return parent::beforeSave();
        }

        public function getOpenIdServiceData(){
            return array(
                'FACEBOOK' => 'Facebook',
                'YAHOO' => 'Yahoo',
                'GOOGLE' => 'Google',
            );
        }

        public function getOpenIdServiceLabel($openidService = NULL){
            $openidService = $openidService ? $openidService : $this->openid_service;
            return $openidService ? $this->openIdServiceData[$openidService] : NULL;
        }

}