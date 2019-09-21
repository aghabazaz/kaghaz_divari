<section class="page-title">
    <div class="grid-row clearfix">
        <h1>
            <?= 'برچسب ها' ?>
            <?php
            if ( $sRow[ 'id' ] )
            {
                echo ' : ' . $sRow[ 'title' ] ;
            }
            ?>
        </h1>

        <nav class="bread-crumbs">
            <a href="<?= \f\ifm::app ()->siteUrl ?>"><i class="fa fa-home"></i> <?= 'خانه' ?></a>
            &nbsp;&nbsp;<i class="fa fa-angle-left"></i>&nbsp;
            <?php
            if ( $sRow[ 'id' ] )
            {
                ?>
                <a href="<?= \f\ifm::app ()->siteUrl ?>tag/<?= $sRow[ 'id' ] ?>"><?= 'برچسب ها' ?></a>
                &nbsp;&nbsp;<i class="fa fa-angle-left"></i>&nbsp;
                <a href="<?= \f\ifm::app ()->siteUrl ?>tag/<?= $sRow[ 'id' ] ?>"><?= $sRow[ 'title' ] ?></a>

                <?php
            }
            ?>

        </nav>
    </div>
</section>
<main class="page-content">
    <div class="grid-row">
        <section class="widget news news-1" id="news">						
            <div class="grid isotope" >
                <?php
                if ( ! empty ( $row ) )
                {
                    $this->registerGadgets ( array (
                        'dateG' => 'date' ) ) ;
                    foreach ( $row AS $data )
                    {
                        $picture = $data[ 'picture' ] ? $data[ 'picture' ] : 530 ;
                        ?>
                        <div class="item isotope-item" >
                            <h3 class="widget-title">
                                <a href="<?= \f\ifm::app ()->siteUrl . 'contentDetail/' . $data[ 'id' ] ?>"> <?= $data[ 'title' ] ?></a>
                            </h3>
                            <div class="date">
                                <?php
                                $date    = $this->dateG->dateTime ( $data[ 'date_register' ],
                                                                    1 ) ;
                                echo $this->dateG->dateGrToJa ( $date, 2 ) . ' ، ' . date ( "H:i",
                                                                                            $data[ 'date_register' ] ) ;
                                ?>
                                <i></i>
                                <!--<i class="fa fa-eye"><span>3</span></i>-->
                                </div>
                            <div class="wrapper">
                                <div class="pic">
                                    <img alt=" <?= $data[ 'title' ] ?>" src="<?= \f\ifm::app ()->fileBaseUrl . $picture ?>" style="border:1px solid #eee;padding: 3px">
                                    <div class="links">
                                        <ul>
                                            <li><a class="fa fa-eye" href="<?= \f\ifm::app ()->siteUrl . 'contentDetail/' . $data[ 'id' ] ?>"></a></li>										
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <p style="direction: rtl">
                                <?=$data['short']?>
                            </p>
                            <!--
                            <div class="cats">Posted in: <a href="news-full-width.html#">Dental Clinic</a>, <a href="news-full-width.html#">General</a>, <a href="news-full-width.html#">News</a><a class="more fa fa-long-arrow-right" href="news-full-width.html#"></a></div>
                            -->
                        </div>

                        <?php
                    }
                }
                else
                {
                    echo 'هیچ مطلبی در این بخش وجود ندارد.' ;
                }
                ?>

            </div>
        </section>
        <div class="pagination" style="text-align: center">

            <?php
            


            $lastpage  = ceil ( ($num / $num_page ) ) ;
            $i         = 1 ;
            $lpm1      = $lastpage - 1 ;
            $adjacents = 3 ;
            $pr        = $page - 1 ;
            $nx        = $page + 1 ;
            if ( $sRow[ 'id' ] )
            {
                $href = \f\ifm::app ()->siteUrl . 'tag/' . $sRow[ 'id' ] ;
            }

            include 'pagination_1.php' ;
            ?>

        </div>
    </div>
</main>


