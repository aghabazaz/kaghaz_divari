<section class="page-title">
    <div class="grid-row clearfix">
        <h1>نتایج جستجو</h1>

        <nav class="bread-crumbs">
            <a href="<?= \f\ifm::app ()->siteUrl ?>"><i class="fa fa-home"></i> <?= 'خانه' ?></a>
            &nbsp;&nbsp;<i class="fa fa-angle-left"></i>&nbsp;
            <a href="<?= \f\ifm::app ()->siteUrl . 'search' ?>">نتایج جستجو</a>
        </nav>
    </div>
</section>
<main class="page-content" style="direction: rtl;min-height:100px;">

    <?php
//\f\pr($row);
    if ( ! empty ( $row ) )
    {

        foreach ( $row AS $data )
        {
            ?>
            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                <div class="item">
                    <div class="pimg">
                        <a href="<?= \f\ifm::app ()->siteUrl . 'productDetail/' . $data[ 'id' ] ?>" target="_blank">
                            <img src="<?= \f\ifm::app ()->fileBaseUrl . $data[ 'picture' ] ?>" class="img-responsive" alt="<?= $data[ 'name' ] ?>">
                        </a>
                    </div>
                    <h2 class="item-title">
                        <a href="<?= \f\ifm::app ()->siteUrl . 'productDetail/' . $data[ 'id' ] ?>" target="_blank">
                            <?= $data[ 'title' ] . ' ' . $data[ 'model' ] ?>
                        </a>
                    </h2>
                    <h3 class="cat-title">
                        <a href="<?= \f\ifm::app ()->siteUrl . 'product/' . $data[ 'category' ] ?>">
                            <?= $data[ 'catTitle' ] ?>
                        </a>
                    </h3>
                    <div class="price">
                        <?php
                        if ( $data[ 'sale_status' ] == 'enabled' )
                        {
                            ?>
                            <span style="color:gray">فروخته شده</span>
                            <?php
                        }
                        else
                        {
                            ?>
                            <span style="color:green">
                                <?php
                                if ( $data[ 'price' ] )
                                {
                                    echo number_format ( $data[ 'price' ] ) . ' تومان' ;
                                }
                                else
                                {
                                    echo 'توافقی' ;
                                }
                                ?>

                            </span>
                            <?php
                        }
                        ?>
                    </div>

                </div>
            </div>

            <?php
        }
    }
    else
    {
        echo 'دستگاهی با این مشخصات وجود ندارد ...' ;
    }
    ?>    
    <div class="clearfix"></div>
</main>


<style>
    .item
    {
        -moz-border-bottom-colors: none;
        -moz-border-left-colors: none;
        -moz-border-right-colors: none;
        -moz-border-top-colors: none;
        border-color: #e9e9e9;
        border-image: none;
        border-style: solid;
        border-width: 2px 1px 1px;
        margin: 0px 0px 10px 0;
        position: relative;
        padding: 5px;
    }
    .item:hover
    {
        border-color: #ccc;
        box-shadow: 0 1px 4px 1px rgba(0, 0, 0, 0.2);
    }
    .pimg
    {
        margin-top: 0px;
        height: 160px;
        overflow: hidden;
        text-align: center;

    }
    .cat-title
    {
        margin-top: 5px;

    }
    .cat-title a
    {
        color:silver;
    }
    .cat-title a:hover
    {
        color: #000;
    }
    @media (max-width: 768px) 
    {
        .pimg
        {
            height:auto;
            overflow: visible;
        }
    }
    .price
    {

        margin: 10px 0px 5px;
        font: 17px Yekan;
    }
    .item-title
    {
        font-family: Arial,Yekan;
        font-size:13px;
        padding: 5px;

    }
</style>