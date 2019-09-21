<?php
if ( $commentStatus == 'enabled' )
{
    $disabled  = 'disabled' ;
    $backColor = '#f0f0f0' ;
    $btnHide   = 'display:none' ;
}
?>
<!-- page content -->
<main class="container page-content">
        <div>
            <div class="url-page-box">
                <div class="page-address-box padding-addressBar">
                    <i style="padding-left:3px;" class="fa fa-home"></i><span class="address-name"><a href="<?= \f\ifm::app ()->siteUrl ?>">خانه</a></span><span class="arrow-address5 fa fa-angle-left"></span><span class="address-name"> امتیازدهی به محصول </span>
                </div>
            </div>
        </div>
    <div class="grid-row" style="background-color: #fff ;direction :rtl;">
        <div class="col-md-4">
            <div class="pro-pic-review">
                <img style="margin:0 auto;" class="img-responsive" src="<?= \f\ifm::app ()->fileBaseUrl . $ratingOptions[ 'picture' ] ?>" alt=" <?php echo $ratingOptions[ 'title' ] ?>" >                               
            </div>
            <div class="pro-name-review">
                <a target="_blanck" href="<?= \f\ifm::app ()->siteUrl . 'productDetail/' . $ratingOptions[ 'id' ] ?>" title="<?=$ratingOptions[ 'title' ]?>"><?php echo $ratingOptions[ 'sub_title' ] ; ?></a>
                <h2><?= $ratingOptions[ 'title' ] ; ?></h2>
            </div>
        </div>
        <div class="col-md-8 desktop-view">
            <div class="rate-box">
                <div class="rate-box-text">
                    <span >
                        امتیاز شما به این محصول
                    </span>
                </div>
                <form id="rateSave" method="post" action="<?= \f\ifm::app ()->siteUrl . 'shop/product/productRateSave' ?>">
                    <input type="hidden" name="product_id" value="<?= $ratingOptions[ 'id' ] ?>">
                    <?php
                    //\f\pre($ratingTitle);
                    if ( $ratingTitle )
                    {
                        foreach ( $ratingTitle AS $data )
                        {
                            $value = $rateOld ? $rateOld[ $data[ 'id' ] ] : 3 ;
                            ?>
                            <div class="col-md-6">
                                <span class="title-range-review"><?= $data[ 'title' ] ; ?></span>
                                <div class="range-slider">
                                    <input type="hidden" name="option_id[]" value="<?php echo $data[ 'id' ] ?>" >
                                    <input <?php echo $disabled ; ?> name="rate[]" class="range-slider__range" type="range" value="<?= $value ?>" min="0" max="5">
                                    <span class="range-slider__value"><?= $value ?></span>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                    <div class="clearfix"></div>
                    <?php
                    if ( ! $rateOld )
                    {
                        ?>
                        <div class="btn-setRate">
                            <button type="submit" class="SetRate" id="setRate">ثبت امتیاز</button>
                        </div>
                        <?php
                    }
                    ?>
                </form>
            </div>
        </div>
        <div class="col-md-8 mobile-view mobile-rate-box">
            <div class="rate-box" style="text-align: center;">
                <div class="rate-box-text">
                    <span >
                        امتیاز شما به این محصول
                    </span>
                </div>
                <form id="rateSave" method="post" action="<?= \f\ifm::app ()->siteUrl . 'shop/product/productRateSave' ?>">
                    <input type="hidden" name="product_id" value="<?= $ratingOptions[ 'id' ] ?>">
                    <?php
                    if ( $ratingTitle )
                    {
                        foreach ( $ratingTitle AS $data )
                        {
                            $value = $rateOld ? $rateOld[ $data[ 'id' ] ] : 3 ;
                            ?>
                            <div class="col-md-6">
                                <span class="title-range-review"><?= $data[ 'title' ] ; ?></span>
                                <div class="range-slider">
                                    <input type="hidden" name="option_id[]" value="<?php echo $data[ 'id' ] ?>" >
                                    <input <?php echo $disabled ; ?> name="rate[]" class="range-slider__range" type="range" value="<?= $value ?>" min="0" max="5">
                                    <span class="range-slider__value"><?= $value ?></span>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                    <div class="clearfix"></div>
                    <?php
                    if ( ! $rateOld )
                    {
                        ?>
                        <div class="btn-setRate">
                            <button type="submit" class="SetRate" id="setRate">ثبت امتیاز</button>
                        </div>
                        <?php
                    }
                    ?>
                </form>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="grid-row" style="background-color: #fff ;direction :rtl;text-align:right;">
        <div class="set-comment-box">
            <div class="wrapper clearfix rate-help" style="margin-top:0px;width:100%;margin-right:0px;">
                <h4>دیگران را با نوشتن نقد، بررسی و نظرات خود، برای انتخاب این محصول راهنمایی کنید.</h4>
            </div>
            <li style="display:none ; margin-bottom: 12px" class="boxs empty">
                <input type="text" name="weakness[]">
                <span class="icon-form-add button-removes"><i class="fa fa-minus" aria-hidden="true"></i></span>
            </li>
            <li style="display:none ; margin-bottom: 12px" class="box empty">
                <input type="text" name="strength[]">
                <span class="icon-form-add button-remove"><i class="fa fa-minus" aria-hidden="true"></i></span>
            </li>

            <form id="commentSave" method="post" action="<?= \f\ifm::app ()->siteUrl . 'shop/product/productCommentSave' ?>">
                <input type="hidden" name="product_id" value="<?= $ratingOptions[ 'id' ] ?>">
                <input type="hidden" name="id" value="<?= $productComment[ 'id' ] ?>">
                <div class="form-groups-comment clearfix">
                    <label id="subjectLable" for="subject">عنوان نقد و بررسی شما<span class="error-message">لطفا عنوان نقد و بررسی را وارد کنید</span></label>
                    <input <?php echo $disabled ; ?> style="background-color:<?php echo $backColor ; ?>" type="text" id="title"  class="form-control" name="title" value="<?= $productComment[ 'title' ] ?>" >
                </div>
                <div class="col-md-6">
                    <div class="form-groups clearfix inputClone">
                        <label class="green">نقاط قوت</label>
                        <ul class="multi-fields" id="advantages">

                            <?php
                            if ( $arrTipStrength )
                            {
                                foreach ( $arrTipStrength AS $data )
                                {
                                    ?>
                                    <li style="display:inline ; margin-bottom: 12px" class="box">
                                        <input  type="text" <?php echo $disabled ; ?>  style="background-color:<?php echo $backColor ; ?>" name="strength[]" class="strengthInput" value="<?= $data ?>">
                                        <span class="icon-form-add button-remove" style="<?php echo $btnHide ; ?>"><i class="fa fa-minus" aria-hidden="true"></i></span>
                                    </li>
                                    <?php
                                }
                            }
                            else
                            {
                                ?>
                                <li style="display:inline ; margin-bottom: 12px" class="box">
                                    <input type="text" name="strength[]" >
                                    <span class="icon-form-add button-remove"><i class="fa fa-minus" aria-hidden="true"></i></span>
                                </li>
                                <?php
                            }
                            ?>
                            <li style="display:inline">
                                <span class="icon-form-add button-add" style="<?php echo $btnHide ; ?>"><i class="fa fa-plus add-field"  aria-hidden="true"></i></span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-groups clearfix inputClones">
                        <label class="green">نقاط ضعف</label>
                        <ul id="advantages">

                            <?php
                            if ( $arrTipWeak )
                            {
                                foreach ( $arrTipWeak AS $data )
                                {
                                    ?>
                                    <li style="display:inline ; margin-bottom: 12px" class="boxs">
                                        <input type="text" <?php echo $disabled ; ?>  style="background-color:<?php echo $backColor ; ?>" name="weakness[]" class="weaknessInput" value="<?= $data ?>">
                                        <span class="icon-form-add button-removes" style="<?php echo $btnHide ; ?>"><i class="fa fa-minus" aria-hidden="true"></i></span>
                                    </li>
                                    <?php
                                }
                            }
                            else
                            {
                                ?>
                                <li style="display:inline ; margin-bottom: 12px" class="boxs">
                                    <input type="text" name="weakness[]">
                                    <span class="icon-form-add button-removes"><i class="fa fa-minus" aria-hidden="true"></i></span>
                                </li>
                                <?php
                            }
                            ?>
                            <li style="display:inline">
                                <span class="icon-form-add button-adds" style="<?php echo $btnHide ; ?>"><i class="fa fa-plus"  aria-hidden="true"></i></span>
                            </li>
                        </ul>
                    </div>
                </div>
              
                <div class="clearfix"></div>
                <div class="form-groups-comment clearfix">
                    <label id="commentTextLabel"><span>متن نقد و بررسی شما (اجباری)</span></label>
                    <textarea <?php echo $disabled ; ?> style="background-color:<?php echo $backColor ; ?>"  id="commentText-product"  name="description" placeholder="متن خود را وارد نمایید"><?= $productComment[ 'description' ] ?></textarea>
                </div>
                <div class="SetComment" style="<?php echo $btnHide ; ?>">
                    <button  type="submit" class="SetRate ">ثبت دیدگاه</button>
                </div>

            </form>
        </div>
    </div>
</main>

<style>
    span.icon-form-add.addCF>i {
        padding-top: 4px;
    }
    ul#advantages>li>input {
        display: inline;
        width: 60%;
    }
    .form-groups.inputClone {
        margin-left: 53px;
        width: 460px;
    }
    .form-groups.inputClones {
        margin-left: 53px;
        width: 460px;
    }
    li.box>input {
        margin-bottom: 10px;
    }

    .inputClone span {
        margin-right: 10px;
        top: 4px;
        cursor: pointer;
        display: inline-block;
        text-align: center;
        height: 19px;
        width: 19px;
        background: #969ba8;
        border-radius: 100%;
        color: #f7f9fa;
        position: relative;
    }
    .inputClones span {
        margin-right: 10px;
        top: 4px;
        cursor: pointer;
        display: inline-block;
        text-align: center;
        height: 19px;
        width: 19px;
        background: #969ba8;
        border-radius: 100%;
        color: #f7f9fa;
        position: relative;
    }
    .form-groups.clearfix {
        margin-bottom: 22px;
    }
    label#subjectLable {
        display: block;
        font-size: 13px;
        color: #4d4d4d;
        margin-bottom: 8px;
    }
    .form-groups-comment.clearfix>input {
        /* width: 100%; */
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
        -webkit-appearance: none;
        direction: rtl;
        /* width: 64%; */
    }
    .form-groups.clearfix.inputClone input {
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
        -webkit-appearance: none;
        direction: rtl;
    }
    .form-groups.clearfix.inputClones input {
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
        -webkit-appearance: none;
        direction: rtl;
    }
    textarea#commentText-product {
        font-size: 12px;
        width: 100%;
        height: 190px;
        border: 1px solid #d4dbde;
    }
    label#commentTextLabel span {
        display: block;
        font-size :13px;
        color: #4d4d4d;
        margin-bottom: 8px;
    }
    .form-groups-comment.clearfix {
        margin-right: 15px;
        margin-left: 15px;
        margin-bottom: 20px;
    }
    .btn-setRate {
        position: absolute;
        left: 33px;
        bottom: 10px;
    }
    .wrapper.clearfix>h4 {
        color: #4d4d4d;
        font-size: 15px;
        margin-bottom: 38px;
        margin-right: 15px;
        margin-top: 34px;
        padding-left: 15px;
    }
    .form-groups-comment.clearfix>input {
        width: 62%;
    }
    @media screen and (max-width: 767px){
        .grid-row {
            width: auto;
            margin-bottom: 15px;
        }
        .form-groups.inputClone {
            margin-left: 53px;
            width: auto;
        }
        .form-groups.inputClones {
            margin-left: 53px;
            width: auto;
        }
        }
    .SetComment {
        -moz-box-shadow:inset 0px 39px 0px -24px #3ca4f4;
        -webkit-box-shadow:inset 0px 39px 0px -24px #3ca4f4;
        box-shadow:inset 0px 39px 0px -24px #3ca4f4;
        background-color:#3ca4f4;
        -moz-border-radius:4px;
        -webkit-border-radius:4px;
        border-radius:4px;
        border:1px solid #3ca4f4;
        display:inline-block;
        cursor:pointer;
        color:#ffffff;
        font-size:13px;
        padding: 1px 15px;
        text-decoration:none;
        float: left;
        margin-bottom: 14px;
        margin-left: 15px;
        text-shadow:0px 1px 0px #3ca4f4;
    }
    .SetComment:hover {
        background-color:#3ca4f4;
        color : #fff;
    }

    .SetComment:active {
        position:relative;
        top:1px;
    }

    ul#advantages>li>span>i {
        padding-top: 4px;
        padding-right: 1px;
    }

    ul#advantages>li>span>i {
        padding-top: 4px;
        padding-right: 1px;
    }
    li.boxs>input {
        margin-bottom: 10px;
    }
</style>
