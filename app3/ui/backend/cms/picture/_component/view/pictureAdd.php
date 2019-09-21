<?php
$title = $row ? 'editpicture' : 'addpicture';
/* @var $this membersView */

$this->registerWidgets(array(
    'formW' => 'form',
    'boxW' => 'box',
    'pageTitleW' => 'pageTitle'
));

$statusArr = array(
    \f\ifm::t('enable') => 'enabled',
    \f\ifm::t('disable') => 'disabled',
);

$statusArr2 = array(
    \f\ifm::t('yes') => 'enabled',
    \f\ifm::t('no') => 'disabled',
);
//$this->

echo $this->pageTitleW->renderTitle(array(
    'title' => \f\ifm::t($title),
    'links' => array(
        array(
            'title' => \f\ifm::t('listPicture'),
            'href' => \f\ifm::app()->baseUrl . 'cms/picture/index'))));


echo $this->boxW->begin(array(
    'type' => 'form',
    'title' => \f\ifm::t($title)));


$form = '';
$form .= $this->formW->begin(array(
    'htmlOptions' => array(
        'method' => 'post',
        'action' => \f\ifm::app()->baseUrl . 'cms/picture/pictureSave',
        'id' => 'picture_Add'
    ),
));
$form .= $this->formW->input(array(
    'htmlOptions' => array(
        'type' => 'hidden',
        'name' => 'id',
        'id' => 'id',
        'value' => $row['id'],
    ),
));


$form .= $this->formW->rowStart();
$form .= $this->formW->input(array(
    'htmlOptions' => array(
        'type' => 'text',
        'name' => 'title',
        'value' => $row['title'],
    ),
    'validation' => array(
        'required' => ''
    ),
    'label' => array(
        'text' => \f\ifm::t('title'),
    ),
));
$form .= $this->formW->rowEnd();

$form .= $this->formW->rowStart();
$form .= $this->formW->input(array(
    'htmlOptions' => array(
        'type' => 'text',
        'name' => 'title_en',
        'value' => $row['title_en'],
    ),
    'validation' => array(
        'required' => ''
    ),
    'label' => array(
        'text' => \f\ifm::t('title_en'),
    ),
));
$form .= $this->formW->rowEnd();

$form .= $this->formW->fieldsetStart(array(
    'legend' => array(
        'text' => \f\ifm::t('gallery')
    )
));
$form .= '<input type="hidden" name="num_pic" id="num_pic" value="' . $numPic . '">';
$form .= '<input type="hidden" name="picture" id="picture" value="' . $cover . '">';

$form .= $this->formW->buttonTag(array(
    'htmlOptions' => array(
        'type' => 'button',
        'id' => 'selectProfilePicBtn',
        'class' => 'btn btn-custom-primary btn-md'
    ),
    'content' => '<i class="fa fa-upload"></i> ' . 'آپلود تصویر جدید',
    'action' => array(
        'preServerSideAction' => array(
            'route' => 'core.fileManager.registerUploadSession',
            'options' => array(
                //change
                'multiUpload' => 10,
                'extensions' => '.jpg, .png, .bmp, .jpeg,.gif',
                'tasks' => array(
                    'upload')
            ),
        ),
        'display' => 'dialog',
        'params' => array(
            'targetRoute' => "cms.picture.galleryPic",
            'triggerElement' => 'selectProfilePicBtn', //chanage
            'containerId' => '#fileContainer',
            'urlParams' => array(
                'path' => 'cms.picture.' . $id //chanage
            ),
            'dialogTitle' => \f\ifm::t("fileUpload"),
            'ajaxParams' => array(
                'mode' => '',
                'fileId' => '',
                'path' => 'cms.picture.' . $id, //chanage
                'func' => 'refreshGallery',
            )
        )
    )));
$form .= '<br>
<div class="row list-group king-gallery" style="margin:30px 3px 0px">';
$form .= $gallery;
$form .= '<div class="clearfix"></div></div>';

$form .= $this->formW->fieldsetEnd();


$form .= '<br></br>';
$form .= $this->formW->rowStart();
$form .= $this->formW->buttonTag(array(
    'htmlOptions' => array(
        'type' => 'submit',
    ),
    'content' => '<i class="fa fa-floppy-o"></i> ' . ($row ? \f\ifm::t('saveEdit') : \f\ifm::t('saveNew')),
));
$form .= $this->formW->rowEnd();


$form .= $this->formW->flush();

echo $form;

echo $this->boxW->flush();
?>
<script>
        widgetHelper.formSubmit('#picture_Add');
</script>
<script>
    function refreshGallery(params) {
        params['galId'] = '<?= $id ?>';
        widgetHelper.tt('ui', 'cms.picture.addPic', params, 'addPic')
    }
    function addPic(params) {
        $('.king-gallery').prepend(params.content);
        var numPic = parseInt($('#num_pic').val()) + 1;
        $('#num_pic').val(numPic);
        $('.modal').modal('hide');
        $('[data-toggle=confirmation]').confirmation();

        var cover = $('#picture').val();
        if (!cover) {
            $('#picture').val(params.fileId);
        }
    }
    function removePic(params) {
        $('#pic' + params.id).remove();
        var numPic = parseInt($('#num_pic').val()) - 1;
        $('#num_pic').val(numPic);
        var cover = parseInt($('#picture').val());

        if (cover == params.id) {
            $('#picture').val('');
        }
    }
    function coverPic(id) {
        $('.king-gallery .item').each(function (i, e) {
            if (e.id === 'pic' + id) {
                $('#pic' + id + ' .thumbnail').css('border', '2px dotted #34A6C8');
            } else {
                $('#' + e.id + ' .thumbnail').css('border', '');
            }
        });
        $('#picture').val(id);
    }
</script>


<div class="modal fade" id="newProduct">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header dialog-header-success">
                <h4 class="modal-title" id="myModalLabel"><i class="fa fa-check-circle"></i> پیغام سیستم</h4>
            </div>
            <div class="modal-body">
                <?= "محصول با موفقیت ثبت شد. آیا می خواهید محصول جدیدی ثبت کنید؟" ?>
            </div>

        </div>
    </div>
</div>

