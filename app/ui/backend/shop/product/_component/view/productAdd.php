<?php
//\f\pre($row);
$title = $row ? 'editproduct' : 'addproduct' ;
/* @var $this membersView */

$this->registerWidgets ( array (
    'formW'      => 'form',
    'boxW'       => 'box',
    'pageTitleW' => 'pageTitle'
) ) ;

$statusArr = array (
    \f\ifm::t ( 'enable' )  => 'enabled',
    \f\ifm::t ( 'disable' ) => 'disabled',
        ) ;

$statusArr2 = array (
    \f\ifm::t ( 'yes' ) => 'enabled',
    \f\ifm::t ( 'no' )  => 'disabled',
        ) ;
//$this->

echo $this->pageTitleW->renderTitle ( array (
    'title' => \f\ifm::t ( $title ),
    'links' => array (
        array (
            'title' => \f\ifm::t ( 'listproduct' ),
            'href'  => \f\ifm::app ()->baseUrl . 'shop/product/index' ) ) ) ) ;


echo $this->boxW->begin ( array (
    'type'  => 'form',
    'title' => \f\ifm::t ( $title ) ) ) ;



$form = '' ;
$form.=$this->formW->begin ( array (
    'htmlOptions' => array (
        'method' => 'post',
        'action' => \f\ifm::app ()->baseUrl . 'shop/product/productSave',
        'id'     => 'product_Add'
    ),
        ) ) ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'  => 'hidden',
        'name'  => 'id',
        'id'    => 'id',
        'value' => $row[ 'id' ],
    ),
        ) ) ;

$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'  => 'hidden',
        'name'  => 'typeCat',
        'id'    => 'typeCat',
        'value' => '',
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
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'sub_title',
        'value' => $row[ 'sub_title' ],
    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'sub_title' ),
    ),
        ) ) ;
$form.=$this->formW->rowEnd () ;

//$form.=$this->formW->rowStart () ;
//$form.=$this->formW->select ( array (
//    'htmlOptions' => array (
//        'id'       => 'brand',
//        'name'     => 'brand',
//    ),
//    'label'       => array (
//        'text' => \f\ifm::t ( 'brand' ),
//    ),
//    'choices'     => $brand,
//    'selected'    => $row[ 'shop_brand_id' ] ? json_decode ( $row[ 'shop_brand_id' ], true ) : '',
//        ) ) ;
//
//$form.=$this->formW->rowEnd () ;


$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'  => 'hidden',
        'id'    => 'oldCat',
        'value' => $oldCat,
    ),
        ) ) ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'  => 'hidden',
        'id'    => 'oldCatAll',
        'value' => $oldCategoryAll,
    ),
) ) ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'  => 'hidden',
        'id'    => 'dynamicForm',
        'name'=>'dynamicForm',
        'value' => '',
    ),
) ) ;
/*
$form.=$this->formW->rowStart () ;
$form.='<div class="col-sm-10">'
        . '<label class="col-sm-3 control-label">بخش بندی محصول</label>'
        . '<div class="col-sm-9">'
        . '<select name="category" multiple="multiple" id="category" onChange="loadFeature()" data-parsley-required=""><option></option>' ;

foreach ( $category AS $data )
{
    if ( $row[ 'shop_category_id' ] == $data[ 'id' ] )
    {
        $selected = "selected" ;
    }
    else
    {
        $selected = "" ;
    }
    if($data['dynamic']=='true'){
        $dynamic='true';
    }else{
        $dynamic='false';
    }
    $form.='<option value="' . $data[ 'id' ] . '" id="' . $data[ 'parent' ] . '" ' . $selected . '  data-dynamic="'.$dynamic.'">'
            . $data[ 'title' ]
            . '</option>' ;
}
$form.= '</select>'
        . '</div>'
        . '<div class="clear"></div>'
        . '</div>' ;

$form.=$this->formW->rowEnd () ;*/

