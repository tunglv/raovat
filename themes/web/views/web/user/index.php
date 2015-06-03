<style>
    .feed-course a.active{
        color: #00aec8;
    }
    .left-box h2, .right-box h2{
        font-size: 16px;
    }
    .left-box span.field-left-box{
        margin: 20px 0;
        border-top: 1px dotted #dfdfdf;
        padding-top: 8px;
    }
    #your-profile a:hover{
        text-decoration: underline;
    }
    a{
        cursor: pointer;
    }
    .comment-feed{
        display: block;
        clear: both;
        padding: 5px 0;
    }
</style>
<div class="clearfix" style="margin: 60px 0 30px"></div>
<div class="container clearfix">
    <!--    left box-->
    <div class="one-third column">
        <div class="left-box">
            <!--            <h2 class="title"><a href="">Tài liệu </a><span class="line"></span></h2>-->
            <div style="display: inline-block;margin-bottom: 15px;">
                <a style="float: left;display: inline-block;height: 48px;width: 48px;overflow: hidden;border-radius: 25px;"><img src="http://playenglish.tung/upload/user_image/100022/avatar/avatar_65.jpg?556d6e76b32c8"></a>
                <div id="your-profile" style="display: inline-block;line-height: 20px;font-size: 12px;padding-left: 10px;">
                    <a style="display: block;color: #00aec8;cursor: pointer;">Tung le Van</a>
                    <a style="display: block;color: #9197a3;cursor: pointer" href="/tai-khoan/cap-nhap-tai-khoan">Edit Profile</a>                </div>
            </div>
        </div>
        <div class="left-box" style="margin-top: 20px;">
            <h2 class="title"><a href="">Các tin đã đăng</a><span class="line"></span></h2>
            <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 250px;"><div id="list-homework" style="height: 250px; overflow: hidden; width: auto;">
                    <span class="field-left-box" style="display: block;clear: both;margin: 0;border-top: none;padding-top: 0;"><i class="icon-document" style="margin-right: 5px;height: 28px;width: 28px;display: inline-block;float: left;background-size: 100%;background-image: url(/themes/web/files/images/icons/pen-32.png)"></i><a style="font-size: 13px;" href="/upload/homework/4/Tuan 1 - Phat am - Le Van Tung .jpg">Tuan 1 - Phat am - Le Van Tung .jpg</a></span>
                    <span class="field-left-box" style="display: block;clear: both;"><i class="icon-document" style="margin-right: 5px;height: 28px;width: 28px;display: inline-block;float: left;background-size: 100%;background-image: url(/themes/web/files/images/icons/pen-32.png)"></i><a style="font-size: 13px;" href="/upload/homework/5/Tuan 2 - Phat am - Le Van Tung .jpg">Tuan 2 - Phat am - Le Van Tung .jpg</a></span>
                    <span class="field-left-box" style="display: block;clear: both;"><i class="icon-document" style="margin-right: 5px;height: 28px;width: 28px;display: inline-block;float: left;background-size: 100%;background-image: url(/themes/web/files/images/icons/pen-32.png)"></i><a style="font-size: 13px;" href="/upload/homework/6/Tuan 3 - Phat am - Le Van Tung.jpg">Tuan 3 - Phat am - Le Van Tung.jpg</a></span>
                </div><div class="slimScrollBar" style="width: 7px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 250px; background: rgb(0, 0, 0);"></div><div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; opacity: 0.2; z-index: 90; right: 1px; background: rgb(51, 51, 51);"></div></div>
        </div>
    </div>
    <!--    center box-->
    <div class="two-thirds column">
        <div class="feed-course" style="overflow: hidden;font-family: arial, helvetica, sans-serif;color: #000">
            <script type="text/javascript" src="/files/editors/tiny_mce/tiny_mce.js"></script>
            <script type="text/javascript" src="/files/editors/tiny_mce/editor_user_verry_short.js"></script>
            <script type="text/javascript" src="/files/js/relCopy.jquery.js"></script>
            <link rel="stylesheet" media="all" type="text/css" href="/files/js/jquery.timepicker/jquery-ui-timepicker-addon.css" />
            <script type="text/javascript" src="/files/js/jquery.timepicker/jquery-ui-timepicker-addon.js"></script>
            <style>
                .checkbocklist {
                    width:100px;
                    float:left;
                    overflow:hidden;
                }
                .checkbocklist label{
                    width: 50px;
                }
                label.required {
                    float:left;
                }
                .ui-datepicker {
                    width: 232px;
                }
                .upload_method{
                    cursor: pointer;
                }
                .upload_method.selected{
                    text-decoration: underline;
                    font-weight: bold;
                }
                #img_file {
                    margin-top: 5px;
                }
                #image_file, #image_url{
                    display: none;
                }
                .par.control-group {
                    padding: 20px 0;
                    display: block;
                }

            </style>
            <script>
                $(function(){
                    $("#Object_date_start, #Object_date_end").datetimepicker({
                        'dateFormat':'dd-mm-yy',
                        'timeFormat':'hh:mm TT'

                    });
                });
            </script>
            <div class="grid_4">
            <div class="da-panel">

            <div id="da-ex-tabs" class="ui-tabs ui-widget ui-widget-content ui-corner-all">
            <div style="padding-bottom: 20px;">

            <?php $this->widget('admin.components.widgets.AlertWidget');?>

            <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'object-form',
                'enableClientValidation'=>true,
                'clientOptions'=>array(
                    'validateOnSubmit'=>true,
                ),
                //'enableAjaxValidation'=>true,
                'htmlOptions' => array('class' => 'stdform', 'enctype' => 'multipart/form-data')
            )); ?>
            <h2 class="title"><a href="">Nội dung tin rao vặt</a><span class="line"></span></h2>
            <div class="par control-group">
                <label class="control-label three columns required" style="line-height: 24px;" for="Object_title">Tiêu đề <span class="required">*</span></label>
                <div class="controls seven columns">
                    <?php echo $form->textField($model,'title',array('maxlength'=>255, 'class' => 'seven columns', 'style'=>'padding: 6px;border-radius: 15px;border: 1px solid #ccc;')); ?>
                    <?php echo $form->error($model,'title');?>
                    <?php echo $form->textField($model,'alias',array('maxlength'=>255, 'style'=>'display: none;', 'class' => 'input-large', 'placeholder' => 'Url Post Name')); ?>
                </div>
                <small class="desc" style="float: right;padding-right: 16px;padding-top: 5px;">Name should be 255 chars <span id="name_char_count"></span></small>
            </div>

            <script>
                $(function(){
                    $("#a_url").click(function(){
                        $('#a_file').removeClass('selected');
                        $('#a_url').addClass('selected');
                        $('#image_url').show();
                        $('#image_file').hide();
                        $("#img_url").show();
                        $('#img_file').hide();
                        $('#Object_upload_method').val('url');
                    });
                    $("#a_file").click(function(){
                        $('#a_url').removeClass('selected');
                        $('#a_file').addClass('selected');
                        $('#image_file').show();
                        $('#image_url').hide();
                        $("#img_url").hide();
                        $('#img_file').show();
                        $('#Object_upload_method').val('file');
                    });
                    $("#browse_file").change(function(evt){
                        var files = evt.target.files;
                        var f = files[0];

                        if(!f.type.match('image.*')) {
                            alert('File không hợp lệ. Hãy chọn 1 file ảnh khác.');
                            return false;
                        }
                        var i = document.createElement('input');
                        if('multiple' in i){
                            var reader = new FileReader();
                            reader.readAsDataURL(f);
                            reader.onload = (function(){
                                return function(e){
                                    $('#img_url').hide();
                                    $('#img_file').attr('src', e.target.result).show();
                                };
                            })(f);
                            $('#img_review').show();
                        }
                    });

                    $("#Object_image_url").bind('change keyup blur', function(evt){
                        var method = $('#Object_upload_method').val();
                        var ext = $(this).val().split('.').pop().toLowerCase();
                        if(method == 'url' && $.inArray(ext, [ 'jpg', 'gif', 'png' ] >= 0)){
                            $('#img_file').hide();
                            $('#img_url').attr('src', $(this).val()).show();
                            $('#img_review').show();
                        }
                    });

                    <?php if($model->upload_method == 'file'):?>
                    $('#image_file').show();
                    $('#image_url').hide();
                    $('#a_file').addClass('selected');
                    <?php else:?>
                    $('#image_url').show();
                    $('#image_file').hide();
                    $('#a_url').addClass('selected');
                    <?php if($model->image_url):?>
                    $('#img_url').attr('src', '<?php echo $model->image_url?>').show();
                    <?php endif?>
                    <?php endif?>
                });
            </script>
            <div class="clearfix"></div>
            <div class="par control-group">
                <label class="seven columns">Ảnh đại diện <span class="required">*</span> </label>
                <div class="clearfix"></div>
                <div class="controls">
                    <div style="float: left;line-height: 24px;" class="three columns">
                        <a id="a_file" class="upload_method">Từ máy tính</a> &nbsp;|&nbsp;
                        <a id="a_url" class="upload_method">Từ URL</a>
                        <?php echo $form->hiddenField($model,'upload_method'); ?>
                    </div>

                    <div id="image_file" class="seven columns">
                        <?php echo $form->fileField($model,'image_file', array('class' => 'da-custom-file seven columns', 'name' => 'browse_file')); ?>
                    </div>
                    <div id="image_url" class="seven columns">
                        <?php echo $form->textField($model,'image_url', array('class' => 'seven columns', 'placeholder' => 'http://domain.com/path/image.jpg', 'style'=>'padding: 6px;border-radius: 15px;border: 1px solid #ccc;')); ?>
                    </div>
                    <?php echo $form->error($model,'image_file');?>
                    <?php echo $form->error($model,'upload_method');?>
                </div>
                <div class="controls">
                    <?php if($this->action->id == 'update'):?>
                        <img id="img_file" style="display: none; height: 60px; width: auto; margin-left: 220px;" />
                        <img id="img_url" style="height: 60px; width: auto; margin-left: 220px;" src="<?php echo Object::model()->getImageUrl( $model->id , '157');?>"/>
                        <!--<img style="height: 60px; width: auto;margin-left: 220px;" src="<?php // echo Object::model()->getImgUrl($model->id, $model->image.'_small.jpg');?>" />-->
                    <?php else:?>
                        <img id="img_file" style="display: none; height: 60px; width: auto; margin-left: 220px;" />
                        <img id="img_url" style="display: none; height: 60px; width: auto; margin-left: 220px;" />
                    <?php endif?>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="par control-group">
                <label class="control-label three columns required" for="Object_desc">Mô tả ngắn <span class="required">*</span></label>
                <div class="controls seven columns">
                    <?php echo $form->textArea($model,'desc',array('maxlength'=> 1000, 'style' => 'height: 60px;width: 98%;border-radius: 10px;', 'class' => 'seven columns')); ?>
                    <?php echo $form->error($model,'desc');?>
                </div>
                <small class="desc" style="float: right;padding-right: 10px;padding-top: 5px;">Description should be 1000 chars <span id="desc_char_count"></span></small>
            </div>

            <div class="clearfix"></div>

            <div class="par control-group">
                <label class="control-label three columns" style="line-height: 30px;" for="Object_type">Loại tin đăng</label>
                <div class="controls seven columns">
                    <?php echo $form->dropDownList($model,'type', Object::model()->getTypeData(), array('class'=>'four columns', 'style'=>'padding: 6px;border: 1px solid #ccc;border-radius: 15px;')); ?>
                    <?php echo $form->error($model,'type');?>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="par control-group date_start">
                <label class="control-label three columns required" style="line-height: 30px;" for="Object_date_start">Thời hạn <span class="required">*</span></label>
                <div class="controls seven columns">
                    <?php echo $form->dropDownList($model,'date_start', Object::model()->getTimeData(), array('class'=>'four columns', 'style'=>'padding: 6px;border: 1px solid #ccc;border-radius: 15px;')); ?>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="par control-group">
                <label class="control-label seven columns" for="Object_content">Nội dung</label>
                <div class="controls" style="padding-left: 10px;">
                    <?php echo $form->textArea($model,'content',array('class'=> 'mce_editor ten columns', 'editorTemplate'=>'null', 'style' => 'height: 300px;width: 100%;')); ?>
                </div>
            </div>

            <div class="clearfix"></div>
            <h2 class="title"><a href="">Thông tin liên hệ</a><span class="line"></span></h2>

            <div class="clearfix"></div>
            <div class="par control-group">
                <label class="control-label three columns" for="Object_province_id" style="line-height: 24px">Tỉnh/ TP</label>
                <div class="controls seven columns">
                    <?php echo $form->dropDownList($model,'province_id', Province::model()->getData(), array('empty'=>'--Tỉnh/Tp--', 'class'=>'four columns', 'style'=>'padding: 6px;border: 1px solid #ccc;border-radius: 15px;')); ?>
                    <?php echo $form->textField($model,'province_name',array('maxlength'=>255, 'style'=>'display: none','class' => 'input-large')); ?>
                    <?php echo $form->error($model,'province_id');?>
                </div>
            </div>

            <div class="clearfix"></div>
            <div class="par control-group">
                <label class="control-label three columns" for="Object_address">Địa chỉ</label>
                <div class="controls seven columns">
                    <?php echo $form->textArea($model,'address',array('maxlength'=> 255, 'style' => 'min-height: 80px;width: 100%;padding: 6px;border-radius: 15px;border: 1px solid #ccc;', 'class' => 'seven columns')); ?>
                    <?php echo $form->error($model,'address');?>
                </div>
                <small class="desc" style="float: right;padding-right: 10px;padding-top: 5px;">Address should be 255 chars <span id="desc_char_count"></span></small>
            </div>

            <div class="clearfix"></div>
            <div class="par control-group">
                <label class="control-label three columns required" for="Object_mobile" style="line-height: 24px">Di động/ Máy bàn <span class="required">*</span></label>
                <div class="controls seven columns">
                    <?php echo $form->textField($model,'mobile',array('maxlength'=>255, 'class' => 'three columns', 'style'=>'padding: 6px;border: 1px solid #ccc;border-radius: 15px;', 'placeholder' => 'Số di động')); ?>
                    <?php echo $form->textField($model,'phone',array('maxlength'=>255, 'class' => 'three columns', 'placeholder' => 'Số máy bàn', 'style' => 'padding: 6px;border: 1px solid #ccc;border-radius: 15px;')); ?>
                    <?php echo $form->error($model,'mobile');?>
                </div>
            </div>

            <div class="clearfix"></div>
            <div class="par control-group">
                <label class="control-label three columns" for="Object_email" style="line-height: 24px;">Email</label>
                <div class="controls seven columns">
                    <?php echo $form->textField($model,'email',array('maxlength'=>255, 'class' => 'three columns', 'style' => 'padding: 6px;border: 1px solid #ccc;border-radius: 15px;')); ?>
                    <?php echo $form->error($model,'email');?>
                </div>
            </div>

            <div class="clearfix"></div>
            <div class="par control-group">
                <label class="control-label three columns" for="Object_skyper" style="line-height: 24px">Nick skyper/ yahoo</label>
                <div class="controls seven columns">
                    <?php echo $form->textField($model,'skyper',array('maxlength'=>255, 'class' => 'three columns', 'style' => 'padding: 6px;border: 1px solid #ccc;border-radius: 15px;', 'placeholder' => 'Nick skyper')); ?>
                    <?php echo $form->textField($model,'yahoo',array('maxlength'=>255, 'class' => 'three columns', 'style' => 'padding: 6px;border: 1px solid #ccc;border-radius: 15px;', 'placeholder' => 'Nick yahoo')); ?>
                    <?php echo $form->error($model,'skyper');?>
                </div>
            </div>

            <div class="par control-group">
                <label class="control-label three columns required" style="line-height: 24px;" for="Object_title">Link website <span class="required">*</span></label>
                <div class="controls seven columns">
                    <?php echo $form->textField($model,'link_web',array('maxlength'=>255, 'class' => 'seven columns', 'style'=>'padding: 6px;border-radius: 15px;border: 1px solid #ccc;')); ?>
                    <?php echo $form->error($model,'link_web');?>
                </div>
            </div>

            <p class="stdformbutton">
                <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'btn btn-info')); ?>
            </p>
            <?php $this->endWidget(); ?>
            </div>
            </div>
            </div>
            <script>
                $("#Object_province_id").on('change', function(){
                    $('#Object_province_name').val($(this).find(":selected").text());
                });
                //alias

                $("#Object_title").keyup(function(){
                    $('#name_char_count').text($(this).val().length);
                }).keyup();
                $("#Object_desc").keyup(function(){
                    $('#desc_char_count').text($(this).val().length);
                }).keyup();
            </script>

            </div>
        </div>
    </div>
</div>