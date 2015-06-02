<!-- item 1 -->
<div class="one-third column item <?php if($index%2 ==0) echo 'last-child'?>">
    <div class="caption">
        <a href="<?php echo $data['url']?>"><img src="<?php echo $data->getImageUrl(0,'420')?>" alt="<?php echo $data['name']?>" class="pic">
            <span class="hover-effect link"></span></a>
    </div><!-- hover effect -->
    <h4><a href="<?php echo $data['url']?>"><?php echo $data['name']?></a></h4>
    <p title="<?php echo $data['desc']?>"><?php echo (count($words = explode(' ', $data['desc'])) > 8) ? implode(' ', array_slice($words, 0, 8)) . '...' : $data['desc'];?></p>
</div>
<!-- End -->