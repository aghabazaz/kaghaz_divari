<?php

if ( ! empty ( $row ) )
{
//\f\pre($row);
    if ( $mode == 'desktop' )
    {
        $i = 1 ;
        ?>
        <div class="row all-product">
            <?php
            foreach ( $row AS $data )
            {
                ?>
                <div class="col-md-3 col-sm-6 col-product">
                    <div class="grid-product">
                        <div class="img-product" style="position:relative">
                            <a href="<?= \f\ifm::app ()->siteUrl . 'productDetail/' . $data[ 'id' ] ?>" target="_blank">
                                <?php
                                if ( $data[ 'special' ] == 'enabled' )
                                {
                                    echo '<!--<div class="special" ></div>-->' ;
                                }
                                ?>
                                <img class="img-responsive" src="<?= \f\ifm::app ()->fileBaseUrl . $data[ 'picture' ] ?>"/>
                            </a>
                        </div>
                        <!--                        <div class="product-rate">
                                                    <span class="author-ratings">
                        <?php
                        $rate = $data[ 'rate_avg' ] ;
                        for ( $i = 0 ; $i < 5 ; $i ++ )
                        {
                            if ( $rate > $i && $rate >= $i + 1 )
                            {
                                echo '<i class="fa fa-star"></i>' ;
                            }
                            else if ( $rate > $i && $rate < $i + 1 )
                            {
                                echo '<i class="fa fa-star-half-o"></i>' ;
                            }
                            else
                            {
                                echo '<i class="fa fa-star-o"></i>' ;
                            }
                        }
                        ?>
                                                    </span>
                                                    <span class="fa-digit">
                        <?php
                        echo $data[ 'rate_avg' ] ;
                        ?>
                                                    </span>
                        
                                                </div>-->
                        <div class="product-span">
                            <span><a href="<?= \f\ifm::app ()->siteUrl . 'productDetail/' . $data[ 'id' ] ?>" target="_blank"><?= $data[ 'title' ] ?></a></span>
                        </div>
                        <div class=" product-price-main">
            <!--                            <span>
                                <s>
                            <?php
                            if ( $data[ 'discount' ] && $data[ 'stock' ] > 0 )
                            {
                                echo number_format ( $data[ 'price' ] ) . ' تومان' ;
                            }
                            ?>
                                </s>

                            </span>-->
                        </div>
                        <div class="product-price-span">
                            <?php
                            if ( $data[ 'stock' ] > 0 )
                            {
                                ?>

                                                                <!--<span><?= number_format ( ($data[ 'price' ] - $data[ 'discount' ] ) ) . ' تومان' ?></span>-->
                                <?php
                            }
                            else
                            {
                                ?>

                                                                <!--<span style="color:gray"><i class="fa fa-ban" style="color:darkred"></i> ناموجود</span>-->
                                <?php
                            }
                            ?>

                        </div>
                        <div class="img-sales">
                            <a href="<?= \f\ifm::app ()->siteUrl . 'productDetail/' . $data[ 'id' ] ?>">
                                <img class="img-products img-responsive" src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/main/img/cart.png"/>
                            </a>
                        </div>    

                    </div> 
                </div>
                <?php
            }
            ?>
            <div class="clearfix"></div>
            <div style="text-align: right;margin-top:20px;padding: 0px;direction: rtl">
                <ul class="pagination" style="display:inline">
                    <?php
                    //$num_page = 12 ;


                    $lastpage  = ceil ( ($num / $num_page ) ) ;
                    $i         = 1 ;
                    $lpm1      = $lastpage - 1 ;
                    $adjacents = 3 ;
                    $pr        = $page - 1 ;
                    $nx        = $page + 1 ;
                    $func      = 'getProductByParam' ;



                    include 'pagination_ajax.php' ;
                    ?>
                </ul>
            </div>
            <?php
        }
        else
        {
            ?>
            <div class="all-product">
                <?php
                //\f\pr($row);
                foreach ( $row AS $data )
                {
                    ?>
                    <div style="padding: 10px;margin-bottom:10px;background: #fff;direction: rtl;position: relative;cursor: pointer" onclick="window.location.href = '<?= \f\ifm::app ()->siteUrl . 'productDetail/' . $data[ 'id' ] ?>'">
                        <?php
                        if ( $data[ 'special' ] == 'enabled' )
                        {
                            echo '<div class="special" ></div>' ;
                        }
                        ?>
                        <div class="img-product-mobile" style="float:right;width:30%;text-align: center;height:100px">
                            <img class="img-responsive" src="<?= \f\ifm::app ()->fileBaseUrl . $data[ 'picture' ] ?>" style="max-height:100px"/>
                        </div>
                        <div class="title-product-mobile" style="width:70%;float:right;padding-right:5px;">
                            <div style="color:#000;font-size:12px">
                                <?= $data[ 'title' ] ?>
                            </div>
                            <div style="margin-top:5px;">
                                <div style="float: right;background:#49BDFC;color:#fff;width:60px;padding: 1px;font-size:13px;border-radius: 2px">
                                    &nbsp;
                                    <i class="fa fa-star"></i>
                                    &nbsp;&nbsp;
                                    <span class="fa-digit">
                                        <?php
                                        echo $data[ 'rate_avg' ] ;
                                        ?>
                                    </span>
                                    &nbsp;
                                </div>
                                <div style="color:gray;float: right;padding-right:5px;" class="fa-digit">
                                    <?= 'از ' . $data[ 'rate_count' ] . ' رای' ?>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div style="padding-top:5px">
                                <div class="product-price-span" style="font-size:13px;float: right">
                                    <?php
                                    if ( $data[ 'stock' ] > 0 )
                                    {
                                        ?>
                                        <span class="fa-digit"><?= number_format ( ($data[ 'price' ] - $data[ 'discount' ] ) ) . ' تومان' ?></span>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <span style="color:gray"><i class="fa fa-ban" style="color:darkred"></i> ناموجود</span>
                                        <?php
                                    }
                                    ?>

                                </div>
                                <div class=" product-price-main" style="font-size:11px;color:gray;float:right;margin: 2px">
                                    <span>
                                        <s>
                                            <span class="fa-digit">
                                                <?php
                                                if ( $data[ 'discount' ] && $data[ 'stock' ] > 0 )
                                                {
                                                    echo number_format ( $data[ 'price' ] ) . ' تومان' ;
                                                }
                                                ?>
                                            </span>
                                        </s>
                                    </span>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <?php
                }
                ?>
                <script>
                    $('#page').val(<?= $page ?>);
                </script>
            </div>
            <?php
        }
    }
    else
    {
        if ( $page == 1 )
        {
            ?>
            <div class="alert alert-danger rtl">
                <i class="fa fa-warning"></i> <?= 'برای اطلاعات درخواست شده کالایی در سایت ثبت نشده است.' ?>
            </div>
            <?php
        }
        else
        {
            ?>
            <div class="alert alert-danger rtl">
                <i class="fa fa-warning"></i> <?= 'موارد بیشتری برای نمایش وجود ندارد.' ?>
            </div>
            <script>
                $('#page').val(-1);
            </script>
            <?php
        }
    }
    ?>

    <style>


    </style>
    <script>
        var count = <?= $num ?>;
        $("#countSearchProduct").text(count);
    </script>