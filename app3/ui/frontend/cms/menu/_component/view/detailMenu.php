<?php
if ( $row[ 'status' ] == 'enabled' )
{
    ?>
    <section class="page-title">
        <div class="grid-row clearfix">
            <h1><?= $row[ 'Title' ] ?></h1>

            <nav class="bread-crumbs">
                <a href="<?= \f\ifm::app ()->siteUrl ?>"><i class="fa fa-home"></i> <?= 'خانه' ?></a>
                &nbsp;&nbsp;<i class="fa fa-angle-left"></i>&nbsp;
                <a href="<?= \f\ifm::app ()->siteUrl . 'menuDetail/' . $row[ 'id' ] ?>"><?= $row[ 'Title' ] ?></a>
            </nav>
        </div>
    </section>
    <main class="page-content" style="min-height: 343px">
        <div class="grid-row">
            <!-- map -->
            <section >

                <div style="direction: rtl">
                    <?= $row[ 'content' ] ?>
                </div>
            </section>
        </div>

    </main>

    <?php
}
?>

