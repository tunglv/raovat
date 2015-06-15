<div id="slider">
    <div class="container clearfix">

<!--    --><?php //if($array_product['object']) :?>
<!--        <div class="sixteen columns">-->
<!--            <div class="flex-container">-->
<!--                <div class="flexslider">-->
<!--                    <ul class="slides">-->
<!--                        --><?php //foreach($array_product['object'] as $_product) :?>
<!--                            <li style="width: 100%; float: left; margin-right: -100%; display: none;">-->
<!--                                <a href="--><?php //echo $_product['url']?><!--"><img src="--><?php //echo $_product->getImageUrl(0,'940')?><!--" alt="--><?php //echo $_product->getImageUrl(0,'940')?><!--"></a>-->
<!--                                <p class="flex-caption"> <span>--><?php //echo $_product['desc']?><!--</p>-->
<!--                            </li>-->
<!--                        --><?php //endforeach;?>
<!--                    </ul>-->
<!--                </div>   -->
<!--            </div> -->
<!--        </div>-->
<!--    --><?php //endif;?><!--    -->

    </div><!-- End Container -->
</div><!-- End Slider -->

<div class="container clearfix">

    <?php foreach($result as $_keyO => $_object):?>
        <?php if(count($_object)>0):?>
        <div class="one-third column item" style="box-shadow: 1px 1px 25px #ccc">
            <h2 class="title small" style="padding: 5px 10px 10px;"><?php echo Object::model()->getTypeLabel($_keyO)?><span class="line"></span></h2>

            <ul class="slider">
            <?php foreach($_object as $_key => $_val):?>
                <li class="slide" style="<?php if($_key>0):?>clear: both;border-top: 1px dashed #CCC;<?php endif;?>padding-top: 5px;">
                    <div class="two columns">
                        <a href="http://themes.jozoor.com/wp/crevision/dark/wp-content/uploads/2012/11/thumb-3.jpg" rel="prettyPhoto[]">
                            <img style="padding-bottom: 5px;" src="http://themes.jozoor.com/wp/crevision/dark/wp-content/uploads/2012/11/thumb-3.jpg" alt="" class="pic column-4">
                            <span class="hover-effect zoom"></span>
                        </a>
                    </div>
                    <div>
                        <h4 style="line-height: 12px;"><a href="<?php echo $_val->url?>"><?php echo $_val->title?></a></h4>
                    </div>
                    <div style="padding-top: 10px;">
                        <ul>
                            <li style="background-image: url(http://themes.jozoor.com/wp/crevision/dark/wp-content/themes/crevision/images/icons/twitter-icon.png);background-repeat: no-repeat;background-position: 0px center; padding-left: 25px;display: inline-block"><?php echo $_val->mobile?></li>
                            <li style="background-image: url(http://themes.jozoor.com/wp/crevision/dark/wp-content/themes/crevision/images/icons/twitter-icon.png);background-repeat: no-repeat;background-position: 0px center; padding-left: 25px;display: inline-block"><?php echo $_val->province_name?></li>
                        </ul>
                    </div>
                </li>
            <?php endforeach;?>
            </ul>

            <a href="<?php echo Object::model()->getUrlList($_keyO)?>" style="display: block;clear: both;float: right;padding: 10px;">xem thêm >></a>
        </div>
        <?php endif;?>
    <?php endforeach;?>

</div><!-- <<< End Container >>> -->