<?php
//\f\pre($newProducts);
echo '<div class="mobileNewestMobile">
                    <div class="upLatestThing">
                        <i class="fa fa-shopping-bag" aria-hidden="true"></i>
                        <h3>'. $title .'</h3>
                    </div>
                    <div class="downLatestThing">';
echo '<div class="servicesMobile owl-carousel">';
//\f\pre($newProducts);
foreach ( $newProducts AS $data )
{
    ?>

    <div class="item">
        <?php
        if ($data['stock'] <= 0) {
            ?>

            <div class="off-box-pro">
                <img src="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst/img/unavailable.png"
                     class="img-responsive" alt="">
            </div>
            <?php
        }
        ?>
        <div class="services-item-pic">
            <a href="<?= \f\ifm::app ()->siteUrl . 'productDetail/' . $data[ 'id' ] ?>"><img src="<?= \f\ifm::app ()->fileBaseUrl.$data['picture'] ?>" alt="<?= $data['title'] ?>" class="img-responsive"></a>
            <a href="<?= \f\ifm::app ()->siteUrl . 'productDetail/' . $data[ 'id' ] ?>"><h4><?= $data['title'] ?></h4></a>
        </div>
    </div>

    <?php
}
echo '</div></div></div>'
?>

<style>
    .off-box-pro img {
        position: absolute;
        z-index: 999;
        width: 49px;
        height: 47px;
        top: 0px;
        right: 0px;
    }
</style>