$form.=$this->formW->rowStart () ;
$form.=$this->formW->select ( array (
    'htmlOptions' => array (
        'id'       => 'category',
        'name'     => 'category[]',
        'onChange'=>'loadFeature(this)',
        'multiple' => TRUE
    ),
    'label'       => array (
        'text' =>'بخش بندی محصول' ,
    ),
    'choices'     => $category,
    'data_id'   => $arrayCatD,
    'selected'    => $row['shop_category_id'] ? json_decode ( $row[ 'shop_category_id' ], true ) : '',
) ) ;
$form.=$this->formW->rowEnd () ;


$form.=$this->formW->rowStart () ;
$form.=$this->formW->textarea ( array (
    'htmlOptions' => array (
        'name' => 'short_explanation',
        'rows' => '5'
    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'short_explanation' ),
    ),
    'style'       => array (
        'direction' => 'rtl',

    ),
    'content'     => $row[ 'short_explanation' ]
        ) ) ;

$form.=$this->formW->rowEnd () ;
//$form.=$this->formW->rowStart () ;
//$form.=$this->formW->textarea ( array (
//    'htmlOptions' => array (
//        'name' => 'content',
//    ),
//    'label'       => array (
//        'text' => \f\ifm::t ( 'content' )
//    ),
//    'editor'      => true,
//    'content'     => $row[ 'content' ]
//        ) ) ;
//
//$form.=$this->formW->rowEnd () ;
$form.=$this->formW->rowStart () ;
$form.=$this->formW->textarea ( array (
    'htmlOptions' => array (
        'name' => 'review',
    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'review' )
    ),
    'editor'      => true,
    'content'     => $row[ 'review' ]
        ) ) ;
$form.=$this->formW->rowEnd () ;
$form.=$this->formW->rowStart () ;
$form.=$this->formW->select ( array (
    'htmlOptions' => array (
        'id'       => 'related',
        'name'     => 'related[]',
        'multiple' => TRUE
    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'related' ),
    ),
    'choices'     => $product,
    'selected'    => $row[ 'related' ] ? json_decode ( $row[ 'related' ], true ) : '',
        ) ) ;

$form.=$this->formW->rowEnd () ;
/*
$form.=$this->formW->rowStart () ;
$form.=$this->formW->textarea ( array (
    'htmlOptions' => array (
        'name' => 'video',
    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'video' )
    ),
    'style'       => array (
        'direction' => 'ltr'
    ),
    'content'     => $row[ 'video' ]
        ) ) ;

$form.=$this->formW->rowEnd () ;
*/

$form.=$this->formW->rowStart () ;
$form.=$this->formW->radio ( array (
    'htmlOptions' => array (
        'name' => 'special',
    ),
    'choices'     => $statusArr2,
    'label'       => array (
        'text' => \f\ifm::t ( 'special' ),
    ),
    'checked'     => $row[ 'special' ] ? $row[ 'special' ] : 'disabled',
    'linear'      => TRUE
        ) ) ;
$form.=$this->formW->rowEnd () ;

/*
$form.=$this->formW->rowStart () ;
$form.=$this->formW->radio ( array (
    'htmlOptions' => array (
        'name' => 'gifts',
    ),
    'choices'     => $statusArr2,
    'label'       => array (
        'text' => \f\ifm::t ( 'gifts' ),
    ),
    'checked'     => $row[ 'special' ] ? $row[ 'special' ] : 'disabled',
    'linear'      => TRUE
        ) ) ;
$form.=$this->formW->rowEnd();
*/

$statusArr3 = array (
    \f\ifm::t ( 'yes' ) => 'yes',
    \f\ifm::t ( 'no' )      => 'no',
        ) ;

