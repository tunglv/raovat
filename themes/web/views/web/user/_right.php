<div class="one-third column">
    <div class="left-box">
        <!--            <h2 class="title"><a href="">Tài liệu </a><span class="line"></span></h2>-->
        <div style="display: inline-block;margin-bottom: 15px;">
            <a style="float: left;display: inline-block;height: 48px;width: 48px;overflow: hidden;border-radius: 25px;"><img src="http://playenglish.tung/upload/user_image/100022/avatar/avatar_65.jpg?556d6e76b32c8"></a>
            <div id="your-profile" style="display: inline-block;line-height: 20px;font-size: 12px;padding-left: 10px;">
                <a style="display: block;color: #00aec8;cursor: pointer;"><?php echo $this->user->name?></a>
                <a style="display: block;color: #9197a3;cursor: pointer" href="/tai-khoan/cap-nhap-tai-khoan">Edit Profile</a>                </div>
        </div>
    </div>
    <?php if(count($object)>0):?>
        <div class="left-box" style="margin-top: 20px;">
            <h2 class="title"><a href="">Các tin đã đăng</a><span class="line"></span></h2>
            <div id="list-homework" style="height: 250px; overflow: hidden; width: auto;">
                <?php foreach($object as $_key => $_val):?>
                    <span class="field-left-box" style="display: block;clear: both;<?php if($_key == 0):?>margin: 0;border-top: none;padding-top: 0;<?php endif?>"><i class="icon-document" style="margin-right: 5px;height: 28px;width: 28px;display: inline-block;float: left;background-size: 100%;background-image: url(/themes/web/files/images/icons/pen-32.png)"></i><a style="font-size: 13px;" href="/upload/homework/4/Tuan 1 - Phat am - Le Van Tung .jpg"><?php echo $_val->title?></a></span>
                <?php endforeach;?>
            </div>
        </div>
    <?php endif;?>
</div>