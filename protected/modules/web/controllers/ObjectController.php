<?php

class ObjectController extends WebController {

    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('error', 'index', 'captcha', 'list', 'detail', 'create', 'update', 'search'),
                'users' => array('*'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionError() {
        $this->layout = '//layouts/main';

        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else {

                $view = 'error';
                if (in_array($error['code'], array(404))) {
                    $view .= $error['code'];
                }
                $this->render($view, $error);
            }
        }
    }

    public function actionSearch(){
        $this->layout = '//layouts/main';

        $keyword = Yii::app()->request->getPost('keyword');
        $type = Yii::app()->request->getPost('type');
        $city = Yii::app()->request->getPost('city');
        $type_id = 0;

        if($type) $type_id = Object::model()->getAliasLabel($type);
        Yii::import('ext.TextParser');
        $alias = TextParser::toSEOString($keyword);

        $criteria = new CDbCriteria;
        $criteria->condition = 't.status = "enable"';

        if($keyword) $criteria->addCondition ("MATCH (t.alias) AGAINST ('$alias' IN BOOLEAN MODE)");
        if($type) $criteria->addCondition ('t.type = '.$type_id);
        if($city) $criteria->addCondition ('t.province_id = "'.$city.'"');

        $total = Object::model()->count($criteria);

        $pages = new CPagination($total);
        $pages->pageSize = 9;
        $pages->applyLimit($criteria);

        $posts = Object::model()->findAll($criteria);

        $hot_topic = $this->_getHotTopic($city);

        $this->render('list', array(
            'type'=>$type_id ? Object::model()->getTypeLabel($type_id) : 'Kết quả tìm kiếm: '.$keyword,
            'posts' => $posts,
            'pages' => $pages,
            'hot_topic' => $hot_topic
        ));
    }
    /**
     * @author tunglv Doe <tunglv.1990@gmail.com>
     *
     * @param $id, $alias of type meohay
     * @return page list meohay
     */
    public function actionList($alias = null) {
        if(!$alias) throw new CHttpException(404, 'The requested page does not exist.');
        $this->layout = '//layouts/main';

        $type = Object::model()->getAliasLabel($alias);

        if(!$type) throw new CHttpException(404, 'The requested page does not exist.');

        $criteria = new CDbCriteria();
        $criteria->compare('t.type', $type);
        $criteria->compare('t.status', 'enable');
        $criteria->order = 't.id DESC';

        $total = Object::model()->count($criteria);

        $pages = new CPagination($total);
        $pages->pageSize = 9;
        $pages->applyLimit($criteria);

        $posts = Object::model()->findAll($criteria);

        $hot_topic = $this->_getHotTopic();

        $this->render('list', array(
            'type'=>Object::model()->getTypeLabel($type),
            'posts' => $posts,
            'pages' => $pages,
            'hot_topic' => $hot_topic
        ));
    }

    /**
     * @author tunglv Doe <tunglv.1990@gmail.com>
     *
     * @param $id, $alias of meohay detail
     * @return page detail meohay
     */
    public function actionDetail($alias = null, $id = null) {
        $this->layout = '//layouts/main';

        if(!$id) throw new CHttpException(404, 'The requested page does not exist.');

        $object = Object::model()->findByPk($id);
        $same_object = $this->_getSameProduct($object->type, $object->id, $object->province_id);

        $hot_topic = $this->_getHotTopic($object->province_id, $object->type);

        $this->render('detail',array('object'=>$object, 'same_object' => $same_object, 'hot_topic'=>$hot_topic));
    }

    /**
     * get same topic
     */
    public function _getHotTopic($city_id = null, $type = null){
        $criteria = new CDbCriteria();
        $criteria->compare('t.status', 'enable');
        if($city_id) $criteria->compare('t.province_id', $city_id);
        if($type) $criteria->compare('t.type', $type);
        $criteria->order = 't.viewed DESC';
        $criteria->limit = 10;

        $object = Object::model()->findAll($criteria);

        return $object;
    }

    /**
     * @author tunglv Doe <tunglv.1990@gmail.com>
     *
     * @param $type of meohay
     * @return same meohay
     */
    public function _getSameProduct($type = null, $id = null, $city_id = null) {
        $criteria = new CDbCriteria();
//        $criteria -> select='t.id';

        $criteria->compare('t.type', $type);
        $criteria->compare('t.status', 'enable');
        $criteria->compare('t.province_id', $city_id);
        $criteria->order = 't.created DESC';
        $criteria->limit = 5;

        $object = Object::model()->findAll($criteria);

        $result = array();

        foreach ($object as $value) {
            if($value->id != $id) $result[] = $value;
            else continue;
        }

        return $result;
    }

    /**
     * @author tunglv Doe <tunglv.1990@gmail.com>
     *
     * @param
     * @return array branches has viewd for 1 day ago
     */
    private function _getCookieViewedProduct() {
        if(empty(Yii::app()->request->cookies['view_product'])) return false;

        $viewed_product = Yii::app()->request->cookies['view_product']->value;

        $product_ids = explode(',', $viewed_product);

        foreach($product_ids as $index => $product_id){
            $product_id = intval($product_id);
            if(!$product_id || !is_int($product_id)) unset($product_ids[$index]);
        }

        $product= array();
        foreach($product_ids as $product_id){
            $product[] = Product::model()->getProductById($product_id);
        }
        return $product;
    }
}
