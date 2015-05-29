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
                    <li style="z-index: 100;"><a href="http://meonho.net" class="active">Trang chủ<img src="" class="downarrowclass" style="border:0;"></a></li>
                    <li style="z-index: 99;"><a class="">Sản phẩm<img src="" class="downarrowclass" style="border:0;"></a>
                        <ul style="top: 87px; visibility: visible; left: 0px; width: 180px; display: none;">
                            <?php foreach($catagory as $_catagory):?>
                                <li style="text-transform: uppercase"><a href="<?php echo Yii::app()->createUrl('san-pham/'.$_catagory['alias'])?>"><?php echo $_catagory['name']?></a></li>
                            <?php endforeach;?>
                        </ul>
                    </li>
                    <?php /*<li style="z-index: 98;"><a class="" href="<?php echo Yii::app()->createUrl('web/user/create')?>">Đăng ký<img src="" class="downarrowclass" style="border:0;"></a></li>
                    <li style="z-index: 96;"><a class="" href="<?php echo Yii::app()->createUrl('web/user/login')?>">Đăng nhập<img src="" class="downarrowclass" style="border:0;"></a></li>*/?>
                </ul>
            </nav>
        </div><!-- End Menu -->

        <div class="sixteen columns"><hr></div>

    </div><!-- End Container -->
</header><!-- <<< End Header >>> -->