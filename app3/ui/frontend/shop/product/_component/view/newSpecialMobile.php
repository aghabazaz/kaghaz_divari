<?php
//\f\pre($row);
?>

<?php
echo '<div class="services-item1 owl-carousel1">';
foreach ( $row AS $data )
{
    ?>

    <div class="item1">
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
        <div class="services-item-pic1">
            <a href="<?= \f\ifm::app ()->siteUrl . 'productDetail/' . $data[ 'id' ] ?>"><img src="<?= \f\ifm::app ()->fileBaseUrl.$data['picture'] ?>" alt="" class="img-responsive"></a>
            <a href="<?= \f\ifm::app ()->siteUrl . 'productDetail/' . $data[ 'id' ] ?>">
                <h4><?= $data['title'] ?></h4></a>
        </div>
    </div>

    <?php
}
echo ' </div>';
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

