<input type="hidden" value="<?= $row['id'] ?>" name="product_id" id="product_id"/>
<div class="title-product">
    <?= $row['title'] ?>
</div>
<div class="container " style="padding-left:0px;padding-right:0px;">
    <div class="sliderMobile1 product">
        <div id="owl-demo" class="owl-carousel owl-theme">
            <?php
            foreach ( $picture AS $data )
            {
                ?>
                <div class="item">
                    <img class="b-lazy img-responsive" src="<?php echo $data['path'] ?>"
                         alt="<?php echo $row['title'] ?>">
                </div>
                <?php
            }
            ?>
        </div>

        <div class='product_left_side clearfix'>
            <div class='product_status product_status_1'>
                <i class='status-icon'></i>
                وضعیت: <span class='ps1'>موجود									</span>
            </div>
            <?php if ( !empty ( $colors ) )
            { ?>
                <div class='text-select-color'>
                    <i class='color-icon'></i>

                    <div class="select-color-product">
                        <?php
                        $checked = "checked";

                        foreach ( $colors AS $data )
                        {
                            ?>
                            <div class="roundedTwo">
                                <input name="colorSelect" type="radio" onclick="getGurantee(this.value)"
                                       style="opacity :0 !important;" id="roundedTwo<?= $data['color_id'] ?>"
                                       value="<?= $data['color_id'] ?> " <?= $checked ?> class="colorSelect"/>
                                <label style="background-color: <?= $data['color_code'] ?>;"
                                       for="roundedTwo<?= $data['color_id'] ?>"><span
                                            style="margin-right: 25px;"><?= $data['color_title'] ?> </span></label>
                            </div>
                            <?php
                            $checked = "";
                        }
                        ?>
                    </div>
                </div>
                <?php
            }
            ?>
            <?php // \f\pre($colors);?>
            <?php if ( !empty ( $colors ) )
            { ?>
                <div id="sbHolder" class="sbHolder" tabindex="0">
                    <i class='warranty-icon'></i>

                    <div class="styled-select">
                        <select id="garanty" name="garanty">
                        </select>
                    </div>
                </div>
                <?php
            }
            ?>

            <div class="button-addCart desktop-view">
                <a href="#" class="button-addToCart" onclick=""><span
                            class="desktop-view fa fa-shopping-basket"></span>استعلام قیمت با شماره 03132318258</a>
            </div>
        </div>


    </div>
    <div class='product_down_side col-xs-12 product'>
        <div class='product_text' style="margin-bottom: 10px;position:relative">
            <b class='product-text-header'>معرفی اجمالی محصول</b>
            <h2 style="margin-top:0px;"><?= $row['title'] ?></h2>
            <h3 style="font-size:13px;margin-top:0px;color:#aaa"><?= $row['sub_title'] ?></h3>
            <hr/>
            <div class="body-text" style="">
                <p> <?= $row['short_explanation'] ?></p></div>
            <span class="arrow-btn-box"><i class="fa fa-angle-double-down arrow-btn" aria-hidden="true"></i>
