<?php
/* @var $this smsCenterView */

$this->registerWidgets ( array (
    'formW'      => 'form',
    'boxW'       => 'box',
    'pageTitleW' => 'pageTitle'
) ) ;

echo $this->pageTitleW->renderTitle ( array (
    'title' => \f\ifm::t ( 'memberSetting' ),
) ) ;


echo $this->boxW->begin ( array (
    'type'  => 'form',
    'title' => \f\ifm::t ( 'memberSetting' ) ) ) ;



$form = '' ;
echo $this->formW->begin ( array (
    'htmlOptions' => array (
        'method' => 'post',
        'action' => \f\ifm::app ()->baseUrl . 'member/memberSetting/settingSave',
        'id'     => 'portAdd'
    ),
        ) ) ;

$form .= $this->formW->rowStart () ;
$form .= $this->formW->input ( array (
    'htmlOptions' => array (
        'type'        => 'text',
        'name'        => 'leastBuyUser',
        'value'       => $memberSetting[ 'leastBuyUser' ],
        'placeholder' => \f\ifm::t ( 'leastBuyUser' )
    ),
    'validation'  => array (
        'required' => '',
        'type'     => 'number'
    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'leastBuyUser' ),
    ),
        ) ) ;
$form .= $this->formW->rowEnd ()



;$form .= $this->formW->rowStart () ;
$form .= $this->formW->input ( array (
    'htmlOptions' => array (
        'type'        => 'text',
        'name'        => 'mostBuyUser',
        'value'       => $memberSetting[ 'mostBuyUser' ],
        'placeholder' => \f\ifm::t ( 'mostBuyUser' )
    ),
    'validation'  => array (
        'required' => '',
        'type'     => 'number'
    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'mostBuyUser' ),
    ),
        ) ) ;
$form .= $this->formW->rowEnd () ;


$form .= $this->formW->rowStart () ;
$form .= $this->formW->input ( array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'day_settlement',
        'id'    => 'day_settlement',
        'value' => $memberSetting[ 'day_settlement' ],
    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'settlementDeadline' ),
    ),
) ) ;
$form .= $this->formW->rowEnd () ;


$form .= $this->formW->rowStart () ;
$form .= $this->formW->input ( array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'minPurchase',
        'id'    => 'minPurchase',
        'value' => $memberSetting[ 'minPurchase' ],
    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'minPurchase' ),
    ),
) ) ;
$form .= $this->formW->rowEnd () ;

//$form .= $this->formW->rowStart () ;
//$form .= $this->formW->input ( array (
//    'htmlOptions' => array (
//        'type'        => 'text',
//        'name'        => 'numUseDiscountCard',
//        'value'       => $memberSetting[ 'numUseDiscountCard' ],
//        'placeholder' => \f\ifm::t ( 'numUseDiscountCardMsg' )
//    ),
//    'validation'  => array (
//        'required' => '',
//        'type'     => 'number'
//    ),
//    'label'       => array (
//        'text' => \f\ifm::t ( 'numUseDiscountCard' ),
//    ),
//        ) ) ;
//$form .= $this->formW->rowEnd () ;

