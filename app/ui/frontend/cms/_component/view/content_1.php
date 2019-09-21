<section class="page-title ">
    <div class="grid-row clearfix">
        <h1>
            <?= 'مطالب و مقالات' ?>
            <?php
            if ( $sRow[ 'id' ] )
            {
                echo ' : ' . $sRow[ 'title' ] ;
            }
            ?>
        </h1>

        <nav class="bread-crumbs">
            <a href="<?= \f\ifm::app ()->siteUrl ?>"><i class="fa fa-home"></i> <?= 'خانه' ?></a>
            &nbsp;&nbsp;<i class="fa fa-angle-left"></i>&nbsp;
            <?php
            if ( $sRow[ 'id' ] )
            {
                ?>
                <a href="<?= \f\ifm::app ()->siteUrl ?>content/"><?= 'مطالب و مقالات' ?></a>
                &nbsp;&nbsp;<i class="fa fa-angle-left"></i>&nbsp;
                <a href="<?= \f\ifm::app ()->siteUrl ?>content/<?= $sRow[ 'id' ] ?>"><?= $sRow[ 'title' ] ?></a>

                <?php
            }
            else
            {
                ?>
                <a href="<?= \f\ifm::app ()->siteUrl ?>content/"><?= 'مطالب و مقالات' ?></a>
                <?php
            }
            ?>

        </nav>
    </div>
</section>
<main class="page-content">
    <div class="grid-row">
        <section class="widget news news-1" id="news">						
            <div class="grid isotope" >
                <?php
                if ( ! empty ( $row ) )
                {
                    $this->registerGadgets ( array (
                        'dateG' => 'date' ) ) ;
                    foreach ( $row AS $data )
                    {
                        $picture = $data[ 'picture' ] ? $data[ 'picture' ] : 530 ;
                        ?>
                        <div class="item isotope-item" >
                            <h3 class="widget-title">
                                <a href="<?= \f\ifm::app ()->siteUrl . 'contentDetail/' . $data[ 'id' ] ?>"> <?= $data[ 'title' ] ?></a>
                            </h3>
                            <div class="date">
                                <?php
                                $date    = $this->dateG->dateTime ( $data[ 'date_register' ],
                                                                    1 ) ;
                                echo \f\ifm::faDigit($this->dateG->dateGrToJa ( $date, 2 ) . ' ، ' . date ( "H:i",
                                                                                            $data[ 'date_register' ] )) ;
                                ?>
                                <i></i>
                                <!--<i class="fa fa-eye"><span>3</span></i>-->
                                </div>
                            <div class="wrapper">
                                <div class="pic">
                                    <img alt=" <?= $data[ 'title' ] ?>" src="<?= \f\ifm::app ()->fileBaseUrl . $picture ?>" style="border:1px solid #eee;padding: 3px">
                                    <div class="links">
                                        <ul>
                                            <li><a class="fa fa-eye" href="<?= \f\ifm::app ()->siteUrl . 'contentDetail/' . $data[ 'id' ] ?>"></a></li>										
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <p style="direction: rtl">
                                <?=$data['short']?>
                            </p>
                            <!--
                            <div class="cats">Posted in: <a href="news-full-width.html#">Dental Clinic</a>, <a href="news-full-width.html#">General</a>, <a href="news-full-width.html#">News</a><a class="more fa fa-long-arrow-right" href="news-full-width.html#"></a></div>
                            -->
                        </div>

                        <?php
                    }
                }
                else
                {
                    echo 'هیچ مطلبی در این بخش وجود ندارد.' ;
                }
                ?>

            </div>
        </section>
        <div class="pagination" style="text-align: center">

            <?php
            


            $lastpage  = ceil ( ($num / $num_page ) ) ;
            $i         = 1 ;
            $lpm1      = $lastpage - 1 ;
            $adjacents = 3 ;
            $pr        = $page - 1 ;
            $nx        = $page + 1 ;
            if ( $sRow[ 'id' ] )
            {
                $href = \f\ifm::app ()->siteUrl . 'content/' . $sRow[ 'id' ] ;
            }
            else
            {
                $href = \f\ifm::app ()->siteUrl . 'content' ;
            }

            include 'pagination_1.php' ;
            ?>

        </div>
    </div>