</span>
        </div>

    </div>


    <div class="tab">
        <button class="tablinks" onclick="openTab(event, 'review')">نقد و بررسی</button>
        <button class="tablinks" onclick="openTab(event, 'features')">مشخصات فنی</button>
        <button class="tablinks" onclick="openTab(event, 'comments')">نظرات کاربران</button>
    </div>
    <div class="beforeTab"></div>
    <div id="review" class="tabcontent">
        <?= $row['review'] ?>
    </div>

    <div id="features" class="tabcontent">
        <div class="content-Technical-Specifications">
            <div class="title-device">
                <h4 class="title-Technical-Specifications">مشخصات فنی</h4>
                <h2 class="product_seo_title-Technical"><?= $row['title'] ?></h2>
            </div>

            <?php
            $label = '';

            foreach ( $feature AS $valueArr )
            {
                foreach ( $valueArr AS $data )
                {
                    if ( $data['featureTitle'] != $label )
                    {
                        //  \f\pr($data['featureTitle']);
                        $label = $data['featureTitle'];
                        ?>
                        <div class="title-device">
                            <h4 class="title"><i class="fa fa-caret-left"></i><span><?= $data['featureTitle'] ?></span>
                            </h4>
                        </div>
                        <?php
                    }

                    if ( $data['type'] == 'multiSelect' )
                    {
                        foreach ( $value[$data['fId']] AS $data1 )
                        {
                            $val2[] = $wiki[$data1];
                        }
                        $val = implode( ' ، ',$val2 );
                    } else if ( $data['type'] == 'oneSelect' )
                    {
                        $val = $wiki[$value[$data['fId']]];
                    } else if ( $data['type'] == 'yesOrNo' )
                    {
                        $val = $value[$data['fId']];

                        if ( $val == 'no' )
                        {
                            $val = '<i class="fa fa-times" style="font-size:20px;color: #FF6A6C;"></i>';
                        } else if ( $val == 'yes' )
                        {
                            $val = '<i class="fa fa-check" style="font-size:20px;color: #4CAF50"></i>';
                        }
                    } else
                    {
                        $val =  nl2br($value[$data['fId']]);
                    }
                    if ( $val )
                    {
                        ?>
                        <div class="Technical-Specifications-device">
                            <div class="col-md-3 col-sm-3">
                                <div class="title-Technical-Speci">
                                    <span><?= $wiki[$data['id']] ?></span>
                                </div>
                            </div>
                            <div class="col-md-9 col-sm-9" style="padding-left:0px">
                                <div class="content-Technical-Speci ">
                                    <span><?= $val ? $val : '-' ?></span>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <?php
                        $color = "";
                    }
                }
            }
            ?>

        </div>


    </div>

    <div id="comments" class="tabcontent">
        <div class="Comments-box">
            <div class="col-md-6">
                <div class="Comments-user">
                    <h4 class="title">
                        <i class="fa fa-caret-left"></i>
                        <span>امتیاز کاربران به  : </span>
                        <span class="product-name-device"><?= $row['title'] ?></span>
                    </h4>
                </div>
                <?php
                if ( $ratingTitle )
                {
                    foreach ( $ratingTitle AS $key => $data )
                    {
                        ?>
                        <div class="rangeBar-box">
                            <div class="col-sm-4">
                                <div class="title-range-span">
                                    <span class="title-range"><?= $data ?></span>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="rating-bar">
                                                                            <span data-value="<?= $arrRatingValue[$key] ?>"
                                                                                  class="graph">
                                                                                <div class="graph__container">
        <?php
        $rate = $arrRatingValue[$key];
        if ( $rate > 4 )
        {
            $color = '#218325';
        } else
        {
            $color = '#69ca6d';
        }
        for ( $i = 1; $i <= 5; $i++ )
        {
            if ( $rate >= $i )
            {
                if ( $rate > 4 )
                {
                    $class = 'perfect';
                } else
                {
                    $class = 'done';
                }
            } else if ( ( $rate > $i - 1 && $rate < $i && $rate > !$i ) )
            {
                $value = ( $i - $rate ) * 100;
                $span  = '<div  style="background:' . $color . ';height:100%;width:' . $value . '%"></div>';
            }
            echo "<span class='graph__item $class'>$span</span>";
            $span  = '';
            $class = '';
        }
        ?>
                                                                                </div>
                                                                            </span>
                                </div>
                            </div>
                            <div class="clearfix">
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
                <div class="all-Comments-user">
                    <h4 class="title">
                        <i class="fa fa-caret-left"></i>
                        <span> نظرات کاربران</span>
                        <span class="product-name-device fa-digit">( <?= count( $comments ) - 1 ?> نظر )</span>
                    </h4>
                </div>
            </div>
            <div class="col-md-6">
                <div class="ratings clearfix" style="margin-bottom: 0px">
                    <span class="pull-right fa-digit"
                          style="padding-left: 10px;direction: rtl"> <?= $row['rate_avg'] . ' از 5' ?></span>
                    <div class="author-ratings pull-right" style="padding: 2px 2px 0px;">
                        <?php
                        $rate = $row['rate_avg'];
                        for ( $i = 0; $i < 5; $i++ )
                        {
                            if ( $rate > $i && $rate >= $i + 1 )
                            {
                                echo '<i class="fa fa-star"></i>';
                            } else if ( $rate > $i && $rate < $i + 1 )
                            {
                                echo '<i class="fa fa-star-half-o"></i>';
                            } else
                            {
                                echo '<i class="fa fa-star-o"></i>';
                            }
                        }
                        ?>
                    </div>
                    <div class="pull-right fa-digit" style="direction: rtl;font-size: 12px;padding: 2px 10px 0px;">
                        ( <?= $row['rate_count'] . ' نفر' ?> )
                    </div>

                </div>
                <div class="invate-comment-box">
                    <span>نظر خود را درباره این کالا ثبت کنید </span>
                    <h5 class="invate-comment-text">برای ثبت نظرات، نقد و بررسی شما لازم است ابتدا وارد حساب کاربری خود
                        شوید. اگر این محصول را قبلا از رایسان خریده باشید، نظر شما به عنوان مالک محصول ثبت خواهد
                        شد.</h5>
                    <a onclick="goToRate()" class="set-comment-btn">نظر خود را بنویسید</a>
                </div>

            </div>
            <div class="clearfix"></div>
            <hr class="line-bot-comment">
        </div>
        <?php
        if ( $comments )
        {
            foreach ( $comments AS $data )
            {
                if ( $data != NULL )
                {
                    ?>
                    <div class="comment-box">
                        <div class="read-comment-header">
                            <div class="col-md-6">
                                <ul class="userName-comment">
                                    <li><i class="fa fa-certificate" aria-hidden="true"></i></li>
                                    <li><span class="name-user  "><?= $data['name'] ?></span></li>
                                    <li><span class="type-user fa-digit">( <?=
                                            $this->dateG->dateTime( $data['date_register'],
                                                2 ) . ' ساعت : ' . date( 'H:i',
                                                $data['date_register'] )
                                            ?> )</span></li>
                                </ul>
                            </div>

                            <div class="clearfix"></div>
                        </div>
                        <div class="study-device">
                            <div class="col-md-5">
                                <div class="range-bar-user">
                                    <?php
                                    if ( $ratingTitle )
                                    {
                                        foreach ( $ratingTitle AS $key => $data2 )
                                        {
                                            ?>
                                            <div class="rangeBar-box">
                                                <div class="col-sm-4">
                                                    <div class="title-range-span">
                                                        <span class="title-range"><?= $data2 ?></span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-8">
                                                    <div class="rating-bar"><span
                                                                data-value="<?= $data['rate'][$key] ?>" class="graph">
                                                                                                    <div class="graph__container"><span
                                                                                                                class="graph__item"></span><span
                                                                                                                class="graph__item"></span><span
                                                                                                                class="graph__item"></span><span
                                                                                                                class="graph__item"></span><span
                                                                                                                class="graph__item"></span></div></span>
                                                    </div>
                                                </div>
                                                <div class="clearfix">
                                                </div>
                                            </div>
                                            <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <h3 class="commentSubject">
                                <?= $data['title'] ?>
                            </h3>
                            <div class="Scrutiny">
                                <?php
                                if ( $data['strenght'] || $data['weakness'] )
                                {
                                    ?>
                                    <div class="col-md-6">
                                        <i class="fa fa-arrow-up Final-review-arrow" aria-hidden="true"></i><span
                                                style="color:#4caf50">نقاط  قوت</span>
                                        <ul>
                                            <?php
                                            foreach ( $data['strenght'] AS $key2 => $strenght )
                                            {
                                                echo "<li>$strenght</li>";
                                            }
                                            ?>
                                        </ul>
                                    </div>

                                    <div class="col-md-6">
                                        <i class="fa fa-arrow-down Final-review-arrow" aria-hidden="true"
                                           style="color:red"></i><span>نقاط ضعف</span>
                                        <ul>
                                            <?php
                                            if ( $data['weakness'] )
                                            {
                                                foreach ( $data['weakness'] AS $key2 => $weakness )
                                                {
                                                    echo "<li>$weakness</li>";
                                                }
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                    <?php
                                }
                                ?>
                                <div class="clearfix"></div>
                            </div>
                            <p class="descriptionSec">
                                <?= $data['description'] ?>
                            </p>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <?php
                }
            }
        }
        ?>
    </div>
</div>
<input type="hidden" id="select_price" name="select_price">
<input type="hidden" id="priceIdh" name="priceIdh" value="<?= $priceId ?>"/>
