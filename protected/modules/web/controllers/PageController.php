<?php

class PageController extends WebController {

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
                'actions' => array('error', 'index', 'captcha'),
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

    /**
     * @author tunglv Doe <tunglv.1990@gmail.com>
     * 
     * @param 
     * @return page home of site 
     */
    public function actionIndex() {
        $this->layout = '//layouts/main';

//        $product_viewed = $this->_getCookieViewedProduct();
        $object_1 = $this->_getObjectByType("1");
        $object_2 = $this->_getObjectByType("2");
        $object_3 = $this->_getObjectByType("3");
        $object_4 = $this->_getObjectByType("4");
        $object_5 = $this->_getObjectByType("5");
        $object_6 = $this->_getObjectByType("6");
        $object_7 = $this->_getObjectByType("7");
        $object_8 = $this->_getObjectByType("8");
        $object_9 = $this->_getObjectByType("9");
        $object_10 = $this->_getObjectByType("10");
        $object_11 = $this->_getObjectByType("11");
        $object_12 = $this->_getObjectByType("12");
        $object_13 = $this->_getObjectByType("13");

        $result = array(
            '1'=>$object_1,
            '2'=>$object_2,
            '3'=>$object_3,
            '4'=>$object_4,
            '5'=>$object_5,
            '6'=>$object_6,
            '7'=>$object_7,
            '8'=>$object_8,
            '9'=>$object_9,
            '10'=>$object_10,
            '11'=>$object_11,
            '12'=>$object_12,
            '13'=>$object_13
        );

        $this->render('index', array(
            'result'=>$result,
        ));
    }


    private function _getObjectByType($type = null){
        $criteria = new CDbCriteria();

        $criteria->compare('t.type', $type);
        $criteria->compare('t.status', 'enable');
        $criteria->order = 't.created DESC';
        $criteria->limit = 3;

        $object = Object::model()->findAll($criteria);

        return $object;
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
