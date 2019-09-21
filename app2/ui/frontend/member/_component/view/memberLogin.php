
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
                <span class="address-name">ورود کاربران</span>
            </div>
        </div>
    </div>

    <div class="container">
    <div class="grid-row section-mainDetail mobile-login">
        <div class="col-md-12 " style="text-align: center">
            <i class="icon icon-user-login"></i>
            <h1 style="font-size:18px"> ورود کاربران</h1>
        </div>

        <div class="clearfix"></div>
            <br>
            <div class="col-md-12 no-mobile-padding" >
                <div class="form-container noback" >
                    <div class="userbox rtl">
                        <form action="<?= \f\ifm::app ()->siteUrl ?>member/checkLogin" method="POST" class="clearfix" id="registerForm" novalidate="novalidate">
                            <div class="userform " >
                                <div class="form-group clearfix">
                                    <div class="" style="padding-bottom: 15px">
                                        <label for="username" class="lable-form">شماره همراه / موبایل </label>
                                        <input type="username" name="username" data-parsley-type="username" data-parsley-required="" class="form-control en login-form" placeholder="شماره همراه / پست الکترونیک">
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <div class="" style="padding-bottom: 15px">
                                        <label for="password" class="lable-form">کلمه عبور </label>
                                        <input type="password" name="password" id="password" data-parsley-required="" autocomplete="off" class="form-control en login-form" placeholder="Password">
                                    </div>
                                </div>  
                                <div class="form-group clearfix">
                                    <div>
                                        <button class="btn btn-primary login-btn-set" type="submit">
                                            <i class="fa fa-sign-in" style="position: relative;top:3px;padding-left: 5px"></i> ورود ...
                                        </button>
                                        </br>
                                        </br>
                                        <a style="color: #2196F3;" href="<?= \f\ifm::app ()->siteUrl ?>forgetPass">         رمز عبور خود را فراموش کرده ام ...</a>
                                    </div>
                                    <div style="padding-top: 10px;border-top: 1px solid #eee;margin-top: 10px">
                                        <a href="<?= \f\ifm::app ()->siteUrl ?>register" style="color:#000">
                                            <i class="fa fa-user-plus"></i> ثبت نام
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <div class="clearfix"></div>

        </div>
    </div>
    </div>

    <div class="clearfix"></div>

</div>
</main>


