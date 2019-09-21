<section class="breadcrumbs white-block">
    <div class="container">
        <div class="clearfix">
            <div class="pull-right">
                <ul class="list-unstyled list-inline breadcrumbs-list" style="padding-right:0px">
                    <li>
                        <a href="<?= \f\ifm::app ()->siteUrl ?>"><i class="fa fa-home"></i> <?= 'خانه' ?></a>
                    </li>
                    <?php
                    if ( $sRow[ 'id' ] )
                    {
                        ?>
                        <li>
                            <a href="<?= \f\ifm::app ()->siteUrl ?>content/"><?= 'مطالب و مقالات' ?></a>
                        </li>
                        <li>
                            <?= $sRow[ 'title' ] ?>
                        </li>
                        <?php
                    }
                    else
                    {
                        ?>
                        <li>
                            <?= 'مطالب و مقالات' ?>
                        </li>
                        <?php
                    }
                    ?>


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


            <div class="widget blog-media white-block" >
                <div class="blog-title" style="font-size: 18px;border-bottom: 1px solid #eee;color:silver;padding-bottom: 15px;margin-bottom: 10px">
                    <div class="pull-right">
                        <?= 'مطالب و مقالات' ?>
                        <?php
                        if($sRow[ 'id' ] )
                        {
                            echo ' : '.$sRow['title'] ;
                        }
                        ?>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <?php
                if ( ! empty ( $row ) )
                {
                    $this->registerGadgets ( array ( 'dateG' => 'date' ) ) ;
                    ?>

                    <ul class="list-unstyled ordered-list">
                        <?php
                        foreach ( $row AS $data )
                        {
                            $picture = $data[ 'picture' ] ? $data[ 'picture' ] : 530 ;
                            ?>
                            <li class="reviews-avatar">
                                <img src="<?= \f\ifm::app ()->fileBaseUrl . $picture ?>" style="border-radius: 0%;padding: 0px;margin:0px;float:right;width:60px;height:60px;border:1px solid #eee">
                                <div style="margin-right: 10px;float: right">
                                    <h3 style="font-size: 17px;margin:0px 0px 0px">
                                        <a href="<?= \f\ifm::app ()->siteUrl . 'contentDetail/' . $data[ 'id' ] ?>" target="_blank" style="margin:0px;padding: 0px">
                                            <?= $data[ 'title' ] ?>
                                        </a>

                                    </h3>
                                    <div style="color:silver;padding-bottom: 10px;font-size:13px">
                                        <?php
                                        $date    = $this->dateG->dateTime ( $data[ 'date_register' ],
                                                                            1 ) ;
                                        echo $this->dateG->dateGrToJa ( $date, 2 ) . ' ، ' . date ( "H:i",
                                                                                                    $data[ 'date_register' ] ) ;
                                        ?>
                                    </div>
                                </div>
                                <div class="clear"></div>
                            </li>
                            <?
                        }
                        ?>


                    </ul>
                    <?php
                }
                else
                {
                    echo 'هیچ مطلبی در این بخش وجود ندارد.' ;
                }
                ?>
            </div>
        </div>
        <div style="text-align: center">
            <ul class="pagination">
                <?php
                //$num_page = 12 ;


                $lastpage  = ceil ( ($num / $num_page ) ) ;
                $i         = 1 ;
                $lpm1      = $lastpage - 1 ;
                $adjacents = 3 ;
                $pr        = $page - 1 ;
                $nx        = $page + 1 ;
                if($sRow['id'])
                {
                    $href      = \f\ifm::app ()->siteUrl . 'content/' . $sRow['id'] ;
                }
                else
                {
                    $href      = \f\ifm::app ()->siteUrl . 'content' ;
                }

                include 'pagination.php' ;
                ?>
            </ul>
        </div>
    </div>
</section>