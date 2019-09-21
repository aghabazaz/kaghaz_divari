<?php
if ( $row[ 'status' ] == 'enabled' )
{
    $this->registerGadgets ( array (
        'dateG' => 'date' ) ) ;
    ?>
    <section class="page-title">
        <div class="grid-row clearfix">
            <h1>محصولات</h1>

            <nav class="bread-crumbs">
                <a href="<?= \f\ifm::app ()->siteUrl ?>"><i class="fa fa-home"></i> <?= 'خانه' ?></a>
                &nbsp;&nbsp;<i class="fa fa-angle-left"></i>&nbsp;
                <a href="<?= \f\ifm::app ()->siteUrl ?>product/"><?= 'محصولات' ?></a>
                &nbsp;&nbsp;<i class="fa fa-angle-left"></i>&nbsp;
                <a href="<?= \f\ifm::app ()->siteUrl ?>product/<?= $sRow[ 'id' ] ?>"><?= $sRow[ 'title' ] ?></a>
                &nbsp;&nbsp;<i class="fa fa-angle-left"></i>&nbsp;
                <a href="<?= \f\ifm::app ()->siteUrl ?>productDetail/<?= $row[ 'id' ] ?>"><?= $row[ 'title' ] ?></a>
            </nav>
        </div>
    </section>

    <section class="single-blog" style="direction: rtl">
        <div class="container" >
            <div class="row">
                <article class="widget blog-post" style="direction: rtl">	
                    <div class="widget-title"><?= $row[ 'title' ] ?></div>

                    <div class="date">
                        <!--
                        <div class="share">
                            <a class="fa fa-linkedin" href="news-blog-post.html#"></a>
                            <a class="fa fa-twitter" href="news-blog-post.html#"></a>
                            <a class="fa fa-facebook" href="news-blog-post.html#"></a>
                        </div>
                        -->
                        <?php
                        $date = $this->dateG->dateTime ( $row[ 'date_register' ],
                                                         1 ) ;
                        echo 'تاریخ ثبت : ' . $this->dateG->dateGrToJa ( $date,
                                                                         2 ) . ' ، ' . date ( "H:i",
                                                                                              $row[ 'date_register' ] ) ;
                        ?>
                        <i ><span><?= $row[ 'num_visit' ] ?> بازدید</span></i>
                    </div>




                </article>
                <div class="col-sm-4">
                    <img alt="<?= $row[ 'title' ] ?>" src="<?= \f\ifm::app ()->fileBaseUrl . $row[ 'picture' ] ?>" style="max-width: 100%">

                    <div>
                        <?php
                        foreach ( $picture AS $data )
                        {
                            ?>
                            <div class="productItem">

                                <a class="grouped_elements" rel="group1" href="<?=$data['path'] ?>">
                                    <img src="<?=$data['path'] ?>" alt="<?=$data['title'] ?>" style="max-height:58px;max-width: 58px"/>
                                </a>
                            </div>
                           
                            <?php
                        }
                        ?>
                         <div class="clearfix"></div>
                    </div>

                </div>
                <div class="col-sm-8">
                    <section class="widget widget-details" style="direction: rtl">
                        <br>
                        <?= $row[ 'content' ] ?>
                        <br></br>
                    </section>

                </div>
                <div class="clearfix"></div>
                <br></br>
            </div>
        </div>
    </section>
    <?php
}
?>
<style>
    .productItem {
        background: #fafbfc none repeat scroll 0 0 !important;
        border: 1px solid #e5e5e5;
        cursor: pointer;
        float: right;
        height: 64px;
        max-height: 64px;
        padding: 4px 0 0;
        position: relative;
        text-align: center;
        width: 64px;
        margin:2px;
    }
</style>
