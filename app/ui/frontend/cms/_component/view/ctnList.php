<?php
if(!empty($contntList)){?>
    <section class="section section-height-4 bg-light-5">
        <div class="container">
            <div class="row text-center">
                <div class="col">
                    <div class="overflow-hidden mb-3">
                        <h2 class="font-weight-bold mb-0 appear-animation" data-appear-animation="maskUp" data-appear-animation-delay="200"> آخرین مطالب بلاگ </h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-10 col-sm-8 col-md-12 mx-auto d-flex overflow-hidden p-0 appear-animation dir-ltr" data-appear-animation="fadeInUpShorter" data-appear-animation-duration="700ms">
                    <div class="owl-carousel carousel-center-active-items carousel-center-active-items-style-3" data-plugin-carousel data-plugin-options="{'autoplay': false, 'dots': false, 'nav': true, 'loop': true, 'margin': 40, 'responsive': { '0': {'items': 1}, '576': {'items': 1}, '768': {'items': 3}, '992': {'items': 3}, '1200': {'items': 5}}}">
                        <?php
                        foreach ($contntList AS $data) {
                            $this->registerGadgets(array(
                                'dateG' => 'date'));
                            $date_register = $this->dateG->dateTime($data['date_register'], 2);
                            $date = explode("/", $date_register);
                            $formattedDate = $this->dateG->formated_j_date($date[0], $date[1],
                                $date[2]);

                            $picture = \f\ttt::service('core.fileManager.loadFileUrl', [
                                'fileId' => $data['picture'],
                                'width' => '244',
                                'height' => '90',
                                'option' => 'auto',
                            ]);
                            ?>
                            <div class="appear-animation" data-appear-animation="fadeInLeftShorter" data-appear-animation-delay="400">
                                <article class="card rounded bg-light border-0 p-0">
                                    <a href="<?= \f\ifm::app()->siteUrl . 'contentDetail/' . $data['id'].'/'.$data['title'] ?>"  title="<?= $data['title'] ?>">
                                        <img src="<?= $picture; ?>" title="<?= $data['title'] ?>" alt="<?= $data['title'] ?>" class="card-img-top hover-effect-2">
                                    </a>
                                    <div class="card-body">
                                        <h3 class="font-weight-bold text-4 mb-1">
                                            <a href="<?= \f\ifm::app()->siteUrl . 'contentDetail/' . $data['id'].'/'.$data['title'] ?>" title="<?= $data['title'] ?>" class="link-color-dark">
                                                <?=$data['title']?>
                                            </a>
                                        </h3>
                                    </div>
                                </article>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row mt-4">
                <div class="col d-flex justify-content-center">
                    <a href="portfolio-grid-4-columns.html" class="btn btn-primary btn-rounded btn-h-5 btn-v-3 font-weight-semibold">مشاهده همه</a>
                </div>
            </div>
        </div>
    </section>

    <?php

}else{
    ?>
    <div>هیچ مطلبی منتشر نشده است.</div>
    <?php
}
?>












