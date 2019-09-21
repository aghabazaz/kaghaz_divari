<?php
if ( $row[ 'status' ] == 'enabled' )
{
    $this->registerGadgets ( array (
        'dateG' => 'date' ) ) ;
    ?>
    <section class="single-blog" style="direction: rtl">
        <div class="container" >
            <div class="url-page-box">
                <div class="page-address-box padding-addressBar">
                    <i style="padding-left:3px;" class="fa fa-home"></i><span class="address-name">
                    <a href="<?= \f\ifm::app()->siteUrl ?>">خانه</a></span>
                    <span class="arrow-address5 fa fa-angle-left"></span>
                    <a href="<?= \f\ifm::app()->siteUrl ?>">مطالب و مقالات</a></span>
                    <span class="arrow-address5 fa fa-angle-left"></span>
                    <span class="address-name">
                    <a href="<?= \f\ifm::app()->siteUrl.'contentDetail/'.$row[ 'id' ]?>"><?= $row[ 'title' ] ?></a>
                </span>
                </div>
            </div>

            <div class="row noMarginRightLeft boxInfo">

                <div class="col-sm-12">

                    <div >

                        <div class="widget blog-media white-block" >
                            <div class="blog-title" style="font-size: 13px;border-bottom: 1px solid #eee;color:silver;padding-bottom: 15px;margin-bottom: 10px">
                                <div class="pull-right">
                                    <?php
                                    $date = $this->dateG->dateTime ( $row[ 'date_register' ],
                                                                     1 ) ;
                                    echo 'تاریخ ثبت مطلب : ' . $this->dateG->dateGrToJa ( $date,
                                                                                          2 ) . ' ، ' . date ( "H:i",
                                                                                                               $row[ 'date_register' ] ) ;
                                    ?>
                                </div>
                                <div class="pull-left">
                                    <?php
                                    echo $row[ 'visit' ] . ' بازدید' ;
                                    ?>
                                </div>
                                <div class="clearfix"></div>

                            </div>
                            <div>
                                <img alt="<?= $row[ 'title' ] ?>" src="<?= \f\ifm::app ()->fileBaseUrl . $row[ 'picture' ] ?>" class="alignleft img-responsive" style="border:1px solid #e4e4e4;padding:3px" align="left">
                                <h1 class="main-title-content" style="font-size:18px;margin-top: 15px;"><?= $row[ 'title' ] ?></h1>
                                <div style="line-height:29px;padding: 5px 0px 10px"><?= $row[ 'short' ] ?></div>
                                <?= $row[ 'content' ] ?>
                            </div>
                            <?php
                            if ( $keyword )
                            {
                                echo '<div style="border-top:1px dashed #eee;padding: 5px 0px 10px;margin: 20px 0px 10px 0px;direction: rtl; ">
                            <div style="padding-bottom:5px">کلمات کلیدی : </div>' ;
                                echo $keyword . ' </div>' ;
                            }
                            ?>

                        </div>
                        <?php
                        if ( ! empty ( $related ) )
                        {
                            ?>
                            <div class="widget white-block" >
                                <div class="blog-title" style="margin-top:35px;font-size: 18px;border-bottom: 1px solid #eee;margin-bottom: 18px">
                                    <div class="pull-right">
                                        <div class="widget-title"><?= 'مطالب و مقالات مرتبط' ?></div>

                                    </div>

                                    <div class="clearfix"></div>


                                </div>
                                <?php
                                foreach ( $related AS $data )
                                {
                                    ?>
                                    <div class="col-md-4">
                                        <a target="_blank" href="<?= \f\ifm::app ()->legacyBaseUrl . 'contentDetail/' . $data[ 'id' ] ?>">
                                        <img alt="<?= $data[ 'title' ] ?>" src="<?= \f\ifm::app ()->fileBaseUrl . $data[ 'picture' ] ?>" class="alignleft img-responsive" >
                                        </a>
                                        <div style="direction: rtl;padding-bottom: 10px">
                                            <a class="link-related-title" target="_blank" href="<?= \f\ifm::app ()->legacyBaseUrl . 'contentDetail/' . $data[ 'id' ] ?>">
                                                <i class="fa fa-circle-o"></i> <?= $data[ 'title' ] ?>
                                            </a>
                                        </div>
                                    </div>

                                    <?php
                                }
                                ?>

                                <div class="clearfix"></div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <br></br>
                </div>
                <div class="col-sm-2"></div>

            </div>
        </div>
    </section>
    <?php
}
?>
<style>
    a.link-related-title {
        line-height: 24px;
        color: #000000a6;
        font-size: 12px;
    }
    .widget.white-block img {
        margin-bottom: 11px;
        margin-right:10px;
    }
    h1.main-title-content {
        display: inline-block;
        line-height: 23px;
    }
    .page-title {
        border-top-color: #242f3e !important;
        background-color: #242f3e !important;
    }
    .grid-row {
        width: 1170px;
        margin: 0 auto 60px;
    }
    .page-title .grid-row {
        margin-bottom: 0;
    }
    span.tollbar-title {
        line-height: 48px;
    }
    span.tollbar-title {
        font-size: 16px;
    }
    .widget.white-block {
        margin-bottom: 25px;
    }
    .page-title {
        margin-bottom: 50px;
        border-top-width: 7px;
        border-top-style: solid;
        color: #fff;
        direction: rtl;
    }
    .page-title h1 {
        float: right;
        padding: 18px 0;
        font-size: 15px;
        line-height: 28px;
        text-transform: uppercase;
    }
    .page-title nav {
        float: left;
        margin-left: 0px;
        padding: 22px 0;
        font-size: 13px;
        line-height: 20px;
    }
    .page-title nav a {
        color: #fff;
        font-size: 11px;
    }
    .registerUp i, p {
        display: block !important;
    }
</style>

