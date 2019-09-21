<main class="page-content">
    <div class="container">
        <div class="grid-row" style="direction :rtl;">
            <div class="col-md-12">
                <div class="url-page-box">
                    <div class="page-address-box padding-addressBar">
                        <i style="padding-left:3px;" class="fa fa-home"></i><span class="address-name"><a
                                    href="<?= \f\ifm::app()->siteUrl ?>" title="خانه">خانه</a></span>
                        <span class="arrow-address5 fa fa-angle-left"></span><span class="address-name"><a
                                    href="<?= \f\ifm::app()->siteUrl ?>" title="اخبار">اخبار</a></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="grid-row ">
            <div class="col-md-12 ">
                <div class="content-boxed">
            <h1>
                <?= 'ارسال درخواست پوستر سفارشی' ?>
            </h1>

            <form name="customRequest" id="customRequest"  method="post" action="<?php echo \f\ifm::app()->siteUrl.'cms/submitCustomReq'?>" >
                <div class="form-group">
                    <label class="control-label col-sm-2" for="nameFamily">نام و نام خانوادگی:</label>
                    <div class="col-sm-10 marginBtn10">
                        <input type="text" class="form-control" name="nameFamily" id="nameFamily" placeholder="نام و نام خانوادگی خود را وارد کنید.">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="callNumber">شماره تماس:</label>
                    <div class="col-sm-10 marginBtn10">
                        <input type="text" class="form-control" name="callNumber" id="callNumber" placeholder="شماره تماس خود را وارد کنید.">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="email">پست الکترونیک:</label>
                    <div class="col-sm-10 marginBtn10">
                        <input type="email" class="form-control" name="email" id="email" placeholder="پست الکترونیکی خود را وارد کنید.">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="width">طول (سانتی متر):</label>
                    <div class="col-sm-10 marginBtn10">
                        <input type="text" class="form-control" name="width" id="width" placeholder="طول مورد نظر خود برای پوستر را انتخاب کنید.">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="height">ارتفاع (سانتی متر):</label>
                    <div class="col-sm-10 marginBtn10">
                        <input type="text" class="form-control" name="height" id="height" placeholder="ارتفاع مورد نظر خود برای پوستر را وارد کنید.">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="height">توضیحات:</label>
                    <div class="col-sm-10 marginBtn10">
                        <textarea name="description" rows="4"></textarea>
                    </div>
                </div>
                <div class="box-content">
                    <?php
                    $this->registerWidgets ( array (
                        'formW' => 'form',
                    ) ) ;
                    $form.='<div class="col-md-6">';
                    $form .= $this->formW->rowStart () ;
                    $form .= '<div class="labelResume">لطفا تصویر پوستر مورد نظر خود را از طریق دکمه زیر آپلود کنید.</div>' ;
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

                    $form.='</div><div class="clearfix"></div>';
                    echo $form ;
                    ?>
                </div>



                <br></br>
                <div id="resume"></div>
                <div id="picture"></div>
                <div class="col-md-12">
                <button type="submit" class="btn btn-primary leftFloat"><i class="fa fa-save"></i> ارسال</button>

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
</main>
<style>
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
</style>
<script>

    function refreshAttached2(params)
    {
        var firstFileUrl = "<?= \f\ifm::app ()->fileBaseUrl ?>" + params.fileId[0];

        $('#attach2').html('<a href="' + firstFileUrl + '" target="_blank" ><i class="fa fa-picture-o"></i> تصویر پیوست شده</a>');
        setTimeout(function () {
            window['closeFileDialog' + runningFuncRandName]();
        }, 100);
    }
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
