<!-- page content -->
<main class="single-blog rtl">
    <div class="container" >
        <div class="row">
            <div class="page-address-box padding-addressBar">
                <span class="address-name">
                    <a href="<?= \f\ifm::app ()->siteUrl ?>">
                        <i style="padding-left:3px;" class="fa fa-home"></i><span class="address-name">خانه</span>
                    </a>
                </span>
                 <span class="arrow-address5 fa fa-angle-left"></span>
                <span class="address-name">
                    <a href="<?= \f\ifm::app ()->siteUrl.'account' ?>">
                        <span class="address-name">حساب کاربری</span>
                    </a>
                </span>
                <span class="arrow-address5 fa fa-angle-left"></span>
                <span class="address-name">تغییر کلمه عبور</span>
            </div>
        </div>
    </div>
    <div class="container grid-row section-mainDetail changePassBox" >
        <div class="head" style="border-bottom: 0px">
            <div class="col-md-12 ">
                <i class="icon icon-user-changepassword"></i>
                <h1> تغییر کلمه عبور</h1>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="section-mainDetail clearfix changePass" style="border:none;box-shadow:none">
            <div class="col-md-12">
                <div class="form-container noback">
                    <div class="userbox rtl">
                        <form action="<?= \f\ifm::app ()->siteUrl ?>member/changePassword" method="POST" class="clearfix" id="registerFormChangePass" novalidate="novalidate">
                            <div class="userform " style="width:40%">
                                <div class="form-group clearfix">
                                    <div class="" style="padding-bottom: 15px">
                                        <label for="password" class="lable-form">کلمه عبور قدیم:</label>
                                        <input type="password" name="oldPassword" id="oldPassword" data-parsley-required="" autocomplete="off" class="form-control en" placeholder="Password">
                                    </div>
                                </div>  
                                <div class="form-group clearfix">
                                    <div class="" style="padding-bottom: 15px">
                                        <label for="password" class="lable-form">کلمه عبور جدید:</label>
                                        <input type="password" name="newPassword" id="newPassword" data-parsley-required="" autocomplete="off" class="form-control en" placeholder="Password">
                                    </div>
                                </div> 
                                <div class="form-group clearfix">
                                    <div class="" style="padding-bottom: 15px">
                                        <label for="password" class="lable-form">تکرار کلمه عبور جدید:</label>
                                        <input type="password" name="newPasswordRepeat" id="newPasswordRepeat" data-parsley-equalto="#newPassword" data-parsley-required="" autocomplete="off" class="form-control en" placeholder="Password">
                                    </div>
                                </div> 
                                <div class="form-group clearfix">
                                    <div class=" left Submit-changePass-mobile">
                                        <button value="Submit" class="form-control raysan-button-reg" style="background-color:#293e92;color:#fff;box-shadow: 0 2px 3px 0 rgba(0, 0, 0, 0.15);" type="submit"> ثبت</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="clearfix"></div>

</div>
</main>

<script>
    widgetHelper.formSubmit('#registerFormChangePass');

</script>
