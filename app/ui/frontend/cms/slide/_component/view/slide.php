<?php
$picture = \f\ttt::service('core.fileManager.loadFileUrl', [
'fileId' => $SlideList['picture']
]);?>
<section id="archinterior" class="section parallax py-0" data-plugin-parallax data-plugin-options="{'speed': 1.5, 'parallaxHeight': '115%'}" data-image-src="<?=$picture?>">
    <div class="container">
        <div class="row align-items-center justify-content-center" style="height: 100vh;">
            <div class="position-relative d-flex align-items-end custom-height-290 w-100">
                <a href="#" class="portfolio-item custom-portfolio-item-style-1 overlay overlay-show">
                    <div class="absolute-x-center pointer-events-none custom-bottom-40 w-100">
                        <div class="overflow-hidden custom-hover-opacity text-center w-100 line-height-4">
                            <span class="d-block text-color-light-3 font-primary font-weight-thin text-5 appear-animation" data-appear-animation="maskUp"><?=$SlideList['top_title']?></span>
                        </div>
                        <div class="overflow-hidden custom-hover-opacity text-center w-100 mb-2">
                            <h2 class="text-color-light text-9 mb-0 appear-animation" data-appear-animation="maskUp" data-appear-animation-delay="200"><?=$SlideList['title']?></h2>
                        </div>

                    </div>

                </a>
            </div>
        </div>
    </div>
</section>


