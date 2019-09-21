<?
if ( $row[ 'status' ] == 'enabled' )
{
    $this->registerGadgets ( array ( 'dateG' => 'date' ) ) ;
    ?>
    <section class="breadcrumbs white-block">
        <div class="container">
            <div class="clearfix">
                <div class="pull-right">
                    <ul class="list-unstyled list-inline breadcrumbs-list" style="padding-right:0px">
                        <li>
                            <a href="<?= \f\ifm::app ()->siteUrl ?>"><i class="fa fa-home"></i> <?= 'خانه' ?></a>
                        </li>
                        <li>
                            <a href="<?= \f\ifm::app ()->siteUrl ?>content/"><?= 'مطالب و مقالات' ?></a>
                        </li>
                        <li>
                            <a href="<?= \f\ifm::app ()->siteUrl ?>content/<?= $row[ 'section' ] ?>"><?= $row[ 'secTitle' ] ?></a>
                        </li>
                        <li><?= $row[ 'title' ] ?></li>
                    </ul>			
                </div>
                <div class="pull-right">
                </div>
            </div>
        </div>
    </section>
    <section class="single-blog">
        <div class="container" >
            <div class="row">
                <div class="col-sm-8">

                    <div >

                        <div class="widget blog-media white-block" >
                            <div class="blog-title" style="font-size: 13px;border-bottom: 1px solid #eee;color:silver;padding-bottom: 15px;margin-bottom: 10px">
                                <div class="pull-right">
                                    <?
                                    $date   = $this->dateG->dateTime ( $row[ 'date_register' ],
                                                                       1 ) ;
                                    echo 'تاریخ ثبت مطلب : ' . $this->dateG->dateGrToJa ( $date,
                                                                                          2 ) . ' ، ' . date ( "H:i",
                                                                                                               $row[ 'date_register' ] ) ;
                                    ?>
                                </div>
                                <div class="pull-left">
                                    <?
                                    echo $row[ 'visit' ] . ' بازدید' ;
                                    ?>
                                </div>
                                <div class="clearfix"></div>

                            </div>
                            <div>
                                <img src="<?= \f\ifm::app ()->fileBaseUrl . $row[ 'picture' ] ?>" style="max-width:200px" align="left">
                                <h2 style="font-size:18px"><?= $row[ 'title' ] ?></h2>
                                <div style="color:silver;padding: 5px 0px 10px"><?= $row[ 'short' ] ?></div>
                                <?= $row[ 'content' ] ?>
                            </div>
                            <?
                            if ( $keyword )
                            {
                                echo '<div style="border-top:1px dashed #eee;padding: 5px 0px 10px;margin: 20px 0px 10px 0px;direction: rtl; ">
                               <div style="padding-bottom:5px">کلمات کلیدی : </div>' ;
                                echo $keyword . ' </div>' ;
                            }
                            ?>

                        </div>
                        <?
                        if ( ! empty ( $related ) )
                        {
                            ?>
                            <div class="widget white-block" >
                                <div class="blog-title" style="font-size: 18px;border-bottom: 1px solid #eee;padding-bottom: 15px;margin-bottom: 10px">
                                    <div class="pull-right">
                                        <i class="fa fa-file-text-o"></i> <?= 'مطالب و مقالات مرتبط' ?>
                                    </div>

                                    <div class="clearfix"></div>


                                </div>
                                <?
                                foreach ( $related AS $data )
                                {
                                    ?>
                                    <div style="direction: rtl;padding-bottom: 10px">
                                        <a target="_blank" href="<?= \f\ifm::app ()->legacyBaseUrl . 'contentDetail/' . $data[ 'id' ] ?>">
                                            <i class="fa fa-circle-o"></i> <?= $data[ 'title' ] ?>
                                        </a>
                                    </div>

                                    <?
                                }
                                ?>


                            </div>
                            <?
                        }
                        ?>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="widget white-block" style="min-height: 500px">
                        <div class="blog-title" style="font-size: 18px;border-bottom: 1px solid #eee;padding-bottom: 15px;margin-bottom: 10px">
                            <div class="pull-right">
                                <i class="fa fa-file-text-o"></i> <?= 'آخرین مطالب و مقالات' ?>
                            </div>

                            <div class="clearfix"></div>


                        </div>
                        <?
                        echo \f\ttt::block ( 'cms.getContentList',
                                             array (
                            'limit'  => 6,
                            'type'   => 'last',
                            'status' => 'enabled'
                        ) )
                        ?>

                    </div>
                </div>


            </div>
        </div>
    </section>


    <?
}
?>

