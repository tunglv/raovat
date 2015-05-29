<div id="slider">
    <div class="container clearfix">

    <?php if($array_product['product']) :?>
        <div class="sixteen columns">
            <div class="flex-container">
                <div class="flexslider">
                    <ul class="slides">
                        <?php foreach($array_product['product'] as $_product) :?>
                            <li style="width: 100%; float: left; margin-right: -100%; display: none;">
                                <a href="<?php echo $_product['url']?>"><img src="<?php echo $_product->getImageUrl(0,'940')?>" alt="<?php echo $_product->getImageUrl(0,'940')?>"></a>
                                <p class="flex-caption"> <span><?php echo $_product['desc']?></p>
                            </li>
                        <?php endforeach;?>
                    </ul>
                </div>   
            </div> 
        </div>
    <?php endif;?>    

    </div><!-- End Container -->
</div><!-- End Slider -->

<div class="container clearfix">
    <div class="two-thirds column">
        <!--catagory makeup-->
        <?php foreach($catagory as $_catagory):?>
            <?php if($array_product[$_catagory['alias']]) :?>
                <div class="recent-work gallery clearfix">
                    <div role="application" style="overflow: hidden; width: 100.2%;" class="slidewrap">
                        <div class="two-thirds column"> <h2 class="title" style="text-transform: uppercase"><?php echo $_catagory['name']?> <span class="line"></span></h2> </div>
                        <ul class="slidecontrols">
                            <li><a href="#makeup-slide" class="next" title="làm đẹp">Next</a></li><li><a aria-disabled="true" href="#makeup-slide" class="prev carousel-disabled" title="làm đẹp">Prev</a></li>
                        </ul>
                        <ul aria-activedescendant="carousel-1-0-slide0" style="margin-left: 0%; float: left; width: 200%; transition: margin-left 0.5s ease 0s;" class="slider" id="makeup-slide">
                            <?php $product_chunk = array_chunk($array_product[$_catagory['alias']], 2) ?>
                            <?php foreach ($product_chunk as $k_product => $val_product) : ?>
                                <li aria-hidden="false" id="carousel-1-0-slide<?php echo ($k_product == 0 ? 0 : 1)?>" role="tabpanel document" style="float: left; width: 50%;" class="slide <?php if($k_product == 0) echo 'carousel-active-slide'?>">
                                    <?php foreach($val_product as $_product) :?>
                                        <?php foreach($_product as $__product) :?>
                                            <div class="one-third column item">
                                                <div class="caption">
                                                    <a href="<?php echo $__product['url']?>"><img src="<?php echo $__product->getImageUrl(0,'420')?>" alt="<?php echo $__product['name']?>" class="pic">
                                                        <span class="hover-effect link"></span></a>
                                                </div><!-- hover effect -->
                                                <h4><a href="<?php echo $__product['url']?>"><?php echo $__product['name']?></a></h4>
                                                <p title="<?php echo $__product['desc']?>"><?php echo (count($words = explode(' ', $__product['desc'])) > 10) ? implode(' ', array_slice($words, 0, 10)) . '...' : $__product['desc'];?></p>
                                            </div>
                                        <?php endforeach;?>
                                    <?php endforeach;?>
                                </li><!-- End slide -->
                            <?php endforeach;?>
                        </ul>
                    </div><!-- End slidewrap -->
                </div><!-- End makeup -->
            <?php endif;?>
        <?php endforeach;?>
    </div>

    <!--right page-->
<!--    --><?php //$this->renderPartial('//common/_right_page',array('new_knowledge'=>$new_knowledge, 'new_today'=>$new_today, 'market_price'=>$market_price)); ?>

    <?php if ($viewed_product) : ?>
        <div class="clients clearfix">
            <div class="sixteen columns"> 
                <h2 class="title">Các mẹo bạn vừa xem <span class="line"></span></h2> 
                <ul class="items">
                    <?php foreach ($viewed_product as $key => $product) : ?>
                        <li><a href="<?php echo $product['url'] ?>" title="<?php echo $product['name'] ?>"><img src="<?php echo $product->getImageUrl(0,'157') ?>" alt="<?php echo $product['name'] ?>"></a></li>
                    <?php endforeach; ?>
                </ul><!-- End items -->
            </div>
        </div><!-- End clients -->
    <?php endif; ?><!-- End clients -->

</div><!-- <<< End Container >>> -->