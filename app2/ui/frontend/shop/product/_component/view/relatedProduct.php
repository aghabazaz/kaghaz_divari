<?php
if ( ! empty ( $newProducts ) )
{
    ?>

    <div class="news-box" style="direction: rtl ; margin-bottom:15px;">
        <div class="header-news">  
            <i class="fa fa-shopping-bag icon-index-shop" aria-hidden="true"></i>
            <span> محصولات مرتبط </span>
        </div>
        <div data-slick='{"slidesToShow": 4, "slidesToScroll": 4}' class="sliderFooter" style="width:90%;margin: 0 auto;margin-top: 20px ; ">

            <?php
            foreach ( $newProducts AS $data )
            {
                ?>
                <div>
                    <a  href="<?= \f\ifm::app ()->siteUrl . 'productDetail/' . $data[ 'id' ] ?>"><div style="height :150px"><img style="margin: 0 auto; max-height : 100%" class="img-responsive" src="<?= \f\ifm::app ()->fileBaseUrl . $data[ 'picture' ] ?>" alt=" <?php echo $data[ 'title' ] ?>" ></div>
                        <h5 class="entitle"><?php echo $data[ 'title' ] ; ?></h5></a>
                    <?php
                    if ( $data[ 'discount' ] )
                    {
                        ?>
                        <h4 class="old-price"><?php echo number_format ( $data[ 'price' ] ) ; ?></h4>
                        <?php
                    }
                    else
                    {
                        ?>
                        <h4 style="height:10px;"></h4>
                        <?php
                    }
                    ?>
                </div>
                <?php
            }
            ?>


        </div>
    </div>

    <?php
}
?>


