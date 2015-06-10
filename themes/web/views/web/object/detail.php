<div class="clearfix" style="margin: 50px 0 30px"></div>
<div class="container clearfix">
    <div class="two-thirds column">
        <!--catagory makeup-->
        <div class="recent-work gallery clearfix">
            <div role="application" style="width: 100.2%;" class="slidewrap">
                <div class="two-thirds column"> <h2 class="title"><?php echo $object->title?><span class="line"></span></h2> </div>
                <div id="fb-root"></div>
                <script>(function(d, s, id) {
                        var js, fjs = d.getElementsByTagName(s)[0];
                        if (d.getElementById(id)) return;
                        js = d.createElement(s); js.id = id;
                        js.src = "//connect.facebook.net/en_GB/all.js#xfbml=1&appId=236470773181814";
                        fjs.parentNode.insertBefore(js, fjs);
                    }(document, 'script', 'facebook-jssdk'));</script>
                <div style="padding: 0 0 10px 11px" class="fb-like" data-href="<?php echo 'http://meonho.net'?>" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div>
                <!-- item 2 -->
                <div class="two-thirds column item" style="text-align:justify;font-family: tahoma, geneva, sans-serif;color: #000;">
                    <strong style="padding: 0 0 20px;display: block;line-height: 25px;"><?php echo $object->desc?></strong>
                    <p class="text-align" style="text-align: justify">
                        <?php echo $object->content?>
                    </p>
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
                <div class="fb-comments two-thirds column" data-width="100%" data-href="<?php echo 'http://meonho.net'?>" data-numposts="5"></div>
            </div><!-- End slidewrap -->

        </div><!-- End makeup -->
    </div>

<!--    --><?php //$this->renderPartial('//common/_right_page',array('new_knowledge'=>$new_knowledge, 'new_today'=>$new_today, 'market_price'=>$market_price)); ?>
    
    <div class="clients clearfix">
        <?php if ($same_object) : ?>
            <div class="sixteen columns">
                <h2 class="title">Các rao vặt tương tự <span class="line"></span></h2>
                <ul class="items">
                    <?php foreach ($same_object as $object): ?>
                        <li><a title="<?php echo $object->title ?>" href="<?php echo $object->url ?>"><img src="<?php echo $object->imageUrl;?>" alt="<?php echo $object->title ?>"></a></li>
                    <?php endforeach; ?>
                </ul><!-- End items -->
            </div>
        <?php endif; ?>
    </div><!-- End clients -->

</div><!-- <<< End Container >>> -->