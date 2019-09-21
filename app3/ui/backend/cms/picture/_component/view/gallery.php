<div class="row" style="padding:0px 9px 8px">
    <div class="project-section general-info">
        <h3>
            <i class="fa fa-picture-o"></i> 
            <?= \f\ifm::t ( "gallery" ) ?>
        </h3>


    </div>
    <br></br>

    <div style="float:right;display: inline-block">
        <?
        echo $this->formW->buttonTag ( array (
            'htmlOptions' => array (
                'type'    => 'button',
                'id'      => 'selectProfilePicBtn',
                'class'   => 'btn btn-custom-primary btn-md'
            ),
            'content' => '<i class="fa fa-upload"></i> ' . 'آپلود تصویر جدید',
            'action'  => array (
                'preServerSideAction' => array (
                    'route'   => 'core.fileManager.registerUploadSession',
                    'options' => array ( //change
                        'multiUpload' => 10,
                        'extensions'  => '.jpg, .png, .bmp, .jpeg,.gif',
                        'tasks'       => array ( 'upload' )
                    ),
                ),
                'display' => 'dialog',
                'params'  => array (
                    'targetRoute'    => "core.fileManager.getUploadForm",
                    'triggerElement' => 'selectProfilePicBtn', //chanage
                    'containerId'    => '#fileContainer',
                    'urlParams'      => array (
                        'path'        => 'service.' . $id //chanage
                    ),
                    'dialogTitle' => \f\ifm::t ( "fileUpload" ),
                    'ajaxParams'  => array (
                        'mode'   => '',
                        'fileId' => '',
                        'path'   => 'service.' . $id,
                        'func'   => 'refreshGallery'//chanage
                    )
                )
            ) ) ) ;
        ?>
    </div>
    <a target="_blank" class="btn btn-default" href="<?= \f\ifm::app ()->baseUrl ?>core/fileManager/index/service/<?= $id ?>">
        <i class="fa fa-folder"></i>
        <?= 'مدیریت فایل های گالری' ?>
    </a>


</div>
<br>
<div class="row list-group king-gallery">
    <?= $gallery ?>
</div>    


<script>
    function refreshGallery(params)
    {
        params['serviceId']=<?= $id ?>;
        params['cover']=<?=$cover?>
        //alert(params.serviceId);
        widgetHelper.tt('ui', 'ranking.service.addPicToService', params, 'addPic')
        //alert(params.fileId);
    }
    function addPic(params)
    {
        //alert(params.content);
        $('.king-gallery').prepend(params.content);
        $('.modal').modal('hide');
    }
    function removePic(params)
    {
        $('#pic'+params.id).remove();
    }
    function coverPic(params)
    {
        $('.king-gallery .item').each(function(i,e)
        {
            if(e.id=='pic'+params.id)
            {
                $('#pic'+params.id+' .thumbnail').css('border','2px dotted #34A6C8');
            }
            else
            {
                $('#'+e.id+' .thumbnail').css('border','');
            }
        });
        
        
    }
</script>

