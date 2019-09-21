<?php
if ( $row[ 'status' ] == 'enabled' )
{
    $this->registerGadgets ( array (
        'dateG' => 'date' ) ) ;
    ?>
    <section class="page-title">
        <div class="grid-row clearfix">
            <h1></h1>

            <nav class="bread-crumbs">
                <a href="<?= \f\ifm::app ()->siteUrl ?>"><i class="fa fa-home"></i> <?= 'خانه' ?></a>
                &nbsp;&nbsp;<i class="fa fa-angle-left"></i>&nbsp;
                <a href="<?= \f\ifm::app ()->siteUrl ?>news/"><?= 'اخبار' ?></a>
                &nbsp;&nbsp;<i class="fa fa-angle-left"></i>&nbsp;
                <a href="<?= \f\ifm::app ()->siteUrl ?>newsDetail/<?= $row[ 'id' ] ?>"><?= $row[ 'title' ] ?></a>
            </nav>
        </div>
    </section>
    <section class="single-blog" style="direction: rtl;min-height: 340px">
        <div class="container" >
            <div class="row">
                <div class="col-sm-12">

                    <div >

                        <div class="widget blog-media white-block" >
                            <div class="blog-title" style="font-size: 13px;border-bottom: 1px solid #eee;color:silver;padding-bottom: 15px;margin-bottom: 10px">
                                <div class="pull-right">
                                    <?php
                                    $date = $this->dateG->dateTime ( $row[ 'date_register' ],
                                                                     1 ) ;
                                    echo 'تاریخ ثبت خبر :' . $this->dateG->dateGrToJa ( $date,
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
                                <img src="<?= \f\ifm::app ()->fileBaseUrl . $row[ 'picture' ] ?>" class="alignleft" style="max-width:260px;border:1px solid #e4e4e4;padding:3px" align="left">
                                <h2 style="font-size:18px"><?= $row[ 'title' ] ?></h2>
                                <div style="color:silver;padding: 5px 0px 10px"><?= $row[ 'short' ] ?></div>
                                <?= $row[ 'content' ] ?>
                            </div>


                        </div>

                    </div>
                    <br></br>
                </div>

            </div>
        </div>
    </section>
    <?php
}
?>

