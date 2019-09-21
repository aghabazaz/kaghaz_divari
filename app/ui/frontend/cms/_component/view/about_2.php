<section class="grayBack dir-rtl">
<div class="container">
    <div>
        <div class="url-page-box marginTop120">
            <div class="page-address-box padding-addressBar">
                <i style="padding-left:3px;" class="fa fa-home"></i>
                <a href="<?= \f\ifm::app ()->siteUrl ?>"><span class="address-name">خانه</span></a><span
                        class="arrow-address5 fa fa-angle-right"></span><span class="address-name"> درباره ما </span>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <section class="page-title aboutPageBox padding-addressBar">
        <div class="grid-row clearfix">
            <h1 class="widget-title">درباره ما</h1>
        </div>
        <main class="page-content" style="min-height: 150px">
            <div class="grid-row">
                <!-- map -->
                <section>
                    <div style="direction: rtl">
                        <?= nl2br( $row['content'] )?>
                    </div>
                </section>
            </div>
        </main>
    </section>
</div>
</section>
