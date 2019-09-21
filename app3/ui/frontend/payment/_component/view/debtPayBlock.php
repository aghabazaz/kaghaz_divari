<div class="teaser_content media" >
    <div style="width:100%;text-align:center;direction: rtl">

        <h3 style="font-size:22px;color:#FFF">
            <i class="fa fa-university"></i> پرداخت آنلاین
        </h3>


    </div>

    <div style="margin-top: 30px;direction: rtl;text-align: center;color: white" class="widget-doctors last-news">
        <form method="post" action="<?= \f\ifm::app ()->siteUrl ?>payment/paymentSave" class="clearfix" id="contactform" novalidate="novalidate">

            <input type="hidden" name="bankid" value="mellat">
            <input type="hidden" name="type" value="deptPay">
            <div style="text-align: right">

                <div style="height: 230px;">
                    <label for="name">نام و نام خانوادگی :</label>
                    <input type="text"  id="name" name="name" class="smallText" data-parsley-required="">                                                                 
                    <label for="comment">پرداخت جهت :</label>
                    <textarea id="comment" name="comment"  data-parsley-required="" rows="1"></textarea>                                                                                     
                    <label for="name">قیمت :</label>
                    <input type="text"  id="price" name="price" class="smallText comma"  data-parsley-required="" >                     
                </div>
                <div class="clearfix"></div>
                <div>
                    <button type="submit" class="wpb_button wpb_btn-alt wpb_regularsize" style="font-size: 13px;margin-bottom: 0px;float:right">پرداخت</button>
                </div>
            </div>
        </form>

    </div>
</div><style>
    .smallText{
        height: 32px!important;
    }
</style>