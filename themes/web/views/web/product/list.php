<style>
    .last-child {
        margin-left: 0 !important;
        margin-right: 0 !important;
    }
</style>
<div class="container clearfix">
    <div class="two-thirds column">
        <!--catagory makeup-->
        <div class="recent-work gallery clearfix">

            <div role="application" style="overflow: hidden; width: 100.2%;" class="slidewrap">

                <div class="two-thirds column"> <h2 class="title" style="text-transform: uppercase"><?php echo $catagory['name']?> <span class="line"></span></h2> </div>
                        
                    <?php $this->widget('zii.widgets.CListView', array(
                                        'dataProvider'=>$dataProvider,
                                        'itemView'=>'_item_view',
                                        'template'=>'{items}{pager}',
                                        'enableSorting' => true,
                                    
                                        'pagerCssClass' => 'pagination paging pagination-centered',
                                        'pager' => Array(
                                        'id'=>'',
                                        //'class'=>'',
                                        'internalPageCssClass'=>'',
                                        'cssFile'=>'', 
                                        'header'=>'',

                                        'hiddenPageCssClass'=>'hidden',
                                        'selectedPageCssClass'=>'active',
                                        'nextPageLabel'=>'Next',
                                        'maxButtonCount'=>5
                                    ),
                                    'emptyText'=>'Hiện chưa có sản phẩm nào, bạn hãy là người đầu tiên đăng sản phẩm trên meonho.net',
                                )); ?>
                      
            </div><!-- End slidewrap -->

        </div><!-- End makeup -->
      
    </div>

    <!--right page-->
<!--    --><?php //$this->renderPartial('//common/_right_page',array('new_knowledge'=>$new_knowledge, 'new_today'=>$new_today, 'market_price'=>$market_price)); ?>

    <?php if($viewed_product) :?>
    <div class="clients clearfix">
        <div class="sixteen columns"> 
            <h2 class="title">Các sản phẩm bạn vừa xem <span class="line"></span></h2>
            <ul class="items">
                <?php foreach ($viewed_product as $key => $_product) :?>
                    <li><a href="<?php echo $_product['url']?>" title="<?php echo $_product['name']?>"><img src="<?php echo $_product->getImageUrl(0,'157')?>" alt="<?php echo $_product['name']?>"></a></li>
                <?php endforeach;?>
            </ul><!-- End items -->
        </div>
    </div><!-- End clients -->
    <?php endif;?>

</div><!-- <<< End Container >>> -->