<div class="one-third column">

    <div class="right-box">
        <?php if(count($hot_topic)>0):?>
            <h2 class="title">Có thể bạn quan tâm<span class="line"></span></h2>
            <ul>
                <?php foreach($hot_topic as $_key => $_val):?>
                    <li style="clear: both;display: block;<?php if($_key != 0):?>border-top: 1px dashed #CCC;padding-top: 15px;<?php endif;?>">
                        <a href="<?php echo $_val->url?>" style="width: 40%;display: inline-block;float: left;"><img width="265" src="<?php echo $_val->getImageUrl('','420')?>" alt="<?php echo $_val->title?>" class="border"></a>
                        <p style="width: 54%;display: inline-block;float: right;" title="<?php echo $_val->desc?>"><a href="<?php echo $_val->url?>"><?php echo $_val->desc?></a></p>
                    </li>
                <?php endforeach;?>
            </ul>
        <?php endif;?>
    </div><!-- End choose us -->
</div>