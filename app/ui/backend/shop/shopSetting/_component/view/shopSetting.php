<?php
/* @var $this smsCenterView */

$this->registerWidgets ( array (
    'formW'      => 'form',
    'boxW'       => 'box',
    'pageTitleW' => 'pageTitle'
) ) ;

echo $this->pageTitleW->renderTitle ( array (
    'title' => \f\ifm::t ( 'shopSetting' ),
) ) ;


echo $this->boxW->begin ( array (
    'type'  => 'form',
    'title' => \f\ifm::t ( 'shopSetting' ) ) ) ;



$form = '' ;
echo $this->formW->begin ( array (
    'htmlOptions' => array (
        'method' => 'post',
        'action' => \f\ifm::app ()->baseUrl . 'shop/shopSetting/settingSave',
        'id'     => 'portAdd'
    ),
        ) ) ;

echo $this->formW->fieldsetStart(array(
    'legend' => array(
        'text' => \f\ifm::t('refundsMobileNumber'),
        'style' => array(
            'font-size' => '16px',
            'padding-bottom' => '10px',
            'font-weight' => 'bolder',
        )
    ),

));

?>
<div style="border:1px solid #ddd " id="paramBox">
    <div style="background: #ddd;padding: 5px;" class="paramHeader">
        <div class="col-md-3">شماره موبایل</div>
        <div class="col-md-1">عملیات</div>
        <div class="clear"></div>
    </div>
    <div class="bodyParam">
        <?php
        if (!empty ($shopSetting['mobileNumber'])) {
            foreach ($shopSetting['mobileNumber'] AS $data) {
                //$id = $data[ 'id' ] ;
                ?>
                <div style="padding: 5px;border-bottom: 1px solid #ddd;" class="paramRow"><div class="col-md-3">
                        <?php
                        echo $this->formW->input ( array (
                            'htmlOptions' => array (
                                'type'  => 'text',
                                'name'  => 'mobileNumber[]',
                                'value' => $data,
                            ),
                            'block'       => ''
                        ) ) ;
                        ?>
                    </div>
                    <div class="col-md-1">
                        <a href="javascript:void(0)" class="removeParam">
                            <i class="fa fa-times-circle fa-2x" style="margin-top:12px"></i>
                        </a>
                    </div>

                    <div class="clear"></div>
                </div>
                <?
            }
        } else {
            ?>
            <div style="padding: 5px;border-bottom: 1px solid #ddd;" class="paramRow">
                <div class="col-md-3">
                    <?php
                    echo $this->formW->input ( array (
                        'htmlOptions' => array (
                            'type'  => 'text',
                            'name'  => 'mobileNumber[]',
                            'value' => $row[ 'mobileNumber' ],
                        ),
                        'block'       => ''
                    ) ) ;
                    ?>
                </div>
                <div class="col-md-1">
                    <a href="javascript:void(0)" class="removeParam">
                        <i class="fa fa-times-circle fa-2x" style="margin-top:12px"></i>
                    </a>
                </div>
                <div class="clear"></div>
            </div>
            <?php
        }
        ?>


    </div>

</div>
<br>
<br>
<a class="btn btn-success pull-right" href='javascript:void(0)' id ='addPrice'><i class='fa fa-plus-circle'></i> <?= 'اضافه کردن شماره جدید' ?></a>
<?php
$form.=$this->formW->fieldsetEnd () ;

$form .= $this->formW->rowStart () ;
$form .= $this->formW->input ( array (
    'htmlOptions' => array (
        'type'        => 'text',
        'name'        => 'cartTimeCredit',
        'value'       => $shopSetting[ 'cartTimeCredit' ],
        'placeholder' => \f\ifm::t ( 'cartTimeCreditMsg' )
    ),
    'validation'  => array (
        'required' => '',
        'type'     => 'number'
    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'cartTimeCredit' ),
    ),
        ) ) ;
$form .= $this->formW->rowEnd () ;

/*

$form .= $this->formW->rowStart () ;
$form .= $this->formW->input ( array (
    'htmlOptions' => array (
        'type'        => 'text',
        'name'        => 'leastBuy',
        'value'       => $shopSetting[ 'leastBuy' ],
        'placeholder' => \f\ifm::t ( 'leastBuy' )
    ),
    'validation'  => array (
        'required' => '',
        'type'     => 'number'
    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'leastBuy' ),
    ),
) ) ;
$form .= $this->formW->rowEnd () ;
*/


//$form .= $this->formW->rowStart () ;
//$form .= $this->formW->input ( array (
//    'htmlOptions' => array (
//        'type'        => 'text',
//        'name'        => 'numUseDiscountCard',
//        'value'       => $shopSetting[ 'numUseDiscountCard' ],
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
//        'value'       => $shopSetting[ 'mainPageText' ],
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
//        'value'       => $shopSetting[ 'mainPageTexth2' ],
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
//    'content' => $shopSetting[ 'newsletterPageText' ]
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
//    'content' => $shopSetting[ 'mainPageText' ]
//        ) ) ;
//
//$form.=$this->formW->rowEnd () ;
//$form.=$this->formW->rowStart () ;
//$form.=$this->formW->input ( array (
//    'htmlOptions' => array (
//        'type'       => 'text',
//        'name'       => 'roll',
//        'value'      => $shopSetting[ 'roll' ],
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
//                'path' => 'shop.gifts' //chanage
//            ),
//            'dialogTitle'    => \f\ifm::t ( "fileUpload" ),
//            'ajaxParams'     => array (
//                'mode'   => $shopSetting[ 'nationCard' ] > 0 ? 'update' : '',
//                //'mode'   => '',
//                'fileId' => $shopSetting[ 'nationCard' ],
//                'path'   => 'shop.gifts'  //chanage
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
//                'value' => $shopSetting[ 'picture' ]
//    ) ) ) ;
//
//$profilePic = \f\html::readyMarkup ( 'img', '',
//                                     array (
//            'htmlOptions' => array (
//                'src'      => \f\ifm::app ()->fileBaseUrl . $shopSetting[ 'picture' ],
//                'data-src' => \f\ifm::app ()->fileBaseUrl . $shopSetting[ 'picture' ],
//            ),
//            'style'       => array (
//                'position'   => 'absolute',
//                'left'       => '30px',
//                'top'        => "-35px",
//                'max-width'  => '50px',
//                'max-height' => '70px',
//                'display'    => $shopSetting[ 'picture' ] > 0 ? 'block' : 'none'
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