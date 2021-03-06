<style>
    .last-child {
        margin-left: 0 !important;
        margin-right: 0 !important;
    }
    .infinite_navigation{
        visibility: hidden;
    }
</style>
<div class="clearfix" style="margin: 50px 0 30px"></div>
<div class="container clearfix">
    <?php if(count($posts) > 0):?>
    <div class="two-thirds column">
        <!--catagory makeup-->
        <div class="recent-work gallery clearfix">

            <div role="application" style="overflow: hidden; width: 100.2%;" class="slidewrap">

                <div class="two-thirds column">
                    <h2 class="title" style="text-transform: uppercase"><?php echo $type?><span class="line"></span></h2>
                </div>

                <div id="posts">
                    <div style="clear: both"></div>
                    <?php foreach($posts as $index => $data): ?>
<!--                items-->
                        <div class="clearfix post" style="padding: 0 10px 10px;display: block;box-shadow: 1px 1px 25px #ccc;margin-bottom: 20px;">
                            <h4><a href="<?php echo $data->url?>"><?php echo $data->title?></a></h4>
                            <div class="three columns" style="margin: 0 10px 0 0;">
                                <a href="<?php echo $data->url?>">
                                    <img src="<?php echo $data->getImageUrl('', '420')?>">
                                </a>
                            </div>
                            <div>
                                <a href="<?php echo $data->url?>">
                                    <p style="text-align: justify;"><?php echo $data->desc?></p>
                                </a>
                                <ul style="padding-top: 15px;color: #000">
                                    <li style="background-image: url(https://cdn2.iconfinder.com/data/icons/ios-7-icons/50/phone1-20.png);background-repeat: no-repeat;background-position: 0px center; padding-left: 16px;display: inline-block;background-size: contain;">09987654321</li>
                                    <li style="background-image: url(https://cdn2.iconfinder.com/data/icons/ios-7-icons/50/link-20.png);background-repeat: no-repeat;background-position: 0px center; padding-left: 16px;display: inline-block;background-size: contain;margin-left: 15px;"><?php echo $data->link_web?></li>
                                    <li style="background-image: url(https://cdn4.iconfinder.com/data/icons/ionicons/512/icon-ios7-location-outline-20.png);background-repeat: no-repeat;background-position: 0px center; padding-left: 16px;display: inline-block;background-size: contain;margin-left: 15px;"><?php echo $data->province_name?></li>
                                    <li style="display: inline-block;float: right;"><?php echo date('d/m/y', $data->date_start)?></li>
                                </ul>
                            </div>
                        </div>
                    <?php endforeach;?>
    <!--                      end items-->
                </div>
                <?php $this->widget('ext.yiinfinite-scroll.YiinfiniteScroller', array(
                    'contentSelector' => '#posts',
                    'itemSelector' => 'div.post',
                    'loadingText' => 'Loading...',
                    'donetext' => 'This is the end...',
                    'pages' => $pages,
                )); ?>
            </div><!-- End slidewrap -->

        </div><!-- End makeup -->
      
    </div>
    <?php else:?>
    <div class="two-thirds column">
        <h2>Không có kết quả phù hợp</h2>
    </div>
    <?php endif;?>
    <!--right page-->
    <?php $this->renderPartial('//common/_right_page',array('hot_topic'=>$hot_topic)); ?>


</div><!-- <<< End Container >>> -->