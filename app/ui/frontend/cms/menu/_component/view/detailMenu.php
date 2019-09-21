<?php
if ( $row[ 'status' ] == 'enabled' )
{
    ?>
    <section class="container">
        <div class="url-page-box marginTop120 dir-rtl">
            <div class="page-address-box padding-addressBar">


                <nav class="bread-crumbs">
                    <a href="<?= \f\ifm::app ()->siteUrl ?>"><i class="fa fa-home"></i> <?= 'خانه' ?></a>
                    &nbsp;&nbsp;<i class="fa fa-angle-right"></i>&nbsp;
                    <a href="<?= \f\ifm::app ()->siteUrl . 'menuDetail/' . $row[ 'id' ] ?>"><?= $row[ 'Title' ] ?></a>
                </nav>
            </div>
        </div>
    </section>
    <main class="container">
        <section class="page-title aboutPageBox padding-addressBar">
            <!-- map -->
            <section >
                <div class="dir-rtl">
                    <?= $row[ 'content' ] ?>
                </div>
            </section>
        </section>

    </main>

    <?php
}
?>

