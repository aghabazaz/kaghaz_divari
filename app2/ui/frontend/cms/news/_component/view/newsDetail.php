<main>
    <div class="container">
        <div class="url-page-box">
            <div class="page-address-box padding-addressBar">
                <i style="padding-left:3px;" class="fa fa-home"></i><span class="address-name">
                    <a href="<?= \f\ifm::app()->siteUrl ?>" title="خانه">خانه</a></span>
                <span class="arrow-address5 fa fa-angle-left"></span>
                <span class="address-name">
                    <a href="<?= \f\ifm::app()->siteUrl . 'news' ?>" title="<?= $newsDetailList['title'] ?>">اخبار</a>
                </span>
                <span class="arrow-address5 fa fa-angle-left"></span>
                <span  class="address-name">
                    <?php echo $newsDetailList['title'] ?>
                </span>
            </div>
        </div>
        <div class="row ">
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                <div class="newsDetail">
                    <div class="col-lg-2 col-md-2 iconNews">
                        <i class="fa fa-file-text" aria-hidden="true"></i>
                    </div>
                    <div class="col-lg-10 col-md-10">
                        <div class="titleDetailNews">
                            <?php
                            $this->registerGadgets(array(
                                'dateG' => 'date'));
                            ?>
                            <h1><?= $newsDetailList['title'] ?> </h1>
                            <br/>
                            <i class="fa fa-clock-o" aria-hidden="true" "></i>
                            <p><?php
                                $date = $this->dateG->dateTime($newsDetailList['date_register'],
                                    1);

                                echo \f\ifm::faDigit($this->dateG->dateGrToJa($date, 2) . ' ساعت : ' . date("H:i",
                                        $newsDetailList['date_register']));
                                ?></p>
                        </div>
                    </div>
                    <div class="downNews">
                        <img src="<?= \f\ifm::app()->fileBaseUrl . $newsDetailList['picture'] ?>" title="<?= $newsDetailList['title'] ?>" alt="<?= $newsDetailList['title'] ?>"/>
                        <p><?= $newsDetailList['content'] ?></p>
                    </div>
                </div>

            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="lastNews">

                    <h4> آخرین اخبار </h4>
                    <?php
                    $this->registerGadgets(array(
                        'dateG' => 'date'));
                    foreach ($newsList AS $data){

                        ?>
                        <div class="lastNewsMain">
                            <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                                <img src="<?= \f\ifm::app()->fileBaseUrl . $data['picture'] ?>" class="img-responsive" title="<?= $data['title'] ?>" alt="<?= $data['title'] ?>">
                            </div>
                            <div class="col-lg-9 col-md-9 noPadding">
                                <a href="<?= \f\ifm::app()->siteUrl . 'newsDetail/' . $data['id']; ?>" title="<?= $data['title'] ?>"><h5><?= $data['title'] ?></h5></a>
                                <div class="timeNews">
                                    <i class="fa fa-clock-o" aria-hidden="true" style="color: #0da9ef;" ></i>
                                    <p><?php
                                        $date = $this->dateG->dateTime($data['date_register'],
                                            1);

                                        echo \f\ifm::faDigit($this->dateG->dateGrToJa($date, 2) . ' ساعت : ' . date("H:i",
                                                $data['date_register']));
                                        ?></p>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <?php
                    }
                    ?>
                </div>

            </div>
        </div>
    </div>
</main>
<style>
    .downNews img {
        width: 80%;
        height: auto;
        display: block;
        margin-left: auto;
        margin-right: auto;
        border-top: 1px solid #dddddd;
        padding-top: 20px;
    }
</style>