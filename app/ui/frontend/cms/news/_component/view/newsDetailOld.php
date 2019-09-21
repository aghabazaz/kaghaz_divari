<!-- page content -->
<main class="page-content" style="background-color: #ffffff" xmlns="http://www.w3.org/1999/html">
    <div class="grid-row" style="background-color: #fff ;direction :rtl;">
        <div class="col-md-8">
            <div class="url-page-box">
                <div class="page-address-box padding-addressBar">
                    <i style="padding-left:3px;" class="fa fa-home"></i><span class="address-name"><a
                                href="<?= \f\ifm::app()->siteUrl ?>">خانه</a></span>
                    <span class="arrow-address5 fa fa-angle-left"></span><span class="address-name"><a
                                href="<?= \f\ifm::app()->siteUrl . 'news' ?>">اخبار</a></span>
                    <span class="arrow-address5 fa fa-angle-left"></span><span
                            class="address-name"><?php echo $newsDetailList['title'] ?></span>
                </div>
            </div>
            <?php
            if ($newsDetailList) {
                $this->registerGadgets(array(
                    'dateG' => 'date'));
                $date_register = $this->dateG->dateTime($newsDetailList['date_register'],
                    2);
                $date = explode("/", $date_register);
                $formattedDate = $this->dateG->formated_j_date($date[0],
                    $date[1],
                    $date[2]);
                ?>
                <div class="newsContent">
                    <div class="newsTitle">
                        <h1><?php echo $newsDetailList['title'] ?></h1>
                    </div>
                    <div class="PublicationDate">
                        <ul>
                            <li><span><i class="fa fa-calendar"
                                         aria-hidden="true"></i> <?php echo $formattedDate[2] . " " . $formattedDate[1] . " " . $formattedDate[0] ?> </span>
                            </li>
                            <li><span><i class="fa fa-clock-o" aria-hidden="true"></i> <?php
                                    echo date('H:i',
                                        $newsDetailList['date_register']);
                                    ?> </span></li>
                        </ul>
                    </div>
                    <div class="img-post">
                        <img style="margin :0 auto; " class="img-responsive"
                             src="<?= \f\ifm::app()->fileBaseUrl . $newsDetailList['picture'] ?>"
                             alt=" <?php echo $newsDetailList['title'] ?>">
                    </div>
                    <div class="content-text">
                        <p style="text-align: justify;"><?php echo $newsDetailList['content'] ?></p>
                    </div>
                </div>
                <?php
            } else {
                ?>
                <div class="alert alert-warning" role="alert">
                    ! <strong>مطلب مورد نظر موجود نیست </strong>
                </div>

                <?php

            }
            ?>
        </div>
        <div class="col-md-4">
            <div class="last-news-box">
                <div class="lastNewsTitle">
                    <span>اخرین اخبار</span>
                </div>
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
                        <div class="row lastNewsSummary">
                            <div class="col-sm-4">
                                <div class="img-last-news">
                                    <img style="margin :0 auto; " class="img-responsive"
                                         src="<?= \f\ifm::app()->fileBaseUrl . $data['picture'] ?>"
                                         alt=" <?php echo $data['title'] ?>">
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="newSummaryText">
                                    <a href="<?= \f\ifm::app()->siteUrl . 'newsDetail/' . $data['id'] ?>"><span><?php echo $data['title']; ?></span></a>
                                </div>
                                <div class="newSummaryDate">
                                    <ul>
                                        <li>
                                            <span> <?php echo $formattedDate[2] . " " . $formattedDate[1] . " " . $formattedDate[0] ?> </span>
                                        </li>
                                        <li><span>-</span></li>
                                        <li><span> <?php echo date('H:i', $data['date_register']) ?> </span></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>
</main>