//$form .= $this->formW->rowStart () ;
//$form .= $this->formW->input ( array (
//    'htmlOptions' => array (
//        'type'        => 'text',
//        'name'        => 'mainPageText',
//        'value'       => $memberSetting[ 'mainPageText' ],
//        'placeholder' => \f\ifm::t ( 'mainPageText' )
//    ),
//    'validation'  => array (
//        'required' => '',
//    ),
//    'label'       => array (
//        'text' => \f\ifm::t ( 'mainPageText' ),
//    ),
//) ) ;
//$form .= $this->formW->rowEnd () ;
//$form .= $this->formW->rowStart () ;
//$form .= $this->formW->input ( array (
//    'htmlOptions' => array (
//        'type'        => 'text',
//        'name'        => 'mainPageTexth2',
//        'value'       => $memberSetting[ 'mainPageTexth2' ],
//        'placeholder' => \f\ifm::t ( 'mainPageTexth2' )
//    ),
//    'validation'  => array (
//        'required' => '',
//    ),
//    'label'       => array (
//        'text' => \f\ifm::t ( 'mainPageTexth2' ),
//    ),
//) ) ;
//$form .= $this->formW->rowEnd () ;
//
//$statusArr2 = array (
//    \f\ifm::t ( 'automatically' ) => 'automatically',
//    \f\ifm::t ( 'manually' )      => 'manually',
//        ) ;
//$form       .= $this->formW->rowStart () ;
//$form       .= $this->formW->radio ( array (
//    'htmlOptions' => array (
//        'name' => 'bestselling',
//    ),
//    'choices'     => $statusArr2,
//    'label'       => array (
//        'text' => \f\ifm::t ( 'bestselling' ),
//    ),
//    'checked'     => $row[ 'bestselling' ] ? $row[ 'bestselling' ] : 'automatically',
//    'linear'      => TRUE
//        ) ) ;
//$form       .= $this->formW->rowEnd () ;

//$form.=$this->formW->rowStart () ;
//$form.=$this->formW->textarea ( array (
//    'htmlOptions' => array (
//        'name' => 'newsletterPageText',
//    ),
//    'label' => array (
//        'text'    => \f\ifm::t ( 'newsletterPageText' )
//    ),
//    'content' => $memberSetting[ 'newsletterPageText' ]
//        ) ) ;
//
//$form.=$this->formW->rowEnd () ;
//
//$form.=$this->formW->rowStart () ;
//$form.=$this->formW->textarea ( array (
//    'htmlOptions' => array (
//        'name' => 'mainPageText',
//    ),
//    'label' => array (
//        'text'    => \f\ifm::t ( 'mainPageText' )
//    ),
//    'editor'  => true,
//    'content' => $memberSetting[ 'mainPageText' ]
//        ) ) ;
//
//$form.=$this->formW->rowEnd () ;
//$form.=$this->formW->rowStart () ;
//$form.=$this->formW->input ( array (
//    'htmlOptions' => array (
//        'type'       => 'text',
//        'name'       => 'roll',
//        'value'      => $memberSetting[ 'roll' ],
//    ),
//    'validation' => array (
//        'required' => ''
//    ),
//    'label'    => array (
//        'text' => \f\ifm::t ( 'roll' ),
//    ),
//        ) ) ;
//$form.=$this->formW->rowEnd () ;
//$form .= $this->formW->rowStart () ;
//$form .= $this->formW->buttonTag ( array (
//    'htmlOptions' => array (
//        'type'  => 'button',
//        'id'    => 'selectBrandLogo',
//        'class' => 'btn btn-default'
//    ),
//    'content'     => '<i class="fa fa-upload"></i> ' . \f\ifm::t ( 'fileSelect' ),
//    'label'       => array (
//        'text' => \f\ifm::t ( 'giftPicture' ),
//    ),
//    'action'      => array (
//        'preServerSideAction' => array (
//            'route'   => 'core.fileManager.registerUploadSession',
//            'options' => array (
//                //change
//                'multiUpload' => 10,
//                'extensions'  => '.jpg, .png, .bmp, .jpeg',
//                'tasks'       => array (
//                    'upload',
//                    'select' )
//            ),
//        ),
//        'display'             => 'dialog',
//        'params'              => array (
//            'targetRoute'    => "core.fileManager.getUploadForm",
//            'triggerElement' => 'selectBrandLogo', //chanage
//            'containerId'    => '#fileContainer3',
//            'urlParams'      => array (
//                'path' => 'member.gifts' //chanage
//            ),
//            'dialogTitle'    => \f\ifm::t ( "fileUpload" ),
//            'ajaxParams'     => array (
//                'mode'   => $memberSetting[ 'nationCard' ] > 0 ? 'update' : '',
//                //'mode'   => '',
//                'fileId' => $memberSetting[ 'nationCard' ],
//                'path'   => 'member.gifts'  //chanage
//            )
//        )
//    ) ) ) ;
//
//$form        .= $this->formW->colStart () ;
//$fileIdInput = \f\html::readyMarkup ( 'input', '',
//                                      array (
//            'htmlOptions' => array (
//                'type'  => 'hidden',
//                'name'  => 'picture',
//                'id'    => 'fileId',
//                'value' => $memberSetting[ 'picture' ]
//    ) ) ) ;
//
//$profilePic = \f\html::readyMarkup ( 'img', '',
//                                     array (
//            'htmlOptions' => array (
//                'src'      => \f\ifm::app ()->fileBaseUrl . $memberSetting[ 'picture' ],
//                'data-src' => \f\ifm::app ()->fileBaseUrl . $memberSetting[ 'picture' ],
//            ),
//            'style'       => array (
//                'position'   => 'absolute',
//                'left'       => '30px',
//                'top'        => "-35px",
//                'max-width'  => '50px',
//                'max-height' => '70px',
//                'display'    => $memberSetting[ 'picture' ] > 0 ? 'block' : 'none'
//            )
//        ) ) ;
//
////$profilePic .= $row[ 'profile_pic' ] == '' ? \f\ifm::t('noFileSelected') : '' ;
//
//$form .= \f\html::readyMarkup ( 'div', $fileIdInput . $profilePic,
//                                array (
//            'htmlOptions' => array (
//                'id'        => 'fileContainer3',
//                'data-type' => 'image'
//            ),
//            'style'       => array (
//                'margin-top' => '15px'
//            )
//                ), true ) ;
//
//$form .= $this->formW->colEnd () ;
//$form .= $this->formW->rowEnd () ;
$form .= $this->formW->rowStart () ;
$form .= $this->formW->buttonTag ( array (
    'htmlOptions' => array (
        'type' => 'submit',
    ),
    'content'     => '<i class="fa fa-floppy-o"></i> ' . (\f\ifm::t ( 'saveEdit' )),
        ) ) ;
