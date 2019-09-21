<!-- page content -->
<main class="single-blog rtl" style="">
    <div class="container" >
        <div class="row">
            <div class="url-page-box">
                <div class="page-address-box padding-addressBar">
                    <i style="padding-left:3px;" class="fa fa-home"></i><a href="<?= \f\ifm::app ()->siteUrl ?>"><span class="address-name">خانه</span></a><span class="arrow-address5 fa fa-angle-left"></span><span class="address-name">تماس با ما</span>
                </div>
            </div>
        </div>
    </div>
    <div class="container   grid-row section-mainDetail contact_us_box">
        <?php
        if ($row['latitude'] && $row['longitude']) {
            ?>
            <div class="grid-row">
                <!-- map -->
                <section class="map">
                    <div class="google-map"
                         style="position: relative; background-color: rgb(229, 227, 223); overflow: hidden;height:250px;">
                        <iframe  height="100%" width="100%" src="http://raysanco.com/map/base.php/?latitude=<?=$row['latitude']?>&longitude=<?=$row['longitude']?>" frameborder="0">

                        </iframe>
                    </div>
                </section>
                <!--/ map -->
            </div>
            <?php
        }
        ?>
        <div class="" >
            <div class="col-md-3" style="margin-right: 0;">
                <section class="widget widget-sevices show-contact-in-mobile">
                    <div class="widget-title">اطلاعات تماس</div>
                    <ul>
                        <li>
                            <i class="fa fa-map-marker"></i>
                            <span><?= \f\ifm::faDigit($row[ 'address' ]) ?></span>
                        </li>
                        <li>
                            <i class="fa fa-phone-square"></i>
                            <span style="direction: ltr"><?= \f\ifm::faDigit($row[ 'phone' ]) ?></span>
                        </li>
                        <li>
                            <i class="fa fa-fax"></i>
                            <span style="direction: ltr"><?= \f\ifm::faDigit($row[ 'fax' ]); ?></span>
                        </li>
                        <li>
                            <i class="fa fa-mobile"></i>
                            <span style="direction: ltr"><?= \f\ifm::faDigit($row[ 'mobile' ]) ?></span>
                        </li>
                        <li>
                            <i class="fa fa-at"></i>
                            <a href="mailto:<?= $row[ 'email' ] ?>" style="direction: ltr"><?= $row[ 'email' ] ?></a>
                        </li>

                    </ul>

                </section>
                <section class="widget widget-sevices" style="margin-top: 8px">
                    <div class="widget-title"> شبکه های اجتماعی</div>
                </section>

                <div class="wpb_wrapper social-in-mobile" >
                    <?php
                    $param = '' ;
                    if ( $row[ 'twitter' ] )
                    {
                        $param .= "
        <a class='soc-icon fa fa-twitter' href='" . $row[ 'twitter' ] . "' target='_blank' title='توییتر'></a> 
    " ;
                    }
                    if ( $row[ 'Facebook' ] )
                    {
                        $param .= "
        <a class='soc-icon fa fa-facebook' href='" . $row[ 'Facebook' ] . "' target='_blank' title='فیسبوک'></a> 
    " ;
                    }
                    if ( $row[ 'Google' ] )
                    {
                        $param .= "
        <a class='soc-icon fa fa-google-plus' href='" . $row[ 'Google' ] . "' target='_blank' title='گوگل پلاس'></a> 
    " ;
                    }
                    if ( $row[ 'Instagram' ] )
                    {
                        $param .= "
        <a class='soc-icon fa fa-instagram' href='" . $row[ 'Instagram' ] . "' target='_blank' title='اینستاگرام'></a> 
    " ;
                    }
                    if ( $row[ 'Telegram' ] )
                    {
                        $param .= "
        <a class='soc-icon fa fa-paper-plane-o' href='" . $row[ 'Telegram' ] . "' target='_blank' title='تلگرام'></a> 
    " ;
                    }
                    if ( $row[ 'LinkedIn' ] )
                    {
                        $param .= "
        <a class='soc-icon fa fa-linkedin' href='" . $row[ 'LinkedIn' ] . "' target='_blank' title='لینکدین'></a> 
    " ;
                    }


                    echo $param ;
                    ?>
                </div>

            </div>
            <div class="col-md-9">
                <article class="feedback">

                    <div class="widget-title">دیدگاه شما</div>
                    <form method="post" action="<?= \f\ifm::app ()->siteUrl ?>api/cms/contact/contactSave" class="clearfix" id="contactform" novalidate="novalidate">
                        <fieldset>
                            <div class="clearfix">
                                <div class="" style="padding-bottom: 15px">
                                    <label for="name">نام شما : </label>
                                    <input type="text" name="name"  required>
                                </div>
                            </div>
                            <div class="clearfix">
                                <div class="" style="padding-bottom: 15px">
                                    <label for="email">پست الکترونیکی :</label>
                                    <input type="email" name="email" data-parsley-type="email" required>
                                </div>
                            </div>
                            <div class="clearfix">
                                <div class="" style="padding-bottom: 15px">
                                    <label for="contact_message">دیدگاه شما :</label>
                                    <textarea name="message"  cols="100" rows="6" placeholder="" data-parsley-required="" data-parsley-minLength="10" required></textarea>
                                </div>
                            </div>


                            <div class="clearfix captcha">
                                <div class="captcha-wrapper">

                                </div>
                                <button value="Submit"  class=" dk-button button form-control" type="submit">ارسال دیدگاه</button>
                            </div>
                        </fieldset>
                    </form>
                </article>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</main>

<script src="https://maps.googleapis.com/maps/api/js?key=<?= \f\ifm::app ()->googleMapKey ?>&v=3.exp&language=fa"></script>
<script>
    /**/
    /* google map */
    /**/

    function init_map()
    {
        var coordLat = <?= $row[ 'latitude' ] ?>;
        var coordLng = <?= $row[ 'longitude' ] ?>;
        if (jQuery(window).width() < 756)
        {
            delta = 0;
        }

        var point = new google.maps.LatLng(coordLat, coordLng);
        var center = new google.maps.LatLng(coordLat, coordLng);

        var mapOptions = {
            zoom: 15,
            center: center,
            scrollwheel: false,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        var map = new google.maps.Map(document.getElementById('map'), mapOptions);
        var image = 'images/gmap_default.png';
        var beachMarker = new google.maps.Marker({
            map: map,
            position: point
        });
    }
    init_map();
</script>
