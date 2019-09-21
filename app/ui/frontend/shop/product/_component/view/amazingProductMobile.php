<?php

            //\f\pre($amazingProducts);

            echo '<div class="services-item1 owl-carousel1">';
            foreach ( $amazingProducts AS $data )
            {
                ?>

                <div class="item1">
                    <div class="services-item-pic1">
                        <a href="<?= \f\ifm::app ()->siteUrl . 'productDetail/' . $data[ 'id' ] ?>"><img src="<?= \f\ifm::app()->fileBaseUrl . $data['picture'] ?>" alt="<?= $data['title'] ?>"
                                                                                                         class="img-responsive"></a>
                        <a href="<?= \f\ifm::app ()->siteUrl . 'productDetail/' . $data[ 'id' ] ?>"><h4><?= $data['categoryTitle'] ?></h4></a>
                    </div>
                </div>

                <?php
            }
            echo '</div>';
            ?>

    </div>



<?php
if ( ! empty ( $amazingProducts ) )
{
    //if ( $_COOKIE[ 'width' ] <= 700 && $_COOKIE[ 'width' ] )
    //{
    ?>
    <!--    <div class="mobile-view">
            <div data-slick='{"slidesToShow": 4, "slidesToScroll": 4}' class="sliderFooter" style="width:88%;margin: 0 auto;margin-top: 20px;direction: ltr;background: none">
    <?php
    foreach ( $amazingProducts AS $data )
    {

        $time = $this->dateG->timeDate ( $data[ 'date_end' ], 2 ) ;

        $diff = $time - time () + 86400 ;
        if ( strlen ( $data[ 'price' ] ) > 6 )
        {
            $price = number_format ( $data[ 'price' ] / 1000000, 3 ) ;
            $unit  = 'میلیون تومان' ;
            $last  = number_format ( ($data[ 'price' ] - $data[ 'discount' ]) / 1000000,
                3 ) ;
        }
        else
        {
            $price = number_format ( ($data[ 'price' ] / 1000 ) ) ;
            $unit  = 'هزار تومان' ;
            $last  = number_format ( ($data[ 'price' ] - $data[ 'discount' ]) / 1000 ) ;
        }
        ?>
                                        <div style="margin:0px;">
                                            <div class="amazing-mobile-title">
                                                پیشنهاد <span>شگفت انگیز</span>
                                            </div>
                                            <div class="amazing-mobile-price" style="">
                                                <div class="amazing-mobile-off-price" ><s><?= $price ?></s></div>
                                                <div class="amazing-mobile-main-price">
        <?= $last . ' ' . $unit ?>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                            <a  href="<?= \f\ifm::app ()->siteUrl . 'productDetail/' . $data[ 'id' ] ?>">
                                                <div style="height :150px">
                                                    <img style="margin: 0 auto; max-height : 100%" class="img-responsive" src="<?= \f\ifm::app ()->fileBaseUrl . $data[ 'picture' ] ?>" alt=" <?php echo $data[ 'title' ] ?>" >
                                                </div>
                                                <h3 class="amazing-mobile-product-title">
        <?php echo $data[ 'title' ] ; ?>
                                                </h3>
                                            </a>




                                        </div>

        <?php
    }
    ?>
            </div>
        </div>-->
    <?php
    //}
    //else
    //{
    ?>
    <!--    <div class="desktop-view">


            <div class="sec-slider">
                <div id="jssor_2" style="position: relative; margin: 0 auto; top: 0px; left: 0px; width: 700px; height: 300px; overflow: hidden; visibility: hidden; background-color: #ffffff;">
                     Loading Screen
                    <div data-u="loading" style="position: absolute; top: 0px; left: 0px;">
                        <div style="filter: alpha(opacity=70); opacity: 0.7; position: absolute; display: block; top: 0px; left: 0px; width: 100%; height: 100%;"></div>
                        <div style="position:absolute;display:block;background:url('img/loading.gif') no-repeat center center;top:0px;left:0px;width:100%;height:100%;"></div>
                    </div>
                    <div class="iu respons-custome" data-u="slides" style="cursor: default; position: relative; top: 0px; left: 160px; width: 680px; height: 298px; overflow: hidden;">

    <?php
    //\f\pre($amazingProducts);
    foreach ( $amazingProducts AS $data )
    {

        $time = $this->dateG->timeDate ( $data[ 'date_end' ], 2 ) ;

        $diff = $time - time () + 86400 ;
        if ( strlen ( $data[ 'price' ] ) > 6 )
        {
            $price = number_format ( $data[ 'price' ] / 1000000, 3 ) ;
            $unit  = 'میلیون تومان' ;
            $last  = number_format ( ($data[ 'price' ] - $data[ 'discount' ]) / 1000000,
                3 ) ;
        }
        else
        {
            $price = number_format ( ($data[ 'price' ] / 1000 ) ) ;
            $unit  = 'هزار تومان' ;
            $last  = number_format ( ($data[ 'price' ] - $data[ 'discount' ]) / 1000 ) ;
        }
        ?>
                                                <div>
                                                    <div class="respons-custome" style="position: absolute; top: 0px; left: 0px; width: 680px; height: 299px;">
                                                        <div class="col-md-6 col-sm-6 col-xs-7" style="height:100%">
                                                            <div class="price-label">
                                                                <span> پیشنهاد شگفت انگیز</span>
                                                            </div>

                                                            <span class="offer-element">
                                                                <div style="transform:skew(-20deg);"><s><?php echo $price ; ?></s></div>
                                                            </span>
                                                            <span class="offer-element-end-price"><div style="transform:skew(-20deg)"><?= $last . ' ' . $unit ?></div></span>
                                                            <div class="discription">
                                                                <div class="all-discription">
                                                                    <div><span><?php echo $data[ 'content' ] ; ?></span></div>
                                                                    <span></span>
                                                                    <span></span>
                                                                </div>
                                                            </div>
                                                            <div class="time-remaining" style="position: absolute;bottom: 5px;">
                                                                <div style="margin:0px;text-align: right;color:gray;font-size:16px">فرصت باقی مانده برای این پیشنهاد</div>
                                                                <div class="clock-offer">
                                                                    <div class="clock<?= $data[ 'id' ] ?>" ></div>
                                                                    <div class="message<?= $data[ 'id' ] ?>"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-6 col-xs-5">
                                                            <div class="offer-picture">
                                                                <div class="img-tab-slider">
                                                                    <a href="<?= \f\ifm::app ()->siteUrl . 'productDetail/' . $data[ 'id' ] ?>"><span class="text-pro-off"><?php echo $data[ 'title' ] ; ?></span>
                                                                        <img class="img-responsive" src="<?= \f\ifm::app ()->fileBaseUrl . $data[ 'picture' ] ?>" alt=" <?php echo $data[ 'title' ] ?>" ></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div style="color:red" data-u="thumb"><?php echo $data[ 'categoryTitle' ] ; ?></div>
                                                </div>
                                                <script>
                                                    var clock;
                                                    jQuery(document).ready(function () {
                                                        var clock;
                                                        clock = $('.clock<?= $data[ 'id' ] ?>').FlipClock({
                                                            clockFace: 'DailyCounter',
                                                            autoStart: false,
                                                            callbacks: {
                                                                stop: function () {
                                                                    $('.message<?= $data[ 'id' ] ?>').html('پایان پیشنهاد شگفت انگیز')
                                                                }
                                                            }
                                                        });
                                                        clock.setTime(<?= $diff ?>);
                                                        clock.setCountdown(true);
                                                        clock.start();
                                                    });
                                                </script>

        <?php
    }
    ?>
                    </div>
                     Thumbnail Navigator
                    <div data-u="thumbnavigator" class="jssort13" style="left:0px;top:0px;width:100px;height:150px;">
                         Thumbnail Item Skin Begin
                        <div data-u="slides" class="set-slider-custome"  style="cursor: default; top: 0px; left: 0px; border-top: 1px solid gray; width:100px !important;">
                            <div data-u="prototype"  class="p">
                                <div  class="w">
                                    <div  data-u="thumbnailtemplate" class="c"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>-->
    <?php
    //}
}
?>
<!--<script>-->
<!--    if ($(window).width() <= 767)-->
<!--    {-->
<!--        $('.desktop-view').remove();-->
<!--    } else-->
<!--    {-->
<!--        $('.mobile-view').remove();-->
<!--    }-->
<!--</script>-->
<!--<style>-->
<!--    .owl-item img {-->
<!--        max-height: 153px;-->
<!--        padding-top: 10px;-->
<!--    }-->
<!--</style>-->
