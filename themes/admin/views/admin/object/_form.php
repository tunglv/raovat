<script type="text/javascript" src="/files/editors/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="/files/editors/tiny_mce/editor_admin.js"></script>
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
    #image_file, #image_url, #img_file, #img_url{
        margin-left: 220px;
    }
    #image_file, #image_url{
        display: none;
    }

</style>
<script>
    $(function(){
        $("#Object_date_start, #Object_date_end").datetimepicker({
//            //timeFormat: "hh:mm",
//            //controlType: 'select',
//            showButtonPanel: true,
//            addSliderAccess: true,
//            sliderAccessArgs: { touchonly: false },
//            timeOnlyTitle: 'Chọn thời gian',
//            timeText: 'Thời gian',
//            hourText: 'Giờ',
//            minuteText: 'Phút',
//            closeText: 'Đóng',
//            stepMinute: 5
            'dateFormat':'dd-mm-yy',
            'timeFormat':'hh:mm TT'

        });
    });
</script>
<div class="grid_4">       
    <div class="da-panel">
        <div class="da-panel-header">
            <span class="da-panel-title">
                Rao vặt
            </span>
        </div>

        <div id="da-ex-tabs" class="ui-tabs ui-widget ui-widget-content ui-corner-all">
            <?php // $this->renderPartial('_tabs', array('model' => $model))?>
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
                <h4 class="widgettitle">Nội dung tin rao vặt</h4>
                <div class="par control-group">
                    <?php echo $form->labelEx($model,'title', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model,'title',array('maxlength'=>255, 'class' => 'input-large')); ?>
                        <?php echo $form->error($model,'title', array('class' => 'help-inline error'));?>
                        <?php echo $form->textField($model,'alias',array('maxlength'=>255, 'class' => 'input-large', 'placeholder' => 'Url Post Name')); ?>
                    </div>
                    <small class="desc">Name should be 255 chars <span id="name_char_count"></span></small>
                </div>
                
                <div class="par control-group">
                    <?php echo $form->labelEx($model,'status', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model,'status', Object::model()->getStatusData()); ?>
                        <?php echo $form->error($model,'status', array('class' => 'help-inline error'));?>
                    </div>
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
                <div class="par control-group">
                    <label>Cover Image <span class="required">*</span> </label>
                    <div class="controls">
                        <div style="float: left;">
                            <a id="a_file" class="upload_method">Từ máy tính</a> &nbsp;|&nbsp; 
                            <a id="a_url" class="upload_method">Từ URL</a>
                            <?php echo $form->hiddenField($model,'upload_method'); ?>
                        </div> 
                        <div style="clear: both;"></div>

                        <div id="image_file">
                            <?php echo $form->fileField($model,'image_file', array('class' => 'da-custom-file', 'name' => 'browse_file')); ?>
                        </div>
                        <div id="image_url">
                            <?php echo $form->textField($model,'image_url', array('placeholder' => 'http://domain.com/path/image.jpg')); ?>
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
                <div class="par control-group">
                    <?php echo $form->labelEx($model,'desc', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textArea($model,'desc',array('maxlength'=> 1000, 'style' => 'height: 80px;width: 625px;', 'class' => 'input-large')); ?>
                        <?php echo $form->error($model,'desc', array('class' => 'help-inline error'));?>
                    </div>
                    <small class="desc">Description should be 1000 chars <span id="desc_char_count"></span></small>
                </div>

                <div class="par control-group">
                    <?php echo $form->labelEx($model,'type', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model,'type', Object::model()->getTypeData()); ?>
                        <?php echo $form->error($model,'type', array('class' => 'help-inline error'));?>
                    </div>
                </div>

                <div class="par control-group date_start">
                    <?php echo $form->labelEx($model,'date_start', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model,'date_start',array('maxlength'=>255, 'class' => 'input')); ?>
                        <?php echo $form->error($model,'date_start');?>
                    </div>
                </div>

                <div class="par control-group date_end">
                    <?php echo $form->labelEx($model,'date_end', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model,'date_end',array('maxlength'=>255, 'class' => 'input')); ?>
                        <?php echo $form->error($model,'date_end');?>
                    </div>
                </div>

                <div class="par control-group">
                    <?php echo $form->labelEx($model,'content', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textArea($model,'content',array('class'=> 'mce_editor', 'style' => 'height: 300px;')); ?>
                    </div>
                </div>

                <h4 class="widgettitle">Thông tin liên hệ</h4>

                <div class="par control-group">
                    <?php echo $form->labelEx($model,'province_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->dropDownList($model,'province_id', Province::model()->getData(), array('empty'=>'--Tỉnh/Tp--')); ?>
                        <?php echo $form->textField($model,'province_name',array('maxlength'=>255, 'style'=>'display: none','class' => 'input-large')); ?>
                        <?php echo $form->error($model,'province_id', array('class' => 'help-inline error'));?>
                    </div>
                </div>

                <div class="par control-group">
                    <?php echo $form->labelEx($model,'address', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textArea($model,'address',array('maxlength'=> 255, 'style' => 'height: 80px;width: 625px;', 'class' => 'input-large')); ?>
                        <?php echo $form->error($model,'address', array('class' => 'help-inline error'));?>
                    </div>
                    <small class="desc">Address should be 255 chars <span id="desc_char_count"></span></small>
                </div>

                <div class="par control-group">
                    <?php echo $form->labelEx($model,'mobile', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model,'mobile',array('maxlength'=>255, 'class' => 'input-large')); ?>
                        <?php echo $form->error($model,'mobile', array('class' => 'help-inline error'));?>
                        <?php echo $form->textField($model,'phone',array('maxlength'=>255, 'class' => 'input-large', 'placeholder' => 'Số máy bàn')); ?>
                    </div>
                </div>

                <div class="par control-group">
                    <?php echo $form->labelEx($model,'email', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model,'email',array('maxlength'=>255, 'class' => 'input-large')); ?>
                        <?php echo $form->error($model,'email', array('class' => 'help-inline error'));?>
                    </div>
                </div>

                <div class="par control-group">
                    <?php echo $form->labelEx($model,'skyper', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->textField($model,'skyper',array('maxlength'=>255, 'class' => 'input-large')); ?>
                        <?php echo $form->error($model,'skyper', array('class' => 'help-inline error'));?>
                        <?php echo $form->textField($model,'yahoo',array('maxlength'=>255, 'class' => 'input-large', 'placeholder' => 'Nick yahoo')); ?>
                    </div>
                </div>

                <div class="par control-group">
                    <label class="control-label">Mã xác nhận <span class="required">*</span></label>
                    <div class="controls" style="position: relative;">
                        <?php echo $form -> textField($model, 'verifyCode', array('class' => 'text')); ?>
                        <?php $this -> widget('CCaptcha', Yii::app() -> params['captcha_view']); ?>
                        <?php echo $form -> error($model, 'verifyCode'); ?>
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
    <?php if($model->isNewRecord):?>
    $('#Object_title').bind('blur keyup', function() {
        $('#Object_alias').val($(this).val().toAlias().replaceAll(' ', '-').toLowerCase());
    });
    <?php endif?>

    $("#Object_title").keyup(function(){
        $('#name_char_count').text($(this).val().length);
    }).keyup();
    $("#Object_desc").keyup(function(){
        $('#desc_char_count').text($(this).val().length);
    }).keyup();
</script>