$form .= $this->formW->rowEnd () ;


$form .= $this->formW->flush () ;

echo $form ;

echo $this->boxW->flush () ;
?>
<script>
    $(document).ready(function () {
        widgetHelper.makeSelect2('select', '<?= \f\ifm::t ( 'select' ) ?>');
        $('.date').each(function () {

            var selector = "#" + $(this).attr('id');
            var lang = 'fa';
            var newOption = {
            };
            var newOptionTo = {};
            widgetHelper.makeDatePicker(selector, lang, newOption, newOptionTo);

        });
    });
    widgetHelper.formSubmit('#portAdd');
    jQuery(document).ready(function ()
    {
        //$(".bodyParam").sortable();
        $("#addPrice").click(function () {
            $('select').select2('destroy');
            var row = $(".paramRow:first").clone();
            $(".bodyParam").append(row);

            widgetHelper.makeSelect2('select', '<?= \f\ifm::t ( 'select' ) ?>');

            $(".paramRow:last").find("select").each(function ()
            {
                $(this).select2('val', 'All');

            });
            $(".paramRow:last").find("input").each(function ()
            {
                $(this).val('');

            });
            $(".comma").keyup(function ()
            {
                addCommas(this);
            });
            $('.paramRow:last a.removeParam').on('click', function ()
            {
                var rowCount = $('.paramRow').length;
                if (rowCount > 1)
                {
                    $(this).closest('.paramRow').remove();
                } else
                {
                    alert('وارد کردن حداقل یک شماره الزامی است.');
                }
                return false;
            });
        });
        $('a.removeParam').on('click', function () {
            var rowCount = $('.paramRow').length;
            if (rowCount > 1)
            {
                $(this).closest('.paramRow').remove();
            } else
            {
                alert('وارد کردن حداقل یک شماره الزامی است.');
            }
            return false;
        });

    });
</script>