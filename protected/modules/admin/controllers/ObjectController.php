<?php

class ObjectController extends AdminController {

    public function init() {
        parent::init();
        $this->layout = '//admin/object/_layout';
        $this->menu_parent_selected = 'object';
    }

    /**
     * @return array action filters
     */
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
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'index', 'update', 'delete'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Index of page handbook
     * list of handbook
     */
    public function actionIndex() {
        $this->menu_child_selected = 'object';
        $this->menu_sub_selected = 'index';

        $model = new Object();
        $model->unsetAttributes();  // clear any default values

        $criteria = new CDbCriteria;
//            $criteria->order = 't.id ASC';
//        $criteria->with = array(
//            'manager' => array(
//                'select' => 'name'
//            ),
//        );

        if ($objectFilter = Yii::app()->request->getQuery('Object')) {
            $model->attributes = $objectFilter;
            if (isset($objectFilter['name']) && $objectFilter['name'])
                $criteria->compare('t.name', $objectFilter['name']);
            if (isset($objectFilter['id']) && $objectFilter['id'])
                $criteria->compare('t.id', $objectFilter['id']);
            if (isset($objectFilter['status']) && $objectFilter['status'])
                $criteria->compare('t.status', $objectFilter['status']);
            if (isset($objectFilter['manager_id']) && $objectFilter['manager_id'])
                $criteria->compare('t.manager_id', $objectFilter['manager_id']);
            if (isset($objectFilter['catagory']) && $objectFilter['catagory'])
                $criteria->compare('t.catagory', $objectFilter['catagory']);
        }


        $dataProvider = new CActiveDataProvider('Object', array(
                    'criteria' => $criteria,
                    'sort' => array(// CSort
                        'defaultOrder' => 't.id DESC',
                    ),
                    'pagination' => array(
                        'pageSize' => 30,
                        //                    'totalItemCount' => 'page',
                        'pageVar' => 'page',
                    ),
                ));
        $this->render('index', array('model' => $model, 'dataProvider' => $dataProvider));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $this->menu_child_selected = 'object_create';
        $this->menu_sub_selected = 'create';

        $model = new Object();

        $imgConf = Yii::app()->params->object;

        if (isset($_POST['Object'])) {
            $post = Yii::app()->request->getPost('Object');
            $model->attributes = $post;
//            $model->manager_id = $this->manager->id;
            $model->image = 'default';
            $model->created = time();
            Yii::import('ext.TextParser');
            $model->alias = $model->alias ? $model->alias : $model->name;
            $model->alias = TextParser::toSEOString($model->alias);
            $model->code = Object::model()->getNewSyntax();
//            var_dump($model->validate());
//            var_dump($model->getErrors());die;

            if ($model->validate()) {
                $model->setIsNewRecord(TRUE);
                $model->insert();

                /////// IMAGES ////////
                $path = $imgConf['path'] . "{$model->id}/";
                if (!file_exists($path))
                    mkdir($path, 0777, true);

                $source = NULL;
                if ($post['upload_method'] == 'file') {
                    $source = 'browse_file';
                } else {
                    $source = $post['image_url'];
                }

                Yii::import('ext.wideimage.lib.WideImage');
                $img = WideImage::load($source);

                foreach ($imgConf['img'] as $key => $imgInfo) {
                    $img = $img->resize($imgInfo['width'], $imgInfo['height'],  $imgInfo['fix'], 'down');
                    $img = $img->resizeCanvas($imgInfo['width'], $imgInfo['height'], 'center', 'center', null, 'down');
                    $img->saveToFile($path . $key . '.jpg', $imgInfo['quality']);
                }

                $model->image = '420';

                if (trim($model->content)) {
                    // add baseUrl to temp images
                    Yii::import('ext.simple_html_dom');
                    $html = new simple_html_dom($model->content);
                    foreach ($html->find('img') as $i => $img) {

                        if (preg_match('{^/upload/temp/object/' . Yii::app()->getSession()->sessionID . '/.+$}', $img->src)) {
                            $imgName = substr($img->src, strlen("/upload/temp/object/" . Yii::app()->getSession()->sessionID . "/"));
                            $image = WideImage::load($this->baseUrl . $img->src);
                            $image->saveToFile($path . $imgName);
                            $img->src = $this->baseUrl . "/" . $path . $imgName;
                        }
                    }
                    $content = $html->save();
                    // upload content images
                    Yii::import('ext.Myext');
                    $model->content = Myext::saveContentImages($content, $path, array(
                        'image_x' => $imgConf['img']['body']['width'],
                        'image_y' => $imgConf['img']['body']['height'],
                    ));
                }

                $model->update();

                Yii::app()->user->setFlash('success', "Post {$model->title} was added successful!");
                $this->refresh();
            }
        }

        $this->render('_form', array(
            'model' => $model
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $this->menu_child_selected = 'object_update';
        $this->menu_sub_selected = 'update';

        $model = Object::model()->findByPk($id);

        $imgConf = Yii::app()->params->object;

        if (isset($_POST['Object'])) {
            $post = Yii::app()->request->getPost('Object');
            $model->attributes = $post;
            $model->created = $model->created ? $model->created : time();

            if ($model->validate()) {
                Yii::import('ext.TextParser');
                $model->alias = $model->alias ? $model->alias : $model->name;
                $model->alias = TextParser::toSEOString($model->alias);
                $model->setIsNewRecord(FALSE);

                /////// IMAGES ////////
                $path = $imgConf['path'] . "{$model->id}/";
                if (!file_exists($path))
                    mkdir($path, 0777, true);

                if (
                        ($post['upload_method'] == 'file' && $_FILES['browse_file']['size']) ||
                        ($post['upload_method'] == 'url' && $post['image_url'])
                ) {
                    $source = NULL;
                    if ($post['upload_method'] == 'file') {
                        $source = 'browse_file';
                    } else {
                        $source = $post['image_url'];
                    }

                    Yii::import('ext.wideimage.lib.WideImage');
                    $img = WideImage::load($source);

                    foreach ($imgConf['img'] as $key => $imgInfo) {
                        $img = $img->resize($imgInfo['width'], $imgInfo['height'],  $imgInfo['fix'], 'down');
                        $img = $img->resizeCanvas($imgInfo['width'], $imgInfo['height'], 'center', 'center', null, 'down');
                        $img->saveToFile($path . $key . '.jpg', $imgInfo['quality']);
                    }

                    $model->image = '420';

                    if (trim($model->content)) {
                        // add baseUrl to temp images
                        Yii::import('ext.simple_html_dom');
                        $html = new simple_html_dom($model->content);
                        foreach ($html->find('img') as $i => $img) {

                            if (preg_match('{^/upload/temp/object/' . Yii::app()->getSession()->sessionID . '/.+$}', $img->src)) {
                                $imgName = substr($img->src, strlen("/upload/temp/object/" . Yii::app()->getSession()->sessionID . "/"));
                                $image = WideImage::load($this->baseUrl . $img->src);
                                $image->saveToFile($path . $imgName);
                                $img->src = $this->baseUrl . "/" . $path . $imgName;
                            }
                        }
                        $content = $html->save();
                        // upload content images
                        Yii::import('ext.Myext');
                        $model->content = Myext::saveContentImages($content, $path, array(
                            'image_x' => $imgConf['img']['body']['width'],
                            'image_y' => $imgConf['img']['body']['height'],
                        ));
                    }
                }

                $model->update();

                Yii::app()->user->setFlash('success', "Post {$model->title} was updated successful!");

                $this->refresh();
            }
        }

        $this->render('_form', array(
            'model' => $model
        ));
    }

    public function actionDelete($id) {
        $object = Object::model()->findByPk($id);
        $object->status = 'disable';
        $object->update();

        //TODO delete file in disk

        echo "Xóa sanr phẩm {$object->title} thành công";

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = Object::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }
}