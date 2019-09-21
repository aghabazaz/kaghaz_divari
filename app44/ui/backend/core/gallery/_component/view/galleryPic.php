<?php
if ( $cover == $params[ 'id' ] )
{
    $color = ' #34A6C8' ;
}
else
{
    $color = '#fff' ;
}
?>
<div class="item col-lg-3 col-md-4 col-sm-6" id="pic<?= $params[ 'id' ] ?>" >
    <div class="thumbnail" style="border:2px dotted <?= $color ?>;height:200px">
        <img alt="" src="<?php echo \f\ifm::app ()->fileBaseUrl . $params[ 'id' ] ?>" class="list-group-image" style="max-height:190px !important;vertical-align: middle">
        <div class="caption" style="background: #eee" >
            <h3 class="inner list-group-item-heading" style="font-size:13px"><?= $params[ 'title' ] ?></h3>
            <ul class="list-unstyled" style="padding-bottom:10px;padding-right: 0px">
                <li style="color:silver;font-size:12px">حجم فایل : <?=
                    number_format ( ($params[ 'size' ] / 1024 ), 1 ) . ' کیلوبایت'
                    ?></li>
            </ul>
            <div class="action-buttons" style="text-align:center">
                <a target="_blank" href="<?= \f\ifm::app ()->baseUrl . 'core/fileManager/fileDetail/' . $params[ 'id' ] ?>" style="color:royalblue">
                    <i class="fa fa-edit" style="font-size:20px;text-decoration: none" data-toggle="tooltip" title="<?= \f\ifm::t ( 'edit' ) ?>"></i> 
                </a>
                <a  style="color:darkred" data-toggle="confirmation" data-placement='top' data-on-confirm='widgetHelper.tt("ui", "core.gallery.deletePic", {fileId: <?= $params[ 'id' ] ?>,selector: "#pic <?= $params[ 'id' ] ?>"}, "removePicGallery" );' href="javascript:void(0)">
                    <i class="fa fa-trash-o" style="font-size:20px;text-decoration: none" data-toggle="tooltip" title="<?= \f\ifm::t ( 'remove' ) ?>"></i> 
                </a>
                <a  style="color:green" data-toggle="confirmation" data-placement='top' data-on-confirm='coverPicGallery(<?= $params[ 'id' ] ?>);' href="javascript:void(0)">
                    <i class="fa fa-picture-o" style="font-size:20px;text-decoration: none" data-toggle="tooltip" title="<?= \f\ifm::t ( 'coverPic' ) ?>"></i> 
                </a>
            </div>
           
        </div>

    </div>

</div>
