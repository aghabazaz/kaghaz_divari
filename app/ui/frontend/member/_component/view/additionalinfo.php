<?php
$this->registerGadgets ( array (
    'dateG' => 'date' ) ) ;
$end    = $this->dateG->today ( 'year' ) ;
$start  = $end - 100 ;
$year = explode('/',$end)[0];
if ( $_SESSION[ 'user_id' ] )
{
    $status = $row[ 'name' ] ? 'saveEdit' : 'saveNew' ;
    ?>
    <!-- page content -->
    <main class="page-content rtl" >
        <div class="container" >
            <div class="row">
                <div class="url-page-box">
                    <div class="page-address-box padding-addressBar">
                        <i style="padding-left:3px;" class="fa fa-home"></i><span class="address-name"><a href="<?= \f\ifm::app ()->siteUrl ?>">خانه</a></span><span class="arrow-address5 fa fa-angle-left"></span><span class="address-name"><a href="<?= \f\ifm::app ()->siteUrl.'account' ?>">حساب کاربری</a></span><span class="arrow-address5 fa fa-angle-left"></span><span class="address-name"><?= $status == 'saveNew' ? 'تکمیل اطلاعات حساب کاربری' : 'ویرایش اطلاعات تکمیلی حساب کاربری' ?></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="container grid-row section-mainDetail additionalinfoBox" >
            <div class="head" style="border:0px">
                <h2 class="title right"><i class="fa fa-user-circle"></i>&nbsp;تکمیل اطلاعات حساب کاربری</h2>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix">
                <div class="col-md-12">
                    <div class="form-container">
                        <form action="<?= \f\ifm::app ()->siteUrl ?>member/additionalInfoSave" method="POST" class="clearfix" id="additionalInfoForm" novalidate="novalidate">
                            <input type="hidden" value="<?= $row[ 'id' ] ?>" name="id">
                            <input type="hidden" value="<?= $_SERVER['HTTP_REFERER'] ?>" name="oldPageBack">
                            <div class="userbox">
                                <div class="userform ">
                                    <div class="col-md-6">
                                        <div class="form-group clearfix">
                                            <div  style="padding-bottom: 15px">
                                                <label for="name" class="lable-form" ><span class="star">*</span>نام و نام خانوادگی:</label>
                                                <input type="text" name="name"  value="<?= $row[ 'name' ] ?>" data-parsley-required="" class="form-control" >
                                            </div>
                                        </div>

                                        <div class="form-group clearfix">
                                            <div style="padding-bottom: 15px">
                                                <label for="nationalCode" class="lable-form">کد ملی:</label>
                                                <input type="text" name="national_code" value="<?= $row[ 'national_code' ] ?>" id="national_code"  class="form-control leftText" data-parsley-minlength="10" data-parsley-maxlength="11">
                                            </div>
                                        </div>

                                        <div class="form-group clearfix ">

                                            <div class="radio2">
                                                <label for="lstGender" style="color:;color:#8e8e8e"><span class="star">*</span> جنسیت :</label>
                                                <br>
                                                <?php
                                                if ( ! $row[ 'gender' ] || $row[ 'gender' ] == 'male' )
                                                {
                                                    ?>
                                                    <div class="radio-control">
                                                        <input id="rbMale" type="radio" name="gender" value="male" checked="">
                                                        <label for="rbMale"></label>
                                                    </div>
                                                    <label for="rbMale">مرد</label>

                                                    <div class="radio-control">
                                                        <input id="rbFemale" type="radio" name="gender" value="female">
                                                        <label for="rbFemale"></label>
                                                    </div>
                                                    <label for="rbFemale">زن</label>
                                                    <?php
                                                }
                                                else
                                                {
                                                    ?>
                                                    <div class="radio-control">
                                                        <input id="rbMale" type="radio" name="gender" value="male" >
                                                        <label for="rbMale"></label>
                                                    </div>

                                                    <label for="rbMale">مرد</label>
                                                    <div class="radio-control">
                                                        <input id="rbFemale" type="radio" name="gender" value="female" checked="">
                                                        <label for="rbFemale"></label>
                                                    </div>
                                                    <label for="rbFemale">زن</label>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="form-group clearfix">

                                            <label for="birthDay" style="padding-bottom:10px;;color:#8e8e8e"> تاریخ تولد:</label>

                                            <div id="birthday-inputs">
                                                <div class="select-container right year" >
                                                    <select name="birthDay-year" id="lstYear">
                                                        <option value="<?= $birthday[ 0 ] ?>" selected=""><?= $birthday[ 0 ] ?></option>
                                                        <?php
                                                        for ( $i = $year ; $i >= $start ; $i -- )
                                                        {
                                                            ?>
                                                            <option value="<?= $i ?>"><?= $i ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <?php
                                                switch ( $birthday[ 1 ] )
                                                {
                                                    case 1:
                                                        $month = 'فروردین' ;
                                                        break ;
                                                    case 2:
                                                        $month = 'اردیبهشت' ;
                                                        break ;
                                                    case 3:
                                                        $month = 'خرداد' ;
                                                        break ;
                                                    case 4:
                                                        $month = 'تیر' ;
                                                        break ;
                                                    case 5:
                                                        $month = 'مرداد' ;
                                                        break ;
                                                    case 6:
                                                        $month = 'شهریور' ;
                                                        break ;
                                                    case 7:
                                                        $month = 'مهر' ;
                                                        break ;
                                                    case 8:
                                                        $month = 'آبان' ;
                                                        break ;
                                                    case 9:
                                                        $month = 'آذر' ;
                                                        break ;
                                                    case 10:
                                                        $month = 'دی' ;
                                                        break ;
                                                    case 11:
                                                        $month = 'بهمن' ;
                                                        break ;
                                                    case 12:
                                                        $month = 'اسفند' ;
                                                        break ;
                                                }
                                                ?>
                                                <div class="select-container right month">
                                                    <select name="birthDay-month" id="lstMonth">
                                                        <option value="<?= $birthday[ 1 ] ?>" selected=""><?= $month ?></option>
                                                        <option value="1">فروردین</option>
                                                        <option value="2">اردیبهشت</option>
                                                        <option value="3">خرداد</option>
                                                        <option value="4">تیر</option>
                                                        <option value="5">مرداد</option>
                                                        <option value="6">شهریور</option>
                                                        <option value="7">مهر</option>
                                                        <option value="8">آبان</option>
                                                        <option value="9">آذر</option>
                                                        <option value="10">دی</option>
                                                        <option value="11">بهمن</option>
                                                        <option value="12">اسفند</option>
                                                    </select>
                                                </div>
                                                <div class="select-container right day" style="margin-right:0px">
                                                    <select name="birthDay-day" id="lstDay" >
                                                        <option value="<?= $birthday[ 2 ] ?>" selected=""><?= $birthday[ 2 ] ?></option>
                                                        <?php
                                                        for ( $i = 1 ; $i <= 31 ; $i ++ )
                                                        {
                                                            ?>
                                                            <option value="<?= $i ?>"><?= $i ?></option>
                                                            <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>

                                                <div class="clearfix"></div>
                                            </div>
                                        </div>
<!--                                        <div class="form-group clearfix ">-->
<!--                                            <label for="card" class="lable-form">شماره کارت:</label>-->
<!--                                            <div class="input-cart-mobile" style="padding-bottom: 15px">-->
<!--                                                <input type="text" name="card1" value="--><?//= $card[ 0 ] ?><!--" maxlength="4" data-parsley-required="" class="form-control card-input en " data-parsley-minlength="4" data-parsley-maxlength="4"  >-->
<!--                                                <input type="text" name="card2"  value="--><?//= $card[ 1 ] ?><!--" maxlength="4" data-parsley-required="" class="form-control card-input en" data-parsley-minlength="4" data-parsley-maxlength="4" >-->
<!--                                                <input type="text" name="card3"  value="--><?//= $card[ 2 ] ?><!--" maxlength="4" data-parsley-required="" class="form-control card-input en" data-parsley-minlength="4" data-parsley-maxlength="4"  >-->
<!--                                                <input type="text" name="card4"  value="--><?//= $card[ 3 ] ?><!--" maxlength="4" data-parsley-required="" class="form-control card-input en" data-parsley-minlength="4" data-parsley-maxlength="4" >-->
<!--                                            </div>-->
<!--                                        </div>-->


                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group clearfix">
                                            <div style="padding-bottom: 15px">
                                                <label for="phone" class="lable-form"><span class="star">*</span> شماره تلفن ثابت:</label>
                                                <input type="text" name="phone"  value="<?= $row[ 'phone' ] ?>" data-parsley-required="" class="form-control leftText" data-parsley-maxlength="11" >
                                            </div>
                                        </div>

                                        <div class="form-group clearfix">
                                            <div style="padding-bottom: 15px">
                                                <label for="mobile" class="lable-form"> <span class="star">*</span> شماره تلفن همراه:</label>
                                                <input type="text" name="mobile"  value="<?= $row[ 'mobile' ] ?>" data-parsley-required="" class="form-control leftText" data-parsley-minlength="10" data-parsley-maxlength="11">
                                            </div>
                                        </div>
                                        <div class="form-group clearfix">
                                            <div style="padding-bottom: 15px">
                                                <label for="email" class="lable-form">پست الکترونیکی:</label>
                                                <input type="text" name="email"  value="<?= $row[ 'email' ] ?>"  class="form-control leftText" data-parsley-minlength="10" data-parsley-maxlength="11">
                                            </div>
                                        </div>
<!--                                        <div class="form-group clearfix">-->
<!--                                            <div style="padding-bottom: 15px">-->
<!--                                                <label for="fax" class="lable-form">نمابر ( فکس )</label>-->
<!--                                                <input type="text" name="fax" value="--><?//= $row[ 'fax' ] ?><!--"  class="form-control leftText" >-->
<!--                                            </div>-->
<!--                                        </div>-->

                                        <div class="form-group clearfix">
                                            <label for="address2" style="padding-bottom:10px;color:#8e8e8e"><span class="star">*</span>
                                                محل سکونت:
                                          </label>
                                            <div class="place-inputs">
                                                <div class="select-container city" >
                                                    <select name="city_id" id="city_id"  data-parsley-required="">
                                                    </select>
                                                    </label>
                                                </div>
                                                <div class="select-container city" style="margin-right:0px">
                                                    <select name="state_id" id="state_id" onchange="getCityByStateId()" data-parsley-required="">
                                                        <?php
                                                        foreach ( $state AS $data )
                                                        {
                                                            if ( $data[ 'id' ] == $row[ 'state_id' ] )
                                                            {
                                                                echo '<option value="' . $data[ 'id' ] . '" selected="">' . $data[ 'title' ] . '</option>' ;
                                                            }
                                                            else
                                                            {
                                                                echo '<option value="' . $data[ 'id' ] . '">' . $data[ 'title' ] . '</option>' ;
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                    </label>
                                                </div>


                                                <div class="clearfix"></div>
                                            </div>
                                        </div>
                                        <div class="form-group clearfix">
                                            <div style="padding-bottom: 15px">
                                                <label for="mobile" class="lable-form"><span class="star">*</span> آدرس دقیق:</label>
                                                <textarea style="height: 118px;" name="address"   data-parsley-required="" class="form-control" rows="3"><?= $row[ 'address' ] ?></textarea>
                                            </div>
                                        </div>


                                    </div>
                                    <!--
                                                                        <div class="form-group clearfix">
                                                                            <div class="ckeckbox-control right">
                                                                                <input id="lstNewsleter" name="newsleterCheck" type="checkbox">
                                                                                <label for="lstNewsleter"></label>
                                                                            </div>
                                                                            <label for="lstNewsleter" class="newsletter">خبرنامه رایسان را برای من ارسال کنید.</label>
                                                                        </div>
                                    -->
                                    <div class="form-group clearfix">
                                        <div class=" left Submit-changePass-mobile col-md-6">
                                            <button value="Submit" class="form-control raysan-button-reg" style="background-color:#2196f3;color:#fff;box-shadow: 0 2px 3px 0 rgba(0, 0, 0, 0.15);" type="submit"><?= $status == 'saveNew' ? 'ثبت نام' : 'ویرایش  اطلاعات' ?></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>

    </div>
    </main>
    <style>
        @media only screen and (max-width: 980px) {

        }
        @media only screen and (max-width: 550px) {
            .userbox .userform {
                width:100%!important;
            }
            input[type=text]{
                width: 100%;
            }
            div{
                margin: 0 auto !important;
            }
        }

        ul#parsley-id-multiple-gender{
            display: inline-block!important;
        }
        .select-container.city{
            width: 158px;
        }
        .card-input{
            width:84px!important;
            float:left;
           text-align: center !important;
        }
        .userform .form-group .radio2 > label {
            display: inline-block;
            width: 110px;
            color: #4d4d4d;
        }
        .userform .form-group .ckeckbox-control, .userform .form-group .radio-control {
            top: 9px;
        }
        .radio-control {
            display: inline-block;
            position: relative;
            height: 18px;
            width: 18px;
            padding: 0;
            margin: 0;
        }
        .radio-control input[type=radio] {
            position: absolute !important;
            opacity: 0;
            display: none;
        }
        .radio-control label {
            width: 14px;
            height: 14px;
            border-radius: 100%;
            background: #fff;
            display: block;
            position: relative;
            border: 1px solid #d4dbde;
            transition: 150ms ease;
            padding: 0;
            margin: 0;
            cursor: pointer;
        }
        .userform .form-group .radio-control + label {
            color: #777;
            margin-left: 15px;
            width: auto !important;
            height:40px;
        }
        .radio-control input[type=radio]:checked + label {
            background: #2196f3;
            border: 1px solid transparent;
            width: 14px;
            height: 14px;
        }
        .radio-control label:after {
            position: absolute;
            top: 5px;
            left: 5px;
            content: "";
            background: #fff;
            width: 2px;
            height: 2px;
            border-radius: 100%;
            border: 1px solid #fff;
        }
        .select-container{
            width: 99px;
            margin-right: 20px;
            float: left;
        }


        .ckeckbox-control label {
            width: 14px;
            height: 14px;
            background: #fff;
            display: block;
            position: relative;
            border: 1px solid #d4dbde;
            transition: 150ms ease;
            padding: 0;
            margin: 0;
            cursor: pointer;
            border-radius: 2px;
            top:5px;
        }
        .ckeckbox-control label:after {
            background: url(../img/slices.png) no-repeat scroll -196px -87px;
            content: "";
            display: block;
            height: 6px;
            left: 3px;
            position: absolute;
            top: 5px;
            width: 8px;
        }
        .ckeckbox-control input[type=checkbox]:checked + label {
            background: #2196f3;
            border: 1px solid transparent;
        }
        .ckeckbox-control input[type=checkbox] {
            position: absolute !important;
            opacity: 0;
            display: none;
        }
         .title {
        color: #000;
        font-size: 18px;
        top:0px;
        position: relative;


    }
        .icon-caret-left-blue {
            background-position: -36px -652px !important;
            height: 10px;
            width: 5px;
        }
        .raysan-button-reg{
            width: 194px;
            height:38px!important;
        }

        .lable-form{
            padding-bottom: 5px;
        }
        .form-group input.en {
            color: #acacac;
            direction: ltr;
            text-align: left;
            font: bold 12px arial;
        }

        .form-group > label.newsletter {
            color: #4d4d4d;
            display: inline-block;
        }
@media screen and (max-width:767px)
{

    .section-mainDetail {
         border: none !important;
        margin-top: 15px;
        padding: 32px 1px 8px 0px !important;
        box-shadow: none !important;
        background: #fff;
    }
    .select-container{
            width: 33% !important;
        }
}

        .container.grid-row.section-mainDetail.additionalinfoBox input, select {
            width: 100%;
            height: 40px;
            padding: 0 10px;
            border: 1px solid #e3e3e3;
            border-radius: 0;
            background: #fff;
            font-size: 13px;
            line-height: 20px;
            color: #333;
            -ms-box-sizing: border-box;
            box-sizing: border-box;
            -moz-box-sizing: border-box;
            direction: rtl;
        }

        .container.grid-row.section-mainDetail.additionalinfoBox label {
            color: #806f6f;
        }
        select {
            background-repeat: no-repeat !important;
        }

    </style>
    <script>

    <?php
    if ( $row[ 'id' ] )
    {
        ?>
            getCityByStateId();
        <?php
    }
    ?>
        function getCityByStateId()
        {
            widgetHelper.tt('ui', 'member.getListCity', {state_id: $('#state_id').val()}, 'refreshSelectCity')
        }
        function refreshSelectCity(params)
        {
            $('#city_id').html(params.content);
            widgetHelper.makeSelect2('#city_id', '<?= \f\ifm::t ( 'select' ) ?>');
    <?php
    if ( $row[ 'city_id' ] )
    {
        ?>
                $('#city_id').select2('val',<?= $row[ 'city_id' ] ?>);
        <?php
    }
    ?>

        }
    </script>
    <?php
}
else
{
    header ( "Location: " . \f\ifm::app ()->siteUrl ) ;
}
?>