$form .= $this->formW->fieldsetStart(array(
    'legend' => array(
        'text' => \f\ifm::t('price')
    )
));
echo $form;
?>
<div style="border:1px solid #ddd " id="paramBox">
    <div style="background: #ddd;padding: 5px;" class="paramHeader">
        <div class="col-md-2 static" >رنگ</div>
        <div class="col-md-2 static" >اندازه</div>
        <div class="col-md-1 static" >موجودی</div>
        <div class="col-md-2 static">قیمت</div>
        <div class="col-md-2 dynamic" >قیمت برحسب متر مربع</div>
        <div class="col-md-9 dynamic" >انتخاب نوع کاغذ</div>
        <div class="col-md-2 static" >نوع تخفیف</div>
        <div class="col-md-2 static"> تخفیف</div>
        <div class="col-md-1">عملیات</div>
        <div class="clear"></div>
    </div>
    <div class="bodyParam">
        <?php

        /*session is started if you don't write this line can't use $_Session  global variable*/
      //  \f\pre($_SESSION);
        //\f\pre($m);
        $majorPrices =array_filter(array_column($price,'majorPrice'));
        $priceStatic=array_filter(array_column($price,'price'));

       //\f\pr($dynamic);
      /*  if($dynamic==true){
            $dynamic='true';
        }else{
            $dynamic='false';
        }*/
        //\f\pr($dynamic);
    // \f\pr($priceStatic);
    //  \f\pr($dynamic);

        if ((!empty ($priceStatic) and $dynamic=='false') or (!empty($majorPrices) and $dynamic=='true')) {
           //\f\pre($price);
            foreach ($price AS $data) {
                if($data['majorPrice']>0){
                    $typeRow='dynamic';
                }else{
                    $typeRow='static';
                }
                ?>
                <div style="padding: 5px;border-bottom: 1px solid #ddd;height:70px" class="paramRow <?=$typeRow?>">
                    <div class="col-md-2 static">
                        <input type="hidden" name="idPrice[]" id="id" value="<?= $data['id'] ?>">
                        <?php
                        echo $this->formW->select(array(
                            'htmlOptions' => array(
                                'id' => 'color',
                                'name' => 'color[]',
                            ),
                            'choices' => $color,
                            'selected' => $data['color_id'],
                            'block' => ''
                        ));
                        ?>
                    </div>
                    <div class="col-md-2 dynamic">
                        <?php
                        echo $this->formW->input(array(
                            'htmlOptions' => array(
                                'type' => 'text',
                                'name' => 'majorPrice[]',
                                'value' => number_format($data['majorPrice']),
                                'class' => 'comma'
                            ),
                            'block' => ''
                        ));
                        ?>
                    </div>
                    <div class="col-md-9 dynamic">
                        <?php
                        echo $this->formW->select(array(
                            'htmlOptions' => array(
                                'id' => 'material',
                                'name' => 'material[]',
                            ),
                            'choices' => $material,
                            'selected' => $data['material_id'],
                            'block' => ''
                        ));
                        ?>
                    </div>
                    <div class="col-md-2 static">
                        <?php
                        echo $this->formW->select(array(
                            'htmlOptions' => array(
                                'id' => 'guarantee',
                                'name' => 'guarantee[]',
                            ),
                            'choices' => $guarantee,
                            'selected' => $data['guarantee_id'],
                            'block' => ''
                        ));
                        ?>
                    </div>
                    <div class="col-md-1 static">
                        <?php
                        echo $this->formW->input(array(
                            'htmlOptions' => array(
                                'type' => 'text',
                                'name' => 'stock[]',
                                'value' => number_format($data['stock']),
                                'class' => 'comma'
                            ),
                            'block' => ''
                        ));
                        ?>
                    </div>
                    <div class="col-md-2 static">
                        <?php
                        echo $this->formW->input(array(
                            'htmlOptions' => array(
                                'type' => 'text',
                                'name' => 'price[]',
                                'value' => number_format($data['price']),
                                'class' => 'comma'
                            ),
                            'block' => ''
                        ));
                        ?>
                    </div>
                    <div class="col-md-2 static">
                        <?php
                        echo $this->formW->select(array(
                            'htmlOptions' => array(
                                'id' => 'type_discount',
                                'name' => 'type_discount[]',
                            ),
                            'choices' => array(
                                    'percent'=>'درصد',
                                    'fixed'=>'قیمت ثابت (ریال)'
                            ),
                            'selected' => $data['type_discount'],
                            'block' => ''
                        ));
                        ?>
                    </div>
                    <div class="col-md-2 static">
                        <?php
                        echo $this->formW->input ( array (
                            'htmlOptions' => array (
                                'type'  => 'text',
                                'name'  => 'discount[]',
                                'value' => $data[ 'discount' ],
                                'class' => 'comma'
                            ),
                            'block'       => ''
                        ) ) ;
                        ?>
                    </div>
                    <div class="col-md-1 ">
                        <a href="javascript:void(0)" class="removeParam">
                            <i class="fa fa-times-circle fa-2x" style="margin-top:12px"></i>
                        </a>
                    </div>
                    <div class="clear"></div>
                </div>
                <?
            }
        } else {
          //  \f\pr($majorPrices);
          //  \f\pre($dynamic);
            ?>
            <div style="padding: 5px;border-bottom: 1px solid #ddd;height:70px" class="paramRow">
                <div class="col-md-2 static">
                    <input type="hidden" name="idPrice[]" id="id" value="">
                    <?php
                    echo $this->formW->select(array(
                        'htmlOptions' => array(
                            'id' => 'color',
                            'name' => 'color[]',
                        ),
                        'choices' => $color,
                        'selected' => '',
                        'block' => ''
                    ));
                    ?>
                </div>
                <div class="col-md-2 dynamic">
                    <?php
                    echo $this->formW->input(array(
                        'htmlOptions' => array(
                            'type' => 'text',
                            'name' => 'majorPrice[]',
                            'value' => '',
                            'class' => 'comma'
                        ),
                        'block' => ''
                    ));
                    ?>
                </div>
                <div class="col-md-9 dynamic">
                    <?php
                    echo $this->formW->select(array(
                        'htmlOptions' => array(
                            'id' => 'material',
                            'name' => 'material[]',
                        ),
                        'choices' => $material,
                        'selected' => '',
                        'block' => ''
                    ));
                    ?>
                </div>
                <div class="col-md-2 static">
                    <?php
                    echo $this->formW->select(array(
                        'htmlOptions' => array(
                            'id' => 'guarantee',
                            'name' => 'guarantee[]',
                        ),
                        'choices' => $guarantee,
                        'selected' => '',
                        'block' => ''
                    ));
                    ?>
                </div>
                <div class="col-md-1 static">
                    <?php
                    echo $this->formW->input(array(
                        'htmlOptions' => array(
                            'type' => 'text',
                            'name' => 'stock[]',
                            'value' => $row['stock'],
                            'class' => 'comma'
                        ),
                        'block' => ''
                    ));
                    ?>
                </div>
                <div class="col-md-2 static">
                    <?php
                    echo $this->formW->input(array(
                        'htmlOptions' => array(
                            'type' => 'text',
                            'name' => 'price[]',
                            'value' => $row['price'],
                            'class' => 'comma'
                        ),
                        'block' => ''
                    ));
                    ?>
                </div>
                <div class="col-md-2 static">
                    <?php
                    echo $this->formW->select(array(
                        'htmlOptions' => array(
                            'id' => 'type_discount',
                            'name' => 'type_discount[]',
                        ),
                        'choices' => array(
                            'percent'=>'درصد',
                            'fixed'=>'مبلغ ثابت (ریال)'
                        ),
                        'selected' => '',
                        'block' => ''
                    ));
                    ?>
                </div>
                <div class="col-md-2 static">

                    <?php
                    echo $this->formW->input ( array (
                        'htmlOptions' => array (
                            'type'  => 'text',
                            'name'  => 'discount[]',
                            'value' => $row[ 'discount' ],
                            'class' => 'comma'
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
            </div>
            <?php
        }
        ?>


    </div>

</div>
<br>
<a class="btn btn-success pull-right" href='javascript:void(0)' id ='addPrice'><i class='fa fa-plus-circle'></i> <?= 'اضافه کردن قیمت جدید' ?></a>
<?
if ( $row[ 'id' ] )
{
    $this->registerGadgets ( array (
        'dateG' => 'date' ) ) ;
    ?>
    <div class="pull-left" style="padding-right: 10px">
        <div class="simple-checkbox simple-checkbox-inline">
            <input type="checkbox" name="history" id="history" value="1"> 
            <label for="history"><?= \f\ifm::t ( 'history' ) ?></label>
        </div>
    </div>

    <div class="alert alert-info pull-left" style="font-size:11px;padding:6px">
        <i class="fa fa-info-circle"></i> آخرین آرشیو در تاریخ :
        <?php
        echo $this->dateG->dateTime ( $history[ 'date_register' ], 2 ) . ' ساعت : ' . date ( 'H:i',
                                                                                             $history[ 'date_register' ] )
        ?>
    </div>

    <?php
}
$form = $this->formW->fieldsetEnd () ;

$form.=$this->formW->fieldsetStart ( array (
    'legend' => array (
        'text' => \f\ifm::t ( 'feature' )
    )
) ) ;
$form.='<div id="feature">'
    . '<div class="alert alert-warning"><i class="fa fa-warning"></i> جهت درج مشخصات فنی لطفا بخش بندی محصول را انتخاب کنید.</div>'
    . '</div>' ;


//newsletter choies
//$form.=$this->formW->fieldsetStart ( array (
//    'legend' => array (
//        'text' => \f\ifm::t ( 'newsletter' )
//    )
//        ) ) ;
//$form.=$this->formW->rowStart () ;
//$choices = array (
//    'emailSend' => \f\ifm::t ( 'emailSend' ),
//        ) ;
//$form.=$this->formW->checkbox2 ( array (
//    'htmlOptions' => array (
//        'name'  => 'checkbox[]',
//        'class' => 'info',
//    ),
//    'choices'     => $choices,
//        ) ) ;
//$form.=$this->formW->rowEnd () ;
//$form.=$this->formW->fieldsetEnd () ;
$form.=$this->formW->fieldsetStart ( array (
    'legend' => array (
        'text' => \f\ifm::t ( 'numGift' ),
        'style'=>array(
                'font-size'=>'18px',
                'padding-bottom'=>'3px'
        )
    )
) ) ;

//\f\pre($row);
$form.=$this->formW->rowStart () ;
$form.='<input type="checkbox" name="enable_gift" class="enable_gift" '.$checkedInput.' >';
$form.='<span style="display:inline-block;margin-top:10px;padding-right:5px">فعال</span>';
$form.=$this->formW->rowEnd () ;
$form.='<div class="gift_section">';
$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'n_buy',
        'value' => $row[ 'n_buy' ],
    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'n_buy' ),
    ),
) ) ;
$form.=$this->formW->rowEnd () ;
$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'm_free',
        'value' => $row[ 'm_free' ],
    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'm_free' ),
    ),
) ) ;
$form.=$this->formW->rowEnd () ;
$form.=$this->formW->rowStart () ;
$form.=$this->formW->rowStart () ;
$form.=$this->formW->select ( array (
    'htmlOptions' => array (
        'id' => 'shop_product_gift_id',
        'name' => 'shop_product_gift_id',
    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'shop_product_gift' ),
    ),
    'choices' => $colorGuarantee,
    'selected'    => $row[ 'shop_product_gift_id' ] ? $row[ 'shop_product_gift_id' ] : '',
) ) ;

