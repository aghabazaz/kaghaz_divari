<div class="logo" style="">
<!--    <a href="#"><img src="<?= \f\ifm::app()->fileBaseUrl ?>/356" alt="" /></a>-->
</div>

<style>
    .login-box input{
        direction: ltr !important;
    }
</style>


<div class="login-box center-block" style="  opacity: 1;width: 420px;">

    <div style="  width: 419px;
         height: 209px;
         margin-right: -25px;
         margin-top: -25px;
         background: #f1f1f1;
         position: absolute;
         opacity: 0.8;
         z-index: -1;">

    </div>

    <form method="post" class="form-horizontal" role="form" action="<?= \f\ifm::app()->baseUrl ?>core/auth/login">
        <p class="title">ورود به نرم افزار...</p>
        <div class="form-group">
            <label for="username" class="control-label sr-only">نام کاربری</label>
            <div class="col-sm-12">
                <div class="input-group">
                    <input name="username" type="text" placeholder="نام کاربری" class="form-control">
                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                </div>
            </div>
        </div>
        <label for="password" class="control-label sr-only">رمز عبور</label>
        <div class="form-group">
            <div class="col-sm-12">
                <div class="input-group">
                    <input name="password" type="password" placeholder="رمز عبور" class="form-control">
                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                </div>
            </div>
        </div>
        <!--
        <div class="simple-checkbox">
            <input name="remember" type="checkbox" id="checkbox1">
            <label for="checkbox1">مرا به خاطر بسپار</label>
        </div>
        -->
        <button class="btn btn-custom-primary btn-lg btn-block btn-login">
            <i style="  height: 20px;
               float: right;
               display: block;
               padding-top: 8px;
               padding-right: 21px;
               color: rgb(255, 255, 255);" class="fa fa-arrow-circle-o-left"></i>ورود </button>
    </form>

    <div class="links" style="display: none">
        <p><a href="page-login.html#">نام کاربری یا رمز عبور خود را فراموش کرده اید؟</a></p>
    </div>

</div>
