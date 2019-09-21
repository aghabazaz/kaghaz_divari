<section class="grayBack dir-rtl">
    <div class="container">
        <div>
            <div class="url-page-box marginTop120">
                <div class="page-address-box padding-addressBar">
                    <i style="padding-left:3px;" class="fa fa-home"></i>
                    <a href="<?= \f\ifm::app ()->siteUrl ?>"><span class="address-name">خانه</span></a><span
                            class="arrow-address5 fa fa-angle-right"></span><span class="address-name"> عضویت در فروشگاه </span>
                </div>
            </div>
        </div>
    </div>

    <div class="container grid-row  register-box">
        <div class="section-mainDetail">
        <div class="head" style="border:0px;margin-top:10px">
            <div class="col-md-12 ">
                <h1> اطلاعات ثبت نام خود را وارد نمایید </h1>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="section-mainDetail clearfix row" style="padding-bottom: 50px;border: none;box-shadow: none;">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div class="form-container noback">
                    <div class="userbox rtl">
                        <form action="<?= \f\ifm::app ()->siteUrl ?>member/memberSave" method="POST" class="clearfix" id="registerForm" novalidate="novalidate">
                            <div class="userform ">

                                <div class="form-group clearfix">
                                    <div class="" style="padding-bottom: 15px">
                                        <label for="mobile" class="lable-form"> شماره همراه* </label>
                                        <input type="mobile" name="mobile" data-parsley-type="mobile" data-parsley-required="" class="form-control en" placeholder="09.......">
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <div class="" style="padding-bottom: 15px">
                                        <label for="password" class="lable-form"> کلمه عبور* </label>
                                        <input type="password" name="password" data-parsley-type="password" data-parsley-required="" class="form-control en">
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <div class="" style="padding-bottom: 15px">
                                        <label for="repeatPassword" class="lable-form"> تکرار کلمه عبور* </label>
                                        <input type="password" name="repeatPassword" data-parsley-type="repeatPassword" data-parsley-required="" class="form-control en">
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <div class="" style="padding-bottom: 15px">
                                        <label for="email" class="lable-form"> ایمیل (اختیاری) </label>
                                        <input type="email" name="email"   class="form-control en" placeholder="ex:exmple@yahoo.com">
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <div class="ckeckbox-control right" style="float: right">
                                        <input id="chkAgreement" name="agreementCheck" checked="checked"
                                               type="checkbox">
                                        <label class="chkAgreement" for="chkAgreement"></label>
                                    </div>
                                    <div class="agreement "><label class="reg-portocol"><a target="_blank" href="#">حریم
                                                خصوصی</a> و <a target="_blank" href="#">شرایط و قوانین</a> استفاده از
                                            سرویس های فروشگاه&zwnj; را مطالعه نموده و با کلیه موارد آن موافقم.</label>
                                    </div>

                                    <div class="clear"></div>
                                </div>
                                <div class="form-group clearfix">
                                    <div class=" left">
                                        <button value="Submit" class="form-control raysan-button-reg" style="width:100%;background-color:#1a365ed9;color:#fff;box-shadow: 0 2px 3px 0 rgba(0, 0, 0, 0.15);" type="submit"> ثبت نام </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>
        </div>
    </div>

    <div class="clearfix"></div>

</div>
    <div class="notification success">
        <div class="icon notif">
            <i class="fa fa-check-circle fa-2x success"></i>
        </div>
        <div class="content">
           اطلاعات مورد نیاز را جهت ثبت نام وارد کنید
        </div>
    </div>
</section>

<style>
    .notifications-container {
        width: 300px;
        height: 100%;
    }
    .notification {
        width: 400px;
        padding: 20px;
        background: #33466e !important;
        box-shadow: 0px 0px 5px 1px rgba(0,0,0,0.2);
        margin-top: 10px;
        opacity: 0;
        position:fixed;
        right: 10px;
        bottom: 10px;
        z-index: 1;
        color: white;
    }
    .icon.notif {
        background: orange;
        color: #FFF;
        position:absolute;
        left: 0;
        width: 60px;
        bottom:0;
        top:0;
        font-weight: bold;
        box-sizing: border-box;
        text-align:center;
        display:flex;
        align-items: center;
        justify-content: center;
    }
    .content {
        margin-left: 70px;
    }
    .notification.success {
        background: #ff7f05;
        animation: opacity 5s;
    }
    .notification.success .icon {
        background: #1a365e;
    }
    .notification.warning {
        animation: opacity 5s 5s;
    }
    .notification.error {
        background: #f16767;
        animation: opacity 5s 10s;
    }
    .notification.error .icon {
        background: red;
    }
    .notification.info {
        background: #6fc0f7;
        animation: opacity 5s 15s;
    }
    .notification.info .icon {
        background: #0099FF;
    }

    @keyframes opacity {
        0% {
            opacity: 0;
            bottom: 0;
        }
        20% {
            bottom: 10px;
        }
        50% {
            opacity: 1;
            bottom: 10px;
        }
        80% {
            opacity: 1;
            bottom: 10px;
        }
        100% {
            opacity: 0;
            bottom: 0;
        }
    }

</style>
