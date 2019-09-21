<?php
$buy_btn_option = array('on' => 'فعال' , 'off' => 'غیرفعال');
$show_index_option = array('enabled' => 'فعال' , 'disabled' => 'غیرفعال');
$title = $row ? 'editcategory' : 'addcategory' ;
/* @var $this membersView */

$this->registerWidgets ( array (
    'formW'      => 'form',
    'boxW'       => 'box',
    'pageTitleW' => 'pageTitle'
) ) ;


//$this->

echo $this->pageTitleW->renderTitle ( array (
    'title' => \f\ifm::t ( $title ),
    'links' => array (
        array (
            'title' => \f\ifm::t ( 'listcategory' ),
            'href'  => \f\ifm::app ()->baseUrl . 'shop/category/index' ) ) ) ) ;


echo $this->boxW->begin ( array (
    'type'  => 'form',
    'title' => \f\ifm::t ( $title ) ) ) ;



$form = '' ;
$form.=$this->formW->begin ( array (
    'htmlOptions' => array (
        'method' => 'post',
        'action' => \f\ifm::app ()->baseUrl . 'shop/category/categorySave',
        'id'     => 'categoryAdd'
    ),
        ) ) ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'  => 'hidden',
        'name'  => 'id',
        'value' => $row[ 'id' ],
    ),
        ) ) ;
$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'title',
        'value' => $row[ 'title' ],
    ),
    'validation'  => array (
        'required' => ''
    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'title' ),
    ),
        ) ) ;
$form.=$this->formW->rowEnd () ;

$form.=$this->formW->rowStart () ;
$form.=$state ;
$form.=$this->formW->rowEnd () ;

$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'title_en',
        'value' => $row[ 'title_en' ],
    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'title_en' ),
    ),
    'style'       => array (
        'direction' => 'ltr'
    )
        ) ) ;

$form.=$this->formW->rowEnd () ;

$form.=$this->formW->rowStart () ;
$form.=$this->formW->select ( array (
    'htmlOptions' => array (
        'id'       => 'rating_options',
        'name'     => 'rating_options[]',
        'multiple' => TRUE
    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'rating_options' ),
    ),
    'choices'     => $rating,
    'selected'    => $row[ 'rating_options' ] ? json_decode ( $row[ 'rating_options' ], true ) : '',
        ) ) ;
$form.=$this->formW->rowEnd () ;


$form.=$this->formW->rowStart () ;
$form.=$this->formW->select ( array (
    'htmlOptions' => array (
        'id'    => 'parent_id',
        'name'  => 'parent_id',
        'class' => 'parent_id'
    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'parent' )
    ),
    'choices'     => $sort,
    'selected'    => $row[ 'parent_id' ] ? $row[ 'parent_id' ] : ''
        ) ) ;
$form.=$this->formW->rowEnd () ;

/*
$form.=$this->formW->rowStart () ;
$form.=$this->formW->select ( array (
    'htmlOptions' => array (
        'id'    => 'buy_btn',
        'name'  => 'buy_btn',
        'class' => 'buy_btn'
    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'buy_btn' )
    ),
    'choices'     => $buy_btn_option,
    'selected'    => $row[ 'buy_btn' ] ? $row[ 'buy_btn' ] : ''
) ) ;
$form.=$this->formW->rowEnd () ;

$form.=$this->formW->rowStart () ;
$form.=$this->formW->select ( array (
    'htmlOptions' => array (
        'id'    => 'show_index',
        'name'  => 'show_index',
        'class' => 'show_index'
    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'show_index' )
    ),
    'choices'     => $show_index_option,
    'selected'    => $row[ 'show_index' ] ? $row[ 'show_index' ] : ''
) ) ;
$form.=$this->formW->rowEnd () ;
*/

$form.=$this->formW->rowStart () ;
$form.=$this->formW->buttonTag ( array (
    'htmlOptions' => array (
        'type'  => 'button',
        'id'    => 'selectProfilePicBtn',
        'class' => 'btn btn-default'
    ),
    'content'     => '<i class="fa fa-upload"></i> ' . \f\ifm::t ( 'fileSelect' ),
    'label'       => array (
        'text' => \f\ifm::t ( 'picContent' ),
    ),
    'action'      => array (
        'preServerSideAction' => array (
            'route'   => 'core.fileManager.registerUploadSession',
            'options' => array (
                //change
                'multiUpload' => 10,
                'extensions'  => '.jpg, .png, .bmp, .jpeg',
                'tasks'       => array (
                    'upload',
                    'select' )
            ),
        ),
        'display'             => 'dialog',
        'params'              => array (
            'targetRoute'    => "core.fileManager.getUploadForm",
            'triggerElement' => 'selectProfilePicBtn', //chanage
            'containerId'    => '#fileContainer',
            'urlParams'      => array (
                'path' => 'shop.category' //chanage
            ),
            'dialogTitle'    => \f\ifm::t ( "fileUpload" ),
            'ajaxParams'     => array (
                'mode'   => $row[ 'picture' ] == '' ? '' : 'update',
                'fileId' => $row[ 'picture' ],
                'path'   => 'shop.category'  //chanage
            )
        )
    ) ) ) ;

$form .= $this->formW->colStart () ;

$fileIdInput = \f\html::readyMarkup ( 'input', '',
                                      array (
            'htmlOptions' => array (
                'type'  => 'hidden',
                'name'  => 'picture',
                'id'    => 'fileId',
                'value' => $row[ 'picture' ]
    ) ) ) ;

