<?php  
$array_base = array(
//    'http://<sub:\w+>.anuong.dev' => '/site/page',  
    'http://<sub:\w+>.anuong.dev<any:.*>' => '/site<any>',
    'http://<sub:\w+>.anuong.hehe.vn<any:.*>' => '/site<any>',
    
    '/<module:(admin|gii)>' => '/<module>',

    '/<city_alias:[\w\-]+>' => '/web/page/index',
    
    // user
    '/tai-khoan/dang-nhap-voi-<service:(google|facebook)>' => '/web/user/login',
    '/tai-khoan/dang-nhap' => '/web/user/login',
    '/tai-khoan/quen-mat-khau' => '/web/user/forgot',
    '/tai-khoan/dang-ky' => '/web/user/create',
    '/tai-khoan/them-tai-khoan-<service:(google|facebook)>' => '/web/user/manageEmail',
    '/tai-khoan/them-email' => '/web/user/manageEmail',
    '/tai-khoan/them-sdt' => '/web/user/managePhone',

    //sản phẩn
    '/san-pham/<alias:[\w\-]+>'=>'/web/object/list',
    '/san-pham/chi-tiet/<alias:[\w\-]+>'=>'/web/object/detail',

    // branch
    '/<city_alias:[\w\-]+>/<alias:[\w\-]+>-<id:\d+>' => '/web/branch/view',
    
    // event
    '/<city_alias:[\w\-]+>/<branch_alias:[\w\-]+>-<branch_id:\d+>/<event_alias:[\w\-]+>-<event_id:\d+>' => '/web/branch/viewDetailEvent',
    
    // branch search
    '/<city_alias:[\w\-]+>/tim-kiem/<get:.+>/trang-<page:\d+>' => '/web/branch/search',
    '/<city_alias:[\w\-]+>/tim-kiem/<get:.+>' => '/web/branch/search',
    '/<city_alias:[\w\-]+>/tim-kiem' => '/web/branch/search',

    // crawl foody
    '/foody/<foody_city_alias>/<page_from>/<page_to>'   => '/crawlFoody/run',
    '/fa/<f>/<t>'   => '/crawlFoody/analyze',
    '/fa'   => '/crawlFoody/analyze',

    '<_p1:\w+>'=>'<_p1>',
    '<_p1:\w+>/<_p2:\w+>'=>'<_p1>/<_p2>',
    '<_p1:\w+>/<_p2:\w+>/<_p3:\w+>'=>'<_p1>/<_p2>/<_p3>',
    '<_p1:\w+>/<_p2:\w+>/<_p3:\w+>/<_p4:\w+>'=>'<_p1>/<_p2>/<_p3>/<_p4>',
);
//$array_domain = require(dirname(__FILE__).'/domain.php');
//$array_base = array_merge($array_domain, $array_base);

return $array_base;