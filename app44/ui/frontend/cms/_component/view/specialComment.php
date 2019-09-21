<div class="teaser_content media">
    <div class="" style="width:100%;text-align:center;direction: rtl">

        <h3 style="font-size:22px;color:#FFF">
            <i class="fa fa-comments"></i> دیدگاه های کاربران
        </h3>


    </div>

    <div style="direction:rtl">
        <?php
        if ( count ( $row ) > 1 )
        {
            $id = 'review-carousel' ;
        }
        ?>

        <div id="<?= $id ?>" class="owl-carousel testimonials-carousel">
            <?php
            //\f\pr($row);
            $this->registerGadgets ( array ( 'dateG' => 'date' ) ) ;
            foreach ( $row AS $data )
            {
                $diff = $this->dateG->secondsToTime ( $data[ 'date_register' ] ) ;
                ?>
                <div class="item">
                    <p style="direction: rtl">
                        <?= nl2br ( $data[ 'comment' ] ) ?>
                    </p>
                    <div style="direction: rtl">
                        <a class="pull-right "  style="padding-left:10px">
                            <img class="media-object" src="<?= \f\ifm::app ()->fileBaseUrl . $data[ 'picture' ] ?>" alt="">
                        </a>
                        <div class="pull-right">
                            <h4><?= $data[ 'name' ] ?></h4>
                            <p style="color:#eee;font-size:12px">
                                <?= $diff[ 'val' ] . ' ' . \f\ifm::t ( $diff[ 'key' ] ) . ' قبل' ?>


                            </p>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>

    </div>
</div>