</main>
<style>
    /**/
    /* news */
    /**/
    .news h3 {
        margin-bottom: 15px;
        font-size: 22px;
        line-height: 26px;
        direction:rtl;
    }
    .news h3 a {
        color: #000;
        font-size: 17px;
    }
    .news p {
        margin-top: 15px;
        line-height: 22px;
        display: inline;
    }
    .news .button {
        margin-top: 30px;
    }
    .news .grid {
        margin: -25px -15px;
    }
    .widget-title {
        border-right-color: #242f3e;
    }
    .widget-title {
        margin-bottom: 20px;
        padding-right: 7px;
        border-right-width: 3px;
        border-right-style: solid;
        font-size: 22px;
        line-height: 30px;
        color: #000;
        text-align: right;
    }
    .news .item {
        position: relative;
        float: right;
        margin: 25px 0;
        padding: 0 15px;
        -ms-box-sizing:border-box;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
    }
    .news .cats {
        position: relative;
        margin-top: 15px;
        padding: 10px 2px;
        border-top: 1px solid #e3e3e3;
        border-bottom: 1px solid #e3e3e3;
        font-size: 13px;
        color: #000;
    }
    .news .cats .more {
        position: absolute;
        top: -1px;
        right: 0;
        display: block;
        width: 40px;
        height: 40px;
        font-size: 14px;
        line-height: 40px;
        text-align: center;
        color: #fff;
    }
    .news .pic,
    .news .video {
        position: relative;
        overflow: hidden;
    }
    .news .video{
        padding-bottom: 56.25%;
    }
    .news .pic img {
        width: 100%;
        height: auto;
    }

    .news .video iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
    .news .audio {
        overflow: hidden;
        margin-top: 15px;
    }
    .news .audio audio {
        display: block;
        width: 100%;
        height: 30px;
    }
    .news .date {
        position: relative;
        margin-bottom: 11px;
        padding-right: 20px;
        font-size: 13px;
        line-height: 48px;
        color: #fff;
        direction:rtl;
        background: #293e92;
    }
    .page-title nav a {
        color: #fff;
    }
    .news .date i {
        position: absolute;
        top: 0;
        left: 0;
        width: 48px;
        height: 48px;
        border-right: 1px solid #fff;
        font-size: 24px;
        line-height: 46px;
        text-align: center;
        color: #fff;
    }
    .news .date span {
        position: absolute;
        top: 0;
        right: 0;
        width: 100%;
        height: 100%;
        font-size: 12px;
        line-height: 48px;
        font-family:Yekan;
    }
    .news .links {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255,255,255,0.5);
        opacity: 0;
        -o-transition: opacity 0.3s;
        -ms-transition: opacity 0.3s;
        -moz-transition: opacity 0.3s;
        -webkit-transition: opacity 0.3s;
    }
    .news .links ul {
        position: absolute;
        top: 50%;
        left: 0;
        width: 100%;
        margin-top: -28px;
        text-align: center;
        font-size: 0;
        padding-right: 0px;
    }
    .news .links li {
        position: relative;
        display: inline-block;
        margin: 0 8px;
        opacity: 0;
        -o-transition: opacity 0.4s;
        -ms-transition: opacity 0.4s;
        -moz-transition: opacity 0.4s;
        -webkit-transition: opacity 0.4s;
    }
    .news .links a {
        display: block;
        width: 56px;
        height: 56px;
        box-shadow: 0 0 0 5px rgba(255,255,255,0.5);
        font-size: 20px;
        line-height: 56px;
        color: #fff;
    }
    .news .pic:hover .links {
        opacity: 1;
    }
    .news .pic:hover .links li {
        opacity: 1;
        -ms-animation-name: slideup;
        -ms-animation-duration: 0.4s;
        -moz-animation-name: slideup;
        -moz-animation-duration: 0.4s;
        -webkit-animation-name: slideup;
        -webkit-animation-duration: 0.4s;
    }
    .news-1 .item {
        width: 100%;
    }
    .news-1 .audio {
        margin-top: 20px;
    }
    .news-1 .wrapper {
        position: relative;
        z-index: 1;
        float: right;
        width: 100px;
        margin: 6px 0px 10px 30px;
    }
    .news-1 .wrapper:after {
        content: '';
        position: absolute;
        top: 0;
        left: 100%;
        width: 30px;
        height: 100%;
    }
    .news-2 .item {
        width: 600px;
    }
    .news-3 .item {
        width: 400px;
    }
    .news-4 .item {
        width: 300px;
    }
    @media screen and (max-width: 1190px) { /* laptop */
        .news .grid {
            margin-right: -10px;
            margin-left: -10px;
        }
        .news .item {
            padding: 0 10px;
        }
        .news-1 .wrapper {
            width: 460px;
            margin-right: 20px;
        }
        .news-1 .wrapper:after {
            width: 20px;
        }
        .news-2 .item {
            width: 480px;
        }
        .news-3 .item {
            width: 320px;
        }
        .news-4 .item {
            width: 240px;
        }
    }
    @media screen and (max-width: 980px) { /* pad */
        .news .grid {
            margin-right: -9px;
            margin-left: -9px;
        }
        .news .item {
            padding: 0 9px;
        }
        .news-1 .wrapper {
            width: 360px;
            margin-right: 18px;
        }
        .news-1 .wrapper:after {
            width: 18px;
        }
        .news-2 .item {
            width: 378px;
        }
        .news-3 .item,
        .news-4 .item {
            width: 252px;
        }
    }
    @media screen and (max-width: 767px) { /* phone */
        .news-1 .wrapper {
            float: none;
            width: 100%;
            margin: 0;
        }
        .news-1 .wrapper:after {
            display: none;
        }
        .news-2 .item,
        .news-3 .item,
        .news-4 .item {
            width: 49.99%;
        }
    }
    @media screen and (max-width: 479px) { /* mini phone */
        .news .grid {
            margin-top: -15px;
            margin-bottom: -15px;
        }
        .news .item {
            width: 100%;
            margin: 15px 0;
        }
    }
    .page-title {
        margin-bottom: 50px;
        border-top-width: 7px;
        border-top-style: solid;
        color: #fff;
        direction: rtl;
    }
    .page-title {
        border-top-color: #293e92;
        background-color: #293e92;
    }
    .grid-row {
        width: 1170px;
        margin: 0 auto 60px;
    }
    .page-title .grid-row {
        margin-bottom: 0;
    }
    .page-title h1 {
        float: right;
        padding: 18px 0;
        font-size: 22px;
        line-height: 28px;
        text-transform: uppercase;
        color:#fff;
    }
    .page-title nav {
        float: left;
        margin-left: 0px;
        padding: 22px 0;
        font-size: 13px;
        line-height: 20px;
        color:#fff;
    }
    /**/
    /* pagination */
    /**/
    .pagination ul {
        font-size: 0;
        display: inline-block;
        padding-right: 0px;
    }
    .pagination {
        width:100%;
        text-align:center;
        direction:rtl;
    }
    .pagination,
    .pagination li {
        display: inline-block;
        margin: 10px 1px;
        font-size: 13px;
        line-height: 38px;
    }
    .pagination a {
        display: block;
        padding: 0 15px;
        border: 1px solid #e3e3e3;
        color: #7c7c7c;
        display: inline-block;
    }
    .pagination a:hover,
    .pagination li.current a {
        color: #000;
    }
    .pagination li.dots a,
    .pagination li.dots a:hover {
        border:none;
        background:none;
        color: #7c7c7c;
    }

    @media screen and (max-width: 479px) { /* phone */
        .pagination ul {
            display: block;
        }
    }
</style>

