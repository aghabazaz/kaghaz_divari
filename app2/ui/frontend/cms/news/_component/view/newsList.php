<!-- page content -->
<main class="page-content">
    <div class="container">
        <div class="grid-row" style="direction :rtl;">
            <div class="col-md-12">
                <div class="url-page-box">
                    <div class="page-address-box padding-addressBar">
                        <i style="padding-left:3px;" class="fa fa-home"></i><span class="address-name"><a
                                    href="<?= \f\ifm::app()->siteUrl ?>" title="خانه">خانه</a></span>
                        <span class="arrow-address5 fa fa-angle-left"></span><span class="address-name"><a
                                    href="<?= \f\ifm::app()->siteUrl ?>" title="اخبار">اخبار</a></span>
                    </div>
                </div>
                <div class="newsMainList">
                    <?php
                    if ($newsList) {
                        foreach ($newsList AS $data) {
                            $this->registerGadgets(array(
                                'dateG' => 'date'));
                            $date_register = $this->dateG->dateTime($data['date_register'],
                                2);
                            $date = explode("/", $date_register);
                            $formattedDate = $this->dateG->formated_j_date($date[0],
                                $date[1],
                                $date[2]);
                            ?>
                            <div class="col-news">
                                <div class="mainNewsTitle">
                                    <a href="<?= \f\ifm::app()->siteUrl . 'newsDetail/' . $data['id'].'/'.$data['title'] ?>" title="<?=$data['title'] ?>">
                                        <h3><?php echo $data['title']; ?></h3>
                                    </a>
                                </div>
                                <div class="main-newsContent">
                                    <div class="col-sm-2">
                                        <div class="main_news_image">
                                            <a href="<?= \f\ifm::app()->siteUrl . 'newsDetail/' . $data['id'].'/'.$data['title'] ?>" title="<?=$data['title'] ?>"><img
                                                        style="margin :0 auto;" class="img-responsive"
                                                        src="<?= \f\ifm::app()->fileBaseUrl . $data['picture'] ?>"
                                                        alt=" <?php echo $data['title'] ?>" title="<?=$data['title'] ?>"></a>
                                        </div>
                                    </div>
                                    <div class="col-sm-10">
                                        <div class="text-main-news">
                                            <div class="content-text-News-main">
                                                <a href="<?= \f\ifm::app()->siteUrl . 'newsDetail/' . $data['id'].'/'.$data['title'] ?>" title="<?=$data['title'] ?>"><span><?php echo $data['short']; ?></span></a>
                                            </div>
                                            <div class="date-main-news">
                                                <ul>
                                                    <li><span><i class="fa fa-calendar"
                                                                 aria-hidden="true"></i> <?php echo \f\ifm::faDigit($formattedDate[2] . " " . $formattedDate[1] . " " . $formattedDate[0]); ?>  </span>
                                                    </li>
                                                    <li><span><i class="fa fa-clock-o"
                                                                 aria-hidden="true"></i> <?php echo \f\ifm::faDigit(date('H:i',
                                                                $data['date_register'])); ?> </span></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        ?>
                        <div class="alert alert-warning" role="alert">
                            ! <strong>خبری ثبت نشده است</strong>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-sm-12">
                <div class="pagination" style="text-align: center">
                    <?php
                    $lastpage = ceil(($num / $num_page));
                    $i = 1;
                    $lpm1 = $lastpage - 1;
                    $adjacents = 3;
                    $pr = $page - 1;
                    $nx = $page + 1;

                    $href = \f\ifm::app()->siteUrl . 'news';
                    include 'pagination.php';
                    ?>
                </div>
            </div>
        </div>
    </div>
</main>
<style>
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
        border-color: #293e92;
        background: #293e92;
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
        line-height: 38px;
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

</style>


