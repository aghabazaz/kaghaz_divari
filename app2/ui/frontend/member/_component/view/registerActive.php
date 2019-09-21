
<!-- page content -->
<main class="single-blog rtl" style="background-color: #eeeff1">
    <div class="container" >
        <div class="row">
            <div class="url-page-box">
                <div class="page-address-box padding-addressBar">
                    <i style="padding-left:3px;" class="fa fa-home"></i><span class="address-name">خانه</span><span class="arrow-address5 fa fa-angle-left"></span><span class="address-name">عضویت در فروشگاه رایسان</span>
                </div>
            </div>
        </div>
    </div>
    <div class="grid-row section-mainDetail">
        <div class="head">
            <div class="col-md-12 ">
                <i class="icon icon-user-signup"></i>
                <h1> به ما ملحق شوید</h1>
                <h3>تایید کد عضویت</h3>
            </div>
        </div>
        <div class="section-mainDetail clearfix">
            <div class="col-md-6">
                <div class="form-container noback">
                    <div class="userbox rtl">
                        <div id="txt-reg-actve">
                            <h3>* یک ایمیل حاوی کد فعالسازی برای شما ارسال شده لطفا آن را به همراه ایمیل ثبت نامی وارد کنید.</h3>
                        </div>
                        <form action="<?= \f\ifm::app ()->siteUrl ?>member/registerActiveSave" method="POST" class="clearfix" id="registerActiveForm" novalidate="novalidate">
                            <div class="userform ">
                                <div class="form-group clearfix">
                                    <div class="" style="padding-bottom: 15px">
                                        <label for="email" class="lable-form">ایمیل ثبت نامی:</label>
                                        <input type="email" name="email" data-parsley-type="email" data-parsley-required="" class="form-control en">
                                    </div>
                                </div>
                                <div class="form-group clearfix">
                                    <div class="" style="padding-bottom: 15px">
                                        <label for="email" class="lable-form">کد شما:</label>
                                        <input type="text" name="active_code" data-parsley-required="" class="form-control en">
                                    </div>
                                </div>

                                <div class="form-group clearfix">
                                    <div class=" left">
                                        <button value="Submit" class="form-control raysan-button-reg" style="background-color:#2196f3;color:#fff;box-shadow: 0 2px 3px 0 rgba(0, 0, 0, 0.15);" type="submit">تایید</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="login-tips noback rtl">
                    <ul>
                        <li><i class="icon icon-userbox-cart"></i><span>سریع تر و ساده تر خرید کنید</span></li>
                        <li><i class="icon icon-userbox-list"></i><span>به سادگی سوابق خرید و فعالیت های خود را مدیریت کنید</span></li>
                        <li><i class="icon icon-userbox-love"></i><span>لیست علاقمندی های خود را بسازید و تغییرات آنها را دنبال کنید</span></li>
                        <li><i class="icon icon-userbox-comment"></i><span>نقد، بررسی و نظرات خود را با دیگران به اشتراک گذارید</span></li>
                        <li><i class="icon icon-userbox-discount"></i><span>در جریان فروش های ویژه و قیمت روز محصولات قرار بگیرید</span></li>

                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="clearfix"></div>

</div>
</main>

<script>
    widgetHelper.formSubmit('#registerActiveForm');

</script>
