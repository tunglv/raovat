<style>
    .ui-helper-hidden-accessible {
        display: none;
    }
</style>
<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'event-grid',
    'dataProvider'=>$dataProvider,
    'filter'=>$model,
    'ajaxUpdate'=> true,
    'template' => "{items} {pager}",
    'itemsCssClass' => 'table table-striped table-bordered',
    'pagerCssClass' => 'pagination pagination-centered',
    'pager'=>array(
        'class'=>'CLinkPager',
        'htmlOptions' => array(
            'class' => '',
        ),
        'hiddenPageCssClass' => 'disabled',
        'selectedPageCssClass' => 'active',
        'maxButtonCount'    =>  8,
        'header'            => FALSE,

    ),
    'loadingCssClass' => '',
    'beforeAjaxUpdate'=>'function(id,options){
        $("#ajax-loading").fadeIn();    
    }',
    'afterAjaxUpdate'=>'function(id,options){
        $("#ajax-loading").fadeOut();    
    }',
    'columns'=>array(
        array(
            'name' => 'id',
            'type'      =>  'html',
            'value' => '$data->id',
            'headerHtmlOptions' => array('style' => 'width: 10px'),
            'filter' => FALSE
        ),
        array(
            'name' => 'image',
            'type'      =>  'html',
            'value' => 'CHtml::image($data->getImageUrl($data->id,"157"), "", array("style" => "width: 100px"))',
        ),
        array(
            'name' => 'title',
            'type'      =>  'raw',
            'value' => '$data->title',
        ),
        array(
            'name' => 'desc',
            'type'      =>  'raw',
            'value' => '$data->desc',
        ),
        array(
            'name' => 'type',
            'type'      =>  'raw',
            'value' => '$data->typeLabel',
            'filter' => $model->typeData
        ),
        array(
            'name' => 'user_name',
            'type'      =>  'raw',
            'value' => '$data->user_name',
        ),
        array(
            'name' => 'date_start',
            'type'      =>  'raw',
            'value' => 'date("d-m-y H:i:s",$data->date_start)'
        ),
        array(
            'name' => 'date_end',
            'type'      =>  'raw',
            'value' => 'date("d-m-y H:i:s",$data->date_end)'
        ),
        array(
            'name' => 'status',
            'type'      =>  'raw',
            'value' => '$data->statusLabel',
            'filter' => $model->statusData
        ),
        array(
            'class'=>'CButtonColumn',
            'template'=>'{update} {delete}',
        ),
    ),
)); ?>    