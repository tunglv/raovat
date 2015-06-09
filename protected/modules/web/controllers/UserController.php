<?php

    class UserController extends WebController
    {
        /**
        * @return array action filters
        */
        public function filters()
        {
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
        public function accessRules()
        {
            return array(
                array('allow',  // allow all users to perform 'index' and 'view' actions
                    'actions'=>array('page', 'index','login', 'forgot','captcha', 'create', 'verifyPhoneCreate', 'verifyPhoneForgot','pageinfo', 'pagefavorite', 'pagecoupon'),
                    'users'=>array('*'),
                ),
                array('allow', // allow authenticated user to perform 'create' and 'update' actions
                    'actions'=>array('logout','update', 'updateObject', 'manageEmail', 'managePhone', 'password', 'verifyPhoneAdd', 'ajaxUpdateEmailList', 'ajaxUpdatePhoneList'),
                    'users'=>array('*'),
                ),
                array('deny',  // deny all users
                    'users'=>array('*'),
                ),
            );
        }

        public function init(){
            parent::init();
        }

        public function actionIndex($user_name = null, $id = null)
        {
            if(!$this->user) $this->redirect('/web/user/login');
            $model = new Object();

            $imgConf = Yii::app()->params->object;

            if (isset($_POST['Object'])) {
                $post = Yii::app()->request->getPost('Object');
                $model->attributes = $post;
//            $model->manager_id = $this->manager->id;
                $model->image = 'default';
                $model->created = time();
                Yii::import('ext.TextParser');
                $model->alias = TextParser::toSEOString($model->title);
                $model->code = Object::model()->getNewSyntax();
                $model->date_start = time();
                $model->date_end = time() + 86400*$model->date_total;
                $model->user_id = $this->user->id;
                $model->user_name = $this->user->name;
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

                    Yii::app()->user->setFlash('success', "Tin {$model->title} của bạn đã được đăng tải!");
                    $this->refresh();
                }
            }

            $object = $this->_getObjet($this->user->id);

            $this->render('index', array('model'=>$model, 'object' => $object));
        }

        public function actionUpdateObject($object_id = null, $object_alias = ''){
            if(!$this->user) $this->redirect('/web/user/login');
            if(!$object_id) throw new CHttpException(404, 'The requested page does not exist.');
            $model = Object::model()->findByPk($object_id);

            $imgConf = Yii::app()->params->object;

            if (isset($_POST['Object'])) {
                $post = Yii::app()->request->getPost('Object');
                $model->attributes = $post;
                $model->created = time();
                Yii::import('ext.TextParser');
                $model->alias = TextParser::toSEOString($model->title);
//            var_dump($model->validate());
//            var_dump($model->getErrors());die;

                if ($model->validate()) {
                    $model->setIsNewRecord(TRUE);

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
                            $img = $img->resize($imgInfo['width'], $imgInfo['height'], $imgInfo['fix'], 'down');
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

                    Yii::app()->user->setFlash('success', "Tin {$model->title} của bạn đã được cập nhập!");
                    $this->refresh();
                }
            }

            $object = $this->_getObjet($this->user->id);

            $this->render('index', array('model'=>$model, 'object' => $object));
        }

        public function actionLogout()
        {
            Yii::app()->user->logout();
            $this->redirect(Yii::app()->request->urlReferrer);
        }
        public function actionUpdate()
        {
            $model = $this->user;
            // echo '<pre>' ;print_r($model->scenario) ;echo '</pre>';die;
            $model->scenario = 'update';

            if(isset($_POST['ajax']) && $_POST['ajax']==='user-form'){
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }

            if(isset($_POST['User'])){
                $post = $_POST['User'];

                $model->attributes = $post;
                if($model->validate())
                {
                    //                    echo '<pre>';print_r($_POST);echo '</pre>';
                    //                    echo '<pre>';print_r($_FILES);echo '</pre>';
                    //                    echo '<pre>';print_r($model->attributes);echo '</pre>';
                    //                    die;

                    // save image
                    $source = $post['upload_method'] == 'file' ? $_FILES["browse_file"]["tmp_name"] : $post['image_url'];

                    if($source){
                        Yii::import('ext.wideimage.lib.WideImage');
                        $imgObj = WideImage::load($source);

                        Myext::createDir($model->avatarPath);
                        foreach(Yii::app()->params->user_img['img'] as $key => $imgInfo){
                            $imgObj = $imgObj->resize($imgInfo['width'], $imgInfo['height'], 'outside', 'down');
                            $imgObj = $imgObj->resizeCanvas($imgInfo['width'], $imgInfo['height'],'center','center', null, 'down');
                            $imgObj->saveToFile($model->avatarPath.'avatar_'.$key.'.jpg', $imgInfo['quality']);  
                        }
                        $model->image = 'avatar';
                    } 

                    // update user   
                    $model->dob = $model->dob ? date('Y-m-d', strtotime($model->dob)) : NULL;
                    $model->update();

                    Yii::app()->user->setFlash('success', 'Tài khoản được cập nhật thành công!');
                    $this->refresh();
                }
            }

            $model->dob = $model->dob ? date('d-m-Y', strtotime($model->dob)) : NULL;
            $city_id = $model->city_id ? $model->city_id : 1;

            $this->render('update', array(
                'model' => $model,
//                'district_data' => District::model()->getDataByCity($city_id),
            ));  
        }


        public function actionLogin($service = NULL)
        {
            //            echo '<pre>returnUrl: ';print_r(Yii::app()->user->returnUrl);echo '</pre>';
            //            echo '<pre>urlReferrer: ';print_r(Yii::app()->request->urlReferrer);echo '</pre>';

            $redirectUrl = Yii::app()->user->returnUrl;

            if($redirectUrl == '/' 
                || $redirectUrl == ''
                || strpos($redirectUrl, 'logout') !== false
            )   $redirectUrl = Yii::app()->request->urlReferrer;

            //            echo '<pre>redirectUrl1: ';print_r($redirectUrl);echo '</pre>';

            if($redirectUrl == ''
                || strpos($redirectUrl, 'login') !== false
                || strpos($redirectUrl, 'forgot') !== false
                || strpos($redirectUrl, 'create') !== false
            )   $redirectUrl = $this->createUrl('/web/user/update');

            //                    echo '<pre>';print_r($redirectUrl);echo '</pre>';
            //            echo '<pre>redirectUrl2: ';print_r($redirectUrl);echo '</pre>';
            //            die;

            // if user is logined
            if($this->user) {
                $this->redirect(array('/web/user/update')); 
            }

            if($service == 'google') $this->_connectGoogle();
            if($service == 'facebook') $this->_connectFacebook();
            if($service == 'yahoo') $this->_connectYahoo();


            Yii::import('web.models.form.LoginForm');
            Yii::import('ext.PasswordHash');


            $model = new LoginForm;

            if(isset($_POST['ajax']) && $_POST['ajax']==='login-form'){
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }

            if(isset($_POST['LoginForm'])){
                $post = $_POST['LoginForm'];

                $model->attributes = $post;
                if($model->validate() && $model->login())
                {
                    $this->redirect(Yii::app()->user->returnUrl);
                }
            }

            $this->render('login', compact('model'));     

        }     

        /**
        * Tạo hoặc thay đổi password
        * 
        */
        public function actionPassword(){
            Yii::import('web.models.form.PasswordForm');
            Yii::import('ext.PasswordHash');

            //            echo '<pre>';print_r($this->user->getHashPassword('123456'));echo '</pre>';;
            //            echo '<pre>';print_r($this->user->getHashPassword('123456'));echo '</pre>';;

            //            die;

            $model = new PasswordForm;
            $model->scenario = $this->user->password ? 'changePassword' : 'updatePassword';
            $passwordActionName =  $this->user->password ? 'Đổi mật khẩu' : 'Tạo mật khẩu';

            if(isset($_POST['ajax']) && $_POST['ajax']==='password-form'){
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }

            if(isset($_POST['PasswordForm'])){
                $post = $_POST['PasswordForm'];

                $model->attributes = $post;
                if($model->validate())
                {
                    $user = $this->user;
                    $user->password = $user->getHashPassword($model->newPassword);
                    $user->update();
                    Yii::app()->user->setFlash('success', "{$passwordActionName} thành công");
                    $this->refresh();
                }
            }

            $this->render('password', compact('model', 'passwordActionName'));      
        }


        public function actionCreate($token = NULL)
        {
            if($this->user) $this->redirect(array('/web/user/update')); 

            // check token email
            if($token){
                list($name, $email, $password, $time) = json_decode(Yii::app()->crypt->decode($token));

                if(!$email){
                    Yii::app()->user->setFlash('error', "Url xác nhận email không hợp lệ.");
                    $this->redirect(array('/web/user/create'));
                }

                if(strtotime(MyDateTime::getCurrentTime()) > strtotime($time) + Yii::app()->params->user['phoneEmailExpire']){
                    Yii::app()->user->setFlash('error', "Url xác nhận đã hết hạn hoặc không hợp lệ. Bạn hãy đăng ký lại.");
                    $this->redirect(array('/web/user/create'));
                }

                if(UserEmail::model()->exists("email = '{$email}'")){
                    Yii::app()->user->setFlash('error', "{$email} đã được sử dụng.");
                    $this->redirect(array('/web/user/create'));
                }

                // create user
                $user = new User;
                $user->name = $name;
                $user->password = $user->getHashPassword($password);
                $user->insert();

                $userEmail = new UserEmail;
                $userEmail->user_id = $user->id;
                $userEmail->email = $email;
                $userEmail->is_main = 1;
                $userEmail->insert();

                // login
                $userIdentity = new CUserIdentity($user->id, '');
                $userIdentity->setState('id', $user->id);
                $userIdentity->setState('name', $userEmail->email);
                Yii::app()->user->login($userIdentity, Yii::app()->params->user['remember']);

                Yii::app()->user->setFlash('success', "Đăng ký tài khoản thành công. Hãy hoàn thiện thông tin tài khoản của bạn.");
                $this->redirect(array('/web/user/update'));
            }





            Yii::import('web.models.form.CreateUserForm');
            Yii::import('ext.PasswordHash');

            $model = new CreateUserForm;

            if(isset($_POST['ajax']) && $_POST['ajax']=='create-user-form'){
                echo CActiveForm::validate($model);
                Yii::app()->end();
            }


            if(isset($_POST['CreateUserForm'])) {
                $post = Yii::app()->request->getPost('CreateUserForm');
                $model->attributes = $post;
                if($model->validate()) {

                    if($model->isEmail){
                        $email = $post['username'];
                        // generate password reset_url
                        $token = Yii::app()->crypt->encode(json_encode(array($post['name'], $email, $post['password'], MyDateTime::getCurrentTime())));
                        $user_create_url = $this->createAbsoluteUrl('/web/user/create', array(
                            'token' => $token
                        ));

                        // send password to email
                        $mail_receiver  = Yii::app()->params['mail_receiver'];
                        $from_email = $mail_receiver['email'];
                        $from_name = $mail_receiver['name'];
                        $subject    = 'Reset mật khẩu';

                        $content    = "Chúng tôi vừa nhập được một yêu cầu đăng ký tài khoản với email {$email}.

                        Để xác nhận đăng ký bạn hãy click vào link bên dưới hoặc copy và paste vào trình duyệt:
                        {$user_create_url}

                        Link xác nhận này có thời hạn trong 24 giờ. Nếu bạn không muốn đăng ký, hãy bỏ qua email này.";

                        //echo "<pre>";print_r($content);echo "<pre>";die;
                        $this->_send_mail($from_email, $from_name, $email, $subject, $content);


                        Yii::app()->user->setFlash('success', "Chúng tôi đã gửi email xác nhận việc đăng ký tới email: {$email}. Check mail trong Inbox hoặc Spam.<br>Nếu bạn không nhận được email trong vài phút, hãy submit lại form..");

                        $this->refresh();
                    }

                    // if username is phone number
                    $phone = $post['username'];
                    $upc = UserPhoneCode::model()->findByAttributes(array('phone' => $phone));
                    if($upc) $upc->delete();

                    // save code for phone
                    $upc = new UserPhoneCode;
                    $upc->code = $upc->newCode;
                    $upc->phone = $phone;
                    $upc->name = $post['name'];
                    $upc->password = User::model()->getHashPassword($post['password']);
                    $upc->insert();


                    // send sms
                    UserPhoneCode::model()->sendMsgCodePhoneCreate($upc->phone, $upc->code);

                    Yii::app()->user->setFlash('success', "Chúng tôi vừa gửi mã xác nhận việc đăng ký tới số điện thoại: {$phone}. Hãy điền mã xác nhận vào ô bên dưới để hoàn tất.");
                    $this->redirect(array('/web/user/verifyPhoneCreate'));

                }
            }

            $this->render('create', array(
                'model' => $model
            ));
        }


        public function actionForgot($token = NULL)
        {
            if($this->user) $this->redirect(array('/web/user/update'));


            // check token reset
            if($token){
                list($user_id, $time) = json_decode(Yii::app()->crypt->decode($token));

                $user = User::model()->with('email_main')->findByPk($user_id);

                if(!$user_id){
                    Yii::app()->user->setFlash('error', "Url xác nhận không hợp lệ.");
                    $this->redirect(array('/web/user/forgot'));
                }


                if(strtotime(MyDateTime::getCurrentTime()) > strtotime($time) + Yii::app()->params->user['phoneEmailExpire']){
                    Yii::app()->user->setFlash('error', "Link reset đã hết hạn hoặc không hợp lệ. Bạn hãy điền lại form để lấy lại link reset mới.");
                    $this->redirect(array('/web/user/forgot'));
                }  

                // update latest reset_time, set password to NULL
                $user->password = NULL;
                $user->reset_time = MyDateTime::getCurrentTime();
                $user->setIsNewRecord(FALSE);
                $user->update();

                // login and redirect to reset page
                $userIdentity = new CUserIdentity($user->id, '');
                $userIdentity->setState('id', $user->id);
                $userIdentity->setState('name', $user->email_main->email);
                Yii::app()->user->login($userIdentity, Yii::app()->params->user['remember']);

                Yii::app()->user->setFlash('success', "Tạo mật khẩu mới cho tài khoản của bạn.");
                $this->redirect(array('/web/user/password'));
            }

            Yii::import('web.models.form.ForgotForm');

            $model = new ForgotForm();

            // if it is ajax validation request
            //        if(isset($_POST['ajax']) && $_POST['ajax']==='forgot-form')
            //        {
            //            echo CActiveForm::validate($model);
            //            Yii::app()->end();
            //        }

            if(isset($_POST['ForgotForm']))
            {
                $post = $_POST['ForgotForm'];
                $model->attributes = $post;

                if($model->validate())
                {
                    $user = $model->user;
                    if($model->isEmail){
                        $email = $post['username'];

                        // generate password reset_url
                        $token = Yii::app()->crypt->encode(json_encode(array($user->id, MyDateTime::getCurrentTime())));
                        $password_reset_url = $this->createAbsoluteUrl('/web/user/forgot', array(
                            'token' => $token
                        ));

                        // send password to email
                        $mail_receiver  = Yii::app()->params['mail_receiver'];
                        $from_email = $mail_receiver['email'];
                        $from_name = $mail_receiver['name'];
                        $subject    = 'Reset mật khẩu';

                        $content    = "Chúng tôi vừa nhập được một yêu cầu reset mật khẩu của bạn.

                        Để reset mật khẩu, bạn hãy click vào link bên dưới hoặc copy và paste vào trình duyệt:
                        {$password_reset_url}

                        Link reset này có thời hạn trong 60 phút. Nếu bạn không muốn reset mật khẩu, hãy bỏ qua email này và mật khẩu của bạn vẫn sẽ được giữ nguyên.";

                        //echo "<pre>";print_r($content);echo "<pre>";die;
                        $this->_send_mail($from_email, $from_name, $email, $subject, $content);


                        Yii::app()->user->setFlash('success', "Chúng tôi đã gửi link reset mật khẩu tới email của bạn: {$email}. Check mail trong Inbox hoặc Spam.<br>Nếu bạn không nhận được email trong vài phút, hãy submit lại form..");

                        $this->refresh();
                    }

                    // if username is phone number
                    $phone = $post['username'];
                    $upc = UserPhoneCode::model()->findByAttributes(array('phone' => $phone));
                    if($upc) $upc->delete();

                    // save code for phone
                    $upc = new UserPhoneCode;
                    $upc->code = $upc->newCode;
                    $upc->phone = $phone;
                    $upc->user_id = $user->id;
                    $upc->insert();


                    // send sms
                    UserPhoneCode::model()->sendMsgCodePhoneAdd($upc->phone, $upc->code);

                    Yii::app()->user->setFlash('success', "Chúng tôi vừa gửi mã xác nhận việc yêu cầu reset mật khẩu tới số điện thoại: {$upc->phone}. Hãy điền mã xác nhận vào ô bên dưới để hoàn tất.");
                    $this->redirect(array('/web/user/verifyPhoneForgot'));

                }

            }


            $this->pageTitle = 'Quên mật khẩu';

            $this->render('forgot', array('model' => $model));
        }

        private function _send_mail($from_email, $from_name, $to_email, $subject, $content){
            // send password to email
            $mail_server    = Yii::app()->params['mail_server'];

            $mail = Yii::createComponent('application.extensions.mailer.EMailer');
            $mail->CharSet    = 'UTF-8';

            $mail->IsSMTP(); // telling the class to use SMTP
            $mail->SMTPDebug  = 1;                     // enables SMTP debug information (for testing)
            // 1 = errors and messages
            // 2 = messages only
            $mail->SMTPAuth   = true;                  // enable SMTP authentication
            //$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
            //$mail->SMTPSecure = "tls";                 // sets the prefix to the servier
            $mail->Host       = $mail_server['host'];      // sets GMAIL as the SMTP server
            $mail->Port       = $mail_server['port'];                   // set the SMTP port for the GMAIL server
            $mail->Username   = $mail_server['username'];  // GMAIL username
            $mail->Password   = $mail_server['password'];            // GMAIL password


            $mail->SetFrom($from_email, $from_email.' - '.$from_name);
            $mail->AddReplyTo($from_email, $from_email.' - '.$from_name);

            $mail->AddAddress($to_email, $to_email);
            $mail->Subject    = $subject;
            $mail->Body    = $content;
            $mail->send();

            //            echo '<pre>';print_r($mail);echo '</pre>';die;
        }

        private function _connectFacebook(){
         //   Yii::app()->session['urlReferrer'] = Yii::app()->request->urlReferrer;

//            $actionRouter = '/web/user/'.($this->user ? 'manageEmail' : 'login');
//            $redirectUri = $this->createAbsoluteUrl($actionRouter, array('service' => 'facebook'));


//            if(Yii::app()->request->getQuery('error') == 'user_denied') {
//                Yii::app()->user->setFlash('error', 'Bạn đã hủy đăng nhập bằng tài khoản Facebook');
//                $this->_openidRedirect($this->createUrl('/web/user/login'));
//            } 

            Yii::import('ext.facebook.src.Facebook');

            $facebook = new Facebook(array(
              'appId'  => '175649432610986',
              'secret' => 'f739e06303679f1125da0d17312dd80b',
            ));

//            // 3.save access token
//            if (isset($_GET['code'])) {
//                $_SESSION['facebook_token'] = $facebook->getAccessToken();
//            }
//             
            // 2.set access token if it exists 
//            if (isset($_SESSION['facebook_token'])) {
//                $facebook->setAccessToken($_SESSION['facebook_token']);
//            }

            // 1
            $openid_id = $facebook->getUser();

            if(!$openid_id){
                $loginUrl = $facebook->getLoginUrl();
                $this->redirect($loginUrl);
                Yii::app()->end();
            }

            $userOpenid = UserEmail::model()->findByAttributes(array('openid_service' => 'FACEBOOK', 'openid_id' => $openid_id));
            $attrs = $facebook->api('/me?fields=id,name,birthday,email,gender,link');
            
            // manager page
            if($this->user){
                
                // if exist openid
                if($userOpenid){
                    if($this->user->id == $userOpenid->user_id){
                        // update openid_token
                        if($userOpenid->openid_token != $_SESSION['facebook_token']){
                            $userOpenid->openid_token = $_SESSION['facebook_token'];
                            $userOpenid->update();   
                        }

                        Yii::app()->user->setFlash('warning', "Openid Facebook {$userOpenid->email} đã được thêm vào tài khoản của bạn rồi.");
                    }else{
                        Yii::app()->user->setFlash('error', "Openid Facebook {$userOpenid->email} đã được sử dụng. Bạn vui lòng sử dụng openid khác.");
                    }

                }
                else{
                    // check exist email
                    $userEmail = UserEmail::model()->findByAttributes(array("email" => $attrs['email']));
                    if($userEmail){
                        if($this->user->id == $userEmail->user_id){
                            $userEmail->openid_id = $openid_id;    
                            $userEmail->openid_service = 'FACEBOOK';
                            $userEmail->openid_token = $_SESSION['facebook_token'];
                            $userEmail->update();
                            Yii::app()->user->setFlash('success', "Thêm thành công Openid Google {$userEmail->email}. Bạn đã có thể sử dụng để đăng nhập như 1 Openid.");
                        }else{
                            Yii::app()->user->setFlash('error', "Email {$userEmail->email} đã được sử dụng. Bạn vui lòng sử dụng email khác.");
                        }

                    }else{

                        $userOpenid = new UserEmail;
                        $userOpenid->user_id = $this->user->id;
                        $userOpenid->email = $attrs['email'];
                        $userOpenid->openid_id = $openid_id;
                        $userOpenid->openid_service = 'FACEBOOK';
                        $userOpenid->openid_token = $_SESSION['facebook_token'];
                        $userOpenid->is_main = (isset($this->user->email_main) && $this->user->email_main) ? NULL : 1;
                        $userOpenid->created = MyDateTime::getCurrentTime();
                        $userOpenid->insert();
                        Yii::app()->user->setFlash('success', "Openid Facebook {$userOpenid->email} đã được thêm thành công. Bạn có thể dùng nó để đăng nhập.");
                    }
                }

                $this->_openidRedirect($this->createUrl('/web/user/manageEmail'));    

            }
            // login page
            else{
                // if exist openid
                if($userOpenid){
                    // update openid_token
                    if($userOpenid->openid_token != $_SESSION['facebook_token']){
                        $userOpenid->openid_token = $_SESSION['facebook_token'];
                        $userOpenid->update();   
                    }

                    $user = $userOpenid->user;

                }
                else{
                    // check exist email
                    $userEmail = UserEmail::model()->findByAttributes(array("email" => $attrs['email']));
                    if($userEmail){
                        Yii::app()->user->setFlash('error', "Email {$userEmail->email} đã được sử dụng. Bạn vui lòng sử dụng email khác.");
                        $this->_openidRedirect($this->createUrl('/web/user/login'));
                    }

                    $user = new User();
                    $user->name = $attrs['name'];
                    $user->dob = preg_replace('{(\d{2})/(\d{2})/(\d{4})}', '$3-$1-$2', $attrs['birthday']);
                    $user->gender = $attrs['gender'];
                    $user->website = $attrs['link'];
                    // TODO -o Haidm: upload
                    $user->image = "http://graph.facebook.com/{$openid_id}/picture?type=large"; 
                    $user->created = MyDateTime::getCurrentTime();
                    $user->status = 'ENABLE';
                    $user->insert(); 

                    $userOpenid = new UserEmail;
                    $userOpenid->user_id = $user->id;
                    $userOpenid->email = $attrs['email'];
                    $userOpenid->openid_id = $openid_id;
                    $userOpenid->openid_service = 'FACEBOOK';
                    $userOpenid->openid_token = $_SESSION['facebook_token'];
                    $userOpenid->is_main = 1;
                    $userOpenid->created = MyDateTime::getCurrentTime();
                    $userOpenid->insert();

                }    

                //login
                $user->loginAuto();
                Yii::app()->user->setFlash('success', "Đăng nhập thành công với Openid Facebook {$userOpenid->email}");
                $this->_openidRedirect();

            } 

        }

        /**
        * @inheritdoc https://developers.google.com/accounts/docs/OAuth2
        * 
        */
        private function _connectGoogle(){

            Yii::app()->session['urlReferrer'] = Yii::app()->request->urlReferrer;

            $actionRouter = '/web/user/'.($this->user ? 'manageEmail' : 'login');
            $redirectUri = $this->createAbsoluteUrl($actionRouter, array('service' => 'google'));

            if(Yii::app()->request->getQuery('error') == 'access_denied') {
                Yii::app()->user->setFlash('error', 'Bạn đã hủy đăng nhập bằng tài khoản Google');

                $this->_openidRedirect($this->createUrl('/web/user/login')); 
            }  

            //https://developers.google.com/oauthplayground/
            Yii::import('ext.google.src.Google_Client');
            Yii::import('ext.google.src.contrib.Google_Oauth2Service');
            //            Yii::import('ext.google.src.contrib.Google_PlusService');

            $client = new Google_Client();
            $client->setApplicationName("Google UserInfo PHP Starter Application");
            $client->setClientId(Yii::app()->params->google['clientId']);
            $client->setClientSecret(Yii::app()->params->google['clientSecret']);
            //            $client->setDeveloperKey(Yii::app()->paramdddds->google['apiKey']);
            $client->setRedirectUri($redirectUri);
            $client->setScopes(array(
                'https://www.googleapis.com/auth/userinfo.email',
                'https://www.googleapis.com/auth/userinfo.profile',
                //                'https://www.googleapis.com/auth/plus.me',
            ));
            $oauth2Service = new Google_Oauth2Service($client);
            //            $plus = new Google_PlusService($client);


            //if (isset($_REQUEST['logout'])) {
            //  unset($_SESSION['google_token']);
            $client->revokeToken();

            //}

            // 2.token response
            if (isset($_GET['code'])) {
                $client->authenticate();
                $_SESSION['google_token'] = $client->getAccessToken();
//                $this->redirect($client->getRedirectUri());
            }


            // 3.set access token if it exists 
            if (isset($_SESSION['google_token'])) {
                $client->setAccessToken($_SESSION['google_token']);
            }

            // 1.token request
            if (!$client->getAccessToken()) {
                $loginUrl = $client->createAuthUrl();
                $this->redirect($loginUrl);
            }




            $attrs = $oauth2Service->userinfo->get();
            //            $me = $plus->people->get('me');

            //            echo '<pre>';print_r($me);echo '</pre>';
            //            echo '<pre>';print_r($attrs);echo '</pre>';die;
            $userOpenid = UserEmail::model()->findByAttributes(array('openid_service' => 'GOOGLE', 'openid_id' => $attrs['id']));


            // manager page
            if($this->user){

                // if exist openid
                if($userOpenid){
                    if($this->user->id == $userOpenid->user_id){
                        // update openid_token
                        if($userOpenid->openid_token != $_SESSION['google_token']){
                            $userOpenid->openid_token = $_SESSION['google_token'];
                            $userOpenid->update();   
                        }

                        Yii::app()->user->setFlash('warning', "Openid Google {$userOpenid->email} đã được thêm vào tài khoản của bạn rồi.");
                    }else{
                        Yii::app()->user->setFlash('error', "Openid Google {$userOpenid->email} đã được sử dụng. Bạn vui lòng sử dụng openid khác.");
                    }
                }
                else{
                    // check exist email
                    $userEmail = UserEmail::model()->findByAttributes(array("email" => $attrs['email']));
                    if($userEmail){
                        if($this->user->id == $userEmail->user_id){
                            $userEmail->openid_id = $attrs['id'];    
                            $userEmail->openid_service = 'GOOGLE';
                            $userEmail->openid_token = $_SESSION['google_token'];
                            $userEmail->update();
                            Yii::app()->user->setFlash('success', "Thêm thành công Openid Google {$userEmail->email}. Bạn đã có thể sử dụng để đăng nhập như 1 Openid.");
                        }else{
                            Yii::app()->user->setFlash('error', "Email {$userEmail->email} đã được sử dụng. Bạn vui lòng sử dụng email khác.");
                        }

                    }else{

                        $userOpenid = new UserEmail;
                        $userOpenid->user_id = $this->user->id;
                        $userOpenid->email = $attrs['email'];
                        $userOpenid->openid_id = $attrs['id'];
                        $userOpenid->openid_service = 'GOOGLE';
                        $userOpenid->openid_token = $_SESSION['google_token'];
                        $userOpenid->is_main = (isset($this->user->email_main) && $this->user->email_main) ? NULL : 1;
                        $userOpenid->created = MyDateTime::getCurrentTime();
                        $userOpenid->insert();
                        Yii::app()->user->setFlash('success', "Openid Facebook {$userOpenid->email} đã được thêm thành công. Bạn có thể dùng nó để đăng nhập.");
                    }
                }

                $this->_openidRedirect($this->createUrl('/web/user/manageEmail'));    

            }
            // login page
            else{
                // if exist openid
                if($userOpenid){
                    // update openid_token
                    if($userOpenid->openid_token != $_SESSION['google_token']){
                        $userOpenid->openid_token = $_SESSION['google_token'];
                        $userOpenid->update();   
                    }

                    $user = $userOpenid->user;
                }
                else{
                    // check exist email
                    $userEmail = UserEmail::model()->findByAttributes(array("email" => $attrs['email']));
                    if($userEmail){
                        Yii::app()->user->setFlash('error', "Email {$userEmail->email} đã được sử dụng. Bạn vui lòng sử dụng email khác.");
                        $this->_openidRedirect($this->createUrl('/web/user/login'));
                    }

                    $user = new User();
                    $user->name = $attrs['name'];
                    // $user->dob = preg_replace('{(\d{2})/(\d{2})/(\d{4})}', '$3-$1-$2', $attrs['birthday']);
                    $user->gender = $attrs['gender'];
                    $user->website = $attrs['link'];
                    // TODO: upload
                    // $user->image = $me['image']['url']; 
                    $user->created = MyDateTime::getCurrentTime();
                    $user->status = 'ENABLE';
                    $user->insert(); 

                    $userOpenid = new UserEmail;
                    $userOpenid->user_id = $user->id;
                    $userOpenid->email = $attrs['email'];
                    $userOpenid->openid_id = $attrs['id'];
                    $userOpenid->openid_service = 'GOOGLE';
                    $userOpenid->openid_token = $_SESSION['google_token'];
                    $userOpenid->is_main = 1;
                    $userOpenid->created = MyDateTime::getCurrentTime();

                    $userOpenid->insert();

                }    

                //login
                $user->loginAuto();
                Yii::app()->user->setFlash('success', "Đăng nhập thành công với Openid Yahoo {$userOpenid->email}");
                $this->_openidRedirect();

            } 

        }

        private function _connectYahoo(){
            Yii::app()->session['urlReferrer'] = Yii::app()->request->urlReferrer;

            Yii::import('ext.lightopenid.LightOpenID');

            $openid = new LightOpenID();
            if(!$openid->mode) {
                $openid->identity = 'https://me.yahoo.com';
                $openid->required = array(
                    'contact/email',
                    'namePerson',
                    'person/gender',
                ); 
                $this->redirect($openid->authUrl());
            }

            if($openid->mode == 'cancel') {
                Yii::app()->user->setFlash('error', 'Bạn đã hủy đăng nhập bằng tài khoản Yahoo');
                $this->_openidRedirect($this->createUrl('/web/user/login'));
            }   

            if($openid->validate()){

                $openid_id = preg_replace('{https://me\.yahoo\.com/a/(.+)#.+}', '$1', $openid->identity);
                $userOpenid = UserEmail::model()->findByAttributes(array('openid_service' => 'YAHOO', 'openid_id' => $openid_id));

                $attrs = $openid->getAttributes();

                // manager page
                if($this->user){

                    // if exist openid
                    if($userOpenid){
                        if($this->user->id == $userOpenid->user_id){
                            Yii::app()->user->setFlash('warning', "Openid Yahoo {$userOpenid->email} đã được thêm vào tài khoản của bạn rồi.");
                        }else{
                            Yii::app()->user->setFlash('error', "Openid Yahoo {$userOpenid->email} đã được sử dụng. Bạn vui lòng sử dụng openid khác.");
                        }

                    }
                    else{
                        // check exist email
                        $userEmail = UserEmail::model()->findByAttributes(array("email" => $attrs['contact/email']));
                        if($userEmail){
                            if($this->user->id == $userEmail->user_id){
                                $userEmail->openid_id = $openid_id;    
                                $userEmail->openid_service = 'YAHOO';
                                $userEmail->update();
                                Yii::app()->user->setFlash('success', "Thêm thành công Openid Yahoo {$userEmail->email}. Bạn đã có thể sử dụng để đăng nhập như 1 Openid.");
                            }else{
                                Yii::app()->user->setFlash('error', "Email {$userEmail->email} đã được sử dụng. Bạn vui lòng sử dụng email khác.");
                            }

                        }else{

                            $userOpenid = new UserEmail;
                            $userOpenid->user_id = $this->user->id;
                            $userOpenid->email = $attrs['contact/email'];
                            $userOpenid->openid_id = $openid_id;
                            $userOpenid->openid_service = 'YAHOO';
                            $userOpenid->is_main = (isset($this->user->email_main) && $this->user->email_main) ? NULL : 1;
                            $userOpenid->created = MyDateTime::getCurrentTime();
                            $userOpenid->insert();
                            Yii::app()->user->setFlash('success', "Openid Google {$userOpenid->email} đã được thêm thành công. Bạn có thể dùng nó để đăng nhập.");
                        }
                    } 


                    $this->_openidRedirect($this->createUrl('/web/user/manageEmail'));
                }
                // login page
                else{
                    // if exist openid
                    if($userOpenid){

                        $user = $userOpenid->user;

                    }
                    else{
                        // check exist email
                        $userEmail = UserEmail::model()->findByAttributes(array("email" => $attrs['contact/email']));
                        if($userEmail){
                            Yii::app()->user->setFlash('error', "Email {$userEmail->email} đã được sử dụng. Bạn vui lòng sử dụng email khác.");
                            $this->_openidRedirect($this->createUrl('/web/user/login'));
                        }

                        $user = new User();
                        $user->name = $attrs['namePerson'];
                        $user->dob = NULL;
                        $user->gender = ($attrs['person/gender'] == 'M') ? 'MALE' : 'FEMALE';
                        $user->website = NULL; 
                        $user->image = NULL; 
                        $user->created = MyDateTime::getCurrentTime();
                        $user->status = 'ENABLE';
                        $user->insert(); 

                        $userOpenid = new UserEmail;
                        $userOpenid->user_id = $user->id;
                        $userOpenid->email = $attrs['contact/email'];
                        $userOpenid->openid_id = $openid_id;
                        $userOpenid->openid_service = 'YAHOO';
                        $userOpenid->is_main = 1;
                        $userOpenid->created = MyDateTime::getCurrentTime();
                        $userOpenid->insert();
                    }
                    //login
                    $user->loginAuto();
                    Yii::app()->user->setFlash('success', "Đăng nhập thành công với Openid Yahoo {$userOpenid->email}");
                    $this->_openidRedirect();
                }
            }
        }

        private function _openidRedirect($url = null){
            if(is_null($url)){
                $url = Yii::app()->session['urlReferrer'];
                unset(Yii::app()->session['urlReferrer']);
            }

            if($success = Yii::app()->user->getFlash('success'))    Yii::app()->session['flash_success'] = $success;
            if($error = Yii::app()->user->getFlash('error'))    Yii::app()->session['flash_error'] = $error;
            if($warning = Yii::app()->user->getFlash('warning'))    Yii::app()->session['flash_warning'] = $warning;
            if($info = Yii::app()->user->getFlash('info'))    Yii::app()->session['flash_info'] = $info;


            $this->renderPartial('openid_popup_redirect', array(
                'url' => $url
            ));
            Yii::app()->end();
        }

        private function _getObjet($user_id = null){
            $criteria = new CDbCriteria();

            $criteria->compare('t.user_id', $user_id);
            $criteria->order = 't.created DESC';
            $criteria->limit = 10;

            $object = Object::model()->findAll($criteria);

//            foreach($object as $_key => $_val){
//                if($_val->date_end < time()){
//                    $_val->date_total = 0;
//                }
//            }

            return $object;
        }

    }
