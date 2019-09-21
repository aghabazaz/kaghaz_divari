<?php
if ( ! empty ( $row ) )
{
    ?>

    <!-- doctors carousel -->
    <section class="widget doctors-carousel doctors" style="direction: rtl;overflow: hidden">
        <div class="widget-title">
            <?php
            if($params['special'])
            {
                echo 'ویژه ها';
                $id='doctors-carousel';
            }
            else
            {
                echo 'آخرین دستگاه ها و ماشین آلات';
                $id='last-product';
            }
            ?>
        </div>
        <div id="<?=$id?>" class="owl-carousel">
            <?php
            foreach ( $row AS $data )
            {
                ?>

                <div class="item">

                    <div class="pic">
                        <img src="<?= \f\ifm::app ()->fileBaseUrl . $data[ 'picture' ] ?>" width="200" height="200" alt="<?= $data[ 'name' ] ?>">
                        <div class="links">
                            <div style=" color:#dd1144;font-size: 16px;">
                                <?='شناسه دستگاه : '.$data['id']?>
                            </div>
                            <ul>
                                <li><a href="<?= \f\ifm::app ()->siteUrl . 'productDetail/' . $data[ 'id' ] ?>" class="fa fa-search"></a></li>

                            </ul>
                        </div>
                    </div>
                    <h3 style="height:40px"><a href="<?= \f\ifm::app ()->siteUrl . 'productDetail/' . $data[ 'id' ] ?>" style="font-family:Verdana,Yekan,tahoma;font-size:13px"><?= $data[ 'title' ] . ' ' . $data[ 'model' ] ?></a></h3>
                    <p><?= $data[ 'catTitle' ] ?></p>

                </div>
                <?php
            }
            ?>


        </div>
    </section>
    <!--/ doctors carousel -->

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