$form.=$this->formW->rowEnd () ;

$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'gift_text',
        'value' => $row[ 'gift_text' ],
    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'gift_text' ),
    ),
) ) ;
$form.=$this->formW->rowEnd () ;
$form.='</div>';
$form.=$this->formW->fieldsetEnd () ;

$form.=$this->formW->fieldsetStart ( array (
    'legend' => array (
        'text' => \f\ifm::t ( 'gallery' )
    )
        ) ) ;
if($row['dynamic']=='true') {
    $form .='<label> پهنای 750 پیکسل برای تصویر کاور مربوط به محصول در دسته بندی داینامیک</label>';
}
$form.='<input type="hidden" name="num_pic" id="num_pic" value="' . $numPic . '">' ;
$form.='<input type="hidden" name="picture" id="picture" value="' . $cover . '">' ;

$form.=$this->formW->buttonTag ( array (
    'htmlOptions' => array (
        'type'  => 'button',
        'id'    => 'selectProfilePicBtn',
        'class' => 'btn btn-custom-primary btn-md'
    ),
    'content'     => '<i class="fa fa-upload"></i> ' . 'آپلود تصویر جدید',
    'action'      => array (
        'preServerSideAction' => array (
            'route'   => 'core.fileManager.registerUploadSession',
            'options' => array (
                //change
                'multiUpload' => 10,
                'extensions'  => '.jpg, .png, .bmp, .jpeg,.gif',
                'tasks'       => array (
                    'upload' )
            ),
        ),
        'display'             => 'dialog',
        'params'              => array (
            'targetRoute'    => "shop.product.galleryPic",
            'triggerElement' => 'selectProfilePicBtn', //chanage
            'containerId'    => '#fileContainer',
            'urlParams'      => array (
                'path' => 'shop.product.' . $id //chanage
            ),
            'dialogTitle'    => \f\ifm::t ( "fileUpload" ),
            'ajaxParams'     => array (
                'mode'   => '',
                'fileId' => '',
                'path'   => 'shop.product.' . $id, //chanage
                'func'   => 'refreshGallery',
            )
        )
    ) ) ) ;
