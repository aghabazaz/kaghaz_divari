<section class="section py-3 dir-ltr category-banner">
    <div class="container">
        <div class="row">
            <?php
            $picture = \f\ttt::service('core.fileManager.loadFileUrl', [
                'fileId' => $specialCategory[0]['picture'],
                'width' => '270',
                'height' => '270',
                'option' => 'auto',
            ]);
            ?>
            <div class="col-4 col-lg-3 p-1 appear-animation" data-appear-animation="fadeInLeftShorter" data-appear-animation-delay="200">
                <div class="image-frame">
                    <div class="image-frame-wrapper align-items-end">
                        <img src="<?=$picture?>" class="img-fluid" alt="">
                        <div class="image-frame-info image-frame-info-show flex-column px-4 mx-2">
                            <h2 class="text-color-light text-center text-5 line-height-2 mb-4"><?=$specialCategory[0]['title']?></h2>
                            <a href="<?= \f\ifm::app ()->siteUrl.'product/'.$specialCategory[0]['title_en']?>" style="margin-bottom: 10px;text-align: center;display: block" class="btn btn-primary btn-rounded font-weight-bold btn-h-2 btn-v-3 appear-animation" data-appear-animation="scaleOut" data-appear-animation-duration="8s">مشاهده همه</a>
<br/>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $picture = \f\ttt::service('core.fileManager.loadFileUrl', [
                'fileId' => $specialCategory[1]['picture'],
                'width' => '270',
                'height' => '270',
                'option' => 'auto',
            ]);
            ?>
            <div class="col-8 col-lg-6 p-1 z-index-1 main-cat-index">
                <div class="image-frame">
                    <div class="image-frame-wrapper">
                        <img src="<?=$picture?>" class="img-fluid appear-animation" alt="" data-appear-animation="scaleOut" data-appear-animation-duration="8s">
                        <div class="image-frame-info image-frame-info-show flex-column align-items-start px-4 pt-md-4 mt-md-3 mx-2">
                            <h2 class="text-color-light font-weight-bold text-8 line-height-2 mb-2"><?=$specialCategory[1]['title']?> </h2>
                            <a href="<?= \f\ifm::app ()->siteUrl.'product/'.$specialCategory[1]['title_en']?>" class="btn btn-primary btn-rounded font-weight-bold btn-h-2 btn-v-3 appear-animation" data-appear-animation="scaleOut" data-appear-animation-duration="8s">مشاهده همه</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            $picture = \f\ttt::service('core.fileManager.loadFileUrl', [
                'fileId' => $specialCategory[2]['picture'],
                'width' => '270',
                'height' => '270',
                'option' => 'auto',
            ]);
            ?>
            <div class="col-lg-3 other-cat">

                <div class="row justify-content-center">
                    <div class="col-6 col-md-5 col-lg-12 p-1 appear-animation" data-appear-animation="fadeInRightShorter" data-appear-animation-delay="200">
                        <div class="image-frame">
                            <div class="image-frame-wrapper align-items-start">
                                <img src="<?=$picture?>" class="img-fluid" alt="">
                                <div class="image-frame-info image-frame-info-show flex-column align-items-center pt-4">
                                    <h2 class="text-color-light text-center text-4 mb-4"><?=$specialCategory[2]['title']?></h2>
                                </div>
                                <a href="<?= \f\ifm::app ()->siteUrl.'product/'.$specialCategory[2]['title_en']?>"><span class="text-color-light bg-primary font-primary font-weight-bold rounded-circle off-tag-bottom-left line-height-1 text-4 p-4">مشاهده همه</span></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-5 col-lg-12 p-1 appear-animation" data-appear-animation="fadeInRightShorter" data-appear-animation-delay="200">
                        <div class="image-frame">
                            <?php
                            $picture = \f\ttt::service('core.fileManager.loadFileUrl', [
                                'fileId' => $specialCategory[3]['picture'],
                                'width' => '270',
                                'height' => '270',
                                'option' => 'auto',
                            ]);
                            ?>
                            <div class="image-frame-wrapper">
                                <img src="<?=$picture?>" class="img-fluid" alt="">
                                <div class="image-frame-info image-frame-info-show flex-column align-items-center">
                                    <h2 class="text-color-light font-weight-bold text-5 line-height-1 mb-2"><?=$specialCategory[3]['title']?></h2>
                                    <a href="<?= \f\ifm::app ()->siteUrl.'product/'.$specialCategory[3]['title_en']?>" class="btn btn-primary btn-rounded font-weight-bold btn-h-2 btn-v-3">مشاهده همه</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>