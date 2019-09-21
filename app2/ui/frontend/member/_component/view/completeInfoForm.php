<!-- page content -->
<main class="single-blog rtl">
    <div class="container" >
        <div>
            <div class="page-address-box padding-addressBar">
                <span class="address-name">
                    <a href="<?= \f\ifm::app ()->siteUrl ?>">
                        <i style="padding-left:3px;" class="fa fa-home"></i><span class="address-name">خانه</span>
                    </a>
                </span>
                <span class="arrow-address5 fa fa-angle-left"></span>
                <span class="address-name">عضویت در فروشگاه</span>
            </div>
        </div>
    </div>
    <div class="container grid-row  register-box">
        <div class="section-mainDetail">
            <div class="head" style="border:0px">
                <div class="col-md-12">
                    <i class="fa fa-address-card-o " style="font-size: 150px;"></i>
                    <h1> اطلاعات تکمیلی جهت ثبت نام را وارد کنید </h1>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="section-mainDetail clearfix" style="padding-bottom: 50px;border: none;box-shadow: none;">
                <input type="hidden" value="<?=$_SESSION['mobile']?>" id="mobileNum"/>
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <div class="form-container noback">
                        <div class="userbox rtl">
                            <form action="<?= \f\ifm::app ()->siteUrl ?>member/saveCompleteInfo" method="POST" class="clearfix" id="completeInfo" novalidate="novalidate">
                                <div class="userform ">
                                    <div class="form-group clearfix">
                                        <div class="" style="padding-bottom: 15px">
                                            <label for="name" class="lable-form"><span class="star">*</span>  نام و نام خانوادگی </label>
                                            <input type="text" name="name"  data-parsley-required="" class="form-control fa" placeholder="نام و نام خانوادگی">
                                        </div>
                                    </div>
                                    <div class="form-group clearfix">
                                        <div class="" style="padding-bottom: 15px">
                                            <label for="username" class="lable-form"><span class="star">*</span>  نام کاربری </label>
                                            <input type="text" name="username"  data-parsley-required="" class="form-control en" placeholder="ex:username">
                                        </div>
                                    </div>
                                    <div class="form-group clearfix">
                                        <div class="" style="padding-bottom: 15px">
                                            <label for="username" class="lable-form"> ایمیل </label>
                                            <input type="email" name="email"   class="form-control en" placeholder="ex:exmple@yahoo.com">
                                        </div>
                                    </div>
                                    <div class="form-group clearfix">
                                        <div class="" style="padding-bottom: 15px">
                                            <label for="password" class="lable-form"><span class="star">*</span> رمز عبور </label>
                                            <input type="password" name="password"  data-parsley-required="" class="form-control en" placeholder="ex:12345">
                                        </div>
                                    </div>
                                    <div class="form-group clearfix">
                                        <div class=" left">
                                            <button value="Submit" class="form-control raysan-button-reg" style="margin-bottom:10px;width:100%;background-color:#1a365ed9;color:#fff;box-shadow: 0 2px 3px 0 rgba(0, 0, 0, 0.15);" type="submit"> ثبت اطلاعات تکمیلی </button>
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
           نام کاربری باید یک کلمه منحصربه فرد با حروف انگلیسی باشد.
        </div>
    </div>
</main>

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