$form.='<br>
<div class="row list-group king-gallery" style="margin:30px 3px 0px">' ;
$form.=$gallery ;
$form.='<div class="clearfix"></div></div>' ;

$form.=$this->formW->fieldsetEnd () ;
$form.='<br></br>' ;
$form.=$this->formW->rowStart () ;
$form.=$this->formW->buttonTag ( array (
    'htmlOptions' => array (
        'type' => 'submit',
    ),
    'content'     => '<i class="fa fa-floppy-o"></i> ' . ($row ? \f\ifm::t ( 'saveEditp' ) : \f\ifm::t ( 'saveNewp' )),
        ) ) ;
$form.=$this->formW->rowEnd () ;


$form.=$this->formW->flush () ;

echo $form ;

echo $this->boxW->flush () ;
?>

<script>
    widgetHelper.makeSelect2('select', '<?= \f\ifm::t ( 'select' ) ?>');
    widgetHelper.formSubmit('#product_Add');
</script>
<script>
<?php
if ( $row[ 'id' ] )
{
    ?>
        loadData();
    <?php
}
?>
$('.enable_gift:checkbox').change(function () {
    if (this.checked) {
        $('.gift_section').slideDown('slow');
    } else {
        $('.gift_section').slideUp('slow');
    }
});
    function refreshGallery(params)
    {
        params['galId'] = '<?= $id ?>';
        widgetHelper.tt('ui', 'shop.product.addPic', params, 'addPic')
    }
    function addPic(params)
    {
        $('.king-gallery').prepend(params.content);
        var numPic = parseInt($('#num_pic').val()) + 1;
        $('#num_pic').val(numPic);
        $('.modal').modal('hide');
        $('[data-toggle=confirmation]').confirmation();

        var cover = $('#picture').val();
        if (!cover)
        {
            $('#picture').val(params.fileId);
        }
    }
    function removePic(params)
    {
        $('#pic' + params.id).remove();
        var numPic = parseInt($('#num_pic').val()) - 1;
        $('#num_pic').val(numPic);
        var cover = parseInt($('#picture').val());

        if (cover == params.id)
        {
            $('#picture').val('');
        }
    }
    function coverPic(id)
    {
        $('.king-gallery .item').each(function (i, e)
        {
            if (e.id === 'pic' + id)
            {
                $('#pic' + id + ' .thumbnail').css('border', '2px dotted #34A6C8');
            } else
            {
                $('#' + e.id + ' .thumbnail').css('border', '');
            }
        });
        $('#picture').val(id);
    }

    jQuery(document).ready(function ()
    {
        loadData();
        $('.enable_gift:checkbox').change();
        //$(".bodyParam").sortable();
        $("#addPrice").click(function () {

            $('select').select2('destroy');

            var row = $(".paramRow:last").clone();

if($('#typeCat').val()=='true'){
    row[0]['className']='paramRow dynamic displayShow';
}else{
    row[0]['className']='paramRow static displayShow';
}

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
                    alert('وارد کردن حداقل یک سطر برای قیمت الزامی است.');
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
                alert('وارد کردن حداقل یک سطر برای قیمت الزامی است.');
            }
            return false;
        });

    });


