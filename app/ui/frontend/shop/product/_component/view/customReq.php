
<section class="grayBack dir-rtl">
    <div class="container">
        <div>
            <div class="url-page-box marginTop120">
                <div class="page-address-box padding-addressBar">
                    <i style="padding-left:3px;" class="fa fa-home"></i>
                    <a href="<?= \f\ifm::app ()->siteUrl ?>"><span class="address-name">خانه</span></a><span
                            class="arrow-address5 fa fa-angle-right"></span><span class="address-name"> ارسال درخواست پوستر سفارشی </span>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="grid-row ">
            <div class="col-md-12 ">
                <div class="content-boxed">

                    <h6 style="padding-right:10px;padding-left:10px;">- وارد کردن فیلدهای ستاره دار الزامی می باشد.</h6>
                    <h6 style="padding-right:10px;padding-left:10px;">- جهت مشخص شدن قیمت لطفا در ابتدا طول و ارتفاع  و سپس جنس کاغذ دیواری را انتخاب کنید.</h6>
            <form name="customRequestProduct" id="customRequestProduct"  method="post" action="<?php echo \f\ifm::app()->siteUrl.'shop/product/sendCustomProductRequest'?>" >
                <div class="form-group">
                    <label class="control-label col-sm-2" for="width"><span class="redStar">*</span>طول (سانتی متر):</label>
                    <div class="col-sm-10 marginBtn10">
                        <input type="text" class="form-control" name="width" id="width" placeholder="طول مورد نظر خود برای پوستر را انتخاب کنید.">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="height"><span class="redStar">*</span> ارتفاع (سانتی متر):</label>
                    <div class="col-sm-10 marginBtn10">
                        <input type="text" class="form-control" name="height" id="height" placeholder="ارتفاع مورد نظر خود برای پوستر را وارد کنید.">
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2" for="description">توضیحات:</label>
                    <div class="col-sm-10 marginBtn10">
                        <textarea name="description" rows="4"></textarea>
                    </div>
                </div>
               <div class="container">
                <div class="row">

                    <?php
                    $this->registerWidgets ( array (
                        'formW' => 'form',
                    ) ) ;
                    $form.='<div class="col-md-6">';
                    $form .= $this->formW->rowStart () ;
                    $form .= '<div class="labelResume"><span class="redStar">*</span>لطفا تصویر پوستر مورد نظر خود را از طریق دکمه زیر آپلود کنید.</div>' ;
                    $form .= $this->formW->buttonTag ( array (
                        'htmlOptions' => array (
                            'type'  => 'button',
                            'id'    => 'selectProfilePicBtn1',
                            'class' => 'btn btn-default',
                            'name'  => 'pic'
                        ),
                        'style'       => array (
                            'right'    => '-15px',
                            'position' => 'relative'
                        ),
                        'content'     => '<i class="fa fa-upload"></i> ' . \f\ifm::t ( 'picSelect' ),
                        'action'      => array (
                            'preServerSideAction' => array (
                                'route'   => 'core.fileManager.registerUploadSession',
                                'options' => array (
                                    //change

                                    'extensions'  => '.jpg, .png, .bmp, .jpeg',
                                    'tasks'       => array (
                                        'upload' )
                                ),
                            ),
                            'display'             => 'dialog',
                            'params'              => array (
                                'targetRoute'    => "fileManager.getUploadForm",
                                'triggerElement' => 'selectProfilePicBtn1', //chanage
                                'containerId'    => '#fileContainer1',
                                'urlParams'      => array (
                                    'path' => 'shop.customRequest' //chanage
                                ),
                                'dialogTitle'    => \f\ifm::t ( "picUpload" ),
                                'ajaxParams'     => array (
                                    'mode'   => '',
                                    'fileId' => '',
                                    'type'   => 'front',
                                    'func'   => 'refreshAttached2',
                                    'path'   => 'shop.customRequest'  //chanage
                                )
                            )
                        ) ) ) ;
                    $form .= $this->formW->colStart () ;
                    $attach2 = \f\html::readyMarkup ( 'div', $catalog2,
                        array (
                            'htmlOptions' => array (
                                'id' => 'attach2'
                            ),
                            'style'       => array (
                                'color'    => 'darkblue',
                                'right'    => '-15px',
                                'position' => 'relative'
                            )
                        ), true ) ;
                    $form .= \f\html::readyMarkup ( 'div',
                        $fileIdInput2 . $attach2,
                        array (
                            'htmlOptions' => array (
                                'id' => 'fileContainer1',
                            ),
                            'style'       => array (
                                'margin-top' => '15px'
                            )
                        ), true ) ;
                    $form .= $this->formW->colEnd () ;
                    $form .= $this->formW->rowEnd () ;

                    $form.='</div>';
                    ?>

                    
                    <?php
                    $this->registerWidgets ( array (
                        'formW' => 'form',
                    ) ) ;
                    $form.='<div class="col-md-6">';
                    $form .= $this->formW->rowStart () ;
                    $form .= '<div class="labelResume">لطفا لوگو پوستر مورد نظر خود را از طریق دکمه زیر آپلود کنید.</div>' ;
                    $form .= $this->formW->buttonTag ( array (
                        'htmlOptions' => array (
                            'type'  => 'button',
                            'id'    => 'selectProfilePicBtn2',
                            'class' => 'btn btn-default',
                            'name'  => 'picImg'
                        ),
                        'style'       => array (
                            'right'    => '-15px',
                            'position' => 'relative'
                        ),
                        'content'     => '<i class="fa fa-upload"></i> ' . \f\ifm::t ( 'picSelect' ),
                        'action'      => array (
                            'preServerSideAction' => array (
                                'route'   => 'core.fileManager.registerUploadSession',
                                'options' => array (
                                    //change

                                    'extensions'  => '.jpg, .png, .bmp, .jpeg',
                                    'tasks'       => array (
                                        'upload' )
                                ),
                            ),
                            'display'             => 'dialog',
                            'params'              => array (
                                'targetRoute'    => "fileManager.getUploadForm",
                                'triggerElement' => 'selectProfilePicBtn2', //chanage
                                'containerId'    => '#fileContainer2',
                                'urlParams'      => array (
                                    'path' => 'shop.customRequest' //chanage
                                ),
                                'dialogTitle'    => \f\ifm::t ( "picUpload" ),
                                'ajaxParams'     => array (
                                    'mode'   => '',
                                    'fileId' => '',
                                    'type'   => 'front',
                                    'func'   => 'refreshAttached3',
                                    'path'   => 'shop.customRequest'  //chanage
                                )
                            )
                        ) ) ) ;
                    $form .= $this->formW->colStart () ;
                    $attach3 = \f\html::readyMarkup ( 'div', $catalog2,
                        array (
                            'htmlOptions' => array (
                                'id' => 'attach3'
                            ),
                            'style'       => array (
                                'color'    => 'darkblue',
                                'right'    => '-15px',
                                'position' => 'relative'
                            )
                        ), true ) ;
                    $form .= \f\html::readyMarkup ( 'div',
                        $fileIdInput2 . $attach3,
                        array (
                            'htmlOptions' => array (
                                'id' => 'fileContainer2',
                            ),
                            'style'       => array (
                                'margin-top' => '15px'
                            )
                        ), true ) ;
                    $form .= $this->formW->colEnd () ;
                    $form .= $this->formW->rowEnd () ;

                    $form.='</div>';
                    echo $form ;
                    ?>

                </div>
               </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="height"><span class="redStar">*</span>جنس کاغذ:</label>
                    <div class="col-sm-10 marginBtn10">
                        <?php
                        foreach ($material as $item) {
                            ?>
                            <input type="radio" name="material" id="material" data-id="<?=$item['id']?>" value="<?=$item['price']?>"> <?=$item['name']?><br>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="height">قیمت:</label>
                    <div class="col-sm-10 marginBtn10">
                        <div id="price">
 <span class="priceMasahat" style="margin-left:5px;">0</span>
                            <span>تومان</span>
                        </div>
                    </div>
                </div>
                <br></br>
                <div id="resume"></div>
                <div id="picture"></div>
                <div class="col-md-12">
                    <a style="float: left;" onclick="sendAddToCartCusPro()" class="btn-add-to-cart button-addToCart" title="افزودن به سبد">افزودن به سبد</a>

                </div>
                <div class="clearfix"></div>
            </form>
            <br>
            <div class="status">
            </div>
            </div>
            </div>
        </div>
    </div>
</section>
<style>
    .redStar{
        color:red;
        padding-left: 3px;
    }
    .labelResume
    {
        color:#999;
        padding-bottom: 10px;
    }
    .content-boxed h1{
        font-size: 20px;
        text-align: center;
        background-color: #8e9db4;
        height: 60px;
        color: #fff;
        padding-top: 20px;
        padding-bottom: 20px;
    }
    .content-boxed textarea{
        height: auto;
    }
    .marginBtn10{
        margin-bottom: 10px;
    }
    #uploadForm .form-control{
        padding: 0px !important;
    }
    #price{
        font-size: 20px;
        font-weight: bold;
    }
    .button-addToCart{
        float: right !important;
        width: 200px;
        margin-top: 20px;
    }
