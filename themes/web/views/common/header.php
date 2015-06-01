<header>
    <div class="container clearfix">

        <div class="one-third column">
            <div class="logo">
                <a href="http://meonho.net">
                    <img src="<?php echo Yii::app()->baseUrl?>/themes/web/files/images/meonho.png" alt="Sản phẩm">
                </a>
            </div>
        </div><!-- End Logo -->

        <div class="two-thirds column">
            <nav id="menu" class="navigation">
                <ul id="nav">
                    <li style="z-index: 100;"><a href="http://meonho.net" class="">Đăng bài miễn phí<img src="" class="downarrowclass" style="border:0;"></a></li>
<!--                    <li style="z-index: 99;"><a class="">-Tỉnh khác-<img src="" class="downarrowclass" style="border:0;"></a>-->
<!--                        <ul style="top: 87px; visibility: visible; left: 0px; width: 180px; display: none;height: 500px;overflow-y: scroll;overflow-x: hidden">-->
<!--                            --><?php //foreach($city as $_city):?>
<!--                                <li style="text-transform: uppercase"><a href="--><?php //echo Yii::app()->createUrl('san-pham/'.$_city->name)?><!--">--><?php //echo $_city->name?><!--</a></li>-->
<!--                            --><?php //endforeach;?>
<!--                        </ul>-->
<!--                    </li>-->

                    <li style="z-index: 100;">
                        <form action="http://kenhdangtin.com/search.html" method="get">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 col-lg-offset-1">
                                <input type="text" name="q" placeholder="Nhập từ khoá cần tìm ..." value="" class="form-control">
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                <select name="category" class="form-control">
                                    <option value="" selected="selected">--- Chọn danh mục ---</option><option value="may-tinh-may-van-phong">Máy tính - Máy văn phòng</option><option value="bat-dong-san">Bất động sản</option><option value="o-to">Ô tô</option><option value="dien-thoai-sim-so">Điện thoại - Sim số</option><option value="thoi-trang-my-pham">Thời trang - Mỹ phẩm</option><option value="viec-l-m-tuyen-sinh">Việc làm - Tuyển sinh</option><option value="dien-lanh-dien-may">Điện lạnh - Điện máy</option><option value="dien-tu-ky-thuat-so">Điện tử - Kỹ thuật số</option><option value="du-lich-the-thao">Du lịch- Thể thao</option><option value="noi-that-ngoai-that">Nội thất - Ngoại thất</option><option value="xe-may-xe-dap">Xe máy - Xe đạp</option><option value="do-dung-me-v-be">Đồ dùng - Mẹ và bé</option><option value="vat-lieu-xay-dung">Vật liệu xây dựng</option><option value="7a8-dich-vu">Dịch vụ</option>
                                </select>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                                <select name="city" class="form-control">
                                    <option value="" selected="selected">--- Chọn Tỉnh/Tp ---</option>
                                    <?php foreach($city as $_city):?>
                                        <option value="<?php echo $_city->provinceid?>"><?php echo $_city->name?></option>
                                    <?php endforeach;?>
                                </select>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                                <button type="submit" class="btn btn-warning"><i class="fa fa-search"></i></button>
                            </div>
                            <div class="clear"></div>
                            <div class="top-search col-lg-offset-1"></div>
                        </form>
                    </li>

                    <?php /*<li style="z-index: 98;"><a class="" href="<?php echo Yii::app()->createUrl('web/user/create')?>">Đăng ký<img src="" class="downarrowclass" style="border:0;"></a></li>
                    <li style="z-index: 96;"><a class="" href="<?php echo Yii::app()->createUrl('web/user/login')?>">Đăng nhập<img src="" class="downarrowclass" style="border:0;"></a></li>*/?>
                </ul>
            </nav>
        </div><!-- End Menu -->

        <div class="sixteen columns"><hr></div>

    </div><!-- End Container -->
</header><!-- <<< End Header >>> -->