function diff(A, B) {
    return A.filter(function (a) {
        return B.indexOf(a) == -1;
    });
}


    function loadFeature(item)
    {
        var oldCat = $('#oldCat').val();
        var strVal=$(item).val();
        var oldCatAllArr=String($('#oldCatAll').val()).split(',').map(Number);
        var strValArr=String(strVal).split(',').map(Number);
        var diffrence=diff(strValArr,oldCatAllArr);
      //  console.log(oldCat);
        var typeCatNew=$('#category option[value="' + diffrence[0] + '"]').attr('data_id');
        var typeCatOld=$('#category option[value="' + oldCat + '"]').attr('data_id');


        if(oldCat>0){
            var typeCat=$('#category option[value="' + oldCat + '"]').attr('data_id');
        }else{
            var typeCat=typeCatNew;
        }

       // console.log(typeCatNew);
        //console.log(typeCatOld);

        if(typeCatNew==typeCatOld || typeof typeCatNew === "undefined" || typeof typeCatOld === "undefined"){
            loadData();
        }else{
            $('#catNotSelectDialog').modal({backdrop: 'static', keyboard: false});
        }

    }

    function loadData()
    {
        var oldCat = $('#oldCat').val();


        if(oldCat>0 ){
            var typeCat=$('#category option[value="' + oldCat + '"]').attr('data_id');
        }else{
            var strVal=$('#category').val();
            var oldCatAllArr=String($('#oldCatAll').val()).split(',').map(Number);
            var strValArr=String(strVal).split(',').map(Number);
            var diffrence=diff(strValArr,oldCatAllArr);
            var typeCat=$('#category option[value="' + diffrence[0] + '"]').attr('data_id');
        }

        if(typeCat=='true'){
            $('.dynamic').addClass('displayShow');
            $('.dynamic').removeClass('displayHide');
            $('.static').addClass('displayHide');
            $('.static').removeClass('displayShow');
            $('#typeCat').val('true');
        }else{
            $('.dynamic').addClass('displayHide');
            $('.dynamic').removeClass('displayShow');
            $('.static').addClass('displayShow');
            $('.static').removeClass('displayHide');
            $('#typeCat').val('false');
        }


       if(oldCat==null || oldCat=='null' || oldCat==''){
            var diffrence=String($('#category').val()).split(',').map(Number);
        }else {
            var strVal = $("#category").val();
            var oldCatAllArr = String($('#oldCatAll').val()).split(',').map(Number);
            var strValArr = String(strVal).split(',').map(Number);
            var diffrence = diff(strValArr, oldCatAllArr);

        }

        //console.log(oldCatAllArr[0]);
        var oldCatAllArr = String($('#oldCatAll').val()).split(',').map(Number);

       console.log(oldCatAllArr[0]);
        var oldCat=String($('#oldCatAll').val()).split(',').pop();
        console.log(diffrence[0]);
       //alert(oldCat);
        var params = {
            id: $('#category').val(),
            pId: $('#id').val(),
            catType:$('#typeCat').val(),
            oldCat:oldCatAllArr[0],
            lastCat:diffrence[0]
        };
        widgetHelper.tt('ui', 'shop.product.loadFeature', params, 'featureForm');

        if( diffrence.length>0){
            $('#oldCat').val(diffrence[0]);
        }


    }

    function cancelLoadData()
    {
        //change string to array olCatAll value
        var arrayOfOldCatAlll=$('#oldCatAll').val().split(",");

        //set values select options
        var values=$('#oldCatAll').val();
        $.each(values.split(","), function(i,e){
            $("#category option[value='" + e + "']").prop("selected", true);
        });

        //set values select2 of category id
        $('#category').select2('val', arrayOfOldCatAlll);
    }
    function featureForm(params)
    {
        if(params.content=='error'){
           $('#catNotSelectFeatureDialog').modal({backdrop: 'static', keyboard: false});
        }else {
            $('#oldCatAll').val($('#category').val());
        }
        $('#dynamicForm').val(params.dynamic);
        
        if(params.dynamic=='true'){
            $('#dynamicForm').val('dynamic');
        }else{
            $('#dynamicForm').val('static');
        }
        if(params.content!='error') {
            $('#feature').html(params.content);
        }
        widgetHelper.makeSelect2('select', '<?= \f\ifm::t ( 'select' ) ?>');
    }

    function confirmNewProduct()
    {
        $('#newProduct').modal({backdrop: 'static', keyboard: false});
    }

    function closeDialog() {
        $('#catNotSelectDialog').modal('toggle');
    }
