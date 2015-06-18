<header>
    <div class="container clearfix">
        <div style="position: fixed;z-index: 999;background-color: #fff;box-shadow: 10px 0px 25px #fff;">
        <div class="two columns">
            <div class="logo" style="margin: 0;">
                <a href="http://meonho.net">
                    <img src="<?php echo Yii::app()->baseUrl?>/themes/web/files/images/meonho.png" alt="Sản phẩm">
                </a>
            </div>
        </div><!-- End Logo -->

        <div class="eleven columns" style="padding: 7px 0">
            <form action="/rao-vat/ket-qua-tim-kiem" method="post" style="float: right;">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 col-lg-offset-1" style="display: inline-block">
                    <input style="border: 1px solid #ddd;padding: 5px;border-radius: 20px;" type="text" name="keyword" placeholder="Nhập từ khoá cần tìm ..." value="" class="form-control">
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3" style="display: inline-block;">
                    <select name="type" class="form-control" style="border: 1px solid #ddd;padding: 5px;border-radius: 20px;">
                        <option value="" selected="selected">--- Chọn danh mục ---</option><option value="may-tinh-may-van-phong">Máy tính - Máy văn phòng</option><option value="bat-dong-san">Bất động sản</option><option value="o-to">Ô tô</option><option value="dien-thoai-sim-so">Điện thoại - Sim số</option><option value="thoi-trang-my-pham">Thời trang - Mỹ phẩm</option><option value="viec-l-m-tuyen-sinh">Việc làm - Tuyển sinh</option><option value="dien-lanh-dien-may">Điện lạnh - Điện máy</option><option value="dien-tu-ky-thuat-so">Điện tử - Kỹ thuật số</option><option value="du-lich-the-thao">Du lịch- Thể thao</option><option value="noi-that-ngoai-that">Nội thất - Ngoại thất</option><option value="xe-may-xe-dap">Xe máy - Xe đạp</option><option value="do-dung-me-v-be">Đồ dùng - Mẹ và bé</option><option value="vat-lieu-xay-dung">Vật liệu xây dựng</option><option value="7a8-dich-vu">Dịch vụ</option>
                    </select>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3" style="display: inline-block;">
                    <select name="city" class="form-control" style="border: 1px solid #ddd;padding: 5px;border-radius: 20px;">
                        <option value="" selected="selected">--- Chọn Tỉnh/Tp ---</option>
                        <?php foreach($city as $_city):?>
                            <option value="<?php echo $_city->provinceid?>"><?php echo $_city->name?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2" style="display: inline-block;padding-left: 10px;padding-top: 3px;float: right;">
                    <button type="submit" class="btn btn-warning" style="padding: 0;border: 0;background-color: transparent;"><i class="fa fa-search" style="background-image: url(https://cdn1.iconfinder.com/data/icons/free-98-icons/32/search-20.png);width: 20px;height: 20px;display: block;"></i></button>
                </div>
                <div class="clear"></div>
                <div class="top-search col-lg-offset-1"></div>
            </form>
        </div>

        <div class="three columns">
            <nav id="menu" class="navigation">
                <ul id="nav">
                    <li style="z-index: 100;"><a href="http://meonho.net" class="" style="padding: 14px 0;">Đăng bài miễn phí<img src="" class="downarrowclass" style="border:0;"></a></li>
                    <!--                    <li style="z-index: 99;"><a class="">-Tỉnh khác-<img src="" class="downarrowclass" style="border:0;"></a>-->
                    <!--                        <ul style="top: 87px; visibility: visible; left: 0px; width: 180px; display: none;height: 500px;overflow-y: scroll;overflow-x: hidden">-->
                    <!--                            --><?php //foreach($city as $_city):?>
                    <!--                                <li style="text-transform: uppercase"><a href="--><?php //echo Yii::app()->createUrl('san-pham/'.$_city->name)?><!--">--><?php //echo $_city->name?><!--</a></li>-->
                    <!--                            --><?php //endforeach;?>
                    <!--                        </ul>-->
                    <!--                    </li>-->
                    <?php /*<li style="z-index: 98;"><a class="" href="<?php echo Yii::app()->createUrl('web/user/create')?>">Đăng ký<img src="" class="downarrowclass" style="border:0;"></a></li>
                    <li style="z-index: 96;"><a class="" href="<?php echo Yii::app()->createUrl('web/user/login')?>">Đăng nhập<img src="" class="downarrowclass" style="border:0;"></a></li>*/?>
                </ul>
            </nav>
        </div><!-- End Menu -->

    </div><!-- End Container -->
        </div>
</header><!-- <<< End Header >>> -->
<div class="sixteen columns" style="width: 100%;"><hr></div>