</style>
<script>

   //widgetHelper.formSubmit('#customRequestProduct');
    function sendAddToCartCusPro() {
        var option={
            'width':$('#width').val(),
            'height':$('#height').val(),
            'description':$('#description').val(),
            'material':$('#material').attr('data-id'),
            'image':$('#fileContainer1 a').attr('href'),
            'logo':$('#fileContainer2 a').attr('href'),
            'price':$('.priceMasahat').text()
            //'selectProfilePicBtn1':$('#selectProfilePicBtn1').val
            //''
        };
        widgetHelper.tt('ui', 'shop.product.sendCustomProductRequest', option, 'getBasketSidebar');
    }
    function getBasketSidebar(params='null') {
        var urlAddr=$('#siteUrl').val();
        window.location=urlAddr+'cart';
    }
    function refreshAttached2(params)
    {
        var firstFileUrl = "<?= \f\ifm::app ()->fileBaseUrl ?>" + params.fileId[0];

        $('#attach2').html('<a href="' + firstFileUrl + '" target="_blank" ><i class="fa fa-picture-o"></i> تصویر پیوست شده</a>');
        setTimeout(function () {
            window['closeFileDialog' + runningFuncRandName]();
        }, 100);
    }
    function refreshAttached3(params)
    {
        var firstFileUrl = "<?= \f\ifm::app ()->fileBaseUrl ?>" + params.fileId[0];

        $('#attach3').html('<a href="' + firstFileUrl + '" target="_blank" ><i class="fa fa-picture-o"></i> تصویر پیوست شده</a>');
        setTimeout(function () {
            window['closeFileDialog' + runningFuncRandName]();
        }, 100);
    }
    $('input[name=material]').change(function () {
        var masahat=($('#width').val()*$('#height').val())/100;
        var price=$(this).val()*masahat;
        $('.priceMasahat').text(price);
    });
    $( "#customRequest" ).submit(function( event ) {
        var that=this;
        // Stop form from submitting normally
        event.preventDefault();
        // Get some values from elements on the page:
        var option={
            nameFamily:$( "input[name='nameFamily']" ).val(),
            callNumber:$( "input[name='callNumber']" ).val(),
            email:$( "input[name='email']" ).val(),
            width:$( "input[name='width']" ).val(),
            height:$( "input[name='height']" ).val(),
            pic:$("#fileContainer1 a").attr('href')
        }
        var posting = $.post($('#siteUrl').val()+'cms/submitCustomReq', option );
        posting.done(function( data ) {
                widgetHelper.successDialog('پیام شما با موفقیت ارسال شد');
                widgetHelper.closeDialog('successDialog');
                that.reset();
        });
    });
  //  widgetHelper.formSubmit('#customRequest');
  // widgetHelper.formSubmit('#customRequest');
</script>
