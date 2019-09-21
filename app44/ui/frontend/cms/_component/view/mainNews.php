<div class="teaser_content media">
    <div style="width:100%;text-align:center;direction: rtl">

        <h3 style="font-size:22px;color:#FFF">
            <i class="fa fa-rss"></i> اخبار و اطلاعیه ها
        </h3>


    </div>

    <div style="margin-top: 30px" class="widget-doctors">
        <ul>
            <?php
            $this->registerGadgets ( array ( 'dateG' => 'date' ) ) ;
            foreach ( $row AS $data )
            {
                $diff = $this->dateG->secondsToTime ( $data[ 'date_register' ] ) ;
                ?>
                <li>
                    <div  class="testimonials-carousel" style="padding:0px">
                        <div style="direction: rtl">
                            <a class="pull-right "  style="padding-left:10px">
                                <img style="width:50px;height:50px" class="media-object" src="<?= \f\ifm::app ()->fileBaseUrl.$data['picture'] ?>" title="<?= $data['title'] ?>" alt="<?= $data['title'] ?>">
                            </a>
                            <div class="pull-right">
                                <h4>
                                    <a href="<?=  \f\ifm::app ()->siteUrl.'newsDetail/'.$data['id']?>" style="color:#fff;">
                                        <?= $data['title'] ?>
                                    </a>

                                </h4>
                                <p>
                                </p>
                            </div>
                            <div class="pull-left">
                                <div style="color:#eee;font-size:11px">
                                    <?= $diff[ 'val' ] . ' ' . \f\ifm::t ( $diff[ 'key' ] ).' قبل'?>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>

                </li>
                <?php
            }
            ?>

            

        </ul>

    </div>
</div>