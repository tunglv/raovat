<div class="container clearfix">
    <div class="two-thirds column">
        <!--catagory makeup-->
        <div class="recent-work gallery clearfix">

            <div role="application" style="width: 100.2%;" class="slidewrap">

                <div class="two-thirds column"> <h2 class="title"><?php echo $product['name'] ?><span class="line"></span></h2> </div>
                <div id="fb-root"></div>
                <script>(function(d, s, id) {
                        var js, fjs = d.getElementsByTagName(s)[0];
                        if (d.getElementById(id)) return;
                        js = d.createElement(s); js.id = id;
                        js.src = "//connect.facebook.net/en_GB/all.js#xfbml=1&appId=236470773181814";
                        fjs.parentNode.insertBefore(js, fjs);
                    }(document, 'script', 'facebook-jssdk'));</script>
                <div style="padding: 0 0 10px 11px" class="fb-like" data-href="<?php echo 'http://meonho.net'.$product['url']?>" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div>
                <!-- item 2 -->
                <div class="two-thirds column item" style="text-align:justify">
                    <strong style="padding: 0 0 20px;display: block"><?php echo $product['desc'] ?></strong>
                    <p class="text-align-left"><?php echo $product['content'] ?></p>
                </div>
                <!-- End -->
                <div id="fb-root"></div>
                <script>(function(d, s, id) {
                        var js, fjs = d.getElementsByTagName(s)[0];
                        if (d.getElementById(id)) return;
                        js = d.createElement(s); js.id = id;
                        js.src = "//connect.facebook.net/en_GB/all.js#xfbml=1&appId=236470773181814";
                        fjs.parentNode.insertBefore(js, fjs);
                    }(document, 'script', 'facebook-jssdk'));</script>
                <div class="fb-comments" data-href="<?php echo 'http://meonho.net'.$product['url']?>" data-numposts="5"></div>
            </div><!-- End slidewrap -->

        </div><!-- End makeup -->

    </div>

    <!--right page-->
<!--    --><?php //$this->renderPartial('//common/_right_page',array('new_knowledge'=>$new_knowledge, 'new_today'=>$new_today, 'market_price'=>$market_price)); ?>

    <div class="clients clearfix">
        <?php if ($same_product) : ?>
            <div class="sixteen columns"> 
                <h2 class="title">Các mẹo tương tự <span class="line"></span></h2> 
                <ul class="items">
                    <?php foreach ($same_product as $_product): ?>
                        <li><a title="<?php echo $_product['name'] ?>" href="<?php echo $_product['url'] ?>"><img src="<?php echo $_product->getImageUrl(0,'157') ?>" alt="<?php echo $_product['name'] ?>"></a></li>
                    <?php endforeach; ?>
                </ul><!-- End items -->
            </div>
        <?php endif; ?>

    </div><!-- End clients -->

    <?php if ($viewed_product) : ?>
        <div class="clients clearfix">
            <div class="sixteen columns"> 
                <h2 class="title">Các sản phẩm bạn vừa xem <span class="line"></span></h2>
                <ul class="items">
                    <?php foreach ($viewed_product as $key => $__product) : ?>
                        <li><a href="<?php echo $__product['url'] ?>" title="<?php echo $__product['name'] ?>"><img src="<?php echo $__product->getImageUrl(0,'157') ?>" alt="<?php echo $__product['name'] ?>"></a></li>
                    <?php endforeach; ?>
                </ul><!-- End items -->
            </div>
        </div><!-- End clients -->
    <?php endif; ?>

</div><!-- <<< End Container >>> -->