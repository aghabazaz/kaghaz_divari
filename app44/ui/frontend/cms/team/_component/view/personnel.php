<?php
if ( ! empty ( $row ) )
{
    ?>
    <div class="grid-row wow fadeInDown animated" >
        <!-- doctors carousel -->
        <section class="widget doctors-carousel doctors" style="direction: rtl;overflow: hidden">
            <div class="widget-title"><?= 'تیم رایسان' ?></div>
            <div id="doctors-carousel" class="owl-carousel">
                <?php
                foreach ( $row AS $data )
                {
                    ?>

                    <div class="item">
                      
                            <div class="pic">
                                <img src="<?= \f\ifm::app ()->fileBaseUrl . $data[ 'picture' ] ?>" width="270" height="270" alt="<?= $data[ 'name' ] ?>">
                                <div class="links">
                                    <ul>
                                        <li><a href="<?= \f\ifm::app ()->siteUrl . 'personnelDetail/' . $data[ 'id' ] ?>" class="fa fa-search"></a></li>

                                    </ul>
                                </div>
                            </div>
                        <h3 style="height:40px"><a href="<?= \f\ifm::app ()->siteUrl . 'personnelDetail/' . $data[ 'id' ] ?>" style="font-size:18px"><?= $data[ 'name' ] ?></a></h3>
                            <p><?=$data['job']?></p>
                       
                    </div>
                    <?php
                }
                ?>


            </div>
        </section>
        <!--/ doctors carousel -->
    </div>
    <?php
}
else
{
    echo '&nbsp;' ;
}
?>
<style>
    .boxItem
    {
        box-shadow: 0 3px 3px rgba(0, 0, 0, 0.25);

    }
</style>