</script>


<div class="modal fade" id="newProduct" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header dialog-header-success">
                <h4 class="modal-title" id="myModalLabel"><i class="fa fa-check-circle"></i> پیغام سیستم</h4>
            </div>
            <div class="modal-body">
                <?= "محصول با موفقیت ثبت شد. آیا می خواهید محصول جدیدی ثبت کنید؟" ?>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-danger" onclick="window.location = '<?= \f\ifm::app ()->baseUrl . 'shop/product/index' ?>';">نه ! همین بسه...</button>
                <button type="button" data-dismiss="modal" class="btn btn-primary" onclick="location.reload();">بله ! بازم می خوام ...</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="catDialog" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header dialog-header-warning">
                <h4 class="modal-title" id="myModalLabel"><i class="fa fa-warning"></i> هشدار سیستم</h4>
            </div>
            <div class="modal-body">
                <?= "با تغییر دسته بندی مقدار مشخصات فنی دوباره بارگذاری خواهد شد!" ?>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-danger" onclick="cancelLoadData()">نه ! اطلاعات فعلی رو میخوام ...</button>
                <button type="button" data-dismiss="modal" class="btn btn-primary" onclick="loadData()"> باشه ! اشکالی نداره ...</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="catNotSelectDialog" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header dialog-header-warning">
                <h4 class="modal-title" id="myModalLabel"><i class="fa fa-warning"></i> هشدار سیستم</h4>
            </div>
            <div class="modal-body">
                <?= " نوع دسته بندی بایستی با اولین دسته بندی انتخاب شده منطبق باشد!" ?>
            </div>
            <button type="button" data-dismiss="modal" class="btn btn-danger" onclick="cancelLoadData()">بستن </button>

        </div>
    </div>
</div>


<div class="modal fade" id="catNotSelectFeatureDialog" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header dialog-header-warning">
                <h4 class="modal-title" id="myModalLabel"><i class="fa fa-warning"></i> هشدار سیستم</h4>
            </div>
            <div class="modal-body">
                <?= "مشخصات فنی بایستی با اولین دسته بندی انتخاب شده منطبق باشد!" ?>
            </div>
            <button type="button" data-dismiss="modal" class="btn btn-danger" onclick="cancelLoadData()">بستن </button>

        </div>
    </div>
</div>
<style>
    .displayShow{
        display:block;
    }
    .displayHide{
        display:none;
    }
</style>