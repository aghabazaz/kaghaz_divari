
<div class="teaser_content media">
    <div class="" style="width:100%;text-align:center;direction: rtl">

        <h3 style="font-size:22px;color:#FFF">
            <i class="fa fa-newspaper-o"></i> <?= 'خبرنامه' ?>
        </h3>
        <!-- testimonials indicators -->

    </div>
    <section class="widget-alt ">

        <p style="color:#fff;padding-top: 20px;margin-bottom: 10%">
            <?php
            echo \f\ttt::block ( 'cms.getCmsSetting',
                                 array (
                'key' => 'newsletterPageText'
            ) )
            ?>
        </p>
        <nav style="">
            <a href="javascript:void(0)" class="button" data-toggle="modal" data-target="#newsletterShare" style="margin: 0px 10px;border-bottom: 1px dashed #2F89D4;">اشتراک یا لغو اشتراک</a>
            <div id="newsletterShare" class="modal fade" role="dialog" style="color:#8699a4;">
                <div class="modal-dialog modal-lg" >
                    <!-- Modal content-->
                    <div class="modal-content" style="text-align: right;">
                        <div class="modal-header" style="font-size:18px">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title" >
                                <i class="fa fa-file-text-o"></i> اشتراک یا لغو اشتراک در خبرنامه
                            </h4>
                        </div>
                        <div class="modal-body" >
                            <form method="post" action="<?= \f\ifm::app ()->siteUrl ?>newsletter/newsletterShareSave" class="clearfix" id="newsletterForm" novalidate="novalidate">
                                <div id="divFiledsSelect" >
                                    <label for="filedsSelect">نحوه اشتراک :</label>
                                    <select name="filedsSelect" id="filedsSelect">
                                        <option></option>
                                        <option value="0">فقط ایمیل</option>
                                        <option value="1">فقط پیامک</option>
                                        <option value="2">هر دو ( پیامک و ایمیل  )</option>
                                    </select>
                                </div>
                                <div class="inputName"  style="display: none;" >
                                    <label for="name">نام و نام خانوادگی :</label>
                                    <input type="text"  id="name" name="name" data-parsley-required="">  
                                </div>                                
                                <div class="inputEmail"  style="display: none;" >
                                    <label for="email">ایمیل :</label>
                                    <input type="text"  id="email" name="email" data-parsley-type="email">  
                                </div>
                                <div class="inputMobile" style="display: none;" >
                                    <label for="mobile">موبایل :</label>
                                    <input type="text" id="mobile" name="mobile"  data-parsley-type="number" data-parsley-minlength="10">                                                
                                </div>                              
                                <div class="inputProductCat" style="display: none;" >
                                    <label for="category[]">دسته بندی </label>
                                    <select name="category[]"  multiple="" id="category">
                                        <option></option>
                                        <?php
                                        foreach ( $category AS $data )
                                        {
                                            echo '<option value="' . $data[ 'id' ] . '">' . $data[ 'title' ] . '</option>' ;
                                        }
                                        ?>

                                    </select> 

                                </div> 
                                <div class="checkbox" style="display: none;">
                                    <label for="newsletterCancel">
                                        <input type="checkbox" name="newsletterCancel" id="newsletterCancel" value="1" />
                                        لغو اشتراک
                                    </label>
                                </div>                                  
                                <button value="Submit" style="margin-top: 20px" name="save" class="button" id="newsletterSubmit" type="submit">ثبت اشتراک</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </nav>        
    </section>

</div>

<script>
    widgetHelper.makeSelect2('select', 'انتخاب کنید...');
    widgetHelper.formSubmit('#newsletterForm');
    $(document).ready(function () {
        $('.close').click(function () {
            $('.inputProductCat').slideUp("fast");
            $('.inputName').slideUp("fast");
            $('.inputMobile').slideUp("fast");
            $('.inputEmail').slideUp("fast");
            $('.checkbox').slideUp("fast");
            $("#newsletterSubmit").html('ثبت اشتراک');
        });
        $('#newsletterCancel').click(function () {
            if ($("#newsletterSubmit").html() == 'ثبت اشتراک') {
                $("#newsletterSubmit").html('لغو اشتراک');
                $('.inputProductCat').slideUp("fast");
                $('.inputName').slideUp("fast");
                $('#name').removeAttr('data-parsley-required');
            } else {
                $("#newsletterSubmit").html('ثبت اشتراک');
                $('.inputProductCat').slideDown("fast");
                $('.inputName').slideDown("fast");
                $('#name').attr('data-parsley-required', '');
            }
        });
        $('#filedsSelect').click(function () {
            if ($('#filedsSelect').val() == 0)
            {
                $('.inputEmail').slideDown("fast");
                $('.inputMobile').slideUp("fast");
                $('#mobile').val('');
                $('#email').attr('data-parsley-required', '');
                $('#mobile').removeAttr('data-parsley-required');
            } else if ($('#filedsSelect').val() == 1)
            {
                $('.inputMobile').slideDown("fast");
                $('.inputEmail').slideUp("fast");
                $('#email').val('');
                $('#email').removeAttr('data-parsley-required');
                $('#mobile').attr('data-parsley-required', '');
            } else
            {
                $('.inputEmail').slideDown("fast");
                $('.inputMobile').slideDown("fast");
                $('#mobile').attr('data-parsley-required', '');
                $('#email').attr('data-parsley-required', '');
            }

            if ($("#newsletterSubmit").html() == 'لغو اشتراک') {
                $('.inputName').slideUp("fast");
                $('.inputProductCat').slideUp("fast");
            } else {
                $('.inputProductCat').slideDown("fast");
                $('.inputName').slideDown("fast");
            }
            $('.checkbox').slideDown("fast");
        });
    });

</script>