$profilePic = \f\html::readyMarkup ( 'img', '',
                                     array (
            'htmlOptions' => array (
                'src'      => \f\ifm::app ()->fileBaseUrl . $row[ 'picture' ],
                'data-src' => \f\ifm::app ()->fileBaseUrl . $row[ 'picture' ],
            ),
            'style'       => array (
                'position'   => 'absolute',
                'left'       => '30px',
                'top'        => "-35px",
                'max-width'  => '50px',
                'max-height' => '70px',
                'display'    => $row[ 'picture' ] == '' ? 'none' : 'block'
            )
        ) ) ;

//$profilePic .= $row[ 'profile_pic' ] == '' ? \f\ifm::t('noFileSelected') : '' ;

$form.= \f\html::readyMarkup ( 'div', $fileIdInput . $profilePic,
                               array (
            'htmlOptions' => array (
                'id'        => 'fileContainer',
                'data-type' => 'image'
            ),
            'style'       => array (
                'margin-top' => '15px'
            )
                ), true ) ;

$form .= $this->formW->colEnd () ;
$form.=$this->formW->rowEnd () ;

if($row['dynamic']=='true'){
    $checkedInput='checked';
}else{
    $checkedInput='';
}
$form.=$this->formW->rowStart () ;
$form.='<input type="checkbox" name="dynamic" '.$checkedInput.' style="margin-right:20px;">';
$form.='<span style="display:inline-block;margin-top:10px;padding-right:5px">داینامیک</span>';
$form.=$this->formW->rowEnd () ;

$form.=$this->formW->fieldsetStart ( array (
    'legend' => array (
        'text' => \f\ifm::t ( 'feature' )
    )
        ) ) ;
echo $form ;
?>
<div style="border:1px solid #ddd " id="paramBox">
    <div style="background: #ddd;padding: 5px;" class="paramHeader">
        <div class="col-md-11">عنوان</div>
        <div class="col-md-1">عملیات</div>
        <div class="clear"></div>
    </div>
    <div class="bodyParam">
        <?php
        if ( ! empty ( $parameter ) )
        {
            foreach ( $parameter AS $data )
            {
                $id = $data[ 'id' ] ;
                ?>
                <div style="padding: 5px;border-bottom: 1px solid #ddd;cursor: move" class="paramRow">
                    <div class="col-md-11">

                        <input type="hidden" name="idFeature[]" id="id" value="<?=$data['id']?>">
                        <?php
                        echo $this->formW->select ( array (
                            'htmlOptions' => array (
                                'id'   => 'feature_id',
                                'name' => 'feature_id[]',
                            ),
                            'choices'     => $feature,
                            'selected'    => $data['shop_feature_id'],
                            'block'       => ''
                        ) ) ;
                        ?>
                    </div>

                    <div class="col-md-1">
                        <a href="javascript:void(0)" class="removeParam">
                            <i class="fa fa-times-circle fa-2x"  style="margin-top:12px"></i>
                        </a>
                    </div>
                    <div class="clear"></div>
                </div>
                <?
            }
        }
        else
        {
            ?>
            <div style="padding: 5px;border-bottom: 1px solid #ddd;cursor: move" class="paramRow">
                <div class="col-md-11">

                    <input type="hidden" name="idFeature[]" id="id" value="">
                    <?php
                    echo $this->formW->select ( array (
                        'htmlOptions' => array (
                            'id'   => 'feature_id',
                            'name' => 'feature_id[]',
                        ),
                        'choices'     => $feature,
                        'selected'    => '',
                        'block'       => ''
                    ) ) ;
                    ?>
                </div>

                <div class="col-md-1">
                    <a href="javascript:void(0)" class="removeParam">
                        <i class="fa fa-times-circle fa-2x"  style="margin-top:12px"></i>
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
<a href='javascript:void(0)' id ='addParam'><i class='fa fa-plus-circle fa-2x'></i> <?= 'اضافه کردن مشخصات فنی جدید' ?></a>
<?php
$form = $this->formW->fieldsetEnd () ;

$form.='<br></br>' ;
$form.=$this->formW->rowStart () ;
$form.=$this->formW->buttonTag ( array (
    'htmlOptions' => array (
        'type' => 'submit',
    ),
    'content'     => '<i class="fa fa-floppy-o"></i> ' . ($row ? \f\ifm::t ( 'saveEdit' ) : \f\ifm::t ( 'saveNew' )),
        ) ) ;
$form.=$this->formW->rowEnd () ;


$form.=$this->formW->flush () ;

echo $form ;

echo $this->boxW->flush () ;
?>

<script>
    widgetHelper.makeSelect2('select', '<?= \f\ifm::t ( 'select' ) ?>');
    widgetHelper.formSubmit('#categoryAdd');

    jQuery(document).ready(function ()
    {
        $(".bodyParam").sortable();
        $("#addParam").click(function () {
            $('select').select2('destroy');
            var row = $(".paramRow:first").clone();
            $(".bodyParam").append(row);

            widgetHelper.makeSelect2('select', '<?= \f\ifm::t ( 'select' ) ?>');

            $(".paramRow:last").find("select").each(function ()
            {
                $(this).select2('val', 'All');

            });
            $('.paramRow:last a.removeParam').on('click', function ()
            {
                var rowCount = $('.paramRow').length;
                if (rowCount > 1)
                {
                    $(this).closest('.paramRow').remove();
                } else
                {
                    alert('وارد کردن حداقل یک سطر برای مشخصات فنی الزامی است.');
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
                alert('وارد کردن حداقل یک سطر برای مشخصات فنی الزامی است.');
            }
            return false;
        });
        $(".comma").keyup(function ()
        {
            addCommas(this);
        });
    });

</script>