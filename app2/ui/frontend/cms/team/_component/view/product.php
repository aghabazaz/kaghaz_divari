<section class="page-title">
    <div class="grid-row clearfix">
        <h1>
            <?= 'محصولات' ?>
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
                <a href="<?= \f\ifm::app ()->siteUrl ?>product/"><?= 'محصولات' ?></a>
                &nbsp;&nbsp;<i class="fa fa-angle-left"></i>&nbsp;
                <a href="<?= \f\ifm::app ()->siteUrl ?>product/<?= $sRow[ 'id' ] ?>"><?= $sRow[ 'title' ] ?></a>

                <?php
            }
            else
            {
                ?>
                <a href="<?= \f\ifm::app ()->siteUrl ?>product/"><?= 'محصولات' ?></a>
                <?php
            }
            ?>

        </nav>
    </div>
</section>
<!-- page content -->
<main class="page-content">
    <div class="grid-row">
        <!-- photo tour -->
        <section id="photo-tour" class="widget photo-tour photo-tour-4" style="direction: rtl">						
            <div class="grid">
                <?php
                if ( ! empty ( $row ) )
                {
                    foreach ( $row AS $data )
                    {
                        $picture = $data[ 'picture' ] ? $data[ 'picture' ] : 530 ;
                        ?>
                        <div class="item">
                            <div class="pic">
                                <img src="<?= \f\ifm::app ()->fileBaseUrl . $picture ?>" width="270" height="142" alt="<?= $data[ 'title' ] ?>">
                                <div class="links">
                                    <ul>
                                        <li><a href="<?= \f\ifm::app ()->siteUrl . 'productDetail/' . $data[ 'id' ] ?>" class="fa fa-eye"></a></li>										
                                    </ul>
                                </div>
                            </div>
                            <h3><?= $data[ 'title' ] ?></h3>
                            <p></p>
                        </div>
                        <?php
                    }
                }
                ?>

            </div>
        </section>
        <div class="clearfix"></div>
        <br>
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
                $href = \f\ifm::app ()->siteUrl . 'content/' . $sRow[ 'id' ] ;
            }
            else
            {
                $href = \f\ifm::app ()->siteUrl . 'content' ;
            }

            include 'pagination_1.php' ;
            ?>

        </div>
    </div>
</main>