<?php
if ( !empty( $row ) )
{
if ( $mode == 'desktop' )
{
$i = 1;
?>
<div class="row">
    <?php
    foreach ( $row AS $data )
    {
        ?>
        <div class="product-item style-1 padding-0 col-bg-3 col-lg-3 col-md-4 col-sm-6 col-xs-6">
            <div class="product-inner">
                <div class="product-thumb">
                    <div class="thumb-inner">
                        <a href="<?= \f\ifm::app()->siteUrl . 'productDetail/' . $data['id'] ?>" title="<?= $data['title'] ?>"><img class="img-responsive product-page-resize" src="<?= \f\ifm::app()->fileBaseUrl . $data['picture'] ?>" alt="<?= $data['title'] ?>" title="<?= $data['title'] ?>"></a>
                    </div>
                </div>
                <div class="product-innfo">
                    <div class="product-name"><a href="<?= \f\ifm::app()->siteUrl . 'productDetail/' . $data['id'].'/'.$data['title'] ?>" title="<?= $data['title'] ?>"><?= $data['title'] ?></a></div>
<!--                    <span class="price">-->
<!--												<ins>160,000 تومان</ins>-->
<!--												<del>190,000 تومان</del>-->
<!--											</span>-->
                    <div>
                        <div class="inner">
                            <a href="<?= \f\ifm::app()->siteUrl . 'productDetail/' . $data['id'].'/'.$data['title'] ?>" class="btn-add-to-cart" title="<?= $data['title'] ?>"> جزئیات بیشتر </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
    <div class="clearfix"></div>
    <div class="col-sm-12">
        <div class="pagination" style="text-align: center">
            <?php
            $lastpage  = ceil( ( $num / $num_page ) );
            $i         = 1;
            $lpm1      = $lastpage - 1;
            $adjacents = 3;
            $pr        = $page - 1;
            $nx        = $page + 1;
            $func      = 'getProductByParam';
            include 'pagination_ajax.php';
            ?>
        </div>
    </div>
    <?php
    }
    else
    {
        ?>
        <div class="all-product">
            <div class="container">
                <div class="row">
                    <?php
                    foreach ( $row AS $data )
                    {
                        ?>
                        <div class="col-sm-6 col-xs-12">
                            <div class="mobileProduct">
                                <?php
                                if ( $data['stock'] <= 0 )
                                {
                                    ?>

                                    <div class="off-box-pro">
                                        <img src="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst/img/unavailable.png"
                                             class="img-responsive" alt="<?= $data['title'] ?>" title="<?= $data['title'] ?>">
                                    </div>
                                    <?php
                                }
                                ?>
                                <div class="col-sm-4 col-xs-4">
                                    <div class="imgProductMobile">
                                        <a href="<?= \f\ifm::app()->siteUrl . 'productDetail/' . $data['id'] ?>">
                                            <img src="<?= \f\ifm::app()->fileBaseUrl . $data['picture'] ?>" title="<?= $data['title'] ?>"
                                                 class="img-responsive" alt="<?= $data['title'] ?>">
                                        </a>
                                    </div>
                                </div>
                                <div class="col-sm-8 col-xs-8">
                                    <div class="textProductMobile">
                                        <a href="<?= \f\ifm::app()->siteUrl . 'productDetail/' . $data['id'] ?>" title="<?= $data['title'] ?>">
                                            <h3><?= $data['title'] ?></h3>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <div class="col-sm-12">
                    <div class="pagination" style="text-align: center">
                        <?php
                        $lastpage  = ceil( ( $num / $num_page ) );
                        $i         = 1;
                        $lpm1      = $lastpage - 1;
                        $adjacents = 3;
                        $pr        = $page - 1;
                        $nx        = $page + 1;
                        $func      = 'getProductByParam';
                        include 'pagination_ajax.php';
                        ?>
                    </div>
                </div>
            </div>

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

    <?php
    if ( $mode == 'desktop' )
    {
        ?>
        <style>
            .off-box-pro img {
                position: absolute;
                right: 34px;
                top: 55px;
                width: 153px;
                height: 94px;
                transform: skewY(-16deg);
            }

            .off-box-pro img {

        </style>
        <?php
    } else
    {
        ?>
        <style>

            .off-box-pro img {
                position: absolute;
                left: 79px;
                bottom: 41px;
                width: 110px;
                height: 63px;
                z-index: 99;
                transform: skewY(-11deg);
            }
        </style>
        <?php
    }
    ?>
    <style>
        #product .thumb-inner a{
            width:100%;
            display: block;
        }
        #product .thumb-inner img{
            margin-right:auto;
            margin-left:auto;
            display:block;
            max-height: 150px;
        }
        /* pagination */
        /**/
        /**/
        .alertBox {
            display: inline-block;
            margin-top: 0px;
        }

        .pagination a:hover,
        .pagination li.current a,
        .widget-tags a:hover {
            position: relative;
            border-color: #f84949;
            background: #f84949;
        }

        .pagination ul {
            font-size: 0;
            display: inline-block;
            padding-right: 0;
        }

        .pagination {
            width: 100%;
            text-align: center;
            direction: rtl;
        }

        .pagination,
        .pagination li {
            display: inline-block;
            margin: 10px 0px;
            font-size: 13px;
            line-height: 37px;
        }

        .pagination a {
            display: block;
            padding: 0 15px;
            border: 1px solid #e3e3e3;
            color: #7c7c7c;
            display: inline-block;
            text-decoration: none;
        }

        .pagination a.btn {
            padding: 11px 18px;
        }

        .pagination a:hover,
        .pagination li.current a {
            color: #fff;
        }
        .pagination li {
            list-style: none;
            display: inline-block;
            padding-right: 0px;
            margin-right:5px;
        }
        .pagination>a {
            padding: 8px 15px !important;
            margin-top: 0px !important;
            border-radius: 0px;
        }
        .pagination li.dots a,
        .pagination li.dots a:hover {
            border: none;
            background: none;
            color: #7c7c7c;
        }

        @media screen and (max-width: 479px) {
            /* phone */
            .pagination ul {
                display: block;
            }
        }
        body {
            background: #fff;
        }


    </style>

    <script>
        var count = <?= $num ?>;
        $("#countSearchProduct").text(count);
    </script>