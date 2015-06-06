<div class="one-third column">
    <div class="left-box">
        <!--            <h2 class="title"><a href="">Tài liệu </a><span class="line"></span></h2>-->
        <div style="display: inline-block;margin-bottom: 15px;">
            <a style="float: left;display: inline-block;height: 48px;width: 48px;overflow: hidden;border-radius: 25px;"><img src="http://tung.playenglish/upload/user_image/100022/avatar/avatar_65.jpg?556d6e76b32c8"></a>
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
                    <span class="field-left-box" style="display: block;clear: both;line-height: 22px;<?php if($_key == 0):?>margin: 0;border-top: none;padding-top: 0;<?php endif?>"><i class="icon-document" style="margin-right: 5px;height: 24px;width: 24px;display: inline-block;float: left;background-size: 100%;background-image: url(<?php if($_val->date_total != 0 && $_val->status != 'disable'):?>https://cdn1.iconfinder.com/data/icons/hawcons/32/698903-icon-22-eye-24.png<?php elseif($_val->status == 'disable'):?>https://cdn1.iconfinder.com/data/icons/hawcons/32/698959-icon-114-lock-24.png<?php elseif($_val->date_total ==0):?>https://cdn1.iconfinder.com/data/icons/hawcons/32/700346-icon-24-stop-watch-24.png<?php endif;?>"></i><a style="font-size: 13px;" href="<?php echo Yii::app()->createUrl('/web/user/updateObject', array('object_id' => $_val->id, 'object_alias'=>$_val->alias))?>)"><?php echo $_val->title?></a></span>
                <?php endforeach;?>
            </div>
        </div>
    <?php endif;?>
</div>