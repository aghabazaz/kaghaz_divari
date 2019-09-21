<?php
//\f\pre($row);
?>
<section id="aboutus" class="section nav-secondary-dark nav-secondary-style-2-dark-active">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 mb-5 mb-lg-0">
                <?=$row['ShortContent']?>
            </div>
            <div class="col-md-8 col-lg-5 offset-lg-1 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="400">
                <div class="bg-dark-5 position-relative max-width-400 ml-auto" data-plugin-float-element data-plugin-options="{'startPos': 'none', 'speed': 10, 'transition': true}">
                    <div class="rect-size custom-rect-size-style-1"></div>
                    <img src="<?=\f\ifm::app()->siteUrl.'/file/'.$row['pictureAbout']?>" class="position-absolute" alt="" data-plugin-float-element data-plugin-options="{'startPos': 'none', 'speed': 9, 'horizontal': true, 'transition': true, 'style': 'top: -45px; right: -10%; width: 75%;'}" />
                    <img src="<?=\f\ifm::app()->siteUrl.'/file/'.$row['pictureAbout1']?>" class="position-absolute" alt="" data-plugin-float-element data-plugin-options="{'startPos': 'none', 'speed': 8.5, 'transition': true, 'style': 'bottom: -10px; left: -20%; width: 90%;'}" />
                </div>
            </div>
        </div>
    </div>
</section>
