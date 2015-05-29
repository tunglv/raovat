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

        $catagory = Catagory::model()->findAll('status = :status', array(':status'=>'ENABLE'));

        $array_product = array();

        //list 4 meohay 
        $criteria = new CDbCriteria();

        $criteria->compare('t.status', 'ENABLE');
        $criteria->order = 't.created DESC';
        $criteria->limit = 5;
        
        $product = Product::model()->findAll($criteria);
        
        foreach ($product as $_product) {
            $array_product['product'][] = $_product;
        }

        foreach($catagory as $key => $_catagory){
            //list 4 meohay Makeup
            $criteria = new CDbCriteria();
//            $criteria_makeup -> select='t.id';

            $criteria->compare('t.catagory', $_catagory['id']);
            $criteria->compare('t.status', 'ENABLE');
            $criteria->order = 't.created DESC';
            $criteria->limit = 4;

            $__product = Product::model()->findAll($criteria);

            $array_product[$_catagory['alias']][] = $__product;
//            foreach ($meohay_makeup as $makeup) {
//                if(empty($array_limit['makeup_id']) || !in_array($makeup->id, $array_limit['makeup_id'])) $array_meohay['makeup'][] = $makeup->getMeohay();
//                else continue;
//            }

//            $array_product[$_catagory['alias']] = array();
        }

        $product_viewed = $this->_getCookieViewedProduct();

        $this->render('index', array('array_product'=>$array_product, 'viewed_product' => $product_viewed, 'catagory'=>